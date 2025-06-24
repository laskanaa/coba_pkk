<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'AdminLTE Page' }}</title>

    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{-- Navbar --}}
        @include('adminlte.partials.navbar')

        {{-- Sidebar --}}
        @include('adminlte.partials.sidebar')

        {{-- Content --}}
        <div class="content-wrapper p-3">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        @include('adminlte.partials.footer')

    </div>

    {{-- AdminLTE JS --}}
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    @livewireScripts
</body>

</html>
