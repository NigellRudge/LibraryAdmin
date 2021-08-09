@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="container">
                <div class="card">
                    <div class="card-header bg-white">
                        <span class="">Confirm</span>
                    </div>
                    <div class="card-body">
                        Are you sure you want to terminate membership of <span class="font-weight-bold text-dark">{{ $data['member']->name() }}</span>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex flex-row justify-content-end">
                            <button class="btn btn-success">Save</button>
                            <button class="btn btn-danger" >Cancel</button>
                        </div>
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
@endsection
