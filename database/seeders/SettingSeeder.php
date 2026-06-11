<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        if (Setting::count() === 0) {
            Setting::create([
                'site_name'          => 'Studyhub 2026',
                'site_description'   => 'La plateforme d\'apprentissage pour les élèves du collège et du lycée.',
                'site_email'         => 'contact@studyhub.test',
                'site_phone'         => '+229 97 00 00 00',
                'site_address'       => 'Cotonou, Bénin',
                'working_hours'      => 'Lun - Sam: 8h - 18h',
                'contact_email'      => 'contact@studyhub.test',
                'contact_phone'      => '+229 97 00 00 00',
                'contact_address'    => 'Cotonou, Bénin',
                'footer_description' => 'Studyhub accompagne les élèves dans leur réussite scolaire.',
                'footer_copyright'   => '© 2026 Studyhub - Tous droits réservés',
                'newsletter_enabled' => true,
                'facebook_url'       => 'https://facebook.com/studyhub',
                'instagram_url'      => 'https://instagram.com/studyhub',
                'youtube_url'        => 'https://youtube.com/studyhub',
                'meta_title'         => 'Studyhub 2026 - Cours, Épreuves et Quiz',
                'meta_description'   => 'Accédez à des cours, épreuves et quiz pour tous les niveaux du collège et lycée.',
            ]);
        }

        $this->command->info('✓ Paramètres du site créés.');
    }
}
