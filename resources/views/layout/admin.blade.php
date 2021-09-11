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
    @include('shared.change_lang_modal')
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

@section('other_js')
    <script type="text/javascript">
        let javascript_trans = {!! json_encode(trans('javascript')) !!};
        let datatableTrans = {
                processing:     javascript_trans.loading_label,
                search:         javascript_trans.search_label,
                lengthMenu:     javascript_trans.select_showing_label,
                info:           javascript_trans.showing_label,
                infoEmpty:      javascript_trans.showing_zero_records_label,
                infoPostFix:    "",
                zeroRecords:    javascript_trans.zero_records_label,
                emptyTable:     javascript_trans.zero_records_label,
                paginate: {
                    first:      javascript_trans.first_label,
                    previous:   javascript_trans.previous_label,
                    next:       javascript_trans.next_label,
                    last:       javascript_trans.last_label
                },
                aria: {
                    sortAscending:  `:${javascript_trans.sort_ascend_label}`,
                    sortDescending: `:${javascript_trans.sort_descend_label}`
                }
            }
    </script>
@endsection
