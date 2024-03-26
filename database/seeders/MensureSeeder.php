<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MensureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //
        DB::table('mensures')->delete();
        $states = array(
            array('name' => "Quilômetro", 'description' => "Quilômetro", 'simbol' => "km",  'unit_id' => 1),
            array('name' => "Metro", 'description' => "Metro", 'simbol' => "m", 'unit_id' => 1),
            array('name' => "Centímetro", 'description' => "Centímetro", 'simbol' => "cm", 'unit_id' => 1),
            array('name' => "Milímetro", 'description' => "Milímetro", 'simbol' => "mm", 'unit_id' => 1),
            array('name' => "Quilograma", 'description' => "Quilograma", 'simbol' => "kg", 'unit_id' => 2),
            array('name' => "Grama", 'description' => "Grama", 'simbol' => "g", 'unit_id' => 2),
            array('name' => "Miligrama", 'description' => "Miligrama", 'simbol' => "mg",  'unit_id' => 2),
            array('name' => "Litro", 'description' => "Litro", 'simbol' => "l",  'unit_id' => 3),
            array('name' => "Quilometro quadrado", 'description' => "Quilometro quadrado", 'simbol' => "km²", 'unit_id' => 4),
            array('name' => "Metro quadrado", 'description' => "Metro quadrado", 'simbol' => "m", 'unit_id' => 4),
            array('name' => "Metro cúbico", 'description' => "Metro cúbico", 'simbol' => "m", 'unit_id' => 5),
            array('name' => "Mês", 'description' => "Mês", 'simbol' => "M", 'unit_id' => 6),
            array('name' => "Dia", 'description' => "Dia", 'simbol' => "D", 'unit_id' => 6),
            array('name' => "Hora", 'description' => "Hora", 'simbol' => "H", 'unit_id' => 6),
            array('name' => "Minuto", 'description' => "Minuto", 'simbol' => "M", 'unit_id' => 6),
            array('name' => "Segundo", 'description' => "Segundo", 'simbol' => "S", 'unit_id' => 6),
            array('name' => "Unidade", 'description' => "Unidade", 'simbol' => "Un", 'unit_id' => 7),
            array('name' => "Peça", 'description' => "Peça", 'simbol' => "Pça", 'unit_id' => 7),
            array('name' => "Fardo", 'description' => "Fardo", 'simbol' => "Fa", 'unit_id' => 8),
            array('name' => "Pacote", 'description' => "Pacote", 'simbol' => "PC", 'unit_id' => 8),

        );
        DB::table('mensures')->insert($states);
    }
}
