@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="col">
            <div class="container d-flex flex-column justify-content-center">
                <div class="row mb-2">
                    <div class="col">
                        <h5 class="text-primary font-weight-bold">New Book</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <form method="post" action="{{ route('books.store') }}" id="editForm" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body px-4 py-4">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="title" class="text-dark font-weight-bold">Title <span class="text-danger">*</span></label>
                                                <input type="text" id="title" name="title" class="form-control">
                                                @error('title')
                                                <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <label for="isbn" class="text-dark  font-weight-bold">ISBN <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-barcode text-dark"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" id="isbn" name="isbn" class="form-control">
                                                </div>
                                                @error('isbn')
                                                <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <label for="author" class="text-dark font-weight-bold">Author<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-user-tie text-dark"></i>
                                                        </div>
                                                    </div>
                                                    <select type="text" id="author" name="author_id" class="form-control"></select>
                                                </div>
                                                @error('author_id')
                                                <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row py-2">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="pub_date" class="text-dark  font-weight-bold">Publication Date <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-calendar text-dark"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" id="pub_date" name="publication_date" class="form-control">
                                                    @error('publication_date')
                                                    <span class="error">{{$message}}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="num_pages" class="text-dark font-weight-bold">Number of Pages</label>
                                                <input type="number" id="num_pages" placeholder="100" name="num_pages" step="1.0" min="1" class="form-control">
                                                @error('num_pages')
                                                <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="sale_price" class="text-dark font-weight-bold">Sale price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-dollar-sign text-dark"></i>
                                                        </div>
                                                    </div>
                                                    <input type="number" step="0.05" min="0.00" placeholder="0.00" id="sale_price" name="sale_price" class="form-control">
                                                    @error('sale_price')
                                                    <span class="error">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="purchase_price" class="text-dark font-weight-bold">Purchase Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fa fa-dollar-sign text-dark"></i>
                                                        </div>
                                                    </div>
                                                    <input type="number" step="0.05" min="0.00" placeholder="0.00" id="purchase_price" name="purchase_price" class="form-control">
                                                    @error('title')
                                                    <span class="error">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row py-2">
                                        <div class="col">
                                            <div class="mb-1 mt-1 text-dark font-weight-bold">Cover Image</div>
                                            <div class="form-group">
                                                <div class="custom-file mb-1">
                                                    <input type="file" class="custom-file-input" id="cover" name="cover">
                                                    <label class="custom-file-label" for="cover">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <label for="categories">Categories</label>
                                                <select name="categories[]" id="categories" multiple class="form-control"></select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="age_restricted">Age restricted <span class="text-danger">*</span></label>
                                                <select class="form-control" id="age_restricted" name="age_restricted">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row py-2">
                                        <div class="col">
                                            <label for="description" class="text-dark  text-dark font-weight-bold">Short description</label>
                                            <textarea rows="5" id="description" name="short_description" placeholder="a long time ago in a galaxy far far away" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success col-lg-2 col-md-3 col-sm-5 mr-2">
                                        <i class="fa fa-save mr-2"></i>
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">No</button>
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
    @include('shared.totalCSS')
@endsection

@section('custom_js')
    @include('shared.totalJS')
    <script>
        $(document).ready(()=> {
            const author = $('#author')
            const pub_date = $('#pub_date')
            const categories = $('#categories')
            categories.select2({
                theme: 'classic',
                placeholder: 'Select categories',
                ajax: {
                    url: '{!! route('category.list') !!}',
                    type: 'post',
                    data: function(params){
                        return {
                            _token: '{!! csrf_token() !!}',
                            name: params.term,
                            page: params.page || 1
                        };
                    },
                    dataType: 'json',
                    cache:true,
                    delay:200,
                    placeholder: 'Search Member',
                    processResults: function(data,params){
                        params.page = params.page || 1;
                        //console.log(params)
                        const {total_items} = data;
                        return {
                            results: data.results,
                            pagination: {
                                more: (params.page * 10) < total_items
                            }
                        }
                    }
                }
            })
            author.select2({
                theme: 'bootstrap4',
                placeholder: 'Select author',
                ajax: {
                    url: '{!! route('authors.list') !!}',
                    type: 'post',
                    data: function(params){
                        return {
                            _token: '{!! csrf_token() !!}',
                            name: params.term,
                            page: params.page || 1
                        };
                    },
                    dataType: 'json',
                    cache:true,
                    delay:200,
                    placeholder: 'Search Member',
                    processResults: function(data,params){
                        params.page = params.page || 1;
                        //console.log(params)
                        const {total_items} = data;
                        return {
                            results: data.results,
                            pagination: {
                                more: (params.page * 10) < total_items
                            }
                        }
                    }
                }
            });

            pub_date.daterangepicker({
                singleDatePicker:true,
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 1901,
                drops:'auto'
            })
        })
    </script>
@endsection
