@extends('layout.admin')


@section('main_content')
    <div class="row d-flex flex-row justify-content-center">
        <div class="col-10">
            <div class="d-flex justify-content-between flex-row">
                <div class="pl-2 mb-2">
                    <h5 class="text-primary font-weight-bold">Info</h5>
                </div>
                <div class="pb-2">
                    <a class="btn btn-info py-2 font-weight-bold text-white" href="{{ route('books.edit',['book' => $data['book']['id']]) }}" style="border-radius: 10px">
                       Edit Info
                        <i class="ml-1 fas fa-edit"></i>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-body pl-4">
                    <div class="row">
                        <div class="col">
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">Book Title:</div>
                                    {{ $data['book']->title }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">Author:</div>
                                    {{ $data['book']->author }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">ISBN:</div>
                                    {{ $data['book']->isbn }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">Publication Date:</div>
                                    {{ $data['book']->publication_date }}
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">Number of pages</div>
                                    {{ $data['book']->num_pages }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">Number of copies</div>
                                    {{ $data['book']->num_copies }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">Age restricted</div>
                                    @if($data['book']->age_restricted == 1)
                                        <span>Yes</span>
                                    @else
                                        <span>No</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">Categories</div>
                                    @foreach($data['categories'] as $item)
                                        @if($loop->last)
                                            <span>{{ $item->category }}</span>
                                        @else
                                            <span>{{ $item->category }}</span>,
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <img src="{{ asset('img/action-thriller-book-cover-design-template-3675ae3e3ac7ee095fc793ab61b812cc_screen.jpg') }}"
                                     alt="book_cover" width="150" height="250" style="object-fit: cover" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 d-flex flex-row justify-content-center">
        <div class="col-10">
            <div class="d-flex justify-content-between flex-row">
                <div class="pl-2">
                    <h5 class="text-primary font-weight-bold">Copies</h5>
                </div>
                <div class="pb-2">
                    <button class="btn btn-primary py-2 font-weight-bold text-white" onclick="AddBookCopy(event)" style="border-radius: 10px">
                        Add Book Copy
                        <i class="ml-1 fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="fix-topbar">
                        <table id="datatable" class="table table-bordered table-hover display compact nowrap">
                            <thead>
                            <tr class="text-dark">
                                <th>Id</th>
                                <th>UUID</th>
                                <th>Title</th>
                                <th>Condition</th>
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

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="addModalLabel">Add Book Copy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="addForm">
                    @csrf
                    <input type="hidden" id="book_id" name="book_id" value="{{ $data['book']->id }}">
                    <div class="modal-body px-3 py-2">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_uid" class="font-weight-bold">UUID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-qrcode text-dark"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="add_uid" name="uid" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_condition" class="font-weight-bold">Condition <span class="text-danger">*</span></label>
                                    <select id="add_condition" name="condition_id" class="form-control">
                                        <option value="0">Select Condition</option>
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
                                    <label for="add_status" class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                    <select id="add_status" name="status_id" class="form-control">
                                        <option value="0">Select status</option>
                                        @foreach($data['statuses'] as $status)
                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_for_sale" class="font-weight-bold">For sale <span class="text-danger">*</span></label>
                                    <select id="add_for_sale" name="for_sale" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary col-lg-2 col-md-3 col-sm-5">Yes</button>
                        <button type="button" class="btn btn-danger col-lg-2 col-md-3 col-sm-5" data-dismiss="modal">No</button>
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
        const addModal = $('#addModal')
        const addForm = $('#addForm')
        $(document).ready(function(){

            const dataTable = $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                lengthMenu: [10, 25, 50, 75, 100 ],
                pageLength:10,
                ajax: {
                    url: '{!! route('books.copies.index') !!}',
                    data: function(d){
                        d.bookId = parseInt({{ $data['book']->id }})
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'uid', name: 'uid'},
                    { data: 'title', name: 'title'},
                    { data: 'condition',name: 'condition'},
                    { data: 'book_status',name: 'book_status'},
                    { data:'actions', name:'actions', orderable: false, searchable: false}
                ]
            });

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
        });

        const AddBookCopy = ($event)=>{
            $event.preventDefault();
            const book = $('#add_book')
            const consumer = $('#add_condition')
            const status = $('#add_status')
            book.select2({
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
            addModal.modal('show')
        }
    </script>
@endsection
