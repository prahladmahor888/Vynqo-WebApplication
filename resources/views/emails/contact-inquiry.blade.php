<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Support Inquiry — {{ $siteName }}</title>
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
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
            padding: 24px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .content {
            padding: 28px 24px;
        }
        .field-group {
            margin-bottom: 18px;
        }
        .field-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 14px;
            color: #0f172a;
            font-weight: 600;
        }
        .message-box {
            background: #f1f5f9;
            border-left: 4px solid #7c3aed;
            padding: 16px;
            border-radius: 6px;
            font-size: 13px;
            color: #334155;
            white-space: pre-wrap;
            line-height: 1.7;
            margin-top: 6px;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            padding: 16px 0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            margin: 20px 0;
        }
        .footer {
            background: #f8fafc;
            padding: 16px 24px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
        .btn {
            display: inline-block;
            background: #7c3aed;
            color: #ffffff !important;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            margin-top: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="badge">🔔 Support Desk Alert</span>
            <h1>New User Inquiry Received</h1>
        </div>

        <div class="content">
            <p style="font-size: 14px; color: #475569; margin-top: 0;">
                A user has submitted an inquiry through the <strong>{{ $siteName }}</strong> support form.
            </p>

            <div class="meta-grid">
                <div class="field-group" style="margin-bottom: 0;">
                    <div class="field-label">Sender Name</div>
                    <div class="field-value">{{ $msg->name }}</div>
                </div>
                <div class="field-group" style="margin-bottom: 0;">
                    <div class="field-label">Sender Email</div>
                    <div class="field-value"><a href="mailto:{{ $msg->email }}" style="color: #7c3aed; text-decoration: none;">{{ $msg->email }}</a></div>
                </div>
            </div>

            <div class="field-group">
                <div class="field-label">Subject</div>
                <div class="field-value" style="font-size: 15px;">{{ $msg->subject }}</div>
            </div>

            <div class="field-group">
                <div class="field-label">Message Content</div>
                <div class="message-box">{{ $msg->message }}</div>
            </div>

            @if(!empty($msg->ip_address))
            <div style="font-size: 11px; color: #94a3b8; margin-top: 16px;">
                IP Address: <code>{{ $msg->ip_address }}</code> &bull; Received at: {{ $msg->created_at->format('M d, Y H:i:s') }}
            </div>
            @endif

            <div style="text-align: center; margin-top: 24px;">
                <a href="mailto:{{ $msg->email }}?subject=Re: {{ urlencode($msg->subject) }}" class="btn">
                    Reply Directly to User
                </a>
            </div>
        </div>

        <div class="footer">
            {{ $siteName }} Admin Support Dispatch &bull; Automated System Notification
        </div>
    </div>
</body>
</html>
