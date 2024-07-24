<?php

namespace App\Services;

use App\Models\IpManagement;
use App\Models\Audit;
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
            'ip_address' => $data['ip_address'],
            'label' => $data['label'],
            'user_id' => Auth::id(),
        ]);

        $ipManagement->save();

        // Log the creation action with the current state
        Audit::create([
            'ip_management_id' => $ipManagement->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'label' => $ipManagement->label,
        ]);

        return $ipManagement;
    }

    public function updateIpManagement($id, $data)
    {
        $ipManagement = IpManagement::findOrFail($id);
        $ipManagement->label = $data['label'] ;
        $ipManagement->user_id = Auth::id();
        $ipManagement->save();

        // Log the update action with the current state
        Audit::create([
            'ip_management_id' => $ipManagement->id,
            'user_id' => Auth::id(),
            'action' => 'updated',
            'label' => $ipManagement->label,
        ]);

        return IpManagement::with('user')->findOrFail($id);
    }

    public function getAllAuditLogs()
    {
        return Audit::with(['ipManagement', 'user'])
            ->orderByRaw("FIELD(action, 'created', 'updated'), created_at desc")
            ->get();
    }

    public function getAuditLogsByUser($userId)
    {
        return Audit::with(['ipManagement', 'user'])
            ->where('user_id', $userId)
            ->orderByRaw("FIELD(action, 'created', 'updated'), created_at desc")
            ->get();
    }

    public function getAuditLogsByIpAddress($ipAddressId)
    {
        return Audit::with(['ipManagement', 'user'])
            ->where('ip_management_id', $ipAddressId)
            ->orderByRaw("FIELD(action, 'created', 'updated'), created_at desc")
            ->get();
    }
}
