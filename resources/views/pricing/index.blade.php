@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">{{trans('common.pricings_label')}}</h4>
                    <div>
                        <button class="btn btn-primary py-2 font-weight-bold text-white" onclick="Add(event)" style="border-radius: 10px">
                            {{trans('common.add_price_label')}}
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
                                <th>{{trans('common.name_label')}}</th>
                                <th>{{trans('common.pricing_type_label')}}</th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-user-cog text-primary"></i></span>
                                    {{trans('common.membership_type_label')}}
                                </th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-dollar-sign text-success"></i></span>
                                    {{trans('common.amount_label')}}
                                </th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-dollar-sign text-danger"></i></span>
                                    {{trans('common.amount_per_day_label')}}
                                </th>
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
                    <input type="hidden" name="category_id" id="remove_category_id">
                    <div class="modal-body">
                        <div class="d-flex flex-row align-baseline">
                            <div class="text-teal mr-2 ml-1" style="font-size: 3.0rem;">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <div class="pt-4 text-dark">
                                Are you sure you want to remove this Category:<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_category"></div> ?
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
                    <h5 class="modal-title" id="addModalLabel">Add Pricing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_name" class="text-dark font-weight-bold">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="add_name" name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_amount" class="text-dark font-weight-bold">Amount <span class="text-danger">*</span></label>
                                    <input type="number" id="add_amount" placeholder="$0.00" name="amount" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_amount_per_day" class="text-dark font-weight-bold">Late fee <span class="text-danger">*</span></label>
                                    <input type="number" id="add_amount_per_day" placeholder="$2.50" name="amount_per_day" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_pricing_type" class="text-dark font-weight-bold">Pricing Type <span class="text-danger">*</span></label>
                                    <select id="add_pricing_type" name="pricing_type_id" class="form-control">
                                        <option value="0">Select pricing</option>
                                        @foreach($data['pricing_types'] as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_membership_type" class="text-dark font-weight-bold">Membership Type <span class="text-danger">*</span></label>
                                    <select id="add_membership_type" name="membership_type_id" class="form-control">
                                        <option value="0">Select type</option>
                                        @foreach($data['membership_types'] as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save mr-1"></i>
                            Yes
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="editForm">
                    @csrf
                    <input type="hidden" id="category_id" name="category_id">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_name" class="text-dark font-weight-bold">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_name" placeholder="Science-fiction, drama etc.." name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_code" class="text-dark font-weight-bold">Code <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_code" placeholder="short code" name="code" class="form-control">
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
            const dataTable = $("#datatable").DataTable({
                language: datatableTrans,
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('pricing.index') !!}',
                    data: function(d){

                    }
                },
                columns: [
                    { data: 'name', name: 'name'},
                    { data: 'pricing_type',name: 'pricing_type'},
                    { data: 'membership_type',name: 'membership_type'},
                    { data: 'amount_info',name: 'amount_info'},
                    { data: 'per_day_info',name: 'per_day_info'},
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
            addForm.submit(function (event) {
                event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url: '{!! route('category.store') !!}',
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
                    url: '{!! route('category.update') !!}',
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
        })

        const Add = ($event)=>{
            $event.preventDefault();
            addModal.modal('show')
        }

        const Edit = ($event)=>{
            $event.preventDefault();
            let id = $event.target.getAttribute('data-id')
        }

        const Remove = (event)=>{
            event.preventDefault()
            const id = event.target.getAttribute('data-id')
            removeModal.modal('show')
        }
    </script>
@endsection
