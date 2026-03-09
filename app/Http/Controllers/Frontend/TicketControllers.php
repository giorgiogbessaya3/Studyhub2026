<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketControllers extends Controller
{
    /**
     * Tableau de bord utilisateur - Liste des tickets de l'utilisateur
     */
    public function index(Request $request)
    {
        // Si l'utilisateur est connecté, on peut filtrer par son email
        $userEmail = auth()->check() ? auth()->user()->email : null;
        
        $query = Ticket::with(['attachments', 'replies'])
                    ->when($userEmail, function($q) use ($userEmail) {
                        $q->where('email', $userEmail);
                    });

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('ticket_number', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistiques pour l'utilisateur
        $stats = [
            'total' => $userEmail ? Ticket::where('email', $userEmail)->count() : 0,
            'pending' => $userEmail ? Ticket::where('email', $userEmail)->where('status', 'ouvert')->count() : 0,
            'in_progress' => $userEmail ? Ticket::where('email', $userEmail)->where('status', 'en_cours')->count() : 0,
            'resolved' => $userEmail ? Ticket::where('email', $userEmail)->where('status', 'resolu')->count() : 0,
        ];

        return view('frontend.dashboard.dashboard', compact('tickets', 'stats'));
    }

    /**
     * Afficher le formulaire de création de ticket
     */
    public function create()
    {
        return view('frontend.tickets.create');
    }

    /**
     * Enregistrer un nouveau ticket
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'category' => 'required|in:technique,facturation,compte,fonctionnalite,autre',
            'priority' => 'required|in:basse,moyenne,haute,urgente',
            'subject' => 'required|string|max:500',
            'message' => 'required|string|min:10',
            'accept_emails' => 'sometimes|boolean',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt'
        ], [
            'name.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'category.required' => 'La catégorie est obligatoire.',
            'priority.required' => 'La priorité est obligatoire.',
            'subject.required' => 'Le sujet est obligatoire.',
            'message.required' => 'La description est obligatoire.',
            'message.min' => 'La description doit contenir au moins 10 caractères.',
            'attachments.*.max' => 'Le fichier ne doit pas dépasser 5MB.',
            'attachments.*.mimes' => 'Seuls les formats JPG, PNG, GIF, PDF, DOC, DOCX, TXT sont autorisés.',
        ]);

        try {
            // Création du ticket
            $ticket = Ticket::create([
                'ticket_number' => 'TKT-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'category' => $validated['category'],
                'priority' => $validated['priority'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'accept_emails' => $validated['accept_emails'] ?? true,
                'status' => 'ouvert',
            ]);

            // Gestion des pièces jointes
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    // Générer un nom unique pour le fichier
                    $fileName = Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('tickets/attachments', $fileName, 'local');

                    $ticket->attachments()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'storage_path' => $path,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'extension' => $file->getClientOriginalExtension(),
                    ]);
                }
            }

            // Redirection avec message de succès
            return redirect()->route('tickets.create')
                ->with('success', 'Votre ticket a été créé avec succès! Votre numéro de ticket est: ' . $ticket->ticket_number);

        } catch (\Exception $e) {
            // En cas d'erreur
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de votre ticket. Veuillez réessayer.')
                ->withInput();
        }
    }

    /**
     * Liste des tickets de l'utilisateur
     */
    public function list(Request $request)
    {
        $userEmail = auth()->check() ? auth()->user()->email : null;
        
        if (!$userEmail) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour voir vos tickets.');
        }

        $query = Ticket::where('email', $userEmail)
                    ->with(['attachments', 'replies']);

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('ticket_number', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtre par priorité
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('frontend.tickets.list', compact('tickets'));
    }

    /**
     * Afficher les détails d'un ticket spécifique
     */
    public function show(Ticket $ticket)
    {
        // Vérifier que l'utilisateur a le droit de voir ce ticket
        $userEmail = auth()->check() ? auth()->user()->email : null;
        
        if ($ticket->email !== $userEmail) {
            abort(403, 'Accès non autorisé à ce ticket.');
        }

        $ticket->load(['attachments', 'replies.user']);

        return view('frontend.tickets.show', compact('ticket'));
    }

    /**
     * Mettre à jour un ticket (pour ajouter des commentaires, etc.)
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Vérifier que l'utilisateur a le droit de modifier ce ticket
        $userEmail = auth()->check() ? auth()->user()->email : null;
        
        if ($ticket->email !== $userEmail) {
            abort(403, 'Accès non autorisé.');
        }

        // Seuls les tickets ouverts ou en cours peuvent être mis à jour
        if (!in_array($ticket->status, ['ouvert', 'en_cours'])) {
            return redirect()->back()->with('error', 'Ce ticket ne peut plus être modifié.');
        }

        $validated = $request->validate([
            'additional_message' => 'required|string|min:5',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt'
        ]);

        try {
            // Ajouter une réponse de l'utilisateur
            \App\Models\TicketReply::create([
                'ticket_id' => $ticket->id,
                'message' => $validated['additional_message'],
                'reply_type' => 'response',
                'user_id' => null, // Réponse du client
            ]);

            // Gestion des nouvelles pièces jointes
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $fileName = Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('tickets/attachments', $fileName, 'local');

                    $ticket->attachments()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'storage_path' => $path,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'extension' => $file->getClientOriginalExtension(),
                    ]);
                }
            }

            // Mettre à jour le statut si nécessaire
            if ($ticket->status === 'resolu') {
                $ticket->update(['status' => 'en_cours']);
            }

            return redirect()->back()->with('success', 'Votre message a été ajouté au ticket.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du message.');
        }
    }

    /**
     * Supprimer un ticket (uniquement si c'est l'utilisateur et que le ticket est ouvert)
     */
    public function destroy(Ticket $ticket)
    {
        // Vérifier que l'utilisateur a le droit de supprimer ce ticket
        $userEmail = auth()->check() ? auth()->user()->email : null;
        
        if ($ticket->email !== $userEmail) {
            abort(403, 'Accès non autorisé.');
        }

        // Seuls les tickets ouverts peuvent être supprimés par l'utilisateur
        if ($ticket->status !== 'ouvert') {
            return redirect()->back()->with('error', 'Seuls les tickets ouverts peuvent être supprimés.');
        }

        try {
            // Supprimer les pièces jointes physiques
            foreach ($ticket->attachments as $attachment) {
                if (Storage::exists($attachment->storage_path)) {
                    Storage::delete($attachment->storage_path);
                }
                $attachment->delete();
            }

            // Supprimer les réponses
            $ticket->replies()->delete();

            // Supprimer le ticket
            $ticket->delete();

            return redirect()->route('tickets.list')
                ->with('success', 'Ticket supprimé avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du ticket.');
        }
    }

    /**
     * Télécharger une pièce jointe
     */
    public function downloadAttachment(Ticket $ticket, TicketAttachment $attachment)
    {
        // Vérifier que l'utilisateur a accès à ce ticket
        $userEmail = auth()->check() ? auth()->user()->email : null;
        
        if ($ticket->email !== $userEmail || $attachment->ticket_id !== $ticket->id) {
            abort(403, 'Accès non autorisé.');
        }

        if (!Storage::exists($attachment->storage_path)) {
            abort(404, 'Fichier non trouvé.');
        }

        return Storage::download($attachment->storage_path, $attachment->original_name);
    }

    /**
     * Fermer un ticket (marquer comme résolu par l'utilisateur)
     */
    public function close(Ticket $ticket)
    {
        // Vérifier que l'utilisateur a le droit de fermer ce ticket
        $userEmail = auth()->check() ? auth()->user()->email : null;
        
        if ($ticket->email !== $userEmail) {
            abort(403, 'Accès non autorisé.');
        }

        try {
            $ticket->update([
                'status' => 'ferme',
                'closed_at' => now()
            ]);

            return redirect()->back()->with('success', 'Ticket fermé avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la fermeture du ticket.');
        }
    }
}