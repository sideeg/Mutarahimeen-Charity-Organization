<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public static function instance(): static
    {
        return static::firstOrFail();
    }

    public function getNameAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->name_en)) ? $this->name_en : $this->name_ar;
    }

    public function getAboutTextAttribute(): string
    {
        return (app()->getLocale() === 'en' && !empty($this->about_text_en)) ? $this->about_text_en : $this->about_text_ar;
    }

    public function getVisionAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->vision_en)) ? $this->vision_en : $this->vision_ar;
    }

    public function getMissionAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->mission_en)) ? $this->mission_en : $this->mission_ar;
    }

    public function getMarketingMessageAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->marketing_message_en)) ? $this->marketing_message_en : $this->marketing_message_ar;
    }

    public function getAddressAttribute(): ?string
    {
        return (app()->getLocale() === 'en' && !empty($this->address_en)) ? $this->address_en : $this->address_ar;
    }
}