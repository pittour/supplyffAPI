<?php

namespace Tests\Feature;

use App\Models\Classified;
use App\Models\Item;
use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClassifiedTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function test_authenticated_user_can_create_classified()
    {
        $user = User::factory()->create([
            'server_id' => Server::first()->id
        ]);
        $this->actingAs($user);

        $data = [
            'general_level' => 10,
            'elemental_level' => 5,
            'element_type' => 'fire',
            'weekly_rate' => 500000,
            'deposit' => 1000000,
            'description' => $this->faker->sentence(10),
            'awake' => false,
            'piercings' => true,
            'free_boolean' => false,
            'item' => [
                'flyff_api_id' => 1,
            ],
        ];

        $response = $this->post('/api/classified', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('classifieds', [

            'weekly_rate' => $data['weekly_rate'],
            'deposit' => $data['deposit'],
            'description' => $data['description'],
            'is_free' => $data['free_boolean'],
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('items', [
            'classified_id' => Classified::latest()->first()->id,
            'flyffapi_item_id' => $data['item']['flyff_api_id'],
            'general_level' => $data['general_level'],
            'elemental_level' => $data['elemental_level'],
            'element_type' => $data['element_type'],
            'piercings' => $data['piercings'],
            'awake' => $data['awake'],
        ]);
    }
}
