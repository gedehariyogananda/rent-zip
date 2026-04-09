<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MaintenanceService;
use App\Services\CostumService;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    protected MaintenanceService $maintenanceService;
    protected CostumService $costumService;

    public function __construct(MaintenanceService $maintenanceService, CostumService $costumService)
    {
        $this->maintenanceService = $maintenanceService;
        $this->costumService = $costumService;
    }

    public function index()
    {
        $maintenances = $this->maintenanceService->getAll();
        return view('admin.maintenances.index', compact('maintenances'));
    }

    public function create()
    {
        $costums = $this->costumService->getAll();
        return view('admin.maintenances.create', compact('costums'));
    }

    public function store(Request $request)
    {
        // TODO: implement
        return redirect()->route('admin.maintenances.index');
    }

    public function show($id)
    {
        $maintenance = $this->maintenanceService->find($id);
        return view('admin.maintenances.show', compact('maintenance'));
    }

    public function edit($id)
    {
        $maintenance = $this->maintenanceService->find($id);
        $costums = $this->costumService->getAll();
        return view('admin.maintenances.edit', compact('maintenance', 'costums'));
    }

    public function update(Request $request, $id)
    {
        // TODO: implement
        return redirect()->route('admin.maintenances.index');
    }

    public function destroy($id)
    {
        // TODO: implement
        return redirect()->route('admin.maintenances.index');
    }
}
