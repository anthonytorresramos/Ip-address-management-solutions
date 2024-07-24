<?php

use App\Models\User;
use App\Models\IpManagement;
use App\Models\Audit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, post, put, get};

uses(RefreshDatabase::class);

it('can fetch audit logs', function () {
    $user = User::factory()->create();
    $ipManagement = IpManagement::factory()->create(['ip_address' => '192.168.1.1', 'label' => 'Initial Label', 'user_id' => $user->id]);

    Audit::factory()->create([
        'ip_management_id' => $ipManagement->id,
        'user_id' => $user->id,
        'action' => 'created',
    ]);

    actingAs($user)->get('/api/audit-logs')
        ->assertStatus(200)
        ->assertJsonFragment(['action' => 'created']);
});

it('can fetch audit logs by user', function () {
    $user = User::factory()->create();
    $ipManagement = IpManagement::factory()->create(['ip_address' => '192.168.1.1', 'label' => 'Initial Label', 'user_id' => $user->id]);

    Audit::factory()->create([
        'ip_management_id' => $ipManagement->id,
        'user_id' => $user->id,
        'action' => 'created',
    ]);

    actingAs($user)->get("/api/audit-logs/user/{$user->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['action' => 'created']);
});

it('can fetch audit logs by ip address', function () {
    $user = User::factory()->create();
    $ipManagement = IpManagement::factory()->create(['ip_address' => '192.168.1.1', 'label' => 'Initial Label', 'user_id' => $user->id]);

    Audit::factory()->create([
        'ip_management_id' => $ipManagement->id,
        'user_id' => $user->id,
        'action' => 'created',
    ]);

    actingAs($user)->get("/api/audit-logs/ip-address/{$ipManagement->id}")
        ->assertStatus(200)
        ->assertJsonFragment(['action' => 'created']);
});
