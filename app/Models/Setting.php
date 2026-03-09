<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_description',
        'site_email',
        'site_phone',
        'site_address',
        'working_hours',
        'contact_email',
        'contact_phone',
        'contact_address',
        'contact_map_url',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'google_analytics',
        'footer_description',
        'footer_copyright',
        'newsletter_enabled',
        'site_logo',
        'site_favicon'
    ];

    protected $casts = [
        'newsletter_enabled' => 'boolean',
    ];
}