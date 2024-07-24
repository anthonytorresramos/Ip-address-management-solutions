<?php

namespace App\Http\Controllers;

use App\Http\Requests\IpManagementRequest;
use App\Services\IpManagementService;
use Illuminate\Http\Request;

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
        return response()->json($this->ipManagementService->createIpManagement($request->validated()), 201);
    }

    public function update(IpManagementRequest $request, $id)
    {
        return response()->json($this->ipManagementService->updateIpManagement($id, $request->validated()));
    }

    public function getAllAuditLogs()
    {
        return response()->json($this->ipManagementService->getAllAuditLogs());
    }

    public function getAuditLogsByUser($userId)
    {
        return response()->json($this->ipManagementService->getAuditLogsByUser($userId));
    }

    public function getAuditLogsByIpAddress($ipAddressId)
    {
        return response()->json($this->ipManagementService->getAuditLogsByIpAddress($ipAddressId));
    }
}
