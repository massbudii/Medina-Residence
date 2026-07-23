<?php

use App\Models\Kawasan;
use App\Models\Material;
use App\Models\MaterialKawasan;
use App\Models\TypeUnit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::create([
        'nama' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]));
});

it('keeps existing material relations when no type units are submitted during update', function () {

    $kawasan = Kawasan::create([
        'nama_kawasan' => 'Kawasan Test',
        'alamat' => 'Alamat Test',
        'status' => 'aktif',
    ]);

    $typeUnit = TypeUnit::create([
        'nama_type' => 'Type Test',
        'luas_bangunan' => 100,
        'luas_tanah' => 200,
        'harga_rumah' => 500000000,
    ]);

    $material = Material::create([
        'nama_material' => 'Semen',
        'satuan' => 'zak',
        'status' => 'aktif',
    ]);

    MaterialKawasan::create([
        'material_id' => $material->id,
        'kawasan_id' => $kawasan->id,
        'type_unit_id' => $typeUnit->id,
    ]);

    $response = $this->put(route('material.update', $material->id), [
            'nama_material' => 'Semen Baru',
            'satuan' => 'kg',
            'kawasan_id' => $kawasan->id,
            'type_unit_id' => [],
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('materials', [
        'id' => $material->id,
        'nama_material' => 'Semen Baru',
        'satuan' => 'kg',
    ]);

    $this->assertEquals(1, MaterialKawasan::where('material_id', $material->id)->count());
});
