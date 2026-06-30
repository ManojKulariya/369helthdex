<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            color: #333;
        }.
        .bg_f6{
            background:#F6F6F6;
        }

        .container {
            width: 800px;
            margin: auto;
            padding: 30px;
            background: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header img {
            height: 60px;
        }

        .invoice-title {
            font-size: 32px;
            color: #1f3e6d;
            font-weight: bold;
        }

        .dark-bar {
            background-color: #1f3e6d;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .dark-bar td {
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: bold;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .info-section .box {
            width: 48%;
            word-wrap: break-word;        /* Wrap long words */
            overflow-wrap: break-word;    /* Ensures wrapping in all browsers */
            white-space: normal; 
        }

        .box p {
            margin: 3px 0;
        }

        .highlight {
            font-weight: bold;
            color: #1f3e6d;
        }

        .highlight-red {
            font-weight: bold;
            color: #d8232a;
        }

        .table-section {
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #1f3e6d;
            color: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 10px;
            font-weight: bold;
        }

        .paid-amount {
            font-size: 16px;
            color: #d8232a;
            font-weight: bold;
        }

        .words {
            margin-top: 30px;
        }

        .payment-summary {
            float: right;
            margin-top: -50px;
            width: 50%;
        }
        .payment-summary strong {
            float: right;
        }

        .payment-summary table {
            width: 100%;
        }
       

        .footer {
            clear: both;
            font-size: 12px;
            margin-top: 10px;
            /*border-top: 1px dashed #999;*/
            /*padding-top: px;*/
        }

        .footer .note {
            margin-top: 10px;
            text-align: center;
        }

        .contact-bar {
            width:100%;
            background: #1f3e6d;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 30px;
        }

        .contact-bar span {
            display: inline-block;
            margin: 0 20px;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .container {
                width: 100%;
                padding: 0;
            }

            .contact-bar {
                position: fixed;
                bottom: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{asset('public/img').'/'.$setting->logo}}" alt="Logo" />
            <div class="invoice-title">INVOICE</div>
        </div>

        <!-- Top info -->
        <table class="dark-bar">
            <tr>
                <td>Invoice No :<br><span>{{ $data->id }}</span></td>
                <td>Invoice Date :<br><span>{{ date('Y-m-d') }}</span></td>
                <td>Booking Id :<br><span>{{ $data->id }}</span></td>
                <td>Sample Collection Date:<br><span>{{ date('Y-m-d', strtotime($data->collected_datetime)) }}</span></td>
            </tr>
        </table>

        <!-- Info Section -->
        <div class="info-section">
            <div class="box">
                <p><span class="highlight">Bill From:</span></p>
                <p>CIN No: <span class="highlight-red">---</span></p>
                <p><strong class="highlight-red">{{ $data->franchise->name }}</strong></p>
                <p>{{ $data->franchise->address }}</p>
                <p>GST: Not Applicable</p>
            </div>
            <div class="box">
                <p><span class="highlight">Customer Billing Details</span></p>
                <p class="highlight-red">{{ $data->customer->name }}</p>
                <p>{{$data->useraddressdetails->house_no}},{{$data->useraddressdetails->address}}</p>
                <p>{{ $data->customer->phone }}</p>
                <p>{{ $data->customer->email }}</p>
            </div>
        </div>

        <!-- Test Table -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>TEST DESCRIPTION</th>
                        <th>AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->orderdata as $do)
                    <tr>
                        <td><spanclass="highlight-red">{{$do->memberdetails->name}}</span>  | {{$do->memberdetails->gender}} | {{$do->memberdetails->relation}}  <br><small>{{$do->item_name}}</small></td>
                        <td class="text-right">{{$currency}}{{number_format($do->price,2,'.','')}}</td>
                    </tr>
                     @endforeach
                    <tr>
                        <td ><strong>TOTAL AMOUNT</strong></td>
                        <td class="text-right"><strong>{{$currency}}{{number_format($data->subtotal,2,'.','')}}/-</strong></td>
                    </tr>
                    <tr>
                        <td>DISCOUNT</td>
                        <td class="text-right">₹ {{$data->wallet_discount +  $data->coupon_discount}}/-</td>
                    </tr>
                    <tr>
                        <td><strong>GRAND TOTAL</strong></td>
                        <td class="text-right"><strong>{{$currency}}{{number_format($data->final_total,2,'.','')}}/-</strong></td>
                    </tr>
                    <tr>
                        <td><strong class="paid-amount">PAID AMOUNT</strong></td>
                        <td class="text-right paid-amount">{{$currency}}{{number_format($data->final_total,2,'.','')}}/-</td>
                    </tr>
                  
                </tbody>
            </table>
        </div>

        <!-- Amount in words -->
        <div class="words">
            <strong>Amount Chargeable (in Words)</strong><br>{{$data->final_total_word}} Rupees Only
        </div>

        <!-- Payment Summary -->
        <div class="payment-summary">
            <strong>Payment Mode Summary</strong>
            <table spacing="0">
                <tr>
                    <th>Payment Date:</th> <th>Payment Mode:</th><th>Amount:</th>
                </tr>
                <tr >
                   <td>{{ $data->date }}</td><td>{{$data->payment_method}}</td><td>{{$currency}}{{number_format($data->final_total,2,'.','')}}/-</td>
                </tr>
            </table>
        </div>

        <!-- PAN -->
        <div class="words" style="margin-top:40px;">
            <strong>Company’s PAN No.: ---</strong><br>
            Please make cheques in favor of <strong>“{{ $data->franchise->name }}.”</strong>
        </div>

        <!-- Footer Notes -->
        <div class="footer">
            <strong>Important Notes:</strong>
            <ul>
                <li>Reliable Diagnostic Centre Pvt Ltd is exempt from GST being a healthcare service provider.</li>
                <li>This invoice can be used for tax exemption under section 80-D (Preventive Health Checkup).</li>
                <li>Reports sent on registered mail ID according to the respective TAT and can also be downloaded through Reliable Application.</li>
                <li>All dispute /claims concerning to reports are subject to the courts of Jaipur.</li>
                <li>Reliable Diagnostic assumes no liability towards any delays beyond its control.</li>
                <li>It is recommended that you consult your treating Doctor/Physician before choosing any treatment based on your results.</li>
            </ul>
            <div class="note">
                This is a computer-generated receipt and does not require a signature/stamp.
            </div>
        </div>

        <!-- Contact Bar -->
        <div class="contact-bar">
            <span>📞 +91-9828112340</span>
            <span>📧 support@rdccare.com</span>
            <span>🌐 www.rdccare.com</span>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(function(){
       window.print();
       setTimeout(window.close, 5000);
    });
</script>
</html>
