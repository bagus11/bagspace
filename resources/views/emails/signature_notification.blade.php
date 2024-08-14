<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.2.0') }}" type="text/css">
    <title>Signature Request</title>
    <style>
        @import url('https://fonts.cdnfonts.com/css/poppins');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fe;
            color: #525f7f;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            max-width: 600px;
            margin: 40px auto;
        }
        h1 {
            color: #32325d;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .btn {
            background-color: #4793AF;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 15px;
            margin: 4px 2px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #357a8b;
        }
        .signature-info {
            background-color: #f7fafc;
            border-left: 4px solid #F6995C;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        fieldset {
            border: 1px solid #e3e3e3;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        legend {
            font-size: 18px;
            font-weight: bold;
            color: #32325d;
            padding: 0 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #8898aa;
        }
        p{
            font-size: 10px !important;
        }
        .btn:hover {
            background-color: #4793AF !important;
        }

    </style>
</head>
<body>
    <div class="container">
        <fieldset>
            <legend>General Information</legend>
            <div class="signature-info">
                <p>Dear {{ $target->userRelation['name'] ?? 'User' }},</p>
                <p><b>{{ $head->userRelation['name'] ?? 'Someone' }}</b> is requesting that you review and sign the document titled : <b>{{ $head->title ?? 'No title provided' }}</b> Please make sure to check it thoroughly before signing.</p>
                <p>Thank you.</p>
                @php
                    $link = str_replace('/', '_', $head->signature_code);
                @endphp
                <a style="  background-color: #357a8b;
                border: none;
                color: white;
                font-family: Poppins;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 10px;
                border-radius: 15px;
                margin: 4px 2px;
                cursor: pointer;
                transition: background-color 0.3s ease;" class="btn" href="{{ url('validationSign/'.$link) }}">View Attachment</a>
            </div>
        </fieldset>
       
        <div class="footer">
            <p><b>ICT - Dev</b></p>
        </div>
    </div>
</body>
</html>
