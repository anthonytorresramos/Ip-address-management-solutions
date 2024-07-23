<?php

namespace App\Http\Controllers;

use App\Http\Requests\IpManagementRequest;
use App\Services\IpManagementService;

class IpManagementController extends Controller
{
    protected $ipManagementService;

    public function __construct(IpManagementService $ipManagementService)
    {
        $this->ipManagementService = $ipManagementService;
    }

    public function index()
    {
        return $this->ipManagementService->getAllIpManagements();
    }

    public function store(IpManagementRequest $request)
    {
        $ipManagement = $this->ipManagementService->createIpManagement($request->validated());

        return response()->json($ipManagement, 201);
    }

    public function update(IpManagementRequest $request, $id)
    {
        $ipManagement = $this->ipManagementService->updateIpManagement($id, $request->validated());

        return response()->json($ipManagement);
    }
}
