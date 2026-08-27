<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function getNameAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->name_en)) ? $this->name_en : $this->name_ar;
    }
}