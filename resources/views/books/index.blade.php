@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">{{ trans('common.books_label') }}</h4>
                    <div>
                        <a class="btn btn-primary py-2  font-weight-bold text-white" href="{{ route('books.create') }}"  style="border-radius: 10px">
                            {{trans('common.books_add_label')}}
                            <i class="ml-1 fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card  px-1 pt-1 rounded-lg">
                <div class="card-body">
                    <div class="row pl-2 mb-3">
                        <div class="col-xl-2 col-lg-3 col-md-5 col-sm-6">
                            <div class="form-group row">
                               <div class="col">
                                   <label for="category_filter" class="col-form-label font-weight-bold">{{trans('common.filter_category_label')}}</label>
                                   <select type="text" id="category_filter" name="category_id" class="form-control">
                                        <option value="0">All</option>
                                        @foreach($data['categories'] as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 d-flex flex-column justify-content-center">
                            <div class="row pt-4">
                                <button class="btn btn-primary text-light font-weight-bol mr-1" id="filterBtn">
                                    {{trans('common.filter_label')}}
                                    <i class="fas fa-filter ml-1"></i>
                                </button>
                                <button class="btn btn-danger text-light font-weight-bold" id="clearBtn">
                                    {{trans('common.clear_label')}}
                                    <i class="fas fa-ban ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="fix-topbar">
                        <table id="datatable" class="table border-right border-left border-bottom display compact nowrap">
                            <thead>
                            <tr class="text-dark">
                                <th>Id</th>
                                <th>{{trans('common.book_title_label')}}</th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-user text-primary"></i></span>
                                    {{trans('common.author_label')}}
                                </th>
                                <th>ISBN</th>
                                <th>{{trans('common.books_number_copies_label')}}</th>
                                <th>{{trans('common.books_pages_label')}}</th>
                                <th>{{trans('common.books_cover_label')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
        const removeModal = $('#removeModal')
        const removeForm = $('#remove_form')

        const addModal = $('#addModal')
        const addForm = $('#addForm')

        const editModal = $('#editModal')
        const editForm = $('#editForm')
        $(document).ready(()=>{
            console.log(javascript_trans)
            let categoryId = 0;
            const categoryFilter = $('#category_filter');
            const filterBtn = $('#filterBtn')
            const clearBtn = $('#clearBtn')
            const dataTable = $("#datatable").DataTable({
                language: datatableTrans,
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('books.index') !!}',
                    data: function(d){
                        d.categoryId = categoryId;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title'},
                    { data: 'author', name: 'author'},
                    { data: 'isbn',name: 'isbn'},
                    { data: 'num_copies',name: 'num_copies'},
                    { data: 'num_pages',name: 'num_pages'},
                    { data: 'cover',name: 'cover'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });

            categoryFilter.on('change',function($event){
                console.log(this.value)
                categoryId = this.value
            });
            filterBtn.on('click',function($event){
                console.log('clicked')
                dataTable.ajax.reload()
            })
            clearBtn.on('click',function($event){
                categoryId = 0
                dataTable.ajax.reload()
            })
            $(".custom-file-input").on("change", function() {
                let fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            addForm.validate({

            })
            addForm.submit(function($event){
                $event.preventDefault()
                let data = new FormData($(this)[0])
                console.log(data)
                $.ajax({
                    url: '{!! route('books.store') !!}',
                    headers: {
                        'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                    },
                    method: 'post',
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    data: data,
                    complete: (xhr)=>{
                        if(xhr.status === 201){
                            const {message} = xhr.responseJSON
                            toastr.success(message,'Success');
                            dataTable.ajax.reload()
                            addModal.modal('hide')
                        }
                    }
                })
            })

            removeForm.submit(function($event){
                $event.preventDefault();
                let data = $(this).serialize()
                $.ajax({
                    url: '{!! route('books.destroy') !!}',
                    method: 'delete',
                    data:data,
                    complete: function (xhr) {
                            if(xhr.status === 201){
                                const {message} = xhr.responseJSON
                                removeModal.modal('hide')
                                toastr.warning(message,'Success!')
                                dataTable.ajax.reload()
                            }
                    }
                })
            })
        })

        const AddBook = ($event)=>{
            $event.preventDefault();
            console.log('click')
            addModal.modal('show')
            const author = $('#add_author')
            const pub_date = $('#add_pub_date')
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
                placeholder:'Select author',
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
        }

        const DeleteBook = ($event)=>{
            $event.preventDefault();
            let id = $event.target.getAttribute('data-id')
            let title = $event.target.getAttribute('data-title')
            $('#confirm_book').html(`${title}`)
            $('#remove_book_id').val( parseInt(id))
            removeModal.modal('show')
        }

        const EditBook = ($event)=>{
            $event.preventDefault()
            let id = $event.target.getAttribute('data-id')
            const title = $('#edit_title')
            const author = $('#edit_author')
            const isbn = $('#edit_isbn')
            const pubDate = $('#edit_pub_date')
            const num_pages = $('#edit_num_pages')
            const salePrice = $('#edit_sale_price')
            const purchasePrice = $('#edit_purchase_price')
            const cover = $('#edit_cover')
            const categories = $('#edit_categories')
            const desciption = $('#edit_description')
            const age = $('#edit_age_restricted')
            $.ajax({
                url: '{!! route('books.getById') !!}',
                method: 'post',
                data: {
                    _token: '{!! csrf_token() !!}',
                    book_id: id
                },
                complete: (xhr)=>{
                    if(xhr.status === 201){
                        const {book,categories} = xhr.responseJSON;
                        console.log(book)
                        console.log(categories)
                    }
                }
            })
        }

        const previewImage = (event)=>{
            let reader = new FileReader();
            reader.onload = function()
            {
                let output = document.getElementById('add_cover_preview');
                $('#add_cover_preview').removeClass('d-none')
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        const setupEditAuthor = (authorId) =>{

        }

        const setupEditCategories = (categories) =>{

        }
    </script>
@endsection
