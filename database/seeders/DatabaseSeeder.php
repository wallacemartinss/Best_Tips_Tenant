<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Wallace',
            'last_name' => 'Martins da Silva',
            'email' => 'wallacemartinss@gmail.com',
            'document_number' => '000.000.000-00',
            'is_admin' => true,
        ]);

        $this->call(UnitSeeder::class);
        $this->call(MensureSeeder::class);
        $this->call(SectorSeeder::class);
        $this->call(CompanyTypeSeeder::class);

    }
}
