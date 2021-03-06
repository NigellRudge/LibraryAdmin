@extends('layout.admin')

@section('main_content')
    <div class="row">
        <div class="container justify-content-center col">
            <div class="row">
                <div class="col d-flex justify-content-between py-2">
                    <h4 class="font-weight-bold text-primary pl-2">{{trans('common.categories_label')}}</h4>
                    <div>
                        <button class="btn btn-primary py-2 font-weight-bold text-white" onclick="AddCategory(event)" style="border-radius: 10px">
                            {{trans('common.add_category_label')}}
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
                                <th>{{trans('common.name_label')}}</th>
                                <th>{{trans('common.code_label')}}</th>
                                <th>{{trans('common.num_books_label')}}</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">{{trans('common.confirm_label')}}</h5>
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
                                {{trans('common.confirm_delete_category')}}<br>
                                <div class="d-inline text-teal font-weight-bold" id="confirm_category"></div> ?
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">
                            <span class="mr-1"><i class="fa fa-trash"></i></span>
                            {{trans('common.yes_label')}}
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            {{trans('common.no_label')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="addModalLabel">{{trans('common.add_category_label')}}</h5>
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
                                    <label for="add_name" class="text-dark font-weight-bold">{{trans('common.name_label')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="add_name" placeholder="Science-fiction, drama etc.." name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_code" class="text-dark font-weight-bold">{{trans('common.code_label')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="add_code" placeholder="short code" name="code" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="mr-1"><i class="fa fa-save"></i></span>
                            {{trans('common.save_label')}}
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <span class="mr-1"><i class="fa fa-ban"></i></span>
                            {{trans('common.cancel_label')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="editModalLabel">{{trans('common.edit_category_label')}}</h5>
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
                                    <label for="edit_name" class="text-dark font-weight-bold">{{trans('common.name_label')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_name" placeholder="Science-fiction, drama etc.." name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_code" class="text-dark font-weight-bold">{{trans('common.code_label')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_code" placeholder="short code" name="code" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="editSubmitBtn">
                            <span class="mr-1"><i class="fa fa-save"></i></span>
                            {{trans('common.save_label')}}
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <span class="mr-1"><i class="fa fa-ban"></i></span>
                            {{trans('common.cancel_label')}}
                        </button>
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
            let categoryId = 0;
            const dataTable = $("#datatable").DataTable({
                language: datatableTrans,
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('category.index') !!}',
                    data: function(d){
                        d.categoryId = categoryId;
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name'},
                    { data: 'code',name: 'code'},
                    { data: 'num_books',name: 'num_books'},
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
                            toastr.warning(message,'{!! trans('common.success_label') !!}')
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
                            toastr.success(message,'{!! trans('common.success_label') !!}')
                            dataTable.ajax.reload()
                        }
                        if(xhr.status === 401){
                            const {message} = xhr.responseJSON
                            addModal.modal('hide')
                            toastr.error(message,'{!! trans('common.error_label') !!}')
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
                            toastr.success(message,'{!! trans('common.success_label') !!}')
                            dataTable.ajax.reload()
                        }
                        if(xhr.status === 401){
                            const {message} = xhr.responseJSON
                            editModal.modal('hide')
                            toastr.error(message,'{!! trans('common.error_label') !!}')
                        }
                    }
                })
            })
        })

        const AddCategory = ($event)=>{
            $event.preventDefault();
            addModal.modal('show')
        }

        const EditCategory = ($event)=>{
            $event.preventDefault();
            let name = $event.target.getAttribute('data-name')
            let code = $event.target.getAttribute('data-code')
            let id = $event.target.getAttribute('data-id')
            $('#edit_name').val(name)
            $('#edit_code').val(code)
            $('#category_id').val(id)
            editModal.modal('show')
        }

        const RemoveCategory = (event)=>{
            event.preventDefault()
            const categoryId = event.target.getAttribute('data-id')
            const categoryName = event.target.getAttribute('data-name')
            console.log([categoryId,categoryName])
            $('#confirm_category').html(`${categoryName}`)
            $('#remove_category_id').val(categoryId)
            removeModal.modal('show')
        }
    </script>
@endsection
