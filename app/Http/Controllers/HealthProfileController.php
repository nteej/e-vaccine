<?php
namespace App\Http\Controllers;
use App\Http\Requests\UpdateHealthProfileRequest;
use App\Models\HealthCondition;
use App\Services\HealthProfileService;
use Illuminate\Http\Request;

class HealthProfileController extends Controller
{
    protected $healthProfileService;

    public function __construct(HealthProfileService $healthProfileService)
    {
        $this->healthProfileService = $healthProfileService;
    }

    public function index()
    {
        $user = auth()->user();
        $healthConditions = HealthCondition::all();
        $userHealthConditions = $user->healthConditions->pluck('id')->toArray();

        $healthProfile = $this->healthProfileService->getUserHealthProfile($user);
        $riskAssessment = $this->healthProfileService->calculateRiskAssessment($user);
        $recommendedActions = $this->healthProfileService->getRecommendedActions($user);
        $allergy=json_decode($user->allergies);
        $medication=json_decode($user->medications);
        return view('health-profile.index', compact(
            'user',
            'healthConditions',
            'userHealthConditions',
            'healthProfile',
            'riskAssessment',
            'recommendedActions',
            'allergy','medication'
        ));
    }

    public function update(UpdateHealthProfileRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        $this->healthProfileService->updateHealthProfile($user, $validated);

        return redirect()->route('health-profile.index')
            ->with('success', 'Health profile updated successfully');
    }
}