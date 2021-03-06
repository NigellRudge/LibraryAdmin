@extends('layout.admin')

@section('main_content')
    <div class="row d-flex justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex flex-row justify-content-between bg-white">
                    <div class="">
                        <h4>{{trans('common.member_info_label')}}</h4>
                    </div>
                    <a class="btn btn-info" href="{{ route('members.edit',['member' => $data['member']]) }}">
                        {{trans('common.edit_info_label')}}
                    </a>
                </div>
                <div class="card-body">
                    <div class="row px-2 py-1">
                        <div class="col">
                            <div class="mb-2">
                                <div class="text-dark font-weight-bold">{{trans('common.name_label')}}</div>
                                <span class="text-secondary">{{ $data['member']['first_name'] . ' ' .$data['member']['last_name'] }}</span>
                            </div>
                            <div class="mb-2">
                                <div class="text-dark font-weight-bold">
                                    <i class="fa fa-calendar text-primary mr-1"></i>
                                    {{trans('common.birth_date')}}
                                </div>
                                <span class="text-secondary">{{ $data['member']['birth_date'] }}</span>
                            </div>
                            <div class="mb-2">
                                <div class="text-dark font-weight-bold">
                                    @if($data['member']['gender_id'] == 1)
                                        <i id="gender_icon" class="fas fa-male text-primary mr-1"></i>
                                    @else
                                        <i id="gender_icon" class="fas fa-female text-primary mr-1  "></i>
                                    @endif
                                    Gender
                                </div>
                                <span class="text-secondary">{{ $data['member']->gender()}}</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <div class="text-dark font-weight-bold">
                                    <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                    {{trans('common.address_label')}}
                                </div>
                                <span class="text-secondary">{{ $data['member']['address'] }}</span>
                            </div>
                            <div class="mb-2">
                                <div class="text-dark font-weight-bold">
                                    <i class="fa fa-phone text-primary mr-1"></i>
                                    {{trans('common.phone_number_label')}}
                                </div>
                                <span class="text-secondary">{{ $data['member']['phone_number'] }}</span>
                            </div>
                            <div class="mb-2">
                                <div class="text-dark font-weight-bold">
                                    <i class="fas fa-envelope text-primary mr-1"></i>
                                    {{trans('common.email_label')}}
                                </div>
                                <span class="text-secondary">{{ $data['member']['email']}}</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <div class="text-dark font-weight-bold">{{trans('common.book_copy_status_label')}}</div>
                                @switch($data['member']['status_id'])
                                    @case(8)
                                        <span class="text-light bg-warning rounded-lg px-1 text-sm">
                                            {{ $data['member']->status() }}
                                         </span>
                                        @break
                                    @case(7)
                                        <span class="text-light  bg-success rounded-lg  px-1 text-sm">
                                            {{ $data['member']->status() }}
                                         </span>
                                        @break
                                    @default
                                    <span class="text-secondary">
                                    {{ $data['member']->status() }}
                                </span>
                                @endswitch
                            </div>
                        </div>
                        <div class="col">
                            <img src="{{ $data['member']->picture }}" alt="" height="200" width="140" style="object-fit: cover" class="rounded-lg" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2 mb-4 d-flex flex-row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header bg-white border-bottom-0">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active font-weight-bold" id="loans-tab" data-toggle="tab" href="#loans" role="tab" aria-controls="home" aria-selected="true">{{trans('common.loans_label')}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link font-weight-bold" id="invoices-tab" data-toggle="tab" href="#invoices" role="tab" aria-controls="profile" aria-selected="false">{{trans('common.invoices_label')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="loans" role="tabpanel" aria-labelledby="loans-tab">
                            <div class="row pb-2">
                                <div class="col d-flex justify-content-end">
                                    <button onclick="addLoan(event)" class="btn btn-primary font-weight-bold text-light ">
                                        {{trans('common.add_loan_label')}}
                                        <i class="fa fa-plus ml-1"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <table id="loanDatatable" class="table border-right border-left border-bottom display compact nowrap">
                                        <thead>
                                        <tr>
                                            <th>{{trans('common.book_title_label')}}</th>
                                            <th>{{trans('common.loan_date_label')}}</th>
                                            <th>{{trans('common.book_copy_status_label')}}</th>
                                            <th>{{trans('common.loan_return_date_label')}}</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                            <div class="row pb-2">
                                <div class="col">
                                    <div class="d-flex justify-content-end">
                                        <button onclick="AddInvoice(event)" class="btn btn-primary font-weight-bold text-light">
                                            {{trans('common.add_invoice_label')}}
                                            <i class="fa fa-plus ml-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <table id="invoice_dataTable" class="table border-right border-left border-bottom display compact nowrap">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>{{trans('common.invoice_total_amount_label')}}</th>
                                            <th>{{trans('common.invoice_open_amount_label')}}</th>
                                            <th>{{trans('common.book_copy_status_label')}}</th>
                                            <th>{{trans('common.invoice_date_label')}}</th>
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="exampleModalLabel">{{trans('common.confirm_label')}}</h5>
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
                                {{trans('common.confirm_loan_delete_label')}}:<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_loan"></div> ?
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="mr-1"><i class="fa fa-trash"></i></span>
                            {{trans('common.delete_label')}}
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('common.cancel_label')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loanModal" tabindex="-1" role="dialog" aria-labelledby="loanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="loanModalLabel">Add Loan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="addLoanForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label for="add_member" class="text-dark font-weight-bold">Member<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-primary">
                                            <i class="fa fa-user text-light "></i>
                                        </div>
                                    </div>
                                    <select name="member_id" id="add_member" class="form-control" readonly="">
                                        <option selected value="{{ $data['member']['id'] }}">{{ $data['member']->name() }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="add_book_item_id" class="text-dark font-weight-bold">Book<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-primary">
                                            <i class="fa fa-book text-light"></i>
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
                                        <div class="input-group-text bg-primary">
                                            <i class="fa fa-calendar text-light"></i>
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

    <div class="modal fade" id="addInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="addInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="addInvoiceModalLabel">{{trans('common.add_invoice_label')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="addForm">
                    @csrf
                    <input type="hidden" name="member_id" value="{{$data['member']['id']}}">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label for="name" class="text-dark font-weight-bold">{{trans('common.member_label')}}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-user text-primary"></i>
                                        </div>
                                    </div>
                                    <input name="name" id="name" value="{{$data['member']['first_name'] . $data['member']['last_name']}}" class="form-control bg-white" readonly />
                                </div>
                            </div>
                            <div class="col">
                                <label for="add_invoice_type" class="text-dark font-weight-bold">{{trans('common.type_label')}}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-cog text-primary"></i>
                                        </div>
                                    </div>
                                    <select name="invoice_type" id="add_invoice_type" class="form-control">
                                        <option value="0" disabled>{{trans('common.select_invoice_type_label')}}</option>
                                        @foreach($data['invoice_types'] as $type)
                                            <option value="{{ $type->id }}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="add_invoice_date" class="text-dark font-weight-bold">{{trans('common.invoice_date_label')}}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-calendar text-primary"></i>
                                        </div>
                                    </div>
                                    <input name="invoice_date" id="add_invoice_date" class="form-control" />
                                </div>
                            </div>
                            <div class="col">
                                <label for="add_amount" class="text-dark font-weight-bold">{{trans('common.invoice_amount_label')}}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-dollar-sign text-success"></i>
                                        </div>
                                    </div>
                                    <input name="amount" placeholder="$0.00" type="number" min="0.01" max="10000000" step="0.5" id="add_amount" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="add_description" class="text-dark font-weight-bold">{{trans('common.invoice_description_label')}}<span class="text-danger">*</span></label>
                                <textarea name="description" placeholder="{{trans('common.invoice_description_placeholder_label')}}"  id="add_description" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">{{trans('common.save_label')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('common.cancel_label')}}</button>
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
        const addLoanModal = $('#loanModal')
        const addLoanForm = $('#addLoanForm')
        const removeLoanForm = $('#removeLoanForm')


        const addInvoiceModal = $('#addInvoiceModal')
        const addInvoiceForm = $('#addInvoiceForm')
        const loanDataTable = $('#loanDatatable')

        const invoiceDataTable = $('#invoice_dataTable')

        $(document).ready(()=>{
            const memberId = {!! $data['member']['id'] !!}
            console.log(memberId)

            invoiceDataTable.DataTable({
                language: datatableTrans,
                processing: true,
                serverSide: true,
                lengthMenu: [5, 10, 15],
                pageLength:5,
                autoWidth: false,
                ajax: {
                    url: '{!! route('members.getMemberInvoices',['member' => $data['member']]) !!}',
                    data: function(d){
                        d.memberId = memberId
                    }
                },
                columns: [
                    // { data: 'id', name: 'id' },
                    { data: 'book', name: 'book'},
                    { data: 'loan_date', name: 'loan_date'},
                    { data: 'status',name: 'status'},
                    { data: 'return_date',name: 'return_date'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });

            loanDataTable.DataTable({
                language: datatableTrans,
                processing: true,
                serverSide: true,
                lengthMenu: [5, 10, 15],
                pageLength:5,
                autoWidth: false,
                ajax: {
                    url: '{!! route('members.getMemberLoans',['member' => $data['member']]) !!}',
                    data: function(d){
                        d.memberId = memberId
                    }
                },
                columns: [
                    // { data: 'id', name: 'id' },
                    { data: 'book', name: 'book'},
                    { data: 'loan_date', name: 'loan_date'},
                    { data: 'status',name: 'status'},
                    { data: 'return_date',name: 'return_date'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });
            removeForm.submit(function(event){
                event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url: '{!! route('category.delete') !!}',
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

            addLoanForm.validate({
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
            addLoanForm.submit(function($event){
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
                            addLoanModal.modal('hide')
                            toastr.success(message,'Success')
                            loanDataTable.ajax.reload()
                        }
                        if(xhr.status === 401){
                            const {message} = xhr.responseJSON
                            addLoanModal.modal('hide')
                            toastr.error(message,'Error!')
                        }
                    }
                })
            })
        })

    const addLoan = ($event) =>{
        addLoanModal.modal('show')
        $('#add_loan_date').daterangepicker({
            singleDatePicker:true,
            autoUpdateInput: true,
            showDropdowns: true,
            minYear: 1901,
            drops:'auto'
        })
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
    }

    const DeleteLoan = ($event)=>{
        $event.preventDefault()
        const id = $event.target.getAttribute('data-id')
        const member = $event.target.getAttribute('data-member')
        const book= $event.target.getAttribute('data-book')
        console.log([id, member, book])
        $('#confirm_loan').html(`${member} - ${book}`)
        $('#remove_loan_id').val(id)
        removeModal.modal('show')
    }

    const AddInvoice = ($event) =>{
        $event.preventDefault();
        $('#add_invoice_date').daterangepicker({
            singleDatePicker:true,
            autoUpdateInput: true,
            showDropdowns: true,
            minYear: 1901,
            drops:'auto'
        })
        addInvoiceModal.modal('show')
    }
    </script>
@endsection
