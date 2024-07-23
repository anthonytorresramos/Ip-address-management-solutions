<?php

namespace App\Services;

use App\Models\IpManagement;
use Illuminate\Support\Facades\Auth;

class IpManagementService
{
    public function getAllIpManagements()
    {
        return IpManagement::with('user')->get();
    }

    public function createIpManagement($data)
    {
        $ipManagement = new IpManagement([
            'mac_address' => $data['mac_address'],
            'label' => $data['label'],
            'user_id' => Auth::id(),
        ]);

        $ipManagement->save();

        return $ipManagement;
    }

    public function updateIpManagement($id, $data)
    {
        $ipManagement = IpManagement::findOrFail($id);
        $ipManagement->label = $data['label'];
        $ipManagement->user_id = Auth::id();
        $ipManagement->save();

        return IpManagement::with('user')->findOrFail($id); // This ensures the updated data with relationships is returned
    }
}
