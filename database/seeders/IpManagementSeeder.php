<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IpManagement;
use App\Models\Audit;
use App\Models\User;
use Str;

class IpManagementSeeder extends Seeder
{
    public function run()
    {
        // Get all users
        $users = User::all();

        for ($i = 0; $i < 30; $i++) {
            $user = $users->random();

            $ipManagement = IpManagement::create([
                'ip_address' => 'MAC' . Str::random(5),
                'label' => 'Label' . $i,
                'user_id' => $user->id,
            ]);

            // Log the creation action
            Audit::create([
                'ip_management_id' => $ipManagement->id,
                'user_id' => $user->id,
                'action' => 'created',
            ]);

            // Optionally, add some updates to the audit log
            for ($j = 0; $j < rand(1, 5); $j++) {
                $updatingUser = $users->random();

                $ipManagement->update(['label' => 'UpdatedLabel' . Str::random(5), 'user_id' => $updatingUser->id]);

                // Log the update action
                Audit::create([
                    'ip_management_id' => $ipManagement->id,
                    'user_id' => $updatingUser->id,
                    'action' => 'updated',
                ]);
            }
        }
    }
}
