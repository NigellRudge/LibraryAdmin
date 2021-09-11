@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="container">
            <div class="row mb-2">
                <div class="col">
                    <h5 class="text-primary font-weight-bold">Edit Book</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form method="post" action="{{ route('books.update',['book' => $data['book']['id']]) }}" id="editForm" enctype="multipart/form-data">
                            @method('patch')
                            @csrf
                            <div class="card-body px-4 py-4">
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="title" class="text-dark font-weight-bold">{{trans('common.book_title_label')}} <span class="text-danger">*</span></label>
                                            <input type="text" id="title" name="title" class="form-control" value="{{ $data['book']['title'] }}">
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
                                                <input type="text" id="isbn" name="isbn" class="form-control" value="{{ $data['book']['isbn'] }}">
                                            </div>
                                            @error('isbn')
                                            <span class="error">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="author" class="text-dark font-weight-bold">{{trans('common.author_label')}}<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-user-tie text-dark"></i>
                                                    </div>
                                                </div>
                                                <select id="author" name="author_id" class="form-control"></select>
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
                                            <label for="pub_date" class="text-dark  font-weight-bold">{{trans('common.books_pub_date_label')}} <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar text-dark"></i>
                                                    </div>
                                                </div>
                                                <input type="text" id="pub_date" name="publication_date" class="form-control" value="{{ $data['book']['publication_date'] }}">
                                                @error('publication_date')
                                                <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="num_pages" class="text-dark font-weight-bold">{{trans('common.books_number_page_label')}}</label>
                                            <input type="number" id="num_pages" placeholder="100" name="num_pages" step="1.0" min="1" class="form-control" value="{{ $data['book']['num_pages'] }}">
                                            @error('num_pages')
                                            <span class="error">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="sale_price" class="text-dark font-weight-bold">{{trans('common.books_sales_price_label')}}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-dollar-sign text-dark"></i>
                                                    </div>
                                                </div>
                                                <input type="number" step="0.05" min="0.00" placeholder="0.00" id="sale_price" name="sale_price" class="form-control" value="{{ $data['book']['sale_price'] }}">
                                                @error('sale_price')
                                                <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="purchase_price" class="text-dark font-weight-bold">{{trans('common.books_purchase_price_label')}}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-dollar-sign text-dark"></i>
                                                    </div>
                                                </div>
                                                <input type="number" step="0.05" min="0.00" placeholder="0.00" id="purchase_price" name="purchase_price" class="form-control" value="{{ $data['book']['purchase_price'] }}">
                                                @error('title')
                                                <span class="error">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row py-2">
                                    <div class="col">
                                        <div class="mb-1 mt-1 text-dark font-weight-bold">{{trans('common.books_cover_image_label')}}</div>
                                        <div class="form-group">
                                            <div class="custom-file mb-1">
                                                <input type="file" class="custom-file-input" id="cover" name="cover" value="{{ $data['book']['cover'] }}">
                                                <label class="custom-file-label" for="cover">{{ $data['book']['cover'] }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="categories">{{trans('common.categories_label')}}</label>
                                            <select name="categories[]" id="categories" multiple class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="age_restricted">{{trans('common.books_age_restricted_label')}} <span class="text-danger">*</span></label>
                                            <select class="form-control" id="age_restricted" name="age_restricted">
                                                @if($data['book']['age_restricted'])
                                                    <option value="1">{{trans('common.yes_label')}}</option>
                                                @else
                                                    <option value="0">{{trans('common.no_label')}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row py-2">
                                    <div class="col">
                                        <label for="description" class="text-dark  text-dark font-weight-bold">{{trans('common.books_description_label')}}</label>
                                        <textarea rows="5" id="description" name="short_description" placeholder="{{trans('common.books_description_example')}}"  class="form-control">{{$data['book']['short_description'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-success col-lg-2 col-md-3 col-sm-5 mr-2">
                                    <i class="fa fa-save mr-2"></i>
                                    {{trans('common.save_label')}}
                                </button>
                                <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">{{trans('common.cancel_label')}}</button>
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
            const pub_date = $('#pub_date')
            const categorySelect = $('#categories').select2({
                theme: 'classic',
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
            $.ajax({
                type: 'POST',
                url: '{!! route('category.list') !!}',
                data: {
                    _token: '{!! csrf_token() !!}',
                    bookId:{{$data['book']['id']}}
                }
            }).then(function(data){
                let category;
                for(category of data.results){
                    let option = new Option(category.text,`${category.id}`,true, true)
                    categorySelect.append(option)
                }
                categorySelect.trigger('change')
                categorySelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });

            const authorSelect = $('#author').select2({
                theme: 'bootstrap4',
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
                    placeholder: 'Search author',
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
            $.ajax({
                type: 'POST',
                url: '{!! route('authors.list') !!}',
                data: {
                    _token: '{!! csrf_token() !!}',
                    authorId:{{$data['book']['author_id']}}
                }
            }).then(function(data){
                let author = data.results[0]
                console.log(author)
                let option = new Option(author.text,`${author.id}`,true, true)
                console.log(option)
                authorSelect.append(option)
                authorSelect.trigger('change')
                authorSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
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
