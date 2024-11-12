<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\HealthUpdateRequest;
use App\Http\Requests\NotificationUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Models\User;
use App\Models\HealthCondition;
use App\Notifications\ProfileUpdatedNotification;
use App\Notifications\HealthProfileUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Services\NotificationPreferenceService;

class ProfileController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationPreferenceService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $user = auth()->user()->load('healthConditions');
        $healthConditions = HealthCondition::all();
        $userHealthConditions = $user->healthConditions->pluck('id')->toArray();
        
        return view('profile.index', compact('user', 'healthConditions', 'userHealthConditions'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        
        $validated = $request->validated();

        // Update user profile
        $user->update($validated);

        // Handle profile picture if uploaded
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->update(['profile_picture' => $path]);
        }

        // Send notification
        $user->notify(new ProfileUpdatedNotification($user));

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function updateHealth(HealthUpdateRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        // Update health conditions
        if (isset($validated['health_conditions'])) {
            $user->healthConditions()->sync($validated['health_conditions']);
        }

        // Update other health information
        $user->update([
            'allergies' => $validated['allergies'] ?? [],
            'medications' => $validated['medications'] ?? [],
            'is_pregnant' => $validated['is_pregnant'] ?? false,
            'is_healthcare_worker' => $validated['is_healthcare_worker'] ?? false
        ]);

        // Notify healthcare providers if critical conditions changed
        $user->notify(new HealthProfileUpdatedNotification($user));

        return redirect()->back()->with('success', 'Health information updated successfully');
    }

    public function updateNotifications(NotificationUpdateRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        // Update notification preferences
        $preferences = [
            'email' => [
                'enabled' => $validated['email_notifications'] ?? false,
                'types' => [
                    'due_vaccinations' => $validated['notify_due_vaccinations'] ?? false,
                    'health_reminders' => $validated['notify_health_reminders'] ?? false,
                    'appointment_reminders' => $validated['notify_appointments'] ?? false,
                    'vaccination_updates' => $validated['notify_updates'] ?? false,
                    'emergency_alerts' => $validated['notify_emergencies'] ?? true
                ]
            ],
            'sms' => [
                'enabled' => $validated['sms_notifications'] ?? false,
                'types' => [
                    'urgent_reminders' => $validated['sms_urgent'] ?? false,
                    'appointment_confirmations' => $validated['sms_appointments'] ?? false
                ]
            ],
            'push' => [
                'enabled' => $validated['push_notifications'] ?? false,
                'types' => [
                    'due_today' => $validated['push_due_today'] ?? false,
                    'upcoming' => $validated['push_upcoming'] ?? false
                ]
            ],
            'reminder_days' => $validated['reminder_days'],
            'quiet_hours' => [
                'enabled' => $validated['quiet_hours_enabled'] ?? false,
                'start' => $validated['quiet_hours_start'] ?? '22:00',
                'end' => $validated['quiet_hours_end'] ?? '07:00'
            ]
        ];

        $user->update(['notification_preferences' => $preferences]);
        $this->notificationService->updateUserChannels($user);

        return redirect()->back()->with('success', 'Notification preferences updated successfully');
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        // Notify user of password change
        $user->notify(new \App\Notifications\PasswordChangedNotification);

        return redirect()->back()->with('success', 'Password updated successfully');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = auth()->user();

        // Archive user data
        $this->archiveUserData($user);

        // Notify relevant parties
        $this->notifyAccountDeletion($user);

        auth()->logout();
        $user->delete();

        return redirect('/');
    }

    protected function archiveUserData(User $user)
    {
        // Archive logic here
    }

    protected function notifyAccountDeletion(User $user)
    {
        // Deletion notifications logic
    }
}

// Form Request Validation Classes

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    public function rules()
    {
        
    }
}





