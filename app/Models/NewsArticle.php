<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts   = [
        'published_at' => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DashboardUser::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNull('deleted_at');
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