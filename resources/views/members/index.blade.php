@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">Members</h4>
                    <div>
                        <button class="btn btn-primary rounded-pill py-2  font-weight-bold text-white" onclick="AddMember(event)">
                            Add Member
                            <i class="ml-1 fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card  px-1 pt-1 rounded-lg">
                <div class="card-body">
                    <div class="row pl-2 mb-3">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                            <div class="form-group row">
                                <label for="gender_filter" class="col-form-label font-weight-bold">Filter By Gender</label>
                                <div class="col">
                                    <select type="text" id="gender_filter" name="gender_id" class="form-control">
                                        <option value="0">All</option>
                                        @foreach($data['genders'] as $gender)
                                            <option value="{{ $gender->id }}">{{ $gender->name }}</option>
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
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Email</th>
                                <th>PhoneNumber</th>
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
                    <h5 class="modal-title" id="addModalLabel">Add Member</h5>
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
                                    <label for="add_first_name" class="text-dark font-weight-bold">First Name <span class="text-danger">*</span></label>
                                    <input type="text" id="add_first_name" name="first_name" class="form-control">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="add_last_name" class="text-dark  font-weight-bold">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" id="add_last_name" name="last_name" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_birth_date" class="text-dark  font-weight-bold">Birth Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar text-dark"></i>
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
                                    <label for="add_gender">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" id="add_gender" name="gender_id">
                                        <option value="0">Select gender</option>
                                        @foreach($data['genders'] as $gender)
                                            <option value="{{ $gender->id }}">{{$gender->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_email" class="text-dark font-weight-bold">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class="text-dark">@</span>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="name@email.com" id="add_email" name="email" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_phone_number" class="text-dark font-weight-bold">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-phone text-dark"></i>
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
                                    <label for="add_address" class="text-dark font-weight-bold">Address</label>
                                    <input type="text" id="add_address" placeholder="street A #12" name="address" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="mb-1 mt-1 text-dark font-weight-bold">Picture</div>
                                <div class="form-group">
                                    <div class="custom-file mb-1">
                                        <input type="file" class="custom-file-input" id="add_picture" name="picture">
                                        <label class="custom-file-label" for="add_picture">Choose file</label>
                                    </div>
                                </div>
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
            let genderId = 0;
            const genderFilter = $('#gender_filter');
            const filterBtn = $('#filterBtn')
            const clearBtn = $('#clearBtn')
            const dataTable = $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('members.index') !!}',
                    data: function(d){
                        d.gender = genderId;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name'},
                    { data: 'gender', name: 'gender'},
                    { data: 'age',name: 'age'},
                    { data: 'email',name: 'email'},
                    { data: 'phone_number',name: 'phone_number'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });

            genderFilter.on('change',function($event){
                console.log(this.value)
                genderId = this.value
            });
            filterBtn.on('click',function($event){
                console.log('clicked')
                dataTable.ajax.reload()
            })
            clearBtn.on('click',function($event){
                genderId = 0
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
                    url: '{!! route('members.store') !!}',
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

        const AddMember = ($event)=>{
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
        }

        const DeleteMember = ($event)=>{
            $event.preventDefault();
            let id = $event.target.getAttribute('data-id')
            let title = $event.target.getAttribute('data-title')
            $('#confirm_book').html(`${title}`)
            $('#remove_book_id').val( parseInt(id))
            removeModal.modal('show')
        }

        const EditMember = ($event)=>{
            $event.preventDefault()
        }


    </script>
@endsection
