<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Two-Step Verification — {{ $siteName }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 24px;
            line-height: 1.6;
        }
        .container {
            max-width: 560px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #6d28d9 0%, #7c3aed 50%, #ec4899 100%);
            padding: 32px 24px;
            text-align: center;
            color: #ffffff;
        }
        .header img {
            height: 48px;
            margin-bottom: 12px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 32px 28px;
        }
        .otp-box {
            background: #f5f3ff;
            border: 2px dashed #8b5cf6;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin: 24px 0;
        }
        .otp-code {
            font-family: 'Courier New', Courier, monospace;
            font-size: 38px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #5b21b6;
            margin: 0;
        }
        .otp-expiry {
            font-size: 12px;
            color: #6d28d9;
            margin-top: 8px;
            font-weight: 600;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 20px;
            background: #f8fafc;
            border-radius: 8px;
            overflow: hidden;
        }
        .meta-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #e2e8f0;
        }
        .meta-label {
            color: #64748b;
            font-weight: 600;
            width: 130px;
        }
        .meta-value {
            color: #0f172a;
            font-family: monospace;
            font-weight: 600;
        }
        .warning-box {
            margin-top: 24px;
            padding: 14px;
            border-radius: 8px;
            background: #fff1f2;
            border-left: 4px solid #e11d48;
            font-size: 12px;
            color: #881337;
        }
        .footer {
            padding: 20px 28px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if(!empty($siteLogo))
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}">
            @endif
            <div><span class="badge">Two-Step Verification</span></div>
            <h1>Admin Authentication Code</h1>
        </div>

        <div class="content">
            <p style="margin: 0 0 14px; font-size: 14px;">Hello <strong>{{ $adminName }}</strong>,</p>
            <p style="margin: 0 0 16px; font-size: 13px; color: #475569;">
                A sign-in request was initiated for the <strong>{{ $siteName }}</strong> Administrator Dashboard. Use the following One-Time Password (OTP) to complete your verification:
            </p>

            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-expiry">Valid for 10 minutes (expires at {{ now()->addMinutes(10)->format('H:i') }} UTC)</div>
            </div>

            <table class="meta-table">
                <tr>
                    <td class="meta-label">Admin Account:</td>
                    <td class="meta-value">{{ $adminName }}</td>
                </tr>
                <tr>
                    <td class="meta-label">Request IP Address:</td>
                    <td class="meta-value">{{ $ipAddress }}</td>
                </tr>
                <tr>
                    <td class="meta-label">Timestamp:</td>
                    <td class="meta-value">{{ now()->toRfc850String() }}</td>
                </tr>
            </table>

            <div class="warning-box">
                <strong>Security Alert:</strong> If you did not attempt to sign into the Sangfy Admin Portal, someone may have obtained your password. Please reset your administrative password and review security access logs immediately.
            </div>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ $siteName }} Platform. All rights reserved. Prahlix Technologies.
        </div>
    </div>
</body>
</html>

