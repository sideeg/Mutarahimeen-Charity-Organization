<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUpdate extends Model
{
    public $timestamps  = false;
    protected $guarded  = ['id'];
    protected $casts    = ['media_urls' => 'array', 'published_date' => 'date'];

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getTitleAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->title_en)) ? $this->title_en : $this->title_ar;
    }

    public function getContentAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->content_en)) ? $this->content_en : $this->content_ar;
    }
}