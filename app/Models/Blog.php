<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'content',
        'author',
        'image',
        'youtube_url',
        'status',
        'views'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Extract YouTube ID from URL or embed code
     */
    public function getYouTubeId()
    {
        if (!$this->youtube_url) {
            return null;
        }

        // Si c'est déjà un code d'intégration iframe
        if (str_contains($this->youtube_url, 'iframe')) {
            $pattern = '/embed\/([a-zA-Z0-9_-]{11})/';
            preg_match($pattern, $this->youtube_url, $matches);
            return $matches[1] ?? null;
        }

        // Si c'est une URL YouTube normale
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $this->youtube_url, $matches);
        
        return $matches[1] ?? null;
    }

    /**
     * Get YouTube embed code for direct playback
     */
    public function getYouTubeEmbed()
    {
        if (!$this->youtube_url) {
            return null;
        }

        $videoId = $this->getYouTubeId();
        if ($videoId) {
            return '<iframe 
                width="100%" 
                height="100%" 
                src="https://www.youtube.com/embed/'.$videoId.'?rel=0&modestbranding=1&autoplay=1" 
                title="'.$this->title.'" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                allowfullscreen>
            </iframe>';
        }

        return null;
    }

    /**
     * Check if article has YouTube video
     */
    public function hasVideo()
    {
        return !empty($this->youtube_url) && $this->getYouTubeId();
    }

    /**
     * Get the excerpt of the description
     */
    public function getExcerptAttribute()
    {
        return Str::limit($this->description, 150);
    }

    /**
     * Get the short title
     */
    public function getShortTitleAttribute()
    {
        return Str::limit($this->title, 50);
    }

    /**
     * Check if article has image
     */
    public function hasImage()
    {
        return !empty($this->image);
    }

    /**
     * Increment views counter
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}