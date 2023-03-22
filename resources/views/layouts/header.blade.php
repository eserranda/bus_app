<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('headcss')
    <title>Dashboard - PO. Sinar Muda</title>
    {{-- sweetalert bukan sweetalert2 ya. --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

    {{-- bootstrap --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> --}}

    <!-- CSS files -->
    <link href="{{ asset('assets') }}/css/tabler.min.css?1674944402" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/tabler-flags.min.css?1674944402" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/tabler-vendors.min.css?1674944402" rel="stylesheet" />
    {{-- <link href="{{ asset('assets') }}/css/tabler-payments.min.css?1674944402" rel="stylesheet" /> --}}
    <link href="{{ asset('assets') }}/css/demo.min.css?1674944402" rel="stylesheet" />

    {{-- fontawesome --}}
    <script src="{{ asset('assets') }}/fontawesome/js/all.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" layout-fluid">
    <script src="{{ asset('assets') }}/js/demo-theme.min.js?1674944402"></script>
    <div class="page">
