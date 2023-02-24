<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servers = [
            ["region" => "Europe", "name" => "Burudeng"],
            ["region" => "Europe", "name" => "Genèse"],
            ["region" => "Europe", "name" => "Totemia"],
        ];

        foreach ($servers as $server) {
            DB::table('servers')->updateOrInsert(
                ['name' => $server['name']],
                [
                    'name' => $server['name'],
                    'region' => $server['region'],
                ]
            );
        }
    }
}
