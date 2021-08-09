@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="shadow h-100 p-1" style="background-color: #faf9f9;border-radius: 14px" >
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h5 class="font-weight-bold text-primary mb-1">Total Books</h5>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{$data['total_books']}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-1">
                        <a href="{{ route('books.index') }}">
                            <span class="text-sm font-weight-bold text-dark">View data </span>
                            <i class="fas fa-arrow-circle-right  text-dark ml-1" style="font-size: 20px"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="shadow h-100 p-1" style="background-color: #faf9f9;border-radius: 14px" >
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h5 class="font-weight-bold text-info mb-1">Total Members</h5>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $data['total_members'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-1">
                        <a href="{{ route('members.index') }}">
                            <span class="text-sm font-weight-bold text-dark">View data </span>
                            <i class="fas fa-arrow-circle-right  text-dark ml-1" style="font-size: 20px"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="shadow h-100 p-1" style="background-color: #faf9f9;border-radius: 14px" >
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h5 class="font-weight-bold text-warning mb-1">Pending Membership requests</h5>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $data['pending_requests'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-1">
                        <a href="{{ route('requests.index') }}">
                            <span class="text-sm font-weight-bold text-dark">View data </span>
                            <i class="fas fa-arrow-circle-right  text-dark ml-1" style="font-size: 20px"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="shadow h-100 p-1" style="background-color: #faf9f9;border-radius: 14px" >
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h5 class="font-weight-bold mb-1" style="color: purple;">Open Invoices</h5>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $data['open_invoices'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x" style="color: purple"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-1">
                        <a href="{{ route('invoices.index') }}">
                            <span class="text-sm font-weight-bold text-dark">View data </span>
                            <i class="fas fa-arrow-circle-right  text-dark ml-1" style="font-size: 20px"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_css')
    @include('shared.totalCSS')
@endsection
@section('custom_js')
    @include('shared.totalJS')
    <script>
        $(document).ready(function () {
            console.log('ready')
        })
    </script>
@endsection
