<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('porchit') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('porchit') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('porchit') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('porchit') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <!-- Datatables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css"> -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.bootstrap4.min.css">
        
        <!-- JS -->
        <script src="{{ asset('porchit') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('porchit') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Optional JS -->
        <script src="{{ asset('porchit') }}/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('porchit') }}/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- <script src="{{ asset('porchit') }}/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script> -->
        <script src="{{ asset('porchit') }}/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="{{ asset('porchit') }}/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="{{ asset('porchit') }}/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="{{ asset('porchit') }}/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="{{ asset('porchit') }}/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
        <!-- Argon JS -->
        <script src="{{ asset('porchit') }}/js/argon.js?v=1.0.0"></script>
        <!-- Datatable JS -->
        <!-- Page plugins -->
        <link rel="stylesheet" href="{{ asset('porchit') }}/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ asset('porchit') }}/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ asset('porchit') }}/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css">
    </head>
    <body class="{{ $class ?? '' }}">
        <style>
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0 !important;
            }
            table.dataTable.no-footer {
                border-bottom: none !important;
            }
        </style>
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth
        
        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest

       
        
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('porchit') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>