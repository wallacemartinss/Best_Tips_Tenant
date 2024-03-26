<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('company_types')->delete();
        $states = array(
            array('id' => 1, 'name' => "MEI", 'description' => ""),
            array('id' => 2, 'name' => "ME (Microempresa)", 'description' => ""),
            array('id' => 3, 'name' => "EPP (Empresa de Pequeno Porte)", 'description' => ""),
            array('id' => 4, 'name' => "Empresário Individual", 'description' => ""),
            array('id' => 5, 'name' => "SLU (Sociedade Limitada Unipessoal)", 'description' => ""),
            array('id' => 6, 'name' => "LTDA (Sociedade Empresária Limitada)", 'description' => ""),
            array('id' => 7, 'name' => "Sociedade Simples", 'description' => ""),
            array('id' => 8, 'name' => "S.A (Sociedade Anônima)", 'description' => ""),
            array('id' => 9, 'name' => "Autônomo", 'description' => ""),

        );
        DB::table('company_types')->insert($states);
    }
}
