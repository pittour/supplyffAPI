<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FlyffClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes_id = Http::withOptions([
            'verify' => base_path('cacert.pem'),
        ])->get('api.flyff.com/class')->json();

        $api_classes = Http::withOptions([
            'verify' => base_path('cacert.pem'),
        ])->get('api.flyff.com/class/' . implode(",",  $classes_id))->json();

        foreach ($api_classes as $class) {
            DB::table('flyffapi_classes')->updateOrInsert(
                ['flyff_api_id' => $class['id']],
                [
                    'flyff_api_id' => $class['id'],
                    'name' => $class['name']['en'],
                ]
            );
        }
    }
}
