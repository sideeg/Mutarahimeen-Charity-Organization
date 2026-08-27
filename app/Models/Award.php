<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $casts   = ['is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('display_order');
    }

    public function getTitleAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->title_en)) ? $this->title_en : $this->title_ar;
    }

    public function getDescriptionAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->description_en)) ? $this->description_en : $this->description_ar;
    }

    public function getIssuerAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->issuer_en)) ? $this->issuer_en : $this->issuer_ar;
    }
}