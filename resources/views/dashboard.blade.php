@extends('layouts.me')

@section('content')
    <div class="min-h-screen">
        <!-- Main Content -->
        <main class="py-6">
             <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Welcome Section -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->first_name }}!</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Here's your vaccination status and upcoming schedule
                    </p>
                </div>

                <!-- Health Alerts Section -->
                @if(count($healthAlerts) > 0)
                <div class="mb-6">
                    <div class="rounded-lg bg-white shadow">
                        <div class="p-4">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Health Alerts</h2>
                            <div class="space-y-3">
                                @foreach($healthAlerts as $alert)
                                    <div class="flex items-center px-4 py-3 rounded-lg
                                        @if($alert['type'] === 'danger') bg-red-50
                                        @elseif($alert['type'] === 'warning') bg-yellow-50
                                        @elseif($alert['type'] === 'success') bg-green-50
                                        @else bg-blue-50 @endif">
                                        <!-- Alert Icon -->
                                        <div class="flex-shrink-0">
                                            @if($alert['type'] === 'danger')
                                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <!-- Alert Content -->
                                        <div class="ml-3">
                                            <p class="text-sm font-medium
                                                @if($alert['type'] === 'danger') text-red-800
                                                @elseif($alert['type'] === 'warning') text-yellow-800
                                                @elseif($alert['type'] === 'success') text-green-800
                                                @else text-blue-800 @endif">
                                                {{ $alert['message'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Stats Overview -->
                <div class="mb-8">
                    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <!-- Completion Rate -->
                        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                            <dt>
                                <div class="absolute bg-indigo-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Completion Rate</p>
                            </dt>
                            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-900">{{ $completionStats['completion_percentage'] }}%</p>
                            </dd>
                        </div>

                        <!-- Due Vaccines -->
                        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                            <dt>
                                <div class="absolute bg-red-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Due Now</p>
                            </dt>
                            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-900">{{ $completionStats['due_count'] }}</p>
                            </dd>
                        </div>

                        <!-- Upcoming -->
                        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                            <dt>
                                <div class="absolute bg-yellow-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Upcoming</p>
                            </dt>
                            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-900">{{ $completionStats['recommended_count'] }}</p>
                            </dd>
                        </div>

                        <!-- Completed -->
                        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                            <dt>
                                <div class="absolute bg-green-500 rounded-md p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Completed</p>
                            </dt>
                            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-900">{{ $completionStats['completed_count'] }}</p>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Due Vaccinations -->
                @if(count($dueVaccinations) > 0)
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Due Vaccinations</h2>
                        <p class="mt-1 text-sm text-gray-500">Vaccinations that require immediate attention</p>
                    </div>
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($dueVaccinations as $vaccination)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($vaccination['priority'] >= 40) bg-red-100 text-red-800
                                            @elseif($vaccination['priority'] >= 30) bg-orange-100 text-orange-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            Priority: {{ $vaccination['priority'] }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-gray-900">{{ $vaccination['vaccine']->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $vaccination['vaccine']->description }}</p>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" onclick="window.location.href='{{ route('vaccine.schedule', $vaccination['vaccine']->id) }}'" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Schedule Now
                                    </button>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Recent Vaccination History -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Recent Vaccination History</h2>
                        <p class="mt-1 text-sm text-gray-500">Your most recent vaccinations</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vaccine</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provider</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Due</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($vaccinationHistory as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $record->vaccine->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $record->administration_date->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $record->administered_by }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $record->next_due_date ? $record->next_due_date->format('M d, Y') : 'N/A' }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection