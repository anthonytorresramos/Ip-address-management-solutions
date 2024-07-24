<?php

use App\Models\User;
use App\Models\IpManagement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, post, put, get};

uses(RefreshDatabase::class);

it('can create an IP management entry', function () {
    $user = User::factory()->create();
    $data = [
        'ip_address' => '192.168.1.1',
        'label' => 'Test Label',
    ];

    actingAs($user)->post('/api/ip-management', $data)
        ->assertStatus(201)
        ->assertJsonFragment(['ip_address' => '192.168.1.1']);
});

it('ensures ip_address is unique', function () {
    $user = User::factory()->create();
    $data1 = [
        'ip_address' => '192.168.1.1',
        'label' => 'Test Label 1',
    ];
    $data2 = [
        'ip_address' => '192.168.1.1',
        'label' => 'Duplicate Test',
    ];

    actingAs($user)->post('/api/ip-management', $data1)
        ->assertStatus(201);

    actingAs($user)->post('/api/ip-management', $data2)
        ->assertStatus(422)
        ->assertJsonValidationErrors('ip_address');
});

it('can update an IP management entry with optional label and ensure ip_address is unchanged', function () {
    $user = User::factory()->create();
    $ipManagement = IpManagement::factory()->create([
        'ip_address' => '192.168.1.1',
        'label' => 'Initial Label',
    ]);

    $data = ['label' => 'Updated Label'];

    actingAs($user)->put("/api/ip-management/{$ipManagement->id}", $data)
        ->assertStatus(200)
        ->assertJsonFragment(['label' => 'Updated Label']);

    // Assert that ip_address has not changed
    $this->assertDatabaseHas('ip_management', [
        'ip_address' => '192.168.1.1',
        'label' => 'Updated Label'
    ]);

    // Ensure the ip_address was not updated
    $this->assertDatabaseHas('ip_management', [
        'ip_address' => '192.168.1.1',
        'label' => 'Updated Label'
    ]);
});

it('can fetch IP management entries', function () {
    $user = User::factory()->create();
    IpManagement::factory()->create([
        'ip_address' => '192.168.1.1',
        'label' => 'Test Label',
    ]);

    actingAs($user)->get('/api/ip-management')
        ->assertStatus(200)
        ->assertJsonFragment(['ip_address' => '192.168.1.1']);
});
