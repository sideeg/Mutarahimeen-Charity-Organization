<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function getMethodNameAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->method_name_en)) ? $this->method_name_en : $this->method_name_ar;
    }

    public function getInstructionsAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->instructions_en)) ? $this->instructions_en : $this->instructions_ar;
    }
}