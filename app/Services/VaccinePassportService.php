<?php
namespace App\Services;

use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VaccinePassportService
{
    public function generatePassportData(User $user)
    {
        $vaccinations = $user->vaccinations()
            ->with('vaccine')
            ->where('status', 'completed')
            ->get()
            ->map(function ($vaccination) {
                return [
                    'vaccine_name' => $vaccination->vaccine->name,
                    'date_administered' => $vaccination->date_administered->format('Y-m-d'),
                    'lot_number' => $vaccination->lot_number,
                    'administered_by' => $vaccination->administered_by,
                    'location' => $vaccination->location->name,
                    'next_due_date' => $vaccination->next_due_date ? 
                        $vaccination->next_due_date->format('Y-m-d') : null
                ];
            });

        return [
            'passport_id' => $this->generatePassportId($user),
            'user_info' => [
                'name' => $user->full_name,
                'date_of_birth' => $user->date_of_birth->format('Y-m-d'),
                'id_number' => $user->id_number
            ],
            'vaccinations' => $vaccinations,
            'generated_at' => now()->toIso8601String(),
            'valid_until' => now()->addMonths(6)->toIso8601String(),
            'issuer' => config('app.name'),
            'verification_url' => url('/vaccine-passport/verify/')
        ];
    }

    public function generateQRCode(User $user)
    {
        $passportData = $this->generatePassportData($user);
        $verificationCode = $this->generateVerificationCode($user);
        
        $qrData = array_merge($passportData, [
            'verification_code' => $verificationCode
        ]);

        return QrCode::size(300)
            ->errorCorrection('H')
            ->format('svg')
            ->generate(json_encode($qrData));
    }

    private function generatePassportId(User $user)
    {
        return sprintf(
            'VP-%s-%s',
            strtoupper(Str::random(8)),
            $user->id
        );
    }

    private function generateVerificationCode(User $user)
    {
        return hash_hmac(
            'sha256',
            $user->id . $user->email . now()->format('Y-m-d'),
            config('app.key')
        );
    }

    public function verifyPassport($code)
    {
        try {
            // Decode the verification code
            $data = json_decode(base64_decode($code), true);
            
            if (!$data) {
                throw new \Exception('Invalid passport format');
            }
    
            // Verify signature
            $signature = $data['signature'] ?? null;
            unset($data['signature']);
            
            $calculatedSignature = hash_hmac(
                'sha256',
                json_encode($data),
                config('app.key')
            );
    
            if (!hash_equals($signature, $calculatedSignature)) {
                throw new \Exception('Invalid passport signature');
            }
    
            // Check expiration
            if (Carbon::parse($data['valid_until'])->isPast()) {
                throw new \Exception('Passport has expired');
            }
    
            return [
                'isValid' => true,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'isValid' => false,
                'error' => $e->getMessage()
            ];
        }

    }
    // Add secure sharing functionality to VaccinePassportService.php
    public function generateShareableLink(User $user, $expiresInHours = 24)
    {
        $token = Str::random(32);
        
        Cache::put(
            "vaccine_passport_share_{$token}",
            $this->generatePassportData($user),
            now()->addHours($expiresInHours)
        );

        return [
            'url' => route('vaccine-passport.shared', $token),
            'expires_at' => now()->addHours($expiresInHours)
        ];
    }

    public function getSharedPassport($token)
    {
        return Cache::get("vaccine_passport_share_{$token}");
    }
}
