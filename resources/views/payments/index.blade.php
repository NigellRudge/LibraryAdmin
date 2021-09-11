@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">Payments</h4>
                    <div>
                        <button class="btn btn-primary py-2 font-weight-bold text-white" onclick="AddPayment(event)" style="border-radius: 10px">
                            Add Payment
                            <i class="ml-1 fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card px-1 pt-1 rounded-lg">
                <div class="card-body">
                    <div class="fix-topbar">
                        <table id="datatable" class="table  border-right border-left border-bottom display compact nowrap">
                            <thead>
                            <tr class="text-dark">
                                <th>Id</th>
                                <th>Member</th>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Amount</th>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="addModalLabel">Make Payment</h5>
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
                                <label for="add_invoice" class="text-dark font-weight-bold">Invoice<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-file-invoice-dollar text-primary"></i>
                                        </div>
                                    </div>
                                    <select name="invoice_id" id="add_invoice" disabled class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="add_date" class="text-dark font-weight-bold">Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-calendar text-primary"></i>
                                        </div>
                                    </div>
                                    <input name="payment_date" disabled id="add_date" class="form-control" />
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
                                    <input name="amount" disabled placeholder="0.00" type="number" step="0.01" id="add_amount" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="saveBtn" disabled>Save</button>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="editForm">
                    @csrf
                    <input type="hidden" id="edit_payment_id" name="payment_id">
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
                                <label for="edit_invoice" class="text-dark font-weight-bold">Invoice<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-file-invoice-dollar text-primary"></i>
                                        </div>
                                    </div>
                                    <select name="invoice_id" id="edit_invoice"  class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="edit_date" class="text-dark font-weight-bold">Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-white">
                                            <i class="fa fa-calendar text-primary"></i>
                                        </div>
                                    </div>
                                    <input name="payment_date"  id="edit_date" class="form-control" />
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
                                    <input name="amount"  placeholder="0.00" type="number" step="0.01" id="edit_amount" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="editSaveBtn">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </form>
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
                    <input type="hidden" name="payment_id" id="remove_payment_id">
                    <div class="modal-body">
                        <div class="d-flex flex-row align-baseline">
                            <div class="text-teal mr-2 ml-1" style="font-size: 3.0rem;">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <div class="pt-4 text-dark">
                                Are you sure you want to remove this Payment:<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_payment"></div> ?
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
        const addForm = $('#addForm')
        const addModal = $('#addModal')

        const editForm = $('#editForm')
        const editModal = $('#editModal')

        const removeModal = $('#removeModal')
        const removeForm = $('#remove_form')

        const statusFilter = $('#status_filter')
        const filterBtn = $('#filterBtn')
        const clearBtn = $('#clearBtn')
        const dataTable = $('#datatable')

        $(document).ready(function(){
            let statusId = 0
            const dataTable = $("#datatable").DataTable({
                language: datatableTrans,
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('payments.index') !!}',
                    data: function(d){

                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'member', name: 'member'},
                    { data: 'invoice',name: 'invoice'},
                    { data: 'payment_date',name: 'payment_date'},
                    { data: 'amount_info',name: 'amount_info'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
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
                statusId = 0
                dataTable.ajax.reload()
            })

            addForm.submit(function (event) {
                event.preventDefault()
                const data = $(this).serialize()
                const complete = function (xhr) {
                    if(xhr.status === 200){
                        const {message} = xhr.responseJSON
                        toastr.success(message, "Succes");
                        dataTable.ajax.reload()
                        addModal.modal('hide')
                    }
                }
                makeRequest('{!! route('payments.store') !!}','post',data,complete)
            })
            removeForm.submit(function (event) {
                event.preventDefault();
                const data = $(this).serialize()
                let complete = function (xhr) {
                    if(xhr.status === 200){
                        const {message} = xhr.responseJSON
                        toastr.warning(message, 'Warning')
                        dataTable.ajax.reload()
                        removeModal.modal('hide')
                    }
                }
                makeRequest('{!! route('payments.delete') !!}', 'delete', data, complete)
            })
            editForm.submit(function (event) {
                event.preventDefault()
                const data = $(this).serialize()
                console.log(data)
            })

            $(".modal").on("hidden.bs.modal", function() {
                clearAddForm()
                clearEditForm()
            })
        });

        const AddPayment = ()=>{
            addModal.modal('show')
            const date = $('#add_date')
            const member = $('#add_member')
            const invoice = $('#add_invoice')
            const amount = $('#add_amount')
            const saveBtn = $('#saveBtn')

            member.select2({
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
            member.on('change', function(event){
                let id = $(this).val()
                invoice.attr('disabled',false)
                invoice.select2({
                    theme: 'bootstrap4',
                    ajax: {
                        url: '{!! route('invoices.list') !!}',
                        type: 'post',
                        data: function(params){
                            return {
                                _token: '{!! csrf_token() !!}',
                                name: params.term,
                                page: params.page || 1,
                                member_id: id
                            };
                        },
                        dataType: 'json',
                        cache:true,
                        delay:200,
                        placeholder: 'Search Invoice',
                        processResults: function(data,params){
                            params.page = params.page || 1;
                            //console.log(params)
                            const {total_items, results} = data;
                            console.log(results)
                            return {
                                results: results,
                                pagination: {
                                    more: (params.page * 10) < total_items
                                }
                            }
                        }
                    }
                });
            })
            invoice.on('change', function (event) {
                date.attr('disabled',false)
                date.daterangepicker({
                    singleDatePicker:true,
                    autoUpdateInput: true,
                    showDropdowns: true,
                    minYear: 1901,
                    drops:'auto'
                })
            })
            date.on('change', function (event) {
                amount.attr('disabled',false)

            })
            amount.on('change', function (event) {
                saveBtn.attr('disabled',false)
            })
        }

        const EditPayment = ($event)=>{
            const id = $event.target.getAttribute('data-id')
            let complete = (xhr)=>{
                if(xhr.status === 200){
                    const {payment} = xhr.responseJSON
                    $('#edit_payment_id').val(payment.id)
                    setupMember(payment.member_id)
                    setupInvoice(payment.invoice_id)
                    $('#edit_amount').val(payment.amount)
                    $('#edit_date').daterangepicker({
                        singleDatePicker:true,
                        showDropdowns: true,
                        minYear: 1901,
                        startDate:payment.payment_date,
                        drops:'auto'
                    })
                    editModal.modal('show')
                }
            }
            let data ={
                _token: '{!! csrf_token() !!}',
                payment_id:id
            }
            makeRequest('{!! route('payments.getById') !!}','post',data, complete)
        }

        const PaymentInfo = ($event)=>{

        }

        const DeletePayment = ($event)=>{
            const id = $event.target.getAttribute('data-id')
            const name = $event.target.getAttribute('data-name')
            $('#remove_payment_id').val(id)
            $('#confirm_payment').html(`${name}`)
            removeModal.modal('show')
        }

        const clearAddForm = ()=>{
            let member = $('#add_member')
            member.val(0)

            let invoice = $('#add_invoice')
            invoice.val(0)
            invoice.attr('disabled', true)

            let date = $('#add_date')
            date.attr('disabled',true)

            let amount = $('#add_amount')
            amount.val(null)
            amount.attr('disabled',true)

            $('#saveBtn').attr('disabled',true)
        }

        const setupMember = (memberId)=>{
            const memberInput = $('#edit_member').select2({
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
                memberInput.append(option).trigger('change')
                memberInput.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
                editModal.modal('show')
            });
        }

        const setupInvoice = (invoiceId)=>{
            const invoiceInput = $('#edit_invoice').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: '{!! route('invoices.list') !!}',
                    type: 'post',
                    data: function(params){
                        return {
                            _token: '{!! csrf_token() !!}',
                            name: params.term,
                            page: params.page || 1,
                        };
                    },
                    dataType: 'json',
                    cache:true,
                    delay:200,
                    placeholder: 'Search Invoice',
                    processResults: function(data,params){
                        params.page = params.page || 1;
                        //console.log(params)
                        const {total_items, results} = data;
                        return {
                            results: results,
                            pagination: {
                                more: (params.page * 10) < total_items
                            }
                        }
                    }
                }
            });
            $.ajax({
                type: 'POST',
                url: '{!! route('invoices.getById') !!}',
                data: {
                    _token: '{!! csrf_token() !!}',
                    invoice_id:invoiceId
                }
            }).then(function(data){
                const {invoice} = data
                let option = new Option(invoice.name,invoice.id,true, true)
                invoiceInput.append(option).trigger('change')
                invoiceInput.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
                editModal.modal('show')
            });
        }
        const clearEditForm = ()=>{
            let member = $('#edit_member')
            member.val(0)

            let invoice = $('#edit_invoice')
            invoice.val(0)
            invoice.attr('disabled', true)

            let date = $('#edit_date')
            date.attr('disabled',true)

            let amount = $('#add_amount')
            amount.val(null)
            amount.attr('disabled',true)

        }

    </script>
@endsection
