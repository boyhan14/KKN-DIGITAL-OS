<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\Campus;
use App\Models\KknGroup;
use App\Models\Umkm;
use App\Models\Program;
use App\Models\HandoverPackage;

class LandingController extends Controller
{
    public function index()
    {
        $demoVillage = Village::where('slug', 'sukamaju')->first() ?? Village::first();
        
        $stats = [
            'total_villages' => Village::count(),
            'total_groups' => KknGroup::count(),
            'total_umkm' => Umkm::where('status', 'PUBLISHED')->count(),
            'total_programs' => Program::count(),
            'completed_handovers' => HandoverPackage::where('status', 'COMPLETED')->count(),
        ];

        $recentVillages = Village::with('profile')
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('landing.index', compact('demoVillage', 'stats', 'recentVillages'));
    }
}
