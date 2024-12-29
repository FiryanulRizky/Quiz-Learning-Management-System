<?php

use Illuminate\Database\Seeder;

class MateriModulTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materi_moduls = [
            [
                'materi_judul'	=> 'Manajemen Setting',
                'materi_nama'	=> 'materi_setting.pdf',
                'materi_departemen'	=> 'Manajemen',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 1,
            ],
            [
                'materi_judul'	=> 'Modul Marketing',
                'materi_nama'	=> 'modul_marketing.pdf',
                'materi_departemen'	=> 'Marketing',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 2,
            ],
            [
                'materi_judul'	=> 'Modul Operasional',
                'materi_nama'	=> 'modul_operasional.pdf',
                'materi_departemen'	=> 'Operasional',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 3,
            ],
            [
                'materi_judul'	=> 'Menu Billing',
                'materi_nama'	=> 'menu_billinng.pdf',
                'materi_departemen'	=> 'Billing',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 4,
            ],
            [
                'materi_judul'	=> 'Menu Payable Payment',
                'materi_nama'	=> 'menu_payable_payment.pdf',
                'materi_departemen'	=> 'Account Payable',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 5,
            ],
            [
                'materi_judul'	=> 'Menu Receivable Payment',
                'materi_nama'	=> 'menu_receivable_payment.pdf',
                'materi_departemen'	=> 'Account Receivable',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 6,
            ],
            [
                'materi_judul'	=> 'Modul Warehouse',
                'materi_nama'	=> 'modul_warehouse.pdf',
                'materi_departemen'	=> 'Warehouse Inventory',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 7,
            ],
            [
                'materi_judul'	=> 'Menu Fleet Yard',
                'materi_nama'	=> 'menu_fleet_yard.pdf',
                'materi_departemen'	=> 'Fleet Yard',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 8,
            ],
            [
                'materi_judul'	=> 'Driver Apps',
                'materi_nama'	=> 'driver_apps.pdf',
                'materi_departemen'	=> 'Driver',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 9,
            ],
            [
                'materi_judul'	=> 'Modul Finance',
                'materi_nama'	=> 'modul_finance.pdf',
                'materi_departemen'	=> 'Finance Accounting',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 10,
            ],
            [
                'materi_judul'	=> 'Auditor',
                'materi_nama'	=> 'menu_auditor.pdf',
                'materi_departemen'	=> 'Auditor',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 11,
            ],
            [
                'materi_judul'	=> 'Modul Vehicle, Inventory & Tyre',
                'materi_nama'	=> 'modul_vehicle_inventory_tyre.pdf',
                'materi_departemen'	=> 'Asset Vehicle',
                'created_at'	=> '2024-19-12 16:00:00',
                'updated_at'	=> '2024-19-12 16:00:00',
                'id_modul'	=> 12,
            ]
        ];

        DB::table('materi_moduls')->insert($materi_moduls);
    }

}
