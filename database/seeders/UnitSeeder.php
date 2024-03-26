<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('units')->delete();
        $states = array(
            array('id' => 1, 'name' => "Tamanho / Comprimento", 'description' => "Unidades de medida de comprimento"),
            array('id' => 2, 'name' => "Peso / Massa", 'description' => "Unidades de medida de massa"),
            array('id' => 3, 'name' => "Litro / Capacidade", 'description' => "Unidades de medida de capacidade"),
            array('id' => 4, 'name' => "Área", 'description' => "Unidades de medida de área"),
            array('id' => 5, 'name' => "Volume", 'description' => "Unidades de medida de volume"),
            array('id' => 6, 'name' => "Tempo", 'description' => "Unidades de medida de Tempo"),
            array('id' => 7, 'name' => "Unidade / Peça", 'description' => "Unidades de medida de peça"),
            array('id' => 8, 'name' => "Fardo / Pacote", 'description' => "Unidades de medida de pacote"),


        );
        DB::table('units')->insert($states);
    }
}
