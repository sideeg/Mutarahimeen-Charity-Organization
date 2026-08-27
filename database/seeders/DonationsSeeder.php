<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationsSeeder extends Seeder
{
    public function run(): void
    {
        $projects   = DB::table('projects')->pluck('id')->toArray();
        $methods    = ['bankak', 'fawri', 'mycash', 'bank_transfer'];
        $donorNames = [
            'أحمد محمد', 'فاطمة علي', 'عمر عبدالله', 'خديجة يوسف',
            'محمود إبراهيم', 'آمنة حسن', 'يوسف عثمان', null, null,
        ];

        $donations = [];
        foreach (range(1, 30) as $i) {
            $donations[] = [
                'project_id'            => $i <= 5
                    ? null
                    : $projects[array_rand($projects)],
                'donor_name'            => $donorNames[array_rand($donorNames)],
                'email'                 => null,
                'phone'                 => '09' . rand(10000000, 99999999),
                'amount'                => [500, 1000, 2000, 5000, 10000, 50000][array_rand([0,1,2,3,4,5])],
                'payment_method'        => $methods[array_rand($methods)],
                'donation_type'         => 'one_time',
                'status'                => 'confirmed',
                'transaction_reference' => 'TXN-' . strtoupper(substr(md5($i), 0, 8)),
                'admin_notes'           => null,
                'created_at'            => now()->subDays(rand(1, 365)),
                'updated_at'            => now(),
            ];
        }

        DB::table('donations')->insert($donations);
    }
}
