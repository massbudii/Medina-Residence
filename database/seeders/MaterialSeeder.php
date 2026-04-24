<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\MaterialKawasan;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        // contoh data material
        $materials = [
            ['nama_material' => 'Besi Beton', 'satuan' => 'kg'],
            ['nama_material' => 'Semen', 'satuan' => 'sak'],
            ['nama_material' => 'Pasir', 'satuan' => 'm3'],
            ['nama_material' => 'Batu Bata', 'satuan' => 'pcs'],
            ['nama_material' => 'Kerikil', 'satuan' => 'm3'],
            ['nama_material' => 'Kayu Balok', 'satuan' => 'batang'],
            ['nama_material' => 'Paku', 'satuan' => 'kg'],
            ['nama_material' => 'Cat Tembok', 'satuan' => 'kaleng'],
            ['nama_material' => 'Pipa PVC', 'satuan' => 'batang'],
            ['nama_material' => 'Kawat Beton', 'satuan' => 'roll'],
            ['nama_material' => 'Baja Ringan', 'satuan' => 'batang'],
            ['nama_material' => 'Kaca', 'satuan' => 'lembar'],
            ['nama_material' => 'Keramik', 'satuan' => 'dus'],
            ['nama_material' => 'Semen Instan', 'satuan' => 'sak'],
            ['nama_material' => 'Aspal', 'satuan' => 'kg'],
            ['nama_material' => 'Besi Hollow', 'satuan' => 'batang'],
            ['nama_material' => 'Triplek', 'satuan' => 'lembar'],
            ['nama_material' => 'Seng', 'satuan' => 'lembar'],
            ['nama_material' => 'Gipsum', 'satuan' => 'lembar'],
            ['nama_material' => 'Mortar', 'satuan' => 'sak'],
        ];

        foreach ($materials as $index => $data) {

            // 🔵 buat material
            $material = Material::create([
                'nama_material' => $data['nama_material'],
                'satuan' => $data['satuan'],
                'status' => 'aktif',
            ]);

            // 🔵 buat relasi (random biar variasi)
            MaterialKawasan::create([
                'material_id' => $material->id,
                'kawasan_id' => 1, // pastikan ada di tabel kawasan
                'type_unit_id' => ($index % 2) + 1, // 1 atau 2
            ]);

            // optional: tambah relasi kedua
            if ($index % 3 == 0) {
                MaterialKawasan::create([
                    'material_id' => $material->id,
                    'kawasan_id' => 1,
                    'type_unit_id' => 2,
                ]);
            }
        }
    }
}
