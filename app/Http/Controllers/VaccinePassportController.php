<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\VaccinePassportService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class VaccinePassportController extends Controller
{
    protected $passportService;

    public function __construct(VaccinePassportService $passportService)
    {
        $this->passportService = $passportService;
    }

    public function show()
    {
        $user = auth()->user();
        $passportData = $this->passportService->generatePassportData($user);
        $qrCode = $this->passportService->generateQRCode($user);
        
        return view('vaccine-passport.show', compact('user', 'passportData', 'qrCode'));
    }

    public function download()
    {
        $user = auth()->user();
        
        $passportData = $this->passportService->generatePassportData($user);
        $qrCode = $this->passportService->generateQRCode($user);
    
        $pdf = Pdf::loadView('vaccine-passport.pdf', compact('user', 'passportData', 'qrCode'));
        
        // Customize PDF settings
        $pdf->setPaper('a4', 'portrait');
        $pdf->setWarnings(false);
        
        // Add protection if needed
        $pdf->setEncryption('password', 'owner-password', [
            'copy',
            'print',
            'print-high',
            'modify',
            'assemble',
            'fill-forms'
        ]);
        
        return $pdf->download('vaccine-passport.pdf');
    }

    public function verify($token)
    {
        $verificationResult = $this->passportService->verifyPassport($token);
        
        // For API requests
        if (request()->wantsJson()) {
            return response()->json($verificationResult);
        }

        // For web requests
        return view('vaccine-passport.verify', compact('verificationResult'));
    }

    public function shared($token)
    {
        $passportData = $this->passportService->getSharedPassport($token);
        
        if (!$passportData) {
            abort(404, 'Shared passport link has expired or is invalid');
        }

        $qrCode = $this->passportService->generateQRCode($passportData);
        
        return view('vaccine-passport.shared', compact('passportData', 'qrCode'));
    }
}
