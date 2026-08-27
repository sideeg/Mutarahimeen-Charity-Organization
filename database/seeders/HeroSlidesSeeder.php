<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroSlidesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hero_slides')->insert([
            [
                'headline_ar'         => 'معًا، نصنع فرقًا في المجتمعات',
                'headline_en'         => 'Together, we make a difference in communities',
                'highlighted_text_ar' => 'فرقًا',
                'highlighted_text_en' => 'difference',
                'subtext_ar'          => 'شباب جامعات وخريجون خرجنا من بيوتنا قاصدين التطوع وعمل الخير، لنكون يداً بيد نحو مجتمع متكافل خالٍ من الحاجة.',
                'subtext_en'          => 'University students and graduates who left our homes to volunteer and do good — hand in hand toward a compassionate, self-sufficient community.',
                'image_url'           => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?auto=format&fit=crop&w=1920&q=80',
                'cta_label_ar'        => 'إدعمنا',
                'cta_label_en'        => 'Support Us',
                'cta_url'             => '/donate',
                'valid_from'          => null,
                'valid_until'         => null,
                'display_order'       => 1,
                'is_active'           => true,
            ],
            [
                'headline_ar'         => 'يد بيد نحو الجنة',
                'headline_en'         => 'Hand in hand towards Jannah',
                'highlighted_text_ar' => 'الجنة',
                'highlighted_text_en' => 'Jannah',
                'subtext_ar'          => 'دعمكم يعزز المجتمعات ويرتقي بالحياة، من خلال برامج مبتكرة تساهم في التمكين وتعزيز الأمل.',
                'subtext_en'          => 'Your support strengthens communities and improves lives through innovative programs of empowerment and hope.',
                'image_url'           => 'https://images.unsplash.com/photo-1594708767771-a7502209ff51?auto=format&fit=crop&w=1920&q=80',
                'cta_label_ar'        => 'تطوع معنا الآن',
                'cta_label_en'        => 'Volunteer Now',
                'cta_url'             => '/donate#volunteer',
                'valid_from'          => null,
                'valid_until'         => null,
                'display_order'       => 2,
                'is_active'           => true,
            ],
        ]);
    }
}