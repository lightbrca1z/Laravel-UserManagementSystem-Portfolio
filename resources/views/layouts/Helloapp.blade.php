<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <style>
            th { background-color:#999; color:#fff; padding:5px 10px; }
            td { border:solid 1px #aaa; color:#999; padding:5px 10px; }
            label { margin:0px; font-size:16px;}
            input { padding:5px 10px; margin:2px; }
            button { padding:5px 20px; margin:2px; }
            .hello-actions { display:flex; gap:12px; margin-bottom:16px; flex-wrap:wrap; }
            .hello-actions .btn {
                display:inline-block;
                padding:8px 16px;
                border-radius:6px;
                text-decoration:none;
                font-size:14px;
                font-weight:500;
                transition: background-color .2s, color .2s, box-shadow .2s;
            }
            .hello-actions .btn-add {
                background:#2563eb;
                color:#fff;
                border:1px solid #1d4ed8;
            }
            .hello-actions .btn-add:hover { background:#1d4ed8; box-shadow:0 2px 8px rgba(37,99,235,.35); }
            .hello-actions .btn-reset {
                background:#059669;
                color:#fff;
                border:1px solid #047857;
            }
            .hello-actions .btn-reset:hover { background:#047857; box-shadow:0 2px 8px rgba(5,150,105,.35); }
            .hello-actions .btn-dummy {
                background:#fff;
                color:#dc2626;
                border:1px solid #dc2626;
            }
            .hello-actions .btn-dummy:hover { background:#dc2626; color:#fff; box-shadow:0 2px 8px rgba(220,38,38,.25); }
            .hello-form-wrap { max-width:420px; margin-top:24px; }
            .hello-form {
                background:#f8fafc;
                border:1px solid #e2e8f0;
                border-radius:12px;
                padding:24px;
                box-shadow:0 1px 3px rgba(0,0,0,.06);
            }
            .hello-form .form-row {
                display:flex;
                align-items:center;
                gap:12px;
                margin-bottom:18px;
            }
            .hello-form .form-row:last-of-type { margin-bottom:22px; }
            .hello-form .form-row label {
                flex-shrink:0;
                width:80px;
                font-size:14px;
                font-weight:500;
                color:#334155;
                margin:0;
            }
            .hello-form .form-row input[type="text"],
            .hello-form .form-row input[type="number"] {
                flex:1;
                min-width:0;
                box-sizing:border-box;
                padding:10px 12px;
                border:1px solid #cbd5e1;
                border-radius:8px;
                font-size:15px;
                transition: border-color .2s, box-shadow .2s;
            }
            .hello-form input:focus {
                outline:none;
                border-color:#2563eb;
                box-shadow:0 0 0 3px rgba(37,99,235,.15);
            }
            .hello-form .form-actions {
                display:flex;
                gap:12px;
                margin-top:24px;
                padding-top:20px;
                border-top:1px solid #e2e8f0;
            }
            .hello-form .btn-submit {
                padding:10px 20px;
                background:#2563eb;
                color:#fff;
                border:none;
                border-radius:8px;
                font-size:14px;
                font-weight:500;
                cursor:pointer;
                transition: background-color .2s, box-shadow .2s;
            }
            .hello-form .btn-submit:hover {
                background:#1d4ed8;
                box-shadow:0 2px 8px rgba(37,99,235,.35);
            }
            .hello-form .btn-cancel {
                display:inline-block;
                padding:10px 20px;
                color:#64748b;
                text-decoration:none;
                border-radius:8px;
                font-size:14px;
                border:1px solid #e2e8f0;
                background:#fff;
                transition: color .2s, border-color .2s, background .2s;
            }
            .hello-form .btn-cancel:hover {
                color:#334155;
                border-color:#cbd5e1;
                background:#f8fafc;
            }
        </style>
        @livewireStyles
    </head>
    <body>
        @yield('content')
        @livewireScripts
    </body>
</html>
