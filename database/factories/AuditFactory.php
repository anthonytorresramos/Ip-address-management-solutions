<?php

namespace Database\Factories;

use App\Models\Audit;
use App\Models\IpManagement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditFactory extends Factory
{
    protected $model = Audit::class;

    public function definition()
    {
        return [
            'ip_management_id' => IpManagement::factory(),
            'user_id' => User::factory(),
            'action' => 'created',
            'label' => $this->faker->word,
            'created_at' => now(),
        ];
    }
}
