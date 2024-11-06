<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vaccine Passport - {{ $user->full_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #4f46e5;
            color: white;
            margin-bottom: 20px;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .info-section {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .vaccination-record {
            border: 1px solid #eee;
            padding: 10px;
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Digital Vaccine Passport</h1>
        <p>{{ $passportData['passport_id'] }}</p>
    </div>

    <div class="info-section">
        <h2>Personal Information</h2>
        <div class="grid">
            <div>
                <strong>Name:</strong> {{ $passportData['user_info']['name'] }}
            </div>
            <div>
                <strong>Date of Birth:</strong> {{ $passportData['user_info']['date_of_birth'] }}
            </div>
            <div>
                <strong>ID Number:</strong> {{ $passportData['user_info']['id_number'] }}
            </div>
        </div>
    </div>

    <div class="qr-code">
        {!! $qrCode !!}
    </div>

    <div class="info-section">
        <h2>Vaccination Records</h2>
        @foreach($passportData['vaccinations'] as $vaccination)
            <div class="vaccination-record">
                <div class="grid">
                    <div>
                        <strong>Vaccine:</strong> {{ $vaccination['vaccine_name'] }}
                    </div>
                    <div>
                        <strong>Date:</strong> {{ $vaccination['date_administered'] }}
                    </div>
                    <div>
                        <strong>Lot Number:</strong> {{ $vaccination['lot_number'] }}
                    </div>
                    <div>
                        <strong>Provider:</strong> {{ $vaccination['administered_by'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="footer">
        <p>Generated: {{ Carbon\Carbon::parse($passportData['generated_at'])->format('F j, Y') }}</p>
        <p>Valid until: {{ Carbon\Carbon::parse($passportData['valid_until'])->format('F j, Y') }}</p>
        <p>Issued by: {{ $passportData['issuer'] }}</p>
        <p>Verify at: {{ $passportData['verification_url'] }}</p>
    </div>
</body>
</html>