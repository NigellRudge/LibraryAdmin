@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">Invoices</h4>
                    <div>
                        <button class="btn btn-primary py-2 font-weight-bold text-white" onclick="AddInvoice(event)" style="border-radius: 10px">
                            Add Invoice
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
                                <div class="col">
                                <label for="type_filter" class="col-form-label font-weight-bold">Invoice Type</label>
                                    <select type="text" id="type_filter" name="type_id" class="form-control">
                                        <option value="0">Select type</option>
                                            @foreach($data['types'] as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-4 col-sm-5">
                            <div class="form-group row">
                                <div class="col">
                                <label for="status_filter" class="col-form-label font-weight-bold">Status</label>
                                    <select type="text" id="status_filter" name="status_id" class="form-control">
                                        <option value="0" readonly="">Select status</option>
                                            @foreach($data['invoice_status'] as $status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex pt-3 align-items-center">
                            <button class="btn btn-primary text-light font-weight-bold mr-2" id="filterBtn">
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
                                <th>Member</th>
                                <th>Total Amount</th>
                                <th>Open Amount</th>
                                <th>Status</th>
                                <th>Invoice Date</th>
                                <th>Type</th>
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
                    <input type="hidden" name="invoice_id" id="remove_invoice_id">
                    <div class="modal-body">
                        <div class="d-flex flex-row align-baseline">
                            <div class="text-teal mr-2 ml-1" style="font-size: 3.0rem;">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <div class="pt-4 text-dark">
                                Are you sure you want to remove this Invoice:<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_invoice"></div> ?
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
                    <h5 class="modal-title" id="addModalLabel">Add Invoice</h5>
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
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-user text-primary"></i>
                                        </div>
                                    </div>
                                    <select name="member_id" id="add_member" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="add_invoice_type" class="text-dark font-weight-bold">Invoice Type<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-cog text-primary"></i>
                                        </div>
                                    </div>
                                    <select name="invoice_type" id="add_invoice_type" class="form-control">
                                        <option value="0" disabled>Select invoice type</option>
                                        @foreach($data['types'] as $type)
                                            <option value="{{ $type->id }}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="add_invoice_date" class="text-dark font-weight-bold">Invoice Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-calendar text-primary"></i>
                                        </div>
                                    </div>
                                    <input name="invoice_date" id="add_invoice_date" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="add_amount" class="text-dark font-weight-bold">Amount<span class="text-danger">*</span></label>
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content" style="position: relative">
                <div class="modal-header bg-primary text-light d-flex flex-row justify-content-between">
                    <h5 class="modal-title" id="editModalLabel">Edit Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="editForm">
                    @csrf
                    <input type="hidden" id="edit_invoice_id" name="invoice_id">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label for="edit_member" class="text-dark font-weight-bold">Member<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-user text-primary"></i>
                                        </div>
                                    </div>
                                    <select name="member_id" id="edit_member" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="edit_invoice_type" class="text-dark font-weight-bold">Invoice Type<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-cog text-primary"></i>
                                        </div>
                                    </div>
                                    <select name="invoice_type" id="edit_invoice_type" class="form-control">
                                        <option value="0" disabled>Select invoice type</option>
                                        @foreach($data['types'] as $type)
                                            <option value="{{ $type->id }}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="edit_invoice_date" class="text-dark font-weight-bold">Invoice Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-calendar text-primary"></i>
                                        </div>
                                    </div>
                                    <input name="invoice_date" id="edit_invoice_date" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="edit_amount" class="text-dark font-weight-bold">Amount<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-dollar-sign text-success"></i>
                                        </div>
                                    </div>
                                    <input name="amount" placeholder="$0.00" type="number" min="0.00" max="10000000" id="edit_amount" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="processModal" tabindex="-1" role="dialog" aria-labelledby="processModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="processModalLabel">Process Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('custom_css')
    @include('shared.totalCSS')
    <style>
        #edit_modal_loading_cover{
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #edit_loading_spinner{

        }
        .modal-backdrop, .modal-backdrop.fade.in{
            opacity: 0.1;
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

        const typeFilter = $('#type_filter')
        const statusFilter = $('#status_filter')
        const filterBtn = $('#filterBtn')
        const clearBtn = $('#clearBtn')

        $(document).ready(()=>{
            let typeId = 0;
            let statusId = 0;
            const dataTable = $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('invoices.index') !!}',
                    data: function(d){
                        d.type_id = typeId;
                        d.status_id = statusId
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'member', name: 'member'},
                    { data: 'total_amount',name: 'total_amount'},
                    { data: 'open_amount',name: 'open_amount'},
                    { data: 'status',name: 'status'},
                    { data: 'invoice_date',name: 'invoice_date'},
                    { data: 'type',name: 'type'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });
            removeForm.submit(function(event){
                event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url: '{!! route('invoices.delete') !!}',
                    method: 'delete',
                    data:data,
                    complete: function (xhr) {
                        if(xhr.status === 200){
                            const {message} = xhr.responseJSON
                            removeModal.modal('hide')
                            dataTable.ajax.reload()
                            toastr.warning(message,'Success')
                        }
                    }

                })
            })
            typeFilter.on('change',function($event){
                console.log(this.value)
                typeId = this.value
            });
            statusFilter.on('change',function($event){
                console.log(this.value)
                statusId = this.value
            });
            filterBtn.on('click',function($event){
                console.log('clicked')
                dataTable.ajax.reload()
            })
            clearBtn.on('click',function($event){
                typeId = 0
                statusId = 0
                dataTable.ajax.reload()
            })

            addForm.validate({});
            addForm.submit(function($event){
                $event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url: '{!! route('invoices.store') !!}',
                    method: 'post',
                    data:data,
                    complete: function(xhr){
                        if(xhr.status === 200){
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
                    member:{
                        required:true,
                    },
                    invoice_type:{
                        required:true,
                    },
                    invoice_date:{
                        required:true,
                        date:true,
                    },
                    amount:{
                        required:true,
                    }
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
                makeRequest('{!! route('invoices.update') !!}','patch',data,function(xhr){
                    if(xhr.status === 200){
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
                })
            })
            $(".modal").on("hidden.bs.modal", clearForms)
        })

        const AddInvoice = ($event)=>{
            $event.preventDefault();
            $('#add_invoice_date').daterangepicker({
                singleDatePicker:true,
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 1901,
                drops:'auto'
            })
            $('#add_member').select2({
                theme: 'bootstrap4',
                placeholder: "Select member",
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
            addModal.modal('show')
        }

        const EditInvoice = ($event)=>{
            $event.preventDefault();
            let id = $event.target.getAttribute('data-id')
            const member = $('#edit_member')
            const date = $('#edit_invoice_date')
            const type = $('#edit_invoice_type')
            const amount = $('#edit_amount')
            $('#edit_invoice_id').val(id)
            makeRequest('{!! route('invoices.getById') !!}', 'post',{invoice_id:id, _token:'{!! csrf_token() !!}'},function(xhr){
                if(xhr.status === 200){
                    const{invoice} = xhr.responseJSON
                    console.log(invoice)
                    type.val(invoice.invoice_type)
                    amount.val(invoice.total_amount)
                    date.val(invoice.invoice_date)
                    setupMember(invoice.member_id)
                }
            });

        }

        const DeleteInvoice = ($event)=>{
            $event.preventDefault()
            const id = $event.target.getAttribute('data-id')
            const member = $event.target.getAttribute('data-member')
            const amount = $event.target.getAttribute('data-amount')
            $('#confirm_invoice').html(`${member} - $${amount}`)
            $('#remove_invoice_id').val(id)
            removeModal.modal('show')
        }

        const SettleInvoice = ($event) => {
            $event.preventDefault()
            processModal.modal('show')
            $('#process_return_date').daterangepicker({
                singleDatePicker:true,
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 1901,
                drops:'auto'
            })
        }

        const clearForms = ()=>{
            $('#add_member').val(0)
            $('#add_invoice_type').val(0)
            $('#add_invoice_date').val('')
            $('#add_amount').val('')

            $('#edit_member').val(0)
            $('#edit_invoice_type').val(0)
            $('#edit_invoice_date').val('')
            $('#edit_amount').val('')
            $('#edit_invoice_id').val(null)
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
    </script>
@endsection
