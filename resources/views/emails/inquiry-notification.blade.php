<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Inquiry Notification - Platinum Hospitality Management</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0A0A0A; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #FAF7F2;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #0A0A0A; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 620px; background-color: #141416; border: 1px solid rgba(197, 162, 101, 0.4); border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.6);">

                    <!-- Header -->
                    <tr>
                        <td style="padding: 35px 30px 25px 30px; text-align: center; background: linear-gradient(180deg, #1A1A1E 0%, #141416 100%); border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                            <div style="font-size: 11px; font-weight: 700; letter-spacing: 3px; color: #C5A265; text-transform: uppercase; margin-bottom: 8px;">
                                PLATINUM HOSPITALITY MANAGEMENT
                            </div>
                            <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #FFFFFF; font-family: 'Playfair Display', Georgia, serif;">
                                @if($inquiry->type === 'booking')
                                    New Table Reservation Request
                                @elseif($inquiry->type === 'franchise')
                                    New Franchise & Partnership Inquiry
                                @else
                                    New Website Contact Message
                                @endif
                            </h1>
                            <p style="margin: 8px 0 0 0; font-size: 13px; color: #A8A29E;">
                                Received on {{ $inquiry->created_at->format('M d, Y \a\t h:i A') }} (UAE Time)
                            </p>
                        </td>
                    </tr>

                    <!-- Content Details Table -->
                    <tr>
                        <td style="padding: 30px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 12px; color: #A8A29E; text-transform: uppercase; letter-spacing: 1px; width: 140px;">
                                        Inquiry Type:
                                    </td>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 14px; color: #DFCA9B; font-weight: 600;">
                                        @if($inquiry->type === 'booking')
                                            Table Reservation
                                        @elseif($inquiry->type === 'franchise')
                                            Franchise Application
                                        @else
                                            General Contact
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 12px; color: #A8A29E; text-transform: uppercase; letter-spacing: 1px;">
                                        Customer Name:
                                    </td>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 14px; color: #FFFFFF; font-weight: 600;">
                                        {{ $inquiry->name }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 12px; color: #A8A29E; text-transform: uppercase; letter-spacing: 1px;">
                                        Email Address:
                                    </td>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 14px; color: #FFFFFF;">
                                        <a href="mailto:{{ $inquiry->email }}" style="color: #C5A265; text-decoration: none;">{{ $inquiry->email }}</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 12px; color: #A8A29E; text-transform: uppercase; letter-spacing: 1px;">
                                        Phone Number:
                                    </td>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 14px; color: #FFFFFF;">
                                        <a href="tel:{{ $inquiry->phone }}" style="color: #DFCA9B; text-decoration: none;">{{ $inquiry->phone ?: 'Not provided' }}</a>
                                    </td>
                                </tr>

                                @if($inquiry->brand)
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 12px; color: #A8A29E; text-transform: uppercase; letter-spacing: 1px;">
                                        Selected Brand:
                                    </td>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 14px; color: #C5A265; font-weight: 600;">
                                        {{ $inquiry->brand }}
                                    </td>
                                </tr>
                                @endif

                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 12px; color: #A8A29E; text-transform: uppercase; letter-spacing: 1px;">
                                        Subject:
                                    </td>
                                    <td style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 14px; color: #FFFFFF;">
                                        {{ $inquiry->subject }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Message Box -->
                            <div style="margin-top: 25px;">
                                <div style="font-size: 12px; color: #A8A29E; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">
                                    Message / Reservation Details:
                                </div>
                                <div style="background-color: #0A0A0A; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 18px; font-size: 13px; line-height: 1.6; color: #E7E5E4; white-space: pre-wrap;">{{ $inquiry->message }}</div>
                            </div>

                            <!-- CTA Button to Admin Panel -->
                            <div style="margin-top: 30px; text-align: center;">
                                <a href="{{ url('/admin/inquiries/' . ($inquiry->type === 'booking' ? 'bookings' : ($inquiry->type === 'franchise' ? 'franchise' : 'contact'))) }}"
                                   style="display: inline-block; background: linear-gradient(135deg, #DFCA9B 0%, #C5A265 50%, #9B783E 100%); color: #0A0A0A; font-size: 13px; font-weight: 700; text-decoration: none; padding: 14px 28px; border-radius: 10px; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(197, 162, 101, 0.3);">
                                    View In Admin Panel
                                </a>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 30px; text-align: center; background-color: #0E0E10; border-top: 1px solid rgba(255, 255, 255, 0.05); font-size: 11px; color: #78716C;">
                            This is an automated notification from the Platinum Hospitality Management Web Platform.<br>
                            You received this because your email is configured as the notification recipient in Admin Settings.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

