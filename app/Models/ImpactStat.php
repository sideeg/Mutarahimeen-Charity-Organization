<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpactStat extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function getDisplayValueAttribute(): string
    {
        return trim(($this->number_value ?? '') . ' ' . ($this->suffix ?? ''));
    }

    public function getLabelAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->label_en)) ? $this->label_en : $this->label_ar;
    }

    public function getDescriptionAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->description_en)) ? $this->description_en : $this->description_ar;
    }
}