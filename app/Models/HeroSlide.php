<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $casts   = [
        'valid_from'  => 'date',
        'valid_until' => 'date',
        'is_active'   => 'boolean',
    ];

    public function scopeCurrentlyVisible($query)
    {
        return $query
            ->where('is_active', true)
            ->where(fn ($q) => $q->whereNull('valid_from')->orWhereDate('valid_from', '<=', now()))
            ->where(fn ($q) => $q->whereNull('valid_until')->orWhereDate('valid_until', '>=', now()))
            ->orderBy('display_order');
    }

    public function getHeadlineAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->headline_en)) ? $this->headline_en : $this->headline_ar;
    }

    public function getHighlightedTextAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->highlighted_text_en)) ? $this->highlighted_text_en : $this->highlighted_text_ar;
    }

    public function getSubtextAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->subtext_en)) ? $this->subtext_en : $this->subtext_ar;
    }

    public function getCtaLabelAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->cta_label_en)) ? $this->cta_label_en : $this->cta_label_ar;
    }
}