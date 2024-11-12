<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        DB::table('organizacion')->insert([
            'nomorg' => 'MINSITERIO',
            'sigla' => 'mindef',
            'idpadre' => 0,
        ]);
    }
}
