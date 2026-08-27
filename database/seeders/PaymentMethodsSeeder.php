<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'method_name_ar'  => 'بنكك',
                'method_name_en'  => 'Bankak',
                'account_name'    => 'منظمة متراحمين الخيرية',
                'account_number'  => '1147823',
                'instructions_ar' => 'أرسل مبلغ التبرع عبر تطبيق بنكك على الرقم المذكور.',
                'instructions_en' => 'Transfer your donation using the Bankak mobile application to the provided account number.',
                'icon_url'        => null,
                'display_order'   => 1,
                'is_active'       => true,
            ],
            [
                'method_name_ar'  => 'فوري',
                'method_name_en'  => 'Fawri',
                'account_name'    => 'منظمة متراحمين الخيرية',
                'account_number'  => '40017632',
                'instructions_ar' => 'أرسل مبلغ التبرع عبر خدمة فوري على الرقم المذكور.',
                'instructions_en' => 'Submit your donation using Fawri payment services to the provided merchant code.',
                'icon_url'        => null,
                'display_order'   => 2,
                'is_active'       => true,
            ],
            [
                'method_name_ar'  => 'MyCash',
                'method_name_en'  => 'MyCash',
                'account_name'    => 'منظمة متراحمين الخيرية',
                'account_number'  => '0900000000',
                'instructions_ar' => 'أرسل مبلغ التبرع عبر تطبيق MyCash على الرقم المذكور.',
                'instructions_en' => 'Send your donation via the MyCash application to the provided number.',
                'icon_url'        => null,
                'display_order'   => 3,
                'is_active'       => true,
            ],
        ]);
    }
}