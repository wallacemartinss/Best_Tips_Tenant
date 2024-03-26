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
            array('name' => "Quilômetro", 'description' => "Quilômetro", 'simbol' => "km",  'units_id' => 1),
            array('name' => "Metro", 'description' => "Metro", 'simbol' => "m", 'units_id' => 1),
            array('name' => "Centímetro", 'description' => "Centímetro", 'simbol' => "cm", 'units_id' => 1),
            array('name' => "Milímetro", 'description' => "Milímetro", 'simbol' => "mm", 'units_id' => 1),
            array('name' => "Quilograma", 'description' => "Quilograma", 'simbol' => "kg", 'units_id' => 2),
            array('name' => "Grama", 'description' => "Grama", 'simbol' => "g", 'units_id' => 2),
            array('name' => "Miligrama", 'description' => "Miligrama", 'simbol' => "mg",  'units_id' => 2),
            array('name' => "Litro", 'description' => "Litro", 'simbol' => "l",  'units_id' => 3),
            array('name' => "Quilometro quadrado", 'description' => "Quilometro quadrado", 'simbol' => "km²", 'units_id' => 4),
            array('name' => "Metro quadrado", 'description' => "Metro quadrado", 'simbol' => "m", 'units_id' => 4),
            array('name' => "Metro cúbico", 'description' => "Metro cúbico", 'simbol' => "m", 'units_id' => 5),
            array('name' => "Mês", 'description' => "Mês", 'simbol' => "M", 'units_id' => 6),
            array('name' => "Dia", 'description' => "Dia", 'simbol' => "D", 'units_id' => 6),
            array('name' => "Hora", 'description' => "Hora", 'simbol' => "H", 'units_id' => 6),
            array('name' => "Minuto", 'description' => "Minuto", 'simbol' => "M", 'units_id' => 6),
            array('name' => "Segundo", 'description' => "Segundo", 'simbol' => "S", 'units_id' => 6),
            array('name' => "Unidade", 'description' => "Unidade", 'simbol' => "Un", 'units_id' => 7),
            array('name' => "Peça", 'description' => "Peça", 'simbol' => "Pça", 'units_id' => 7),
            array('name' => "Fardo", 'description' => "Fardo", 'simbol' => "Fa", 'units_id' => 8),
            array('name' => "Pacote", 'description' => "Pacote", 'simbol' => "PC", 'units_id' => 8),

        );
        DB::table('mensures')->insert($states);
    }
}
