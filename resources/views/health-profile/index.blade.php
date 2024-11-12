@extends('layouts.me')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="space-y-6">
        <!-- Profile Summary -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium text-gray-900">Health Profile Summary</h2>
                <p class="mt-1 text-sm text-gray-500">Overview of your health information</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Blood Type</dt>

                        <dd class="mt-1 text-sm text-gray-900">{{ $user->blood_type ?? 'Not Specified' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Age</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->age }} years</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Primary Physician</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->primary_physician ?? 'Not Specified' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Physical Exam</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $healthProfile['last_physical_date'] ? Carbon\Carbon::parse($healthProfile['last_physical_date'])->format('M d, Y') : 'Not Available' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Risk Assessment -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium text-gray-900">Health Risk Assessment</h2>
                <p class="mt-1 text-sm text-gray-500">Current health risk factors and recommendations</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <div class="space-y-4">
                    <!-- Overall Risk Level -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $riskAssessment['risk_level'] === 'high' ? 'bg-red-100 text-red-800' :
                                   ($riskAssessment['risk_level'] === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($riskAssessment['risk_level']) }} Risk
                            </span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-700">{{ $riskAssessment['summary'] }}</p>
                        </div>
                    </div>

                    <!-- Risk Factors -->
                    @if(count($riskAssessment['risk_factors']) > 0)
                    <div class="mt-4">
                        <h3 class="text-sm font-medium text-gray-700">Risk Factors</h3>
                        <ul class="mt-2 space-y-2">
                            @foreach($riskAssessment['risk_factors'] as $factor)
                            <li class="flex items-start">
                                <span class="flex-shrink-0 h-5 w-5 text-red-500">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm text-gray-700">{{ $factor }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Recommended Actions -->
                    @if(count($recommendedActions) > 0)
                    <div class="mt-4">
                        <h3 class="text-sm font-medium text-gray-700">Recommended Actions</h3>
                        <ul class="mt-2 space-y-2">
                            @foreach($recommendedActions as $action)
                            <li class="flex items-start">
                                <span class="flex-shrink-0 h-5 w-5 text-blue-500">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm text-gray-700">{{ $action }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Health Conditions -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium text-gray-900">Health Conditions</h2>
                <p class="mt-1 text-sm text-gray-500">Current health conditions and chronic illnesses</p>
            </div>
            <div class="border-t border-gray-200">
                <form action="{{ route('health-profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="px-4 py-5 sm:px-6 space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($healthConditions as $condition)
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" 
                                           name="health_conditions[]" 
                                           value="{{ $condition->id }}"
                                           {{ in_array($condition->id, $userHealthConditions) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label class="font-medium text-gray-700">{{ $condition->name }}</label>
                                    <p class="text-gray-500">{{ $condition->description }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Health Conditions
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Allergies and Medications -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium text-gray-900">Allergies & Medications</h2>
                <p class="mt-1 text-sm text-gray-500">Current allergies and medications</p>
            </div>
            <div class="border-t border-gray-200">
                <div class="px-4 py-5 sm:px-6">
                    <!-- Allergies -->
                    <div x-data="{ allergies: {{ json_encode($allergy ?? []) }} }">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Allergies</h3>
                        <template x-for="(allergy, index) in allergies" :key="index">
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" x-model="allergies[index]" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <button @click="allergies.splice(index, 1)" type="button" class="inline-flex items-center p-1.5 border border-transparent rounded-full text-red-600 hover:bg-red-50">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <button @click="allergies.push('')" type="button" class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Allergy
                        </button>
                    </div>

                    <!-- Medications -->
                    <div x-data="{ medications: {{ json_encode($medication ?? []) }} }" class="mt-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Current Medications</h3>
                        <template x-for="(medication, index) in medications" :key="index">
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" x-model="medications[index]" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <button @click="medications.splice(index, 1)" type="button" class="inline-flex items-center p-1.5 border border-transparent rounded-full text-red-600 hover:bg-red-50">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <button @click="medications.push('')" type="button" class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Medication
                        </button>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Allergies & Medications
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection