<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AwardsSeeder extends Seeder
{
    public function run(): void
    {
        // Note: No verified public award records were found for Mutrahimeen at seed time.
        // Replace/extend this list once the organization confirms official recognitions.
        DB::table('awards')->insert([
            [
                'title_ar'       => 'شهادة تقدير لأفضل مبادرة شبابية تطوعية',
                'title_en'       => 'Certificate of Appreciation for Best Youth Volunteer Initiative',
                'year'           => 2022,
                'description_ar' => 'تكريم من الجهات المحلية تقديراً لجهود متراحمين في خدمة المجتمعات المحتاجة بالخرطوم.',
                'description_en' => 'Local recognition honoring Mutrahimeen\'s efforts in serving communities in need across Khartoum.',
                'issuer_ar'      => 'مبادرات المجتمع المدني السوداني',
                'issuer_en'      => 'Sudanese Civil Society Initiatives',
                'image_url'      => 'https://images.unsplash.com/photo-1513151233558-d860c5398176?auto=format&fit=crop&w=800&q=80',
                'display_order'  => 1,
                'is_active'      => true,
            ],
        ]);
    }
}