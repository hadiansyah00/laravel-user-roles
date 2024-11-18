<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            'matakuliah-list',
            'matakuliah-create',
            'matakuliah-edit',
            'matakuliah-delete',
            'jadwal-list',
            'jadwal-create',
            'jadwal-edit',
            'jadwal-delete'
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}