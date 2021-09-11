@extends('layout.admin')


@section('main_content')
    <div class="row d-flex flex-row justify-content-center">
        <div class="col-10">
            <div class="d-flex justify-content-between flex-row">
                <div class="pl-2 mb-2">
                    <h5 class="text-primary font-weight-bold">{{trans('common.book_info_label')}}</h5>
                </div>
                <div class="pb-2">
                    <a class="btn btn-primary py-2 font-weight-bold text-white" href="{{ route('books.edit',['book' => $data['book']['id']]) }}" style="border-radius: 10px">
                        {{trans('common.edit_info_label')}}
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
                                    <div class="font-weight-bold text-dark">{{trans('common.book_title_label')}}</div>
                                    {{ $data['book']->title }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">
                                        <span class="mr-1"><i class="fa fa-user text-primary"></i></span>
                                        {{trans('common.author_label')}}
                                    </div>
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
                                    <div class="font-weight-bold text-dark">{{trans('common.books_pub_date_label')}}:</div>
                                    {{ $data['book']->publication_date }}
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">{{trans('common.books_number_page_label')}}</div>
                                    {{ $data['book']->num_pages }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">{{trans('common.book_copies_label')}}</div>
                                    {{ $data['book']->num_copies }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">{{trans('common.books_age_restricted_label')}}</div>
                                    @if($data['book']->age_restricted == 1)
                                        <span>{{trans('common.yes_label')}}</span>
                                    @else
                                        <span>{{trans('common.no_label')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="font-weight-bold text-dark">{{trans('common.categories_label')}}</div>
                                    @foreach($data['categories'] as $item)
                                        <span class="text-sm rounded-pill text-light" style="font-size: 0.85rem;font-weight: 600;padding: 3px;background-color: var(--info) ">{{ $item->category }}</span>
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
                    <h5 class="text-primary font-weight-bold">{{trans('common.book_copies_label')}}</h5>
                </div>
                <div class="pb-2">
                    <button class="btn btn-primary py-2 font-weight-bold text-white" onclick="AddBookCopy(event)" style="border-radius: 10px">
                        {{trans('common.books_add_copy_label')}}
                        <i class="ml-1 fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="fix-topbar">
                        <table id="datatable" class="table border-bottom border-left border-right display compact nowrap">
                            <thead>
                            <tr class="text-dark">
                                <th>Id</th>
                                <th>{{trans('common.barcode_label')}}</th>
                                <th>{{trans('common.book_copy_condition_label')}}</th>
                                <th>{{trans('common.book_copy_status_label')}}</th>
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
                    <h5 class="modal-title" id="addModalLabel">{{trans('common.books_add_copy_label')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
                <form method="post" action="#" id="addForm">
                    @csrf
                    <input type="hidden" id="book_id" name="book_id" value="{{ $data['book']->id }}">
                    <input type="hidden" id="add_status" name="status_id" value="1">
                    <div class="modal-body px-3 py-2">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="add_uid" class="font-weight-bold">{{trans('common.barcode_label')}} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-white">
                                                <i class="fas fa-qrcode text-primary"></i>
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
                                    <label for="add_condition" class="font-weight-bold">{{trans('common.book_copy_condition_label')}} <span class="text-danger">*</span></label>
                                    <select id="add_condition" name="condition_id" class="form-control">
                                        <option value="0">{{trans('common.select_condition_label')}}</option>
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
                                    <label for="add_for_sale" class="font-weight-bold">{{trans('common.book_copy_for_sale_label')}}<span class="text-danger">*</span></label>
                                    <select id="add_for_sale" name="for_sale" class="form-control">
                                        <option value="1">{{trans('common.yes_label')}}</option>
                                        <option value="0">{{trans('common.no_label')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-out col-lg-3 col-md-2 col-sm-5">
                            <span class="mr-1"><i class="fa fa-save"></i></span>
                            {{trans('common.save_label')}}
                        </button>
                        <button type="button" class="btn btn-secondary col-lg-3 col-md-2 col-sm-5" data-dismiss="modal">
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
        const addModal = $('#addModal')
        const addForm = $('#addForm')
        $(document).ready(function(){

            const dataTable = $("#datatable").DataTable({
                language: datatableTrans,
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
                    { data: 'condition_info',name: 'condition_info'},
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
                            toastr.success(message,'{!! trans('common.success_label') !!}');
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
