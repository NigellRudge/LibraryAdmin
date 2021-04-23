@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between">
                    <h4 class="font-weight-bold text-primary pl-2 pt-2">Book Copies</h4>
                    <div class="pb-2">
                        <button class="btn btn-primary rounded-pill py-2  font-weight-bold text-white" onclick="AddBookCopy(event)">
                            Add Book Copy
                            <i class="ml-1 fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card  px-1 pt-1 rounded-lg">
                <div class="card-body">
                    <div class="row pl-2 mb-3">
                        <div class="col">
                            <div class="form-group row">
                                <label for="status_filter" class="col-form-label font-weight-bold">Filter By Status</label>
                                <div class="col">
                                    <select type="text" id="status_filter" name="status" class="form-control">
                                        <option value="0">All</option>
                                        @foreach($data['statuses'] as $status)
                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row">
                                <label for="condition_filter" class="col-form-label font-weight-bold">Filter By Condition</label>
                                <div class="col">
                                    <select type="text" id="condition_filter" name="condition" class="form-control">
                                        <option value="0">All</option>
                                        @foreach($data['conditions'] as $condition)
                                            <option value="{{$condition->id}}">{{$condition->name}}</option>
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
                                <th>UUID</th>
                                <th>Title</th>
                                <th>Condition</th>
                                <th>Status</th>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="addModalLabel">Add Book Copy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="addForm">
                    @csrf
                    <div class="modal-body px-3 py-2">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_uid" class="font-weight-bold">UUID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-qrcode text-dark"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="add_uid" name="uid" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_book" class="font-weight-bold">Book <span class="text-danger">*</span></label>
                                    <select id="add_book" name="book_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_condition" class="font-weight-bold">Condition <span class="text-danger">*</span></label>
                                    <select id="add_condition" name="condition_id" class="form-control">
                                        <option value="0">Select Condition</option>
                                        @foreach($data['conditions'] as $condition)
                                            <option value="{{$condition->id}}">{{$condition->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_status" class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                    <select id="add_status" name="status_id" class="form-control">
                                        <option value="0">Select status</option>
                                        @foreach($data['statuses'] as $status)
                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_for_sale" class="font-weight-bold">For sale <span class="text-danger">*</span></label>
                                    <select id="add_for_sale" name="for_sale" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary col-lg-2 col-md-3 col-sm-5">Yes</button>
                        <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="editModalLabel">Edit Book Copy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="editForm">
                    @csrf
                    <input type="hidden" id="edit_copy_id" name="copy_id">
                    <div class="modal-body px-3 py-2">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_uid" class="font-weight-bold">UUID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-qrcode text-dark"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="edit_uid" name="uid" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_book" class="font-weight-bold">Book <span class="text-danger">*</span></label>
                                    <select id="edit_book" name="book_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_condition" class="font-weight-bold">Condition <span class="text-danger">*</span></label>
                                    <select id="edit_condition" name="condition_id" class="form-control">
                                        <option value="0">Select Condition</option>
                                        @foreach($data['conditions'] as $condition)
                                            <option value="{{$condition->id}}">{{$condition->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_status" class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                    <select id="edit_status" name="status_id" class="form-control">
                                        <option value="0">Select status</option>
                                        @foreach($data['statuses'] as $status)
                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_for_sale" class="font-weight-bold">For sale <span class="text-danger">*</span></label>
                                    <select id="edit_for_sale" name="for_sale" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary col-lg-2 col-md-3 col-sm-5">Yes</button>
                        <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">No</button>
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
                    <input type="hidden" name="copy_id" id="remove_copy_id">
                    <div class="modal-body">
                        <div class="d-flex flex-row align-baseline">
                            <div class="text-teal mr-2 ml-1" style="font-size: 3.0rem;">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <div class="pt-2 text-dark">
                                Are you sure you want to remove this Book Copy:<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_copy"></div> ?
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom_css')
    @include('shared.totalCSS')
    <style>
        table.dataTable thead {
            background-color:var(--primary);

        }
        table.dataTable thead tr th {
            color:var(--light);
            font-size: 0.9rem;
        }
    </style>
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
            let conditionId = 0;
            let statusId = 0;
            const conditionFilter = $('#condition_filter');
            const statusFilter = $('#status_filter');
            const filterBtn = $('#filterBtn')
            const clearBtn = $('#clearBtn')
            const dataTable = $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('books.copies.index') !!}',
                    data: function(d){
                        d.status = statusId
                        d.condition = conditionId
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'uid', name: 'uid'},
                    { data: 'title', name: 'title'},
                    { data: 'condition',name: 'condition'},
                    { data: 'status',name: 'status'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });

            conditionFilter.on('change',function($event){
                console.log(this.value)
                conditionId = parseInt(this.value)
            });
            statusFilter.on('change',function($event){
                console.log(this.value)
                statusId = parseInt(this.value)
            });
            filterBtn.on('click',function($event){
                dataTable.ajax.reload()
            })
            clearBtn.on('click',function($event){
                statusId = 0
                conditionId = 0
                dataTable.ajax.reload()
            })

            addForm.validate({

            })
            addForm.submit(function($event){
                $event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url: '{!! route('books.copies.store') !!}',
                    method: 'post',
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
                    url: '{!! route('books.copies.destroy') !!}',
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

        const AddBookCopy = ($event)=>{
            $event.preventDefault();
            const book = $('#add_book')
            const consumer = $('#add_condition')
            const status = $('#add_status')
            book.select2({
                theme: 'bootstrap4',
                ajax: {
                    url: '{!! route('books.list') !!}',
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
                    placeholder: 'Search Book',
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

            addModal.modal('show')
        }

        const DeleteBookCopy = ($event)=>{
            $event.preventDefault();
            let id = $event.target.getAttribute('data-id')
            let uid = $event.target.getAttribute('data-uid')
            let title = $event.target.getAttribute('data-title')
            $('#confirm_copy').html(`(${uid}) ${title}`)
            $('#remove_copy_id').val( parseInt(id))
            removeModal.modal('show')
        }

        const EditBookCopy = ($event)=>{
            $event.preventDefault()
            let id = $event.target.getAttribute('data-id')
            const bookId = $('#edit_book')
            const conditionId = $('#edit_condition')
            const statusId = $('#edit_status')
            const uid = $('#edit_uid')
            const forSale = $('#edit_for_sale')

            $.ajax({
                url: '{!! route('books.copies.getById') !!}',
                method: 'post',
                data: {
                    _token: '{!! csrf_token() !!}',
                    copy_id: id
                },
                complete: function(xhr){
                    if(xhr.status === 201){
                        const {book} = xhr.responseJSON
                        console.log(book)
                        conditionId.val(book.condition_id)
                        statusId.val(book.status_id)
                        uid.val(book.uid)
                        forSale.val(book.for_sale)
                        SetupEditBook(book.book_id)
                    }
                }
            })
        }

        const SetupEditBook = (bookId)=>{
            const editBook = $('#edit_book').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: '{!! route('books.list') !!}',
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
                    placeholder: 'Search Book',
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
                url: '{!! route('books.getById') !!}',
                data: {
                    _token: '{!! csrf_token() !!}',
                    book_id:bookId
                }
            }).then(function(data){
                const {book} = data
                console.log(book)
                let option = new Option(book.title,book.id,true, true)
                editBook.append(option).trigger('change')
                editBook.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
                editModal.modal('show')
            });
        }

    </script>
@endsection
