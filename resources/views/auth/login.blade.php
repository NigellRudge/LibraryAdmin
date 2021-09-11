@extends('layout.base')

@section('body')
    <div id="content-wrapper" class="d-flex flex-column bg-primary">
        <div id="content">
            <div class="container-fluid">
                <div class="row d-flex align-items-center" style="min-height: 100vh">
                    <div class="col-xl-4 col-md-8 col-sm-10 container">
                        <div class="text-center justify-content-center d-flex flex-row">
                            <div class="d-flex flex-row">
                                <i class="fas fa-book-reader text-white mr-2 " style="font-size: 2.5rem;"></i>
                            </div>

                            <h3 class="font-weight-bolder pt-2 text-light">Library Admin</h3>
                        </div>
                        <div class="card rounded shadow-sm">
                            <form action="{{route('login')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="email_input" class="font-weight-bold text-secondary">{{trans('common.auth_email_label')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-white">
                                                            <i class="fas fa-envelope text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" id="email_input" name="email" placeholder="example@test.com" class="form-control">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="password" class="font-weight-bold text-secondary">{{trans('common.auth_password_label')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-white">
                                                            <i class="fa fa-lock text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <input type="password" id="password" name="password" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="pl-3 pr-3">
                                            @error('error')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> {{ $message }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="row d-flex justify-content-end">
                                        <div class="col-xl-3 col-md-4 col-sm-6">
                                            <button type="submit" class="btn btn-primary btn-block font-weight-bold">{{trans('common.auth_login_label')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')

@endsection

@section('js')
    @include('shared.totalJS')
    <script>

            const emailInput = $('#email_input')
            const emailLabel = $('#email_label')

            const passwordInput = $('#password_input')
            const passwordLabel = $('#password_label')

            emailInput.on('change', function(event){
                console.log('hello')
            })

    </script>
@endsection
