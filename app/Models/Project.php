<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'target_amount'       => 'decimal:2',
        'raised_amount'       => 'decimal:2',
        'is_featured'         => 'boolean',
        'is_active'           => 'boolean',
        'start_date'          => 'date',
        'end_date'            => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->whereNull('deleted_at');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getTitleAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->title_en)) ? $this->title_en : $this->title_ar;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->short_description_en)) ? $this->short_description_en : $this->short_description_ar;
    }

    public function getFullDescriptionAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->full_description_en)) ? $this->full_description_en : $this->full_description_ar;
    }

    public function getLocationAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->location_en)) ? $this->location_en : $this->location_ar;
    }

    public function getProgressPercentageAttribute(): float
    {
        if (! $this->target_amount || $this->target_amount == 0) {
            return 0;
        }
        return min(100, round(($this->raised_amount / $this->target_amount) * 100, 1));
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function media(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectMedia::class)->orderBy('display_order');
    }

    public function coverImage(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProjectMedia::class)->where('is_cover', true);
    }

    public function updates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectUpdate::class)->orderByDesc('published_date');
    }

    public function donations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Donation::class);
    }
}