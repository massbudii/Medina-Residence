<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_material' => 'Semen', 'satuan' => 'zak'],
            ['nama_material' => 'Pasir', 'satuan' => 'm3'],
            ['nama_material' => 'Kerikil', 'satuan' => 'm3'],
            ['nama_material' => 'Batu Bata', 'satuan' => 'pcs'],
            ['nama_material' => 'Batu Kali', 'satuan' => 'm3'],
            ['nama_material' => 'Besi Beton', 'satuan' => 'batang'],
            ['nama_material' => 'Besi Wiremesh', 'satuan' => 'lembar'],
            ['nama_material' => 'Kayu Balok', 'satuan' => 'batang'],
            ['nama_material' => 'Papan', 'satuan' => 'lembar'],
            ['nama_material' => 'Triplek', 'satuan' => 'lembar'],
            ['nama_material' => 'Paku', 'satuan' => 'kg'],
            ['nama_material' => 'Cat Tembok', 'satuan' => 'kaleng'],
            ['nama_material' => 'Keramik', 'satuan' => 'dus'],
            ['nama_material' => 'Plafon Gypsum', 'satuan' => 'lembar'],
            ['nama_material' => 'Pipa PVC', 'satuan' => 'batang'],
            ['nama_material' => 'Kabel Listrik', 'satuan' => 'roll'],
            ['nama_material' => 'Saklar', 'satuan' => 'pcs'],
            ['nama_material' => 'Stop Kontak', 'satuan' => 'pcs'],
            ['nama_material' => 'Genteng', 'satuan' => 'pcs'],
            ['nama_material' => 'Kloset', 'satuan' => 'pcs'],
        ];

        foreach ($data as $item) {
            Material::create([
                'nama_material' => $item['nama_material'],
                'satuan' => $item['satuan'],
                'status' => 'aktif'
            ]);
        }
    }
}
