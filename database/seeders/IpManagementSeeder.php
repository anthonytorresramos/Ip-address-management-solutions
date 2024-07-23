<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IpManagement;

class IpManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IpManagement::create([
            'mac_address' => '00:1A:2B:3C:4D:5E',
            'label' => 'Device 1',
            'user_id' => 1, // Assuming user with ID 1 exists
        ]);

        IpManagement::create([
            'mac_address' => '11:22:33:44:55:66',
            'label' => 'Device 2',
            'user_id' => 1, // Assuming user with ID 1 exists
        ]);

        IpManagement::create([
            'mac_address' => 'AA:BB:CC:DD:EE:FF',
            'label' => 'Device 3',
            'user_id' => 1, // Assuming user with ID 1 exists
        ]);
    }
}
