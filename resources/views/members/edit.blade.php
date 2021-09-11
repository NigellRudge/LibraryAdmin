@extends('layout.admin')

@section('main_content')
    <div class="row d-flex flex-row justify-content-center">
        <div class="col-10 flex-column">
            <div class="d-flex">
                <h5 class="font-weight-bold">{{trans('common.edit_member_label')}}</h5>
            </div>
            <div class="card">
                <form action="{{ route('members.update',['member' => $data['member']]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="first_name">{{trans('common.first_name_label')}}</label>
                                    <input type="text" id="first_name" name="first_name" value="{{$data['member']['first_name']}}" placeholder="John etc." class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="last_name">{{trans('common.last_name_label')}}</label>
                                    <input type="text" id="last_name" placeholder="Smith etc." value="{{$data['member']['last_name']}}"  class="form-control" name="last_name">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="birth_date">{{trans('common.birth_date')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-primary">
                                                <i class="fa fa-calendar text-light"></i>
                                            </div>
                                        </div>
                                        <input type="text"  value="{{$data['member']['birth_date']}}" id="birth_date" class="form-control" name="birth_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="gender_id">{{trans('common.gender_label')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-primary">
                                                <i id="gender_icon" class="fas fa-male text-light"></i>
                                            </div>
                                        </div>
                                    <select  name="gender_id" class="form-control" id="gender_id">
                                        @foreach($data['genders'] as $gender)
                                            <option @if($gender->id == $data['member']['gender_id']) selected  @endif value="{{$gender->id}}">{{$gender->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="address">{{trans('common.address_label')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-primary">
                                                <i class="fas fa-map-marker-alt text-light"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="address"  value="{{$data['member']['address']}}" id="address" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="phone_number">{{trans('common.phone_number_label')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-primary">
                                                <i class="fa fa-phone text-light"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="phone_number"  value="{{$data['member']['phone_number']}}" id="phone_number" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="email">{{trans('common.email_label')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-primary">
                                                <span class="text-light font-weight-bold">@</span>
                                            </div>
                                        </div>
                                        <input type="text" name="email" id="email" value="{{$data['member']['email']}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-8">
                                <div class="mb-1 mt-1 text-dark font-weight-bold">{{trans('common.picture_label')}}</div>
                                <div class="form-group">
                                    <div class="custom-file mb-1">
                                        <input type="file" class="custom-file-input" value="{{ $data['member']->picture }}" id="picture" name="picture">
                                        <label class="custom-file-label" for="picture">{{ $data['member']->getPictureName() }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col py-2">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="{{ $data['member']['picture']}}"  id="preview_image" alt="Member Image" width="120" height="170" style="object-fit: cover">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-end flex-row">
                            <button type="submit" class="btn btn-success mr-2">
                                <i class="fa fa-save mr-1"></i>
                                {{trans('common.save_label')}}
                            </button>
                            <button class="btn btn-danger mr-2">
                                <i class="fa fa-ban mr-1"></i>
                                {{trans('common.cancel_label')}}
                            </button>
                        </div>
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
        $(document).ready(()=>{
        $('#birth_date').daterangepicker({
                singleDatePicker:true,
                autoUpdateInput: true,
                showDropdowns: true,
                minYear: 1901,
                drops:'auto'
            })
            $(".custom-file-input").on("change", function($event) {
                let fileName = $(this).val().split("\\").pop();
                previewImage($event)
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            $('#gender_id').on('change', function(){
                const value = $(this).val()
                const icon = $('#gender_icon')
                switch(value){
                    case '1':
                        icon.toggleClass('fas fa-female')
                        icon.toggleClass('fa fa-male')
                        break
                    case '2':
                        icon.toggleClass('fas fa-male')
                        icon.toggleClass('fa fa-female')
                        break
                }
            })


        })
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
