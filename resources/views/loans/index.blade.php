@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">Loans</h4>
                    <div>
                        <button class="btn btn-primary py-2 font-weight-bold text-white" onclick="AddLoan(event)" style="border-radius: 10px">
                            Add Loan
                            <i class="ml-1 fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card px-1 pt-1 rounded-lg">
                <div class="card-body">
                    <div class="row pl-2 mb-3">
                        <div class="col-xl-3 col-lg-4 col-4 col-sm-5">
                            <div class="form-group row">
                                <label for="status_filter" class="col-form-label font-weight-bold">Filter By status</label>
                                <div class="col">
                                    <select type="text" id="status_filter" name="status_filter_id" class="form-control">
                                        <option value="0">All</option>
                                        @foreach($data['loan_status_types'] as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
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
                        <table id="datatable" class="table table-bordered display compact nowrap">
                            <thead>
                            <tr class="text-dark">
                                <th>Id</th>
                                <th>Book</th>
                                <th>Name</th>
                                <th>Loan Date</th>
                                <th>Expected Date</th>
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

    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="remove_form">
                    @csrf
                    <input type="hidden" name="loan_id" id="remove_loan_id">
                    <div class="modal-body">
                        <div class="d-flex flex-row align-baseline">
                            <div class="text-teal mr-2 ml-1" style="font-size: 3.0rem;">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <div class="pt-4 text-dark">
                                Are you sure you want to remove this Loan:<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_loan"></div> ?
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

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="addModalLabel">Add Loan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label for="add_member" class="text-dark font-weight-bold">Member<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-user text-dark"></i>
                                        </div>
                                    </div>
                                    <select name="member_id" id="add_member" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="add_book_item_id" class="text-dark font-weight-bold">Book<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-book text-dark"></i>
                                        </div>
                                    </div>
                                <select name="book_item_id" id="add_book_item_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="add_loan_date" class="text-dark font-weight-bold">Loan Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar text-dark"></i>
                                        </div>
                                    </div>
                                    <input name="loan_date" id="add_loan_date" class="form-control" />
                                </div>
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="editModalLabel">Edit Loan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="editForm">
                    @csrf
                    <input type="hidden" id="edit_loan_id" name="loan_id">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label for="edit_member" class="text-dark font-weight-bold">Member<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-user text-dark"></i>
                                        </div>
                                    </div>
                                    <select name="member_id" id="edit_member" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="edit_book_item_id" class="text-dark font-weight-bold">Book<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-book text-dark"></i>
                                        </div>
                                    </div>
                                    <select name="book_item_id" id="edit_book_item_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="edit_loan_date" class="text-dark font-weight-bold">Loan Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar text-dark"></i>
                                        </div>
                                    </div>
                                    <input name="loan_date" id="edit_loan_date" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="editSubmitBtn">Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="processModal" tabindex="-1" role="dialog" aria-labelledby="processModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="processModalLabel">Return Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="process_form">
                    @csrf
                    <input type="hidden" name="loan_id" id="process_loan_id">
                    <input type="hidden" name="member_id" id="process_member_id">
                    <input type="hidden" name="book_item_id" id="process_book_item_id">
                    <div class="pt-2 px-3 pb-2">
                        <div class="form-row">
                            <div class="col">
                                <label for="process_member_name" class="font-weight-bold text-dark">Member</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-user text-dark"></i>
                                        </div>
                                    </div>
                                <input type="text" class="form-control" id="process_member_name" name="process_member_name" readonly></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="process_book_title" class="font-weight-bold text-dark">Book</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-book text-dark"></i>
                                        </div>
                                    </div>
                                <input type="text" id="process_book_title" name="process_book_title" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="process_loan_date" class="text-dark font-weight-bold">Loan Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar text-dark"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="process_loan_date" readonly name="loan_date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="process_return_date" class="text-dark font-weight-bold">Return Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar text-dark"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="process_return_date"  name="return_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="detailModalLabel">Loan Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row p-2">
                        <div class="col">
                            <div class="font-weight-bold">
                                <i class="fa fa-book mr-1 text-primary"></i>
                                Book
                            </div>
                            <div class="text-wrap" id="detail_title"></div>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold">
                                <i class="fa fa-user text-primary mr-1"></i>Member
                            </div>
                            <span class="" id="detail_member"></span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold">
                                <i class="fa fa-cog text-primary mr-1"></i>
                                Status
                            </div>
                            <span class="" id="detail_status"></span>
                        </div>
                    </div>
                    <div class="row p-2 mt-2">
                        <div class="col">
                            <div class="font-weight-bold">
                                <i class="fa fa-calendar mr-1"></i>
                                Loan date
                            </div>
                            <span id="detail_loan_date"></span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold">
                                <i class="fa fa-stopwatch mr-1"></i>
                                Expected Date
                            </div>
                            <span class="" id="detail_expected_date">

                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold">
                                <i class="fa fa-calendar-check mr-1"></i>
                                Return Date
                            </div>
                            <span class="" id="detail_return_date"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
        const detailsModal = $('#detailModal')

        const removeModal = $('#removeModal')
        const removeForm = $('#remove_form')

        const addModal = $('#addModal')
        const addForm = $('#addForm')

        const editModal = $('#editModal')
        const editForm = $('#editForm')

        const processModal = $('#processModal')
        const processForm = $('#process_form')

        $(document).ready(()=>{
            let categoryId = 0;
            const dataTable = $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('loans.index') !!}',
                    data: function(d){
                        d.categoryId = categoryId;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'book',name: 'book'},
                    { data: 'member', name: 'member'},
                    { data: 'loan_date',name: 'loan_date'},
                    { data: 'expected_date',name: 'expected_date'},
                    { data: 'status',name: 'status'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });
            removeForm.submit(function(event){
                event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url: '{!! route('loans.destroy') !!}',
                    method: 'delete',
                    data:data,
                    complete: function (xhr) {
                        if(xhr.status === 201){
                            const {message} = xhr.responseJSON
                            removeModal.modal('hide')
                            dataTable.ajax.reload()
                            toastr.warning(message,'Success')
                        }
                    }

                })
            })

            addForm.validate({
                rules:{
                    name:{
                        required:true,
                        minlength:4,
                    },
                    code:{
                        required:false,
                        maxlength:8,
                    },
                },
                messages:{
                    name: "please select a valid name",
                    code: "code can not be longer than 8 characters",
                },
                errorClass: 'is-invalid',
                validClass: 'is-valid',
            });
            addForm.submit(function($event){
                $event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url: '{!! route('loans.store') !!}',
                    method: 'post',
                    data:data,
                    complete: function(xhr){
                        if(xhr.status === 201){
                            const {message} = xhr.responseJSON
                            addModal.modal('hide')
                            toastr.success(message,'Success')
                            dataTable.ajax.reload()
                        }
                        if(xhr.status === 401){
                            const {message} = xhr.responseJSON
                            addModal.modal('hide')
                            toastr.error(message,'Error!')
                        }
                    }
                })
            })

            editForm.validate({
                rules:{
                    name:{
                        required:true,
                        minlength:4,
                    },
                    code:{
                        required:false,
                        maxlength:8,
                    },
                },
                messages:{
                    name: "please select a valid name",
                    code: "code can not be longer than 8 characters",
                },
                errorClass: 'is-invalid',
                validClass: 'is-valid',
            });
            editForm.submit(function (event) {
                event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url: '{!! route('loans.update') !!}',
                    method: 'patch',
                    data:data,
                    complete: function(xhr){
                        if(xhr.status === 201){
                            const {message} = xhr.responseJSON
                            editModal.modal('hide')
                            toastr.success(message,'Success')
                            dataTable.ajax.reload()
                        }
                        if(xhr.status === 401){
                            const {message} = xhr.responseJSON
                            editModal.modal('hide')
                            toastr.error(message,'Error!')
                        }
                    }
                })
            })

            processForm.validate({})
            processForm.submit(function($event){
                $event.preventDefault();
                let data = $(this).serialize()
                const complete = (xhr)=>{
                    if(xhr.status === 201){
                        const {message} = xhr.responseJSON
                        toastr.info(message,'Success')
                        processModal.modal('hide')
                        dataTable.ajax.reload()
                    }
                }
                makeRequest('{!! route('loans.resolve') !!}','post',data, complete)
            })
        })

        const AddLoan = ($event)=>{
            $event.preventDefault();
            $('#add_loan_date').daterangepicker({
                singleDatePicker:true,
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 1901,
                drops:'auto'
            })

            $('#add_member').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: '{!! route('members.list') !!}',
                    type: 'post',
                    data: function(params){
                        return {
                            _token: '{!! csrf_token() !!}',
                            name: params.term,
                            page: params.page || 1,
                            status: 7
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
            $('#add_book_item_id').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: '{!! route('books.copies.list') !!}',
                    type: 'post',
                    data: function(params){
                        return {
                            _token: '{!! csrf_token() !!}',
                            name: params.term,
                            page: params.page || 1,
                            status: 1
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
            addModal.modal('show')
        }

        const EditLoan = ($event)=>{
            $event.preventDefault();
            let id = $event.target.getAttribute('data-id')
            let data= {
                _token: '{!! csrf_token()  !!}',
                loanId: id
            }
            const complete = (xhr)=>{
                if(xhr.status === 201){
                    const {loan} = xhr.responseJSON
                    $('#edit_loan_id').val(id)
                    setupMember(loan.member_id)
                    setupBookItem(loan.book_item_id)
                    $('#edit_loan_date').daterangepicker({
                        singleDatePicker:true,
                        showDropdowns: true,
                        startDate:loan.loan_date,
                        minYear: 1901,
                        drops:'auto'
                    })
                    editModal.modal('show')
                }
            }
            makeRequest('{!! route('loans.getById') !!}', 'post', data, complete)

        }

        const loanDetails = ($event)=>{
            $event.preventDefault()
            let id = $event.target.getAttribute('data-id')
            const bookTitle = $('#detail_title')
            const member = $('#detail_member')
            const loanDate = $('#detail_loan_date')
            const returnDate = $('#detail_return_date')
            const expectedDate = $('#detail_expected_date')
            const statusEl = $('#detail_status')
            const data ={
                _token:'{!! csrf_token() !!}',
                loanId:id
            }
            const complete = (xhr)=>{
                const {status} = xhr
                if(status === 201){
                    const {loan} = xhr.responseJSON
                    console.log(loan)
                    bookTitle.html(`${loan.book}`)
                    member.html(`${loan.member}`)
                    loanDate.html(`${moment(loan.loan_date).format('MMMM Do YYYY')}`)
                    expectedDate.html(`${moment(loan.expected_date).format('MMMM Do YYYY')}`)
                    statusEl.html(`${loan.status}`)
                    if(loan.return_date !== null){
                        returnDate.html(`${moment(loan.return_date).format('MMMM Do YYYY')}`)
                    }
                    else{
                        returnDate.html('No Info')
                    }
                    detailsModal.modal('show')
                }
            }
            makeRequest('{!! route('loans.getById') !!}','post',data,complete)
        }
        const DeleteLoan = ($event)=>{
            $event.preventDefault()
            const id = $event.target.getAttribute('data-id')
            const member = $event.target.getAttribute('data-member')
            const book = $event.target.getAttribute('data-book')
            console.log([id, member, book])
            $('#confirm_loan').html(`${member} - ${book}`)
            $('#remove_loan_id').val(id)
            removeModal.modal('show')
        }

        const ResolveLoan = ($event) => {
            $event.preventDefault()
            processModal.modal('show')
            const id = $event.target.getAttribute('data-id')
            const memberId = $('#process_member_id')
            const memberName = $('#process_member_name')
            const bookItemId = $('#process_book_item_id')
            const bookTitle = $('#process_book_title')
            const loanDate = $('#process_loan_date')
            const loanId = $('#process_loan_id')

            $.ajax({
                url:'{!! route('loans.getById') !!}',
                method:'post',
                data:{
                    _token: '{!! csrf_token() !!}',
                    loanId:id
                },
                complete: (xhr)=>{
                    if(xhr.status === 201){
                        const {loan} = xhr.responseJSON
                        console.log(loan)
                        memberName.val(loan.member)
                        memberId.val(loan.member_id)
                        bookTitle.val(loan.book)
                        bookItemId.val(loan.book_item_id)
                        loanDate.val(loan.loan_date)
                        loanId.val(id)
                    }
                }

            })

            $('#process_return_date').daterangepicker({
                singleDatePicker:true,
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 1901,
                drops:'auto'
            })
        }

        const setupMember = (memberId)=>{
            const editBook = $('#edit_member').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: '{!! route('members.list') !!}',
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
                url: '{!! route('members.getById') !!}',
                data: {
                    _token: '{!! csrf_token() !!}',
                    memberId:memberId
                }
            }).then(function(data){
                const {member} = data
                let option = new Option(member.name,member.id,true, true)
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

        const setupBookItem = (bookItemId)=>{
            const editBook = $('#edit_book_item_id').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: '{!! route('books.copies.list') !!}',
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
                url: '{!! route('books.copies.getById') !!}',
                data: {
                    _token: '{!! csrf_token() !!}',
                    copy_id:bookItemId
                }
            }).then(function(data){
                const {book} = data
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
