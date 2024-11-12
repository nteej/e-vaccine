<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use App\Models\Vaccine;
use App\Services\VaccinationService;
use Illuminate\Http\Request;
use App\Notifications\VaccinationScheduledNotification;
class VaccinationScheduleController extends Controller
{

    protected $vaccinationService;
    

   public function __construct(VaccinationService $vaccinationService)
   {
    $this->middleware('auth');
       $this->vaccinationService = $vaccinationService;
   }

   public function show(Vaccination $vaccination)
   {
       $availableTimeSlots = $this->vaccinationService->getAvailableTimeSlots();
       $locations = $this->vaccinationService->getAvailableLocations();
       // dd($vaccination);
       return view('vaccinations.schedule', compact('vaccination', 'availableTimeSlots', 'locations'));
   }

   public function store(Request $request, Vaccination $vaccination)
   {
       $validated = $request->validate([
           'date' => 'required|date|after:today',
           'time' => 'required|date_format:H:i',
           'location' => 'required|exists:vaccination_locations,id'
       ]);

       $this->vaccinationService->scheduleVaccination($vaccination, $validated);

       return redirect()->route('vaccinations.index')
           ->with('success', 'Vaccination scheduled successfully');
   }
}
