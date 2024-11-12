<?php
namespace App\Services;

use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Carbon\Carbon;
use \Cache;
use Exception;
class VaccinePassportService
{
    public function generatePassportData()
    {
        $user = auth()->user();
       
        $vaccinations = $user->vaccinations()
            ->with('vaccine','user.vaccinationRecords')
            //->where('status', 'completed')
            ->get()
            ->map(function ($vaccination,$recs) {
                return [
                    'vaccine_name' => $vaccination->vaccine->name,
                    'date_administered' => $vaccination->date_administered->format('Y-m-d'),
                    'lot_number' => $vaccination->lot_number,
                    'administered_by' => $vaccination->administered_by,
                    //'location' => $vaccination->user->vaccinationRecords,
                    'next_due_date' => $vaccination->next_due_date ? 
                        $vaccination->next_due_date->format('Y-m-d') : null
                ];
            });

            //dd($vaccinations);

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
        // Generate verification token
        $verificationToken = $this->generateVerificationToken($user);
        
        // Create verification URL
        $verificationUrl = route('vaccine-passport.verify', $verificationToken);

        return QrCode::size(300)
            ->errorCorrection('H')
            ->format('svg')
            ->generate($verificationUrl);
    }
    private function generateVerificationToken(User $user)
    {
        $passportData = $this->generatePassportData($user);
        
        // Create a token that includes user ID and timestamp
        $tokenData = [
            'user_id' => $user->id,
            'timestamp' => now()->timestamp,
            'passport_id' => $passportData['passport_id']
        ];

        // Encrypt the token data
        $encryptedToken = encrypt(json_encode($tokenData));
        
        // Store the passport data in cache with the token as key
        Cache::put(
            "passport_verification_{$user->id}_{$tokenData['timestamp']}", 
            $passportData, 
            now()->addDays(7)
        );

        return base64_encode($encryptedToken);
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

    public function verifyPassport($token)
    {
        try {
            // Decode and decrypt the token
            $decryptedToken = decrypt(base64_decode($token));
            $tokenData = json_decode($decryptedToken, true);

            if (!$tokenData) {
                throw new Exception('Invalid verification token');
            }

            // Get passport data from cache
            $cacheKey = "passport_verification_{$tokenData['user_id']}_{$tokenData['timestamp']}";
            $passportData = Cache::get($cacheKey);

            if (!$passportData) {
                throw new Exception('Verification data has expired');
            }

            // Verify passport data
            if ($passportData['passport_id'] !== $tokenData['passport_id']) {
                throw new Exception('Invalid passport data');
            }

            // Verify signature
            $signature = $passportData['signature'] ?? null;
            unset($passportData['signature']);
            
            $expectedSignature = $this->signPassportData($passportData);

            if (!$signature || !hash_equals($signature, $expectedSignature)) {
                throw new Exception('Invalid passport signature');
            }

            // Verify expiration
            if (Carbon::parse($passportData['valid_until'])->isPast()) {
                throw new Exception('Passport has expired');
            }

            return [
                'isValid' => true,
                'data' => $passportData
            ];

        } catch (Exception $e) {
            return [
                'isValid' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    private function signPassportData(array $data)
    {
        $dataToSign = json_encode($data);
        return hash_hmac('sha256', $dataToSign, config('app.key'));
    }

    // Optional: Method to generate QR code for PDF (PNG format)
    public function generateQRCodeForPDF(User $user)
    {
        $verificationToken = $this->generateVerificationToken($user);
        $verificationUrl = route('vaccine-passport.verify', $verificationToken);

        return base64_encode(QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate($verificationUrl));
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
