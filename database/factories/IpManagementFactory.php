<?php

namespace Database\Factories;

use App\Models\IpManagement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IpManagementFactory extends Factory
{
    protected $model = IpManagement::class;

    public function definition()
    {
        return [
            'ip_address' => $this->faker->ipv4,
            'label' => $this->faker->word,
            'user_id' => User::factory(),
        ];
    }
}
