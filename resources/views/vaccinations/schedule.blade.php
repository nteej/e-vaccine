@extends('layouts.me')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
   <div class="max-w-3xl mx-auto">
       <div class="bg-white shadow overflow-hidden sm:rounded-lg">
           <div class="px-4 py-5 sm:px-6">
               <h2 class="text-lg font-medium text-gray-900">Schedule Vaccination</h2>
               <p class="mt-1 text-sm text-gray-500">{{ $vaccination->vaccine->name }}</p>
           </div>
           
           <form action="{{ route('vaccination.schedule.store', $vaccination) }}" method="POST">
               @csrf
               <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                   <!-- Date Selection -->
                   <div class="mb-6">
                       <label class="block text-sm font-medium text-gray-700">Select Date</label>
                       <input type="date" 
                              name="date" 
                              min="{{ now()->addDay()->format('Y-m-d') }}"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                   </div>

                   <!-- Time Slots -->
                   <div class="mb-6">
                       <label class="block text-sm font-medium text-gray-700">Select Time</label>
                       <select name="time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                           @foreach($availableTimeSlots as $slot)
                               <option value="{{ $slot }}">{{ Carbon\Carbon::parse($slot)->format('g:i A') }}</option>
                           @endforeach
                       </select>
                   </div>

                   <!-- Location Selection -->
                   <div class="mb-6">
                       <label class="block text-sm font-medium text-gray-700">Select Location</label>
                       <select name="location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                           @foreach($locations as $location)
                               <option value="{{ $location->id }}">{{ $location->name }}</option>
                           @endforeach
                       </select>
                   </div>

                   <div class="mt-6">
                       <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                           Schedule Vaccination
                       </button>
                   </div>
               </div>
           </form>
       </div>
   </div>
</div>
@endsection