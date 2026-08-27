<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];

    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Project::class, 'category_id');
    }

    public function getNameAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->name_en)) ? $this->name_en : $this->name_ar;
    }

    public function getDescriptionAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->description_en)) ? $this->description_en : $this->description_ar;
    }
}