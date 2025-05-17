<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Strand;

class StrandSeeder extends Seeder
{
    public function run()
    {
        $strands = [
            [
                'name' => 'Science, Technology, Engineering and Mathematics',
                'code' => 'STEM',
                'description' => 'STEM focuses on advanced concepts in Science, Technology, Engineering, and Mathematics.',
                'status' => 'active',
                'capacity' => 40
            ],
            [
                'name' => 'Accountancy, Business and Management',
                'code' => 'ABM',
                'description' => 'ABM focuses on basic business concepts and theories.',
                'status' => 'active',
                'capacity' => 40
            ],
            [
                'name' => 'Humanities and Social Sciences',
                'code' => 'HUMSS',
                'description' => 'HUMSS focuses on human behavior and social sciences.',
                'status' => 'active',
                'capacity' => 40
            ]
        ];

        foreach ($strands as $strand) {
            Strand::create($strand);
        }
    }
}
