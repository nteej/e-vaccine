@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
            <div class="max-w-md mx-auto">
                <div class="divide-y divide-gray-200">
                    <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        @if($verificationResult['isValid'])
                            <div class="bg-green-50 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Valid Vaccine Passport</h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>This vaccine passport is valid and verified.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900">Passport Details</h3>
                                <dl class="mt-4 space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $verificationResult['data']['user_info']['name'] }}
                                        </dd>
                                    </div>
                                    
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Vaccinations</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <ul class="divide-y divide-gray-200">
                                                @foreach($verificationResult['data']['vaccinations'] as $vaccination)
                                                    <li class="py-3">
                                                        <p class="font-medium">{{ $vaccination['vaccine_name'] }}</p>
                                                        <p class="text-gray-500">Administered: {{ $vaccination['date_administered'] }}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        @else
                            <div class="bg-red-50 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Invalid Vaccine Passport</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>{{ $verificationResult['error'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection