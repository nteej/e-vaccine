@extends('layouts.me')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <!-- Passport Header -->
            <div class="px-4 py-5 sm:px-6 bg-indigo-600">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-white">Digital Vaccine Passport</h2>
                        <p class="mt-1 text-sm text-indigo-100">
                            ID: {{ $passportData['passport_id'] }}
                        </p>
                    </div>
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                </div>
            </div>

            <!-- Personal Information -->
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $passportData['user_info']['name'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $passportData['user_info']['date_of_birth'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ID Number</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $passportData['user_info']['id_number'] }}</dd>
                    </div>
                </div>
            </div>

            <!-- QR Code -->
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <div class="flex justify-center">
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        {!! $qrCode !!}
                    </div>
                </div>
                <p class="mt-2 text-sm text-center text-gray-500">
                    Scan to verify vaccination status
                </p>
            </div>

            <!-- Vaccination Records -->
            <div class="border-t border-gray-200">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">Vaccination Records</h3>
                    <div class="mt-4 space-y-4">
                        @foreach($passportData['vaccinations'] as $vaccination)
                            <div class="border rounded-lg p-4">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Vaccine</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $vaccination['vaccine_name'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Date Administered</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $vaccination['date_administered'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Lot Number</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $vaccination['lot_number'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Healthcare Provider</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $vaccination['administered_by'] }}</dd>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('vaccine-passport.download') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Download PDF
                    </a>
                    <button type="button" onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Print Passport
                    </button>
                </div>
            </div>

            <!-- Validity Information -->
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6 bg-gray-50">
                <div class="text-center text-sm text-gray-500">
                    <p>Generated on: {{ Carbon\Carbon::parse($passportData['generated_at'])->format('F j, Y') }}</p>
                    <p>Valid until: {{ Carbon\Carbon::parse($passportData['valid_until'])->format('F j, Y') }}</p>
                    <p>Issued by: {{ $passportData['issuer'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection