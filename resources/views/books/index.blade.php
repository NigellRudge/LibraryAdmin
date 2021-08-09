@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">Books</h4>
                    <div>
                        <a class="btn btn-primary py-2  font-weight-bold text-white" href="{{ route('books.create') }}"  style="border-radius: 10px">
                            Add Book
                            <i class="ml-1 fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card  px-1 pt-1 rounded-lg">
                <div class="card-body">
                    <div class="row pl-2 mb-3">
                        <div class="col-5">
                            <div class="form-group row">
                                <label for="category_filter" class="col-form-label font-weight-bold">Filter By category</label>
                                <div class="col">
                                    <select type="text" id="category_filter" name="category_id" class="form-control">
                                        <option value="0">All</option>
                                        @foreach($data['categories'] as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary text-light font-weight-bold" id="filterBtn">
                                Filter
                                <i class="fas fa-filter ml-1"></i>
                            </button>
                            <button class="btn btn-danger text-light font-weight-bold" id="clearBtn">
                                Clear
                                <i class="fas fa-ban ml-1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="fix-topbar">
                        <table id="datatable" class="table table-bordered table-hover display compact nowrap">
                            <thead>
                            <tr class="text-dark">
                                <th>Id</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Copies</th>
                                <th>Cover</th>
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

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="addModalLabel">Add Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="addForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body px-3 py-2">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_title" class="text-dark font-weight-bold">Title <span class="text-danger">*</span></label>
                                    <input type="text" id="add_title" name="title" class="form-control">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="add_isbn" class="text-dark  font-weight-bold">ISBN <span class="text-danger">*</span></label>
                                    <input type="text" id="add_isbn" name="isbn" class="form-control">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="add_author" class="text-dark font-weight-bold">Author<span class="text-danger">*</span></label>
                                    <select type="text" id="add_author" name="author_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_pub_date" class="text-dark  font-weight-bold">Publication Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar text-dark"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="add_pub_date" name="publication_date" class="form-control">
                                    </div>

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_num_pages" class="text-dark font-weight-bold">Number of Pages</label>
                                    <input type="number" id="add_num_pages" placeholder="100" name="num_pages" step="1.0" min="1" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="add_sale_price" class="text-dark font-weight-bold">Sale price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-dollar-sign text-dark"></i>
                                            </div>
                                        </div>
                                        <input type="number" step="0.05" min="0.00" placeholder="0.00" id="add_sale_price" name="sale_price" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="add_purchase_price" class="text-dark font-weight-bold">Purchase Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-dollar-sign text-dark"></i>
                                            </div>
                                        </div>
                                        <input type="number" step="0.05" min="0.00" placeholder="0.00" id="add_purchase_price" name="purchase_price" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="mb-1 mt-1 text-dark font-weight-bold">Cover Image</div>
                                <div class="form-group">
                                    <div class="custom-file mb-1">
                                        <input type="file" class="custom-file-input" id="add_cover" name="cover">
                                        <label class="custom-file-label" for="add_cover">Choose file</label>
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
                                    <label for="add_age_restricted">Age restricted <span class="text-danger">*</span></label>
                                    <select class="form-control" id="add_age_restricted" name="age_restricted">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="add_description" class="text-dark  text-dark font-weight-bold">Short description</label>
                                <textarea rows="5" id="add_description" name="short_description" placeholder="a long time ago in a galaxy far far away" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success col-lg-2 col-md-3 col-sm-5">Yes</button>
                            <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="editModalLabel">Edit Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="editForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body px-3 py-2">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_title" class="text-dark font-weight-bold">Title <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_title" name="title" class="form-control">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_isbn" class="text-dark  font-weight-bold">ISBN <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_isbn" name="isbn" class="form-control">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_author" class="text-dark font-weight-bold">Author<span class="text-danger">*</span></label>
                                    <select type="text" id="edit_author" name="author_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_pub_date" class="text-dark  font-weight-bold">Publication Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar text-dark"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="edit_pub_date" name="publication_date" class="form-control">
                                    </div>

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_num_pages" class="text-dark font-weight-bold">Number of Pages</label>
                                    <input type="number" id="edit_num_pages" placeholder="100" name="num_pages" step="1.0" min="1" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="edit_sale_price" class="text-dark font-weight-bold">Sale price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-dollar-sign text-dark"></i>
                                            </div>
                                        </div>
                                        <input type="number" step="0.05" min="0.00" placeholder="0.00" id="edit_sale_price" name="sale_price" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="edit_purchase_price" class="text-dark font-weight-bold">Purchase Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-dollar-sign text-dark"></i>
                                            </div>
                                        </div>
                                        <input type="number" step="0.05" min="0.00" placeholder="0.00" id="edit_purchase_price" name="purchase_price" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="mb-1 mt-1 text-dark font-weight-bold">Cover Image</div>
                                <div class="form-group">
                                    <div class="custom-file mb-1">
                                        <input type="file" class="custom-file-input" id="edit_cover" name="cover">
                                        <label class="custom-file-label" for="edit_cover">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_categories">Categories</label>
                                    <select name="categories[]" id="edit_categories" multiple class="form-control"></select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="edit_age_restricted">Age restricted <span class="text-danger">*</span></label>
                                    <select class="form-control" id="edit_age_restricted" name="age_restricted">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="edit_description" class="text-dark  text-dark font-weight-bold">Short description</label>
                                <textarea rows="5" id="edit_description" name="short_description" placeholder="a long time ago in a galaxy far far away" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success col-lg-2 col-md-3 col-sm-5">Yes</button>
                            <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="removeModalLabel">Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="remove_form">
                    @csrf
                    <input type="hidden" name="book_id" id="remove_book_id">
                    <div class="modal-body">
                        <div class="d-flex flex-row align-baseline">
                            <div class="text-teal mr-2 ml-1" style="font-size: 3.0rem;">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <div class="pt-4 text-dark">
                                Are you sure you want to remove this Book:<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_book"></div> ?
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </form>
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
            let categoryId = 0;
            const categoryFilter = $('#category_filter');
            const filterBtn = $('#filterBtn')
            const clearBtn = $('#clearBtn')
            const dataTable = $("#datatable").DataTable({
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
