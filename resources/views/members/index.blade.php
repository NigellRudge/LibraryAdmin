@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">{{trans('common.members_label')}}</h4>
                </div>
            </div>
            <div class="card  px-1 pt-1 rounded-lg">
                <div class="card-body">
                    <div class="row pl-2 mb-3">
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-5">
                            <div class="form-group row">
                                <div class="col">
                                    <label for="gender_filter" class="col-form-label font-weight-bold">Gender</label>
                                    <select type="text" id="gender_filter" name="gender_id" class="form-control">
                                        <option value="0">{{trans('common.gender_label')}}</option>
                                        @foreach($data['genders'] as $gender)
                                            <option value="{{ $gender->id }}">
                                                {{ ucfirst($gender->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-5">
                            <div class="form-group row">
                                <div class="col">
                                    <label for="status_filter" class="col-form-label font-weight-bold">{{trans('common.book_copy_status_label')}}</label>
                                    <select type="text" id="status_filter" name="status_id" class="form-control">
                                        <option value="0">{{trans('common.all_label')}}</option>
                                        @foreach($data['statuses'] as $status)
                                            <option value="{{ $status->id }}">{{ ucfirst($status->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex flex-column justify-content-center pt-4">
                            <div class="row">
                                <button class="btn btn-primary text-light font-weight-bold mr-1" id="filterBtn">
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
                                <th>{{trans('common.name_label')}}</th>
                                <th>{{trans('common.gender_label')}}</th>
                                <th>{{trans('common.age_label')}}</th>
                                <th>{{trans('common.book_copy_status_label')}}</th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-users-cog text-primary"></i></span>
                                    {{trans('common.membership_types_label')}}
                                </th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-envelope text-primary"></i></span>
                                    {{trans('common.email_label')}}
                                </th>
                                <th>
                                    <span class="mr-1"><i class="fa fa-phone text-primary"></i></span>
                                    {{trans('common.phone_number_label')}}
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
                    <input type="hidden" name="member_id" id="remove_member_id">
                    <div class="modal-body">
                        <div class="d-flex flex-row align-baseline">
                            <div class="text-teal mr-2 ml-1" style="font-size: 3.0rem;">
                                <i class="far fa-question-circle"></i>
                            </div>
                            <div class="pt-4 text-dark">
                                {{trans('common.members_delete_confirm_label')}}:<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_member"></div> ?
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">{{trans('common.members_terminate_confirm_label')}}</button>
                        <button type="submit" class="btn btn-danger">{{trans('common.delete_label')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('common.close_label')}}</button>
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
        $(document).ready(()=>{
            let genderId = 0;
            let statusId = 0;
            const genderFilter = $('#gender_filter');
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
                    url: '{!! route('members.index') !!}',
                    data: function(d){
                        d.gender = genderId;
                        d.status = statusId
                    }
                },
                columns: [
                    // { data: 'id', name: 'id' },
                    { data: 'name', name: 'name'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age',name: 'age'},
                    { data: 'membership_status',name: 'membership_status'},
                    { data: 'member_type',name: 'member_type'},
                    { data: 'email',name: 'email'},
                    { data: 'phone_number',name: 'phone_number'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });

            genderFilter.on('change',function($event){
                console.log(this.value)
                genderId = this.value
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
                genderId = 0
                statusId = 0
                dataTable.ajax.reload()
            })
            $(".custom-file-input").on("change", function() {
                let fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            {{--addForm.validate({--}}

            {{--})--}}
            {{--addForm.submit(function($event){--}}
            {{--    $event.preventDefault()--}}
            {{--    let data = new FormData($(this)[0])--}}
            {{--    console.log(data)--}}
            {{--    $.ajax({--}}
            {{--        url: '{!! route('members.store') !!}',--}}
            {{--        headers: {--}}
            {{--            'X-CSRF-TOKEN': '{!! csrf_token() !!}'--}}
            {{--        },--}}
            {{--        method: 'post',--}}
            {{--        enctype: 'multipart/form-data',--}}
            {{--        processData: false,  // Important!--}}
            {{--        contentType: false,--}}
            {{--        data: data,--}}
            {{--        complete: (xhr)=>{--}}
            {{--            if(xhr.status === 201){--}}
            {{--                const {message} = xhr.responseJSON--}}
            {{--                toastr.success(message,'Success');--}}
            {{--                dataTable.ajax.reload()--}}
            {{--                addModal.modal('hide')--}}
            {{--            }--}}
            {{--        }--}}
            {{--    })--}}
            {{--})--}}

            removeForm.submit(function($event){
                $event.preventDefault();
                let data = $(this).serialize()
                $.ajax({
                    url: '{!! route('members.destroy') !!}',
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

        const DeleteMember = ($event)=>{
            $event.preventDefault();
            let id = $event.target.getAttribute('data-id')
            let name = $event.target.getAttribute('data-name')
            $('#confirm_member').html(`${name}`)
            $('#remove_member_id').val( parseInt(id))
            removeModal.modal('show')
        }

    </script>
@endsection
