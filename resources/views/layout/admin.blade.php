@extends('layout.base')

@section('body')
    @include('shared.sidemenu')<!-- Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
           @include('shared.top_nav_bar') <!-- Topbar -->
            <!-- Begin Page Content -->
            <div class="container-fluid">
                @yield('main_content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        @include('shared.footer')<!-- Footer -->
    </div>
    <!-- End of Content Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    @include('shared.logout_confirm_modal')<!-- Logout Modal-->
@endsection

@section('css')
    @yield('custom_css')
@endsection

@section('js')
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('plugins/jquery-easing/jquery.easing.min.js')}}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js')}}"></script>
    @yield('custom_js')
@endsection
