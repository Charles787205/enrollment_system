<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\StrandSeeder;  // Correct namespace for the import

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the StrandSeeder
        $this->call([
            StrandSeeder::class,  // Ensure the correct class name here
        ]);
    }
}
