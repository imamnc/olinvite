<?php

namespace Database\Seeders;

use App\Models\BankChannel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'name' => 'Bank Central Asia',
                'short_name' => 'bca',
                'logo' => null
            ],
            [
                'name' => 'Bank Mandiri',
                'short_name' => 'mandiri',
                'logo' => null
            ],
            [
                'name' => 'Bank Rakyat Indonesia',
                'short_name' => 'bri',
                'logo' => null
            ],
            [
                'name' => 'Bank Nasional Indonesia',
                'short_name' => 'bni',
                'logo' => null
            ],
            [
                'name' => 'Bank Tabungan Negara',
                'short_name' => 'btn',
                'logo' => null
            ],
            [
                'name' => 'Bank CIMB Niaga',
                'short_name' => 'cimb',
                'logo' => null
            ],
            [
                'name' => 'Bank Danamon',
                'short_name' => 'danamon',
                'logo' => null
            ],
            [
                'name' => 'Bank Syariah Indonesia',
                'short_name' => 'bsi',
                'logo' => null
            ],
            [
                'name' => 'Bank Permata',
                'short_name' => 'permata',
                'logo' => null
            ],
            [
                'name' => 'Bank OCBC NISP',
                'short_name' => 'ocbc',
                'logo' => null
            ],
            [
                'name' => 'Bank Panin',
                'short_name' => 'panin',
                'logo' => null
            ],
            [
                'name' => 'Dana',
                'short_name' => 'dana',
                'logo' => null
            ],
            [
                'name' => 'Gopay',
                'short_name' => 'gopay',
                'logo' => null
            ],
            [
                'name' => 'ShopeePay',
                'short_name' => 'shopeepay',
                'logo' => null
            ],
            [
                'name' => 'OVO',
                'short_name' => 'ovo',
                'logo' => null
            ],
        ];
        collect($banks)->each(function ($bank) {
            BankChannel::create($bank);
        });
    }
}
