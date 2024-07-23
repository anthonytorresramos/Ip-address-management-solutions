<?php

namespace App\Http\Controllers;

use App\Models\IpManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IpManagementController extends Controller
{
    public function index()
    {
        return IpManagement::with('user')->get();
    }


    public function store(Request $request)
    {
        $request->validate([
            'mac_address' => 'required|string|max:255',
            'label' => 'required|string|max:255',
        ]);

        $ipManagement = new IpManagement([
            'mac_address' => $request->mac_address,
            'label' => $request->label,
            'user_id' => Auth::id(),
        ]);

        $ipManagement->save();

        return response()->json($ipManagement, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $ipManagement = IpManagement::findOrFail($id);
        $ipManagement->label = $request->label;
        $ipManagement->user_id = Auth::id();
        $ipManagement->save();

        return IpManagement::with('user')->findOrFail($id);
    }
}
