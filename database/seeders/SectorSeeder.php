<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('sectors')->delete();
        $states = array(
            array('id' => 1, 'name' => "Administrativo", 'description' => "Departamento Administrativo, não vinculado a produção"),
            array('id' => 2, 'name' => "Produção", 'description' => "Departamento Produtivo, Destinado a Fabricação de Produtos"),
        );
        DB::table('sectors')->insert($states);
    }
}
