@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">{{trans('common.members_applications_label')}}</h4>
                    <div>
                        <button class="btn btn-primary py-2 font-weight-bold text-white" onclick="AddRequest(event)" style="border-radius: 10px">
                            {{trans('common.member_add_application')}}
                            <i class="ml-1 fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card  px-1 pt-1 rounded-lg">
                <div class="card-body">
                    <div class="row pl-2 mb-3">
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5">
                            <div class="form-group">
                                <label for="status_filter" class="col-form-label font-weight-bold">{{trans('common.book_copy_status_label')}}</label>
                                <select type="text" id="status_filter" name="status_filter" class="form-control">
                                    <option value="0">{{trans('common.all_label')}}</option>
                                    @foreach($data['statuses'] as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5">
                            <div class="form-group">
                                <label for="type_filter" class="col-form-label font-weight-bold">{{trans('common.membership_types_label')}}</label>
                                <select type="text" id="type_filter" name="type_filter" class="form-control">
                                    <option value="0">{{trans('common.all_label')}}</option>
                                    @foreach($data['membership_types'] as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col d-flex pt-3 align-items-center">
                            <button class="btn btn-primary text-light font-weight-bold mr-2" id="filterBtn">
                                {{trans('common.filter_label')}}
                                <i class="fas fa-filter ml-1"></i>
                            </button>
                            <button class="btn btn-danger text-light font-weight-bold" id="clearBtn">
                                {{trans('common.clear_label')}}
                                <i class="fas fa-ban ml-1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="fix-topbar">
                        <table id="datatable" class="table order-column  border-right border-left border-bottom table-hover display compact nowrap">
                            <thead>
                            <tr class="text-dark">
                                <th>Id</th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-user text-primary"></i></span>
                                    {{trans('common.member_label')}}
                                </th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-users-cog text-primary"></i></span>
                                    {{trans('common.membership_types_label')}}
                                </th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-calendar text-primary"></i></span>
                                    {{trans('common.request_date_label')}}
                                </th>
                                <th>{{trans('common.book_copy_status_label')}}</th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-calendar-check text-primary"></i></span>
                                    {{trans('common.process_date_label')}}
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

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="addModalLabel">{{trans('common.member_add_application')}}</h5>
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
                                    <label for="add_request_date" class="text-dark font-weight-bold">{{trans('common.request_date_label')}}<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-white">
                                                <i class="fa fa-calendar text-primary"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="add_request_date" name="request_date" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="add_membership_type_id" class="text-dark  font-weight-bold">{{trans('common.membership_types_label')}}<span class="text-danger">*</span></label>
                                    <select type="text" id="add_membership_type_id" name="membership_type_id" class="form-control">
                                        <option value="0">{{trans('common.select_mem_type_label')}}</option>
                                        @foreach($data['membership_types'] as $type)
                                            <option value="{{ $type->id }}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_first_name" class="text-dark font-weight-bold">{{trans('common.first_name_label')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="add_first_name" placeholder="John" name="first_name" class="form-control">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="add_last_name" class="text-dark  font-weight-bold">{{trans('common.last_name_label')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="add_last_name" placeholder="Smith" name="last_name" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_birth_date" class="text-dark  font-weight-bold">{{trans('common.birth_date')}} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-white">
                                                <i class="fa fa-calendar text-primary"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="add_birth_date" name="birth_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="add_gender" class="font-weight-bold text-dark">{{trans('gender')}} <span class="text-danger">*</span></label>
                                    <select class="form-control" id="add_gender" name="gender_id">
                                        <option value="0">{{trans('common.select_gender_label')}}</option>
                                        @foreach($data['genders'] as $gender)
                                            <option value="{{ $gender->id }}">{{$gender->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_email" class="text-dark font-weight-bold">{{trans('common.auth_email_label')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-white">
                                                <span class="font-weight-bold text-primary">@</span>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="name@email.com" id="add_email" name="email" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_phone_number" class="text-dark font-weight-bold">{{trans('common.phone_number_label')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-white">
                                                <i class="fa fa-phone text-primary"></i>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="(+597) 0000000" id="add_phone_number" name="phone_number" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_address" class="text-dark font-weight-bold">{{trans('common.address_label')}}</label>
                                    <input type="text" id="add_address" placeholder="street A #12" name="address" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-8">
                                <div class="mb-1 mt-1 text-dark font-weight-bold">{{trans('common.picture_label')}}</div>
                                <div class="form-group">
                                    <div class="custom-file mb-1">
                                        <input type="file" class="custom-file-input" id="add_picture" name="picture">
                                        <label class="custom-file-label" for="add_picture">{{trans('common.choose_file_label')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col py-2">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('storage/placeholder-male.jpg') }}"  id="preview_image" alt="Member Image" width="70" height="120" style="object-fit: cover">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success col-lg-2 col-md-3 col-sm-5">
                                <i class="fa fa-save mr-1"></i>
                                {{trans('common.save_label')}}
                            </button>
                            <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">
                                {{trans('common.cancel_label')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="editModalLabel">{{trans('common.member_edit_application')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="editForm" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="edit_request_id" name="request_id">
                    <div class="modal-body px-3 py-2">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_request_date" class="text-dark font-weight-bold">{{trans('common.request_date_label')}}<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar text-dark"></i>
                                            </div>
                                        </div>
                                    <input type="text" id="edit_request_date" name="request_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_membership_type_id" class="text-dark  font-weight-bold">{{trans('common.membership_types_label')}}<span class="text-danger">*</span></label>
                                    <select type="text" id="edit_membership_type_id" name="membership_type_id" class="form-control">
                                        <option value="0">{{trans('common.select_mem_type_label')}}</option>
                                        @foreach($data['membership_types'] as $type)
                                            <option value="{{ $type->id }}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="edit_member" class="text-dark font-weight-bold">{{trans('common.member_label')}}<span class="text-danger">*</span></label>
                                <input type="text" id="edit_member" name="member" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success col-lg-3 col-md-3 col-sm-5">
                                <span class="mr-1"><i class="fa fa-save"></i></span>
                                {{trans('common.update_label')}}
                            </button>
                            <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">
                                {{trans('common.cancel_label')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="detailModalLabel">{{trans('common.application_info_labels')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <div class="p-4">
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-center flex-row">
                            <img src="{{ asset('storage/placeholder-male.jpg') }}" id="d_image" class="rounded-lg" style="object-fit: cover" height="200" width="160"  alt="image"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary">{{trans('common.name_label')}}:</div>
                                <span class="" id="d_name">Deyon Rudge</span>
                            </div>
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary">{{trans('common.gender_label')}}:</div>
                                <span class="" id="d_gender">male</span>
                            </div>
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary">
                                    <span class="mr-1"><i class="fa fa-calendar text-primary"></i></span>
                                    {{trans('common.birth_date')}}:
                                </div>
                                <span class="" id="d_birth_date">Jan 1st 2000</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary">
                                    <span class="mr-1"><i class="fa fa-envelope text-primary"></i></span>
                                    {{trans('common.email_label')}}:
                                </div>
                                <span class="" id="d_email">deyon@gmail.com</span>
                            </div>
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary">
                                    <span class="mr-1"><i class="fa fa-phone text-primary"></i></span>
                                    {{trans('common.phone_number_label')}}:
                                </div>
                                <span class="" id="d_phone_number">(+597) 998833</span>
                            </div>
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary">
                                    <span class="mr-1"><i class="fa fa-location-arrow text-primary"></i></span>
                                    {{trans('common.address_label')}}:
                                </div>
                                <span class="" id="d_address">Street name #19</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary">{{trans('common.request_date_label')}}:</div>
                                <span class="" id="d_requested_on">Jan 1st 2021</span>
                            </div>
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary">{{trans('common.membership_types_label')}}:</div>
                                <span class="" id="d_package">Single package</span>
                            </div>
                            <div class="mb-2">
                                <div class="font-weight-bold text-secondary">{{trans('common.book_copy_status_label')}}:</div>
                                <span class="" id="d_status">pending</span>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <input type="hidden" name="request_id" id="remove_request_id">
                    <div class="modal-body">
                        <div class="d-flex flex-row">
                            <div class="text-teal mr-3 ml-1" style="font-size: 3.0rem;">
                                <i class="far fa-question-circle text-primary"></i>
                            </div>
                            <div class="pt-2 text-dark">
                                {{trans('common.application_delete_confirm_label')}}:<br>
                                <div class="d-inline text-dark text-capitalize font-weight-bold" id="confirm_request"></div> ?
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">
                            <span class="mr-1"><i class="fa fa-trash"></i></span>
                            {{trans('common.delete_label')}}
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('common.cancel_label')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="processModal" tabindex="-1" role="dialog" aria-labelledby="processModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="processModalLabel">{{trans('common.application_process_label')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="process_form">
                    @csrf
                    <input type="hidden" name="request_id" id="process_request_id">
                    <div class="pt-2 px-3 pb-2">
                        <div class="form-row">
                            <div class="col">
                                <label for="process_name" class="font-weight-bold text-dark">{{trans('common.name_label')}}</label>
                                <input type="text" class="form-control" id="process_name" readonly></div>
                            <div class="col">
                                <label for="process_request_date" class="font-weight-bold text-dark">{{trans('common.request_date_label')}}</label>
                                <input type="text" id="process_request_date" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col">
                                <label for="process_result_id" class="text-dark font-weight-bold">{{trans('common.result_label')}} <span class="text-danger">*</span></label>
                                <select id="process_result_id" name="result_id" class="form-control">
                                    <option value="0">{{trans('common.result_select_label')}}</option>
                                    @foreach($data['actions'] as $action)
                                        <option value="{{ $action->id }}">{{$action->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="process_date" class="text-dark font-weight-bold">{{trans('common.process_date_label')}}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar text-dark"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="process_date" name="process_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="mr-1"><i class="fa fa-save"></i></span>
                            {{trans('common.save_label')}}
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('common.close_label')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom_css')
    @include('shared.totalCSS')
    <style>
        .order-column{

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

        const processModal = $('#processModal')
        const processForm = $('#process_form')

        const detailModal = $('#detailModal')

        $(document).ready(()=>{
            let statusId = 0;
            let typeId = 0;
            const statusFilter = $('#status_filter');
            const typeFilter = $('#type_filter');
            const filterBtn = $('#filterBtn')
            const clearBtn = $('#clearBtn')
            const dataTable = $("#datatable").DataTable({
                language: datatableTrans,
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('requests.index') !!}',
                    data: function(d){
                        d.status = statusId;
                        d.type = typeId;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'member', name: 'member'},
                    { data: 'membership_type',name: 'membership_type'},
                    { data: 'request_date', name: 'request_date'},
                    { data: 'status_info',name: 'status_info'},
                    { data: 'processed_date',name: 'processed_date'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });

            statusFilter.on('change',function($event){
                console.log(this.value)
                statusId = this.value
            });
            typeFilter.on('change',function($event){
                console.log(this.value)
                typeId = this.value
            });
            filterBtn.on('click',function($event){
                console.log('clicked')
                dataTable.ajax.reload()
            })
            clearBtn.on('click',function($event){
                statusId = 0
                typeId = 0
                typeFilter.val(0)
                statusFilter.val(0)
                dataTable.ajax.reload()
            })
            $(".custom-file-input").on("change", function($event) {
                let fileName = $(this).val().split("\\").pop();
                previewImage($event)
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            addForm.validate({

            })
            addForm.submit(function($event){
                $event.preventDefault()
                let data = new FormData(this)
                console.log(data)
                $.ajax({
                    url: '{!! route('requests.store') !!}',
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

            editForm.validate({

            })
            editForm.submit(function($event){
                $event.preventDefault()
                let data = new FormData(this)
                console.log(data)
                $.ajax({
                    url: '{!! route('requests.update') !!}',
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
                            editModal.modal('hide')
                        }
                    }
                })
            })
            removeForm.submit(function($event){
                $event.preventDefault();
                let data = $(this).serialize()
                $.ajax({
                    url: '{!! route('requests.destroy') !!}',
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

            processForm.validate({

            })
            processForm.submit(function($event){
                $event.preventDefault()
                let data = $(this).serialize()
                console.log(data)
                $.ajax({
                    url: '{!! route('requests.process') !!}',
                    method: 'post',
                    data:data,
                    complete:(xhr)=>{
                        if(xhr.status === 201){
                            let {message} = xhr.responseJSON
                            dataTable.ajax.reload()
                            processModal.modal('hide')
                            toastr.success(message,'Success')
                        }
                    }
                })
            })
        })

        const AddRequest = ($event)=>{
            $event.preventDefault();
            console.log('click')
            addModal.modal('show')

            $('#add_birth_date').daterangepicker({
                singleDatePicker:true,
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 1901,
                drops:'auto'
            })
            $('#add_request_date').daterangepicker({
                singleDatePicker:true,
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 1901,
                drops:'auto'
            })
        }

        const DeleteRequest = ($event)=>{
            $event.preventDefault();
            let id = $event.target.getAttribute('data-id')
            let name = $event.target.getAttribute('data-member')
            let date = $event.target.getAttribute('data-date')
            $('#confirm_request').html(`(${date}) ${name}`)
            $('#remove_request_id').val( parseInt(id))
            removeModal.modal('show')
        }

        const EditRequest = ($event)=>{
            $event.preventDefault()
            const id = $event.target.getAttribute('data-id')

            $.ajax({
                url:'{!! route('requests.getById') !!}',
                method:'post',
                data:{
                    _token: '{!! csrf_token() !!}',
                    requestId: id
                },
                complete: (xhr)=>{
                    if(xhr.status === 201){
                        const {request} =  xhr.responseJSON
                        $('#edit_member').val(request.member)
                        $('#edit_request_id').val(request.id)
                        $('#edit_membership_type_id').val(request.membership_type_id)
                        editModal.modal('show')
                        $('#edit_request_date').daterangepicker({
                            singleDatePicker:true,
                            autoUpdateInput: true,
                            showDropdowns: true,
                            minYear: 1901,
                            startDate: request.request_date,
                            drops:'auto'
                        })

                        console.log(request)
                    }
                }
            })
        }

        const ProcessRequest = ($event)=>{
            $event.preventDefault()
            processModal.modal('show')
            let id = $event.target.getAttribute('data-id')
            let member = $event.target.getAttribute('data-member')
            let requestDate = $event.target.getAttribute('data-date')
            console.log([member,requestDate])
            $('#process_name').val(member)
            $('#process_request_date').val(requestDate)
            $('#process_request_id').val(id)
            $('#process_date').daterangepicker({
                singleDatePicker:true,
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 1901,
                drops:'auto'
            })

        }

        const openDetails = ($event)=>{
            $event.preventDefault()
            const id = $event.target.getAttribute('data-id')
            // const
            $.ajax({
                url:'{!! route('requests.getById') !!}',
                method:'post',
                data:{
                    _token: '{!! csrf_token() !!}',
                    requestId: id
                },
                complete: (xhr)=>{
                    if(xhr.status === 201){
                        const {request} =  xhr.responseJSON
                        console.log(request)
                        let statusElement = $('#d_status')
                        $('#d_name').html(`${request.member}`)
                        statusElement.html(`${request.status}`)
                        $('#d_package').html(`${request.membership_type}`)
                        $('#d_requested_on').html(`${request.request_date}`)
                        $('#d_birth_date').html(`${request.birth_date}`)
                        $('#d_email').html(`${request.email}`)
                        $('#d_address').html(`${request.address}`)
                        $('#d_phone_number').html(`${request.phone_number}`)
                        if(request.member_picture !== null){
                            $('#d_image').attr('src',request.member_picture)
                        }
                        statusElement.css({'font-size': '0.9rem','padding':'3px 8px  3px 8px','border-radius': '8px','font-weight': 600})
                        statusElement.addClass('text-light')
                        switch(request.status_id){
                            case 3:
                                statusElement.addClass('bg-secondary')
                                break;
                            case 4:
                                statusElement.addClass('bg-success')
                                break
                            case 5:
                                statusElement.addClass('bg-warning')
                                break
                        }
                        detailModal.modal('show')
                    }
                }
            })

        }

        const previewImage = (event)=>{
            console.log('hello')
            console.log(event.target.files[0])
            let reader = new FileReader()
            reader.onload = function(){
                //console.log(reader.result)
                const image = $('#preview_image')
                image.attr('src',reader.result)
                image.removeClass('d-none')
            }
            reader.readAsDataURL(event.target.files[0])
        }

    </script>
@endsection
