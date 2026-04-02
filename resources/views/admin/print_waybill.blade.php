<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Waybill - {{ $shipment->tracking_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&display=swap');
        
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 40px;
            color: #111;
        }

        .waybill-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border: 2px solid #000;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .tracking-box {
            text-align: right;
        }

        .tracking-title {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            color: #666;
        }

        .tracking-number {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Fake Barcode CSS */
        .barcode {
            height: 40px;
            width: 100%;
            background: repeating-linear-gradient(90deg, #000, #000 2px, transparent 2px, transparent 4px, #000 4px, #000 5px, transparent 5px, transparent 8px);
            margin-top: 5px;
        }

        .grid-row {
            display: flex;
            border: 2px solid #000;
            margin-bottom: 20px;
        }

        .grid-col {
            flex: 1;
            padding: 15px;
        }

        .grid-col:first-child {
            border-right: 2px solid #000;
        }

        .section-label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            background: #000;
            color: #fff;
            display: inline-block;
            padding: 3px 8px;
            margin-bottom: 10px;
        }

        .info-group {
            margin-bottom: 10px;
        }

        .info-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            margin-bottom: 20px;
        }

        .details-table th, .details-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .details-table th {
            background: #f1f1f1;
            font-size: 12px;
            text-transform: uppercase;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-top: 30px;
        }

        .print-btn {
            display: block;
            margin: 0 auto 30px;
            background: #000;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Space Grotesk', sans-serif;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }
            .print-btn {
                display: none;
            }
            .waybill-container {
                box-shadow: none;
                border: 2px solid #000;
            }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">Print Official Waybill</button>

    <div class="waybill-container">
        
        <div class="header">
            <div class="logo-text">
                NizCourier<br>Systems
            </div>
            <div class="tracking-box">
                <div class="tracking-title">Consignment Tracking Reference</div>
                <div class="tracking-number">{{ $shipment->tracking_number }}</div>
                <div class="barcode"></div>
            </div>
        </div>

        <div class="grid-row">
            <div class="grid-col">
                <div class="section-label">Origin Sender</div>
                <div class="info-group">
                    <div class="info-label">Name & Legal Entity</div>
                    <div class="info-value">{{ $shipment->sender_name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Contact Relay</div>
                    <div class="info-value">{{ $shipment->sender_phone }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Dispatch Node & Address</div>
                    <div class="info-value">{{ $shipment->from_city }}<br><span style="font-size: 13px; font-weight: normal;">{{ $shipment->sender_address }}</span></div>
                </div>
            </div>
            
            <div class="grid-col">
                <div class="section-label">Destination Consignee</div>
                <div class="info-group">
                    <div class="info-label">Name & Legal Entity</div>
                    <div class="info-value">{{ $shipment->receiver_name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Contact Relay</div>
                    <div class="info-value">{{ $shipment->receiver_phone }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Terminal Node & Address</div>
                    <div class="info-value">{{ $shipment->to_city }}<br><span style="font-size: 13px; font-weight: normal;">{{ $shipment->receiver_address }}</span></div>
                </div>
            </div>
        </div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>Logistics Type</th>
                    <th>Recorded Mass (Weight)</th>
                    <th>Estimated Time Limit</th>
                    <th>Final Tariff</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: 600;">{{ ucfirst($shipment->parcel_type) }} Package</td>
                    <td style="font-weight: 600;">{{ $shipment->weight }} KG</td>
                    <td style="font-weight: 600;">{{ \Carbon\Carbon::parse($shipment->delivery_time)->format('H:i') }} Hrs</td>
                    <td style="font-weight: 600;">Rs. {{ number_format($shipment->price, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div style="border: 2px solid #000; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div class="info-label">Authorization Signature</div>
                <div style="border-bottom: 1px dotted #000; width: 250px; height: 30px;"></div>
            </div>
            <div style="text-align: right;">
                <div class="info-label">Processing Timestamp</div>
                <div class="info-value">{{ $shipment->created_at->format('Y-m-d H:i:s') }}</div>
            </div>
        </div>

        <div class="footer">
            Generated securely via NizCourier Administrative Node. All transits are subject to international logistics treaties.
        </div>

    </div>

</body>
</html>
