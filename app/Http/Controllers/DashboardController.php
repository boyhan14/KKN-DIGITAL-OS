<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TenantService;

class DashboardController extends Controller
{
    public function index(Request $request, TenantService $tenantService)
    {
        $user = auth()->user();

        if ($user->isSuperAdmin() || $user->isCampusAdmin()) {
            return redirect()->route('campus.dashboard');
        }

        if ($user->isSupervisor()) {
            return redirect()->route('supervisor.dashboard');
        }

        if ($user->isVillageAdmin()) {
            $village = $tenantService->getUserVillage($user);
            if ($village) {
                return redirect()->route('village.workspace', $village->id);
            }
        }

        $group = $tenantService->getUserGroup($user);
        if ($group) {
            return redirect()->route('group.workspace', $group->id);
        }

        // Fallback to campus or public
        return redirect()->route('campus.dashboard');
    }
}
