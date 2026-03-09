<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'site_email' => 'required|email',
            'site_phone' => 'required|string|max:20',
            'site_address' => 'required|string|max:500',
            'working_hours' => 'required|string|max:255',
        ]);

        $settings = Setting::firstOrCreate([]);
        $settings->update($request->all());

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres généraux mis à jour avec succès.');
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string|max:500',
            'contact_map_url' => 'nullable|url',
        ]);

        $settings = Setting::firstOrCreate([]);
        $settings->update($request->all());

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres de contact mis à jour avec succès.');
    }

    public function updateSocial(Request $request)
    {
        $request->validate([
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
        ]);

        $settings = Setting::firstOrCreate([]);
        $settings->update($request->all());

        return redirect()->route('admin.settings.index')
            ->with('success', 'Réseaux sociaux mis à jour avec succès.');
    }

    public function updateSeo(Request $request)
    {
        $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'google_analytics' => 'nullable|string',
        ]);

        $settings = Setting::firstOrCreate([]);
        $settings->update($request->all());

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres SEO mis à jour avec succès.');
    }

    public function updateFooter(Request $request)
    {
        $request->validate([
            'footer_description' => 'nullable|string|max:1000',
            'footer_copyright' => 'required|string|max:255',
            'newsletter_enabled' => 'boolean',
        ]);

        $settings = Setting::firstOrCreate([]);
        $settings->update($request->all());

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres du footer mis à jour avec succès.');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        $settings = Setting::firstOrCreate([]);

        if ($request->hasFile('site_logo')) {
            // Supprimer l'ancien logo
            if ($settings->site_logo) {
                Storage::disk('public')->delete($settings->site_logo);
            }
            
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            $settings->update(['site_logo' => $logoPath]);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Logo mis à jour avec succès.');
    }

    public function updateFavicon(Request $request)
    {
        $request->validate([
            'site_favicon' => 'required|image|mimes:ico,png|max:1024',
        ]);

        $settings = Setting::firstOrCreate([]);

        if ($request->hasFile('site_favicon')) {
            // Supprimer l'ancien favicon
            if ($settings->site_favicon) {
                Storage::disk('public')->delete($settings->site_favicon);
            }
            
            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            $settings->update(['site_favicon' => $faviconPath]);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Favicon mis à jour avec succès.');
    }
}