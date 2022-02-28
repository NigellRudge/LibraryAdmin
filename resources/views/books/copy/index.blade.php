@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between">
                    <h4 class="font-weight-bold text-primary pl-2 pt-2">{{trans('common.book_copies_list_label')}}</h4>
                    <div class="pb-2">
                        <button class="btn btn-primary py-2 font-weight-bold text-white" onclick="AddBookCopy(event)" style="border-radius: 10px">
                            {{trans('common.books_add_copy_label')}}
                            <i class="ml-1 fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card  px-1 pt-1 rounded-lg">
                <div class="card-body">
                    <div class="row pl-2 mb-3">
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5">
                            <div class="form-group row">
                                <div class="col">
                                    <label for="status_filter" class="col-form-label font-weight-bold">{{trans('common.filter_by_status_label')}}</label>
                                    <select type="text" id="status_filter" name="status" class="form-control">
                                        <option value="0">{{trans('common.all_label')}}</option>
                                        @foreach($data['statuses'] as $status)
                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5">
                            <div class="form-group row">
                                <div class="col">
                                    <label for="condition_filter" class="col-form-label font-weight-bold">{{trans('common.filter_by_condition_label')}}</label>
                                    <select type="text" id="condition_filter" name="condition" class="form-control">
                                        <option value="0">{{trans('common.all_label')}}</option>
                                        @foreach($data['conditions'] as $condition)
                                            <option value="{{$condition->id}}">{{$condition->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 d-flex flex-column justify-content-center">
                            <div class="row pt-4">
                                <button class="btn btn-primary mr-1 text-light font-weight-bold" id="filterBtn">
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
                        <table id="datatable" class="table  border-right border-left border-bottom display compact nowrap">
                            <thead>
                            <tr class="text-dark">
                                <th style="width: 50px;">Id</th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-qrcode text-primary"></i></span>
                                    {{trans('common.barcode_label')}}
                                </th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-book text-primary"></i></span>
                                    {{trans('common.book_label')}}
                                </th>
                                <th style="width: 60px">{{trans('common.book_copy_condition_label')}}</th>
                                <th style="width: 80px">{{trans('common.book_copy_status_label')}}</th>
                                <th style="width: 120px"></th>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="addModalLabel">{{trans('common.books_add_copy_label')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="addForm">
                    @csrf
                    <input type="hidden" id="add_status" name="status_id" value="1">
                    <div class="modal-body px-3 py-2">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_uid" class="font-weight-bold">UUID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-white">
                                                <i class="fas fa-qrcode text-primary"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="add_uid" placeholder="{{trans('common.enter_unique_code_label')}}" name="uid" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_book" class="font-weight-bold">{{trans('common.book_label')}} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-white">
                                                <i class="fas fa-book text-primary"></i>
                                            </div>
                                        </div>
                                        <select id="add_book" name="book_id" class="form-control"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_condition" class="font-weight-bold">{{trans('common.book_copy_condition_label')}} <span class="text-danger">*</span></label>
                                    <select id="add_condition" name="condition_id" class="form-control">
                                        <option value="0">{{trans('common.select_condition_label')}}</option>
                                        @foreach($data['conditions'] as $condition)
                                            <option value="{{$condition->id}}">{{$condition->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_for_sale" class="font-weight-bold">{{trans('common.book_copy_for_sale_label')}}<span class="text-danger">*</span></label>
                                    <select id="add_for_sale" name="for_sale" class="form-control">
                                        <option value="1">{{trans('common.yes_label')}}</option>
                                        <option value="0">{{trans('common.no_label')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success col-lg-3 col-md-3 col-sm-5">
                            <i class="fa fa-save mr-1"></i>
                            {{trans('common.save_label')}}
                        </button>
                        <button type="button" class="btn btn-danger col-lg-3 col-md-3 col-sm-5" data-dismiss="modal">
                            {{trans('common.cancel_label')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="detailsModal">{{trans('common.book_copy_details_label')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col">
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary mr-2">{{trans('common.book_title_label')}}: </div>
                                <span id="copy_title"></span>
                            </div>
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary mr-2">{{trans('common.barcode_label')}}: </div>
                                <span id="copy_barcode"></span>
                            </div>

                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary mr-2">{{trans('common.book_copy_status_label')}}: </div>
                                <span id="copy_status"></span>
                            </div>
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary mr-2">{{trans('common.author_label')}}: </div>
                                <span id="copy_author"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary mr-2">{{trans('common.book_copy_condition_label')}}: </div>
                                <span id="copy_condition"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="fix-topbar">
                                <h4 class="font-weight-bold text-dark">{{trans('common.loans_label')}}</h4>
                                <table id="loan_table" class="table border-right border-left border-bottom">
                                    <thead>
                                    <tr class="text-dark">
                                        <th>Id</th>
                                        <th>{{trans('common.member_label')}}</th>
                                        <th>{{trans('common.period_label')}}</th>
                                        <th>{{trans('common.book_copy_status_label')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3 border-top-0">
                        <button type="button" class="btn btn-secondary col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">
                            {{trans('common.close_label')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="editModalLabel">{{trans('common.books_copy_edit_label')}}</h5>
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
                                    <label for="edit_uid" class="font-weight-bold">{{trans('common.barcode_label')}} <span class="text-danger">*</span></label>
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
                                    <label for="edit_book" class="font-weight-bold">{{trans('common.book_label')}} <span class="text-danger">*</span></label>
                                    <select id="edit_book" name="book_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_condition" class="font-weight-bold">{{trans('common.book_copy_condition_label')}} <span class="text-danger">*</span></label>
                                    <select id="edit_condition" name="condition_id" class="form-control">
                                        <option value="0">{{trans('common.select_condition_label')}}</option>
                                        @foreach($data['conditions'] as $condition)
                                            <option value="{{$condition->id}}">{{$condition->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_status" class="font-weight-bold">{{trans('common.book_copy_status_label')}} <span class="text-danger">*</span></label>
                                    <select id="edit_status" name="status_id" class="form-control">
                                        <option value="0">{{trans('common.select_status_label')}}</option>
                                        @foreach($data['statuses'] as $status)
                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_for_sale" class="font-weight-bold">{{trans('common.book_copy_for_sale_label')}}<span class="text-danger">*</span></label>
                                    <select id="edit_for_sale" name="for_sale" class="form-control">
                                        <option value="1">{{trans('common.yes_label')}}</option>
                                        <option value="0">{{trans('common.no_label')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary col-lg-2 col-md-3 col-sm-5">{{trans('common.save_label')}}</button>
                        <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">
                            {{trans('common.cancel_label')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="removeModalLabel">{{trans('common.confirm_label')}}</h5>
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
                                {{trans('common.confirm_copy_delete_label')}}:<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_copy"></div> ?
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">
                            <span class="mr-1"><i class="fa fa-trash"></i></span>
                            {{trans('common.yes_label')}}
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('common.cancel_label')}}</button>
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

        const detailsModal = $('#detailsModal')

        $(document).ready(()=>{
            let conditionId = 0;
            let statusId = 0;
            const conditionFilter = $('#condition_filter');
            const statusFilter = $('#status_filter');
            const filterBtn = $('#filterBtn')
            const clearBtn = $('#clearBtn')
            const dataTable = $("#datatable").DataTable({
                language: datatableTrans,
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
                    { data: 'condition_info',name: 'condition_info'},
                    { data: 'book_status',name: 'book_status'},
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

            editForm.validate({})
            editForm.submit(function(event){
                event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url:'{!! route('books.copies.update') !!}',
                    method:'patch',
                    data:data,
                    complete: function(xhr){
                        if(xhr.status === 201){
                            const {message} = xhr.responseJSON
                            toastr.success(message,'Success');
                            dataTable.ajax.reload()
                            editModal.modal('hide')
                        }
                    }
                })
            })

            $(".modal").on("hidden.bs.modal", function() {
                clearAddForm()
                clearDetailModal()
            });
        })

        const AddBookCopy = ($event)=>{
            $event.preventDefault();
            const book = $('#add_book')
            const consumer = $('#add_condition')
            const status = $('#add_status')
            book.select2({
                theme: 'bootstrap4',
                placeholder: '{{trans('common.select_book_label')}}',
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
            const copyId = $('#edit_copy_id')
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
                        copyId.val(id)
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

        const viewDetails = ($event) =>{
            $event.preventDefault()
            const title = $('#copy_title')
            const author = $('#copy_author')
            const barcode = $('#copy_barcode')
            const status = $('#copy_status')
            const condition = $('#copy_condition')
            const datatable = $('#loan_table')
            const id = $event.target.getAttribute('data-id')

            $.ajax({
                url: '{!! route('books.copies.getById') !!}',
                method: 'post',
                data:{
                    copy_id: id,
                    _token: '{!! csrf_token() !!}'
                },
                complete: function(xhr){
                    if(xhr.status === 201){
                        const {book} = xhr.responseJSON
                        console.log(book)
                        title.html(`${book.title}`)
                        barcode.html(`${book.uid}`)
                        status.html(`${book.status}`)
                        author.html(`${book.author}`)
                        condition.html(`${book.condition}`)
                        datatable.DataTable({
                            language: datatableTrans,
                            processing: true,
                            serverSide: true,
                            autoWidth: false,
                            lengthMenu: [5,10, 15 ],
                            pageLength:5,
                            initComplete: ()=>{
                              console.log('complete dude')
                                detailsModal.modal('show')
                            },
                            ajax: {
                                url: '{!! route('books.copies.getLoanList') !!}',
                                method:'get',
                                data:{
                                    copy_id:id
                                }
                            },
                            columns: [
                                { data: 'id', name: 'id' },
                                { data: 'member', name: 'member'},
                                { data: 'loan_date',name: 'loan_date'},
                                { data: 'status', name: 'status'},
                            ]
                        });

                    }
                }
            })

        }

        const clearAddForm = ()=>{
            let barcode = $('#add_uid')
            barcode.val('')
            barcode.removeClass('is-valid')
            barcode.removeClass('is-invalid')

            let book = $('#add_book')
            book.val('')
            book.removeClass('is-valid')
            book.removeClass('is-invalid')

            let status = $('#add_status')
            status.val(0)
            status.removeClass('is-valid')
            status.removeClass('is-invalid')

            let forSale = $('#add_for_sale')
            forSale.val(1)
            forSale.removeClass('is-valid')
            forSale.removeClass('is-invalid')
        }

        const clearEditForm = () =>{

        }

        const clearDetailModal = ()=>{
            const title = $('#copy_title')
            const author = $('#copy_author')
            const barcode = $('#copy_barcode')
            const status = $('#copy_status')
            const condition = $('#copy_condition')
            const datatable = $('#loan_table')

            datatable.DataTable().clear()
            datatable.DataTable().destroy()
            title.html(``)
            barcode.html(``)
            status.html(``)
            author.html(``)
            condition.html(``)
        }

    </script>
@endsection
