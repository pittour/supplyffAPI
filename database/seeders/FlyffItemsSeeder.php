<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlyffItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $items_id = Http::withOptions([
            'verify' => base_path('cacert.pem'),
        ])->get('api.flyff.com/item')->json();

        $batchSize = 1000;
        $api_items = [];

        for ($i = 0; $i <= count($items_id); $i += $batchSize) {
            sleep(5);
            $currentBatch = array_slice($items_id, $i, $batchSize);
            $batch_items = Http::withOptions([
                'verify' => base_path('cacert.pem'),
            ])->get('api.flyff.com/item/' . implode(",",  $currentBatch))->json();

            $api_items = array_merge($api_items, $batch_items);
        }

        foreach ($api_items as $item) {
            DB::table('flyffapi_items')->updateOrInsert(
                ['flyff_api_id' => $item['id']],
                [
                    'flyff_api_id' => $item['id'],
                    'name' => $item['name']['en'],
                    'category' => $item['category'],
                    'subcategory' => $item['subcategory'] ?? null,
                    'rarity' => $item['rarity'],
                    'class_id' => $item['class'] ?? null,
                    'level' => $item['level'],
                    'sex' => $item['sex'] ?? null,
                    'tradable' => $item['tradable'],
                    'icon' => $item['icon'],
                ]
            );
        }
    }
}
