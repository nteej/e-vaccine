<?php
namespace App\Services;

use App\Models\Vaccination;
use App\Models\VaccinationLocation;
use Carbon\Carbon;
use App\Notifications\VaccinationScheduledNotification;

class VaccinationService
{
   public function getAvailableTimeSlots(): array
   {
       $slots = [];
       $start = Carbon::parse('09:00');
       $end = Carbon::parse('17:00');

       while ($start <= $end) {
           $slots[] = $start->format('H:i');
           $start->addMinutes(30);
       }

       return $slots;
   }

   public function getAvailableLocations()
   {
       return VaccinationLocation::where('is_active', true)->get();
   }

   public function scheduleVaccination(Vaccination $vaccination, array $data)
   {
       $appointmentDate = Carbon::parse($data['date'] . ' ' . $data['time']);
       
       $vaccination->update([
           'appointment_date' => $appointmentDate,
           'location_id' => $data['location'],
           'status' => 'scheduled'
       ]);

       // Send confirmation notification
       $vaccination->user->notify(new VaccinationScheduledNotification($vaccination));
   }
}
