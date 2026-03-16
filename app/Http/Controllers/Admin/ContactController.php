<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Affiche la liste des contacts
     */
    public function indexAdmin(Request $request)
    {
        $query = Contact::query();

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Tri
        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $contacts = $query->paginate(15)->withQueryString();

        // Statistiques
        $stats = [
            'total' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'read' => Contact::where('status', 'read')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
            'archived' => Contact::where('status', 'archived')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Affiche les détails d'un contact
     */
    public function showAdmin($id)
    {
        $contact = Contact::findOrFail($id);

        // Marquer comme lu si c'est nouveau
        if ($contact->status == 'new') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Répondre à un contact (redirige vers la boîte mail)
     */
    public function replyAdmin($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Marquer comme répondu
        $contact->update(['status' => 'replied']);

        // Rediriger vers la boîte mail avec l'adresse pré-remplie
        $mailto = "mailto:{$contact->email}?subject=Re: {$contact->subject}";
        
        return redirect($mailto);
    }

    /**
     * Change le statut d'un contact
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,archived'
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour',
            'status' => $contact->status
        ]);
    }

    /**
     * Supprime un contact
     */
    public function destroyAdmin($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message supprimé avec succès.');
    }

    /**
     * Actions groupées
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required|in:delete,mark_as_read,mark_as_new,mark_as_replied,mark_as_archived'
        ]);

        $ids = $request->ids;

        switch ($request->action) {
            case 'delete':
                Contact::whereIn('id', $ids)->delete();
                $message = count($ids) . ' message(s) supprimé(s) avec succès.';
                break;
            case 'mark_as_read':
                Contact::whereIn('id', $ids)->update(['status' => 'read']);
                $message = count($ids) . ' message(s) marqué(s) comme lu(s).';
                break;
            case 'mark_as_new':
                Contact::whereIn('id', $ids)->update(['status' => 'new']);
                $message = count($ids) . ' message(s) marqué(s) comme nouveau(x).';
                break;
            case 'mark_as_replied':
                Contact::whereIn('id', $ids)->update(['status' => 'replied']);
                $message = count($ids) . ' message(s) marqué(s) comme répondu(s).';
                break;
            case 'mark_as_archived':
                Contact::whereIn('id', $ids)->update(['status' => 'archived']);
                $message = count($ids) . ' message(s) archivé(s).';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Export des contacts en CSV
     */
    public function export(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->orderBy('created_at', 'desc')->get();

        $filename = 'contacts-' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');

        // En-têtes
        fputcsv($handle, [
            'ID',
            'Prénom',
            'Nom',
            'Nom complet',
            'Email',
            'Téléphone',
            'Sujet',
            'Message',
            'Statut',
            'Date de création'
        ]);

        // Données
        foreach ($contacts as $contact) {
            fputcsv($handle, [
                $contact->id,
                $contact->first_name,
                $contact->last_name,
                $contact->full_name,
                $contact->email,
                $contact->phone,
                $contact->subject,
                $contact->message,
                $contact->status,
                $contact->created_at->format('d/m/Y H:i')
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}