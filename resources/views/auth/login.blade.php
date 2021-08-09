@extends('layout.base')

@section('body')
    <div id="content-wrapper" class="d-flex flex-column bg-primary">
        <div id="content">
            <div class="container-fluid">
                <div class="row d-flex align-items-center" style="min-height: 100vh">
                    <div class="col-xl-4 col-md-8 col-sm-10 container">
                        <div class="text-center justify-content-center d-flex flex-row">
                            <div class="d-flex flex-row">
                                <i class="fas fa-book-reader text-primary mr-2 " style="font-size: 2.5rem;"></i>
                            </div>

                            <h3 class="font-weight-bolder pt-2 text-light">Library Admin</h3>
                        </div>
                        <div class="card rounded shadow-sm">
                            <div class="card-header bg-white border-bottom-0">
                                <div class="text-center">
                                    <h4 class=" font-weight-bold text-dark" >Login</h4>
                                </div>
                            </div>
                            <form action="{{route('login')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="email" class="font-weight-bold text-dark">Email</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-primary">
                                                            <i class="fas fa-envelope text-light"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" id="email" name="email" placeholder="example@test.com" class="form-control">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="password" class="font-weight-bold text-dark">Password</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-primary">
                                                            <i class="fa fa-lock text-light"></i>
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
                                            @error('email')
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
                                            <button type="submit" class="btn btn-block btn-primary font-weight-bold text-light">Login</button>
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

@section('custom_css')

@endsection

@section('custom_js')

@endsection
