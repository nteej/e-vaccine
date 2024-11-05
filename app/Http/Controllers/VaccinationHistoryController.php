<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VaccinationHistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $vaccinations = Vaccination::with(['vaccine'])
            ->where('user_id', $user->id)
            ->orderBy('date_administered', 'desc')
            ->paginate(10);

        $upcomingVaccinations = Vaccination::with(['vaccine'])
            ->where('user_id', $user->id)
            ->where('next_due_date', '>', Carbon::now())
            ->orderBy('next_due_date')
            ->get();

        $completedVaccinations = Vaccination::with(['vaccine'])
            ->where('user_id', $user->id)
            ->whereNull('next_due_date')
            ->get();

        $stats = [
            'total_vaccinations' => $vaccinations->total(),
            'upcoming_count' => $upcomingVaccinations->count(),
            'completed_count' => $completedVaccinations->count(),
            'compliance_rate' => $this->calculateComplianceRate($user->id),
        ];

        return view('vaccinations.index', compact(
            'vaccinations',
            'upcomingVaccinations',
            'completedVaccinations',
            'stats'
        ));
    }

    private function calculateComplianceRate($userId)
    {
        $totalDue = Vaccination::where('user_id', $userId)
            ->where('next_due_date', '<', Carbon::now())
            ->count();

        $completed = Vaccination::where('user_id', $userId)
            ->where('next_due_date', '<', Carbon::now())
            ->where('status', 'completed')
            ->count();

        return $totalDue > 0 ? ($completed / $totalDue) * 100 : 100;
    }
}
