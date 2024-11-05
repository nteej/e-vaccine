@extends('layouts.me')

@section('content')
   

    <div class="min-h-screen py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Profile Management</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Update your personal information and health profile
                </p>
            </div>

            <!-- Profile Sections -->
            <div class="space-y-6">
                <!-- Personal Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h2>
                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('phone_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth->format('Y-m-d')) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('date_of_birth')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="blood_type" class="block text-sm font-medium text-gray-700">Blood Type</label>
                                    <select name="blood_type" id="blood_type"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $type)
                                            <option value="{{ $type }}" {{ old('blood_type', $user->blood_type) === $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="address" id="address" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Personal Information
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Health Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Health Information</h2>
                        <form action="{{ route('profile.health.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Health Conditions -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Health Conditions</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($healthConditions as $condition)
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="health_conditions[]" value="{{ $condition->id }}"
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
                            </div>

                            <!-- Allergies -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                                <div x-data="{ allergies: {{ json_encode(old('allergies', $user->allergies ?? [])) }} }">
                                    <template x-for="(allergy, index) in allergies" :key="index">
                                        <div class="flex space-x-2 mb-2">
                                            <input type="text" x-model="allergies[index]" :name="'allergies[]'"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="button" @click="allergies.splice(index, 1)"
                                                    class="inline-flex items-center p-2 border border-transparent rounded-md text-red-600 hover:bg-red-50">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                    <button type="button" @click="allergies.push('')"
                                            class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add Allergy
                                    </button>
                                </div>
                            </div>

                            <!-- Medications -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                                <div x-data="{ medications: {{ json_encode(old('medications', $user->medications ?? [])) }} }">
                                    <template x-for="(medication, index) in medications" :key="index">
                                        <div class="flex space-x-2 mb-2">
                                            <input type="text" x-model="medications[index]" :name="'medications[]'"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="button" @click="medications.splice(index, 1)"
                                                    class="inline-flex items-center p-2 border border-transparent rounded-md text-red-600 hover:bg-red-50">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                    <button type="button" @click="medications.push('')"
                                            class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add Medication
                                    </button>
                                </div>
                            </div>

                            <!-- Special Conditions -->
                            <div class="space-y-4">
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="is_pregnant" id="is_pregnant"
                                               {{ old('is_pregnant', $user->is_pregnant) ? 'checked' : '' }}
                                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_pregnant" class="font-medium text-gray-700">Currently Pregnant</label>
                                        <p class="text-gray-500">This information helps determine appropriate vaccinations</p>
                                    </div>
                                </div>

                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="is_healthcare_worker" id="is_healthcare_worker"
                                               {{ old('is_healthcare_worker', $user->is_healthcare_worker) ? 'checked' : '' }}
                                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_healthcare_worker" class="font-medium text-gray-700">Healthcare Worker</label>
                                        <p class="text-gray-500">Additional vaccinations may be recommended</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Health Information
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Emergency Contact</h2>
                        <form action="{{ route('profile.emergency.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Contact Name</label>
                                    <input type="text" name="emergency_contact_name" id="emergency_contact_name"
                                           value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('emergency_contact_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                                    <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone"
                                           value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('emergency_contact_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="emergency_contact_relationship" class="block text-sm font-medium text-gray-700">Relationship</label>
                                    <select name="emergency_contact_relationship" id="emergency_contact_relationship"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach(['Spouse', 'Parent', 'Child', 'Sibling', 'Friend', 'Other'] as $relationship)
                                            <option value="{{ $relationship }}" 
                                                {{ old('emergency_contact_relationship', $user->emergency_contact_relationship) === $relationship ? 'selected' : '' }}>
                                                {{ $relationship }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Emergency Contact
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Notification Preferences -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Notification Preferences</h2>
                        <form action="{{ route('profile.notifications.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="email_notifications" id="email_notifications"
                                               {{ old('email_notifications', $user->notification_preferences['email'] ?? true) ? 'checked' : '' }}
                                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="email_notifications" class="font-medium text-gray-700">Email Notifications</label>
                                        <p class="text-gray-500">Receive vaccination reminders and updates via email</p>
                                    </div>
                                </div>

                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="sms_notifications" id="sms_notifications"
                                               {{ old('sms_notifications', $user->notification_preferences['sms'] ?? false) ? 'checked' : '' }}
                                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="sms_notifications" class="font-medium text-gray-700">SMS Notifications</label>
                                        <p class="text-gray-500">Receive text message reminders for upcoming vaccinations</p>
                                    </div>
                                </div>

                                <div x-data="{ enabled: {{ old('reminder_days', $user->notification_preferences['reminder_days'] ?? 7) }} }">
                                    <label class="block text-sm font-medium text-gray-700">Reminder Days</label>
                                    <div class="mt-1">
                                        <select name="reminder_days"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            @foreach([3, 5, 7, 14, 30] as $days)
                                                <option value="{{ $days }}" 
                                                    {{ old('reminder_days', $user->notification_preferences['reminder_days'] ?? 7) == $days ? 'selected' : '' }}>
                                                    {{ $days }} days before due date
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Notification Preferences
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Change Password</h2>
                        <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                    <input type="password" name="password" id="password"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg font-medium text-red-600 mb-4">Delete Account</h2>
                        <p class="text-sm text-gray-500 mb-4">
                            Once your account is deleted, all of your data will be permanently removed. 
                            This action cannot be undone.
                        </p>
                        <form action="{{ route('profile.delete') }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Delete Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


 @endsection