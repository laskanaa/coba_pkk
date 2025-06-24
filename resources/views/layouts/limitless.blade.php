<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Admin PKK Wonosobo' }}</title>

    <!-- CSS Limitless -->
    <link href="{{ asset('limitless/global_assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/layout_1/LTR/default/full/assets/css/bootstrap.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('limitless/layout_1/LTR/default/full/assets/css/bootstrap_limitless.min.css') }}"
        rel="stylesheet" type="text/css">
    <link href="{{ asset('limitless/layout_1/LTR/default/full/assets/css/layout.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('limitless/layout_1/LTR/default/full/assets/css/components.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('limitless/layout_1/LTR/default/full/assets/css/colors.min.css') }}" rel="stylesheet"
        type="text/css">
    <!-- CKEditor 4 -->
    <script src="{{ asset('limitless/global_assets/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireStyles
</head>

<body>

    <!-- Main navbar -->
    @include('limitless.partials.navbar')
    <!-- /main navbar -->

    <!-- Page content -->
    <div class="page-content">
        <!-- Main sidebar -->
        @include('limitless.partials.sidebar')
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            @include('limitless.partials.header')
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">

                {{ $slot ?? '' }}

            </div>
            <!-- /content area -->


            <!-- Footer -->
            @include('limitless.partials.footer')
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- Core JS files -->
    <script src="{{ asset('limitless/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('limitless/global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>

    <script src="{{ asset('limitless/layout_1/LTR/default/full/assets/js/app.js') }}"></script>
    <script src="{{ asset('limitless/global_assets/js/demo_pages/dashboard.js') }}"></script>
    <!-- /theme JS files -->

    @livewireScripts
    @stack('scripts')
    @stack('styles')


    {{-- Logout Form --}}
    <form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>

</html>
