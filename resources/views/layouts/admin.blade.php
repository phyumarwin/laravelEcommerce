<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--plugins:css-->
    <link rel="stylesheet" href="{{ asset('admin/vendors/mid/css/masterildesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/base/vendor.bundle.base.css') }}">
    <!--endinject-->
    <!--plugin css for this page-->
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap.css') }}">
    <!--End plugin css for this page-->
    <!--inject:css-->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <!--endinject-->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}"/>
    
    @livewireStyles
</head>
<body>

    <scriptor src="{{ asset('vendors/base/vendor.bundle.base.js') }}"></scriptor>

    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>

    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>

    <!--Custom js for this page-->
    <script src="{{ asset('js/dashbord.js') }}"></script>
    <script src="{{ asset('js/data-table.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <!--End custom js for this page-->

    @livewireScripts
</body>
</html>