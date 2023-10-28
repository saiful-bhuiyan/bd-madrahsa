@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">@lang('user.create_title')</h1>
    @component('components.beardcrumb')
    @slot('page_index')
    @lang('user.create_title')
    @endslot
    @slot('page_link')
    {{route('user.index')}}
    @endslot


    @slot('btn_class')
    btn-info
    @endslot


    @slot('btn_target')

    @endslot
    @slot('icon')
    fa fa-eye
    @endslot


    @slot('btn_name')
    @lang('common.view')
    @endslot
    @slot('btn_link')
    {{route('user.index')}}
    @endslot
    @endcomponent
</div>
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">@lang('user.create_title')</div>

                </div>
                <div class="ibox-body">
                    <form method="post" action="{{route('user.update',$data->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">


                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('user.role_id') <span class="text-danger">*</span></label>
                                <select class="form-control" name="role_id" required>
                                    <option>@lang('common.select_one') </option>
                                    @if($user_role)
                                    @foreach($user_role as $view_role)
                                    <option value="{{$view_role->id}}" @if($view_role->id == $data->role_id) selected @endif>
                                        @if($lang == 'en'){{$view_role->role_name_en}}
                                        @elseif($lang == 'bn'){{$view_role->role_name_bn}}@endif
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('user.user_name') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('user.user_name')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="name"
                                    required
                                    value="{{$data->name}}"
                                />
                                </div>
                            </div>

                        

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('user.email') <span class="text-danger">*</span></label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('user.email')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="email"
                                    required
                                    value="{{$data->email}}"
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('user.mobile') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('user.mobile')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="mobile"
                                    value="{{$data->mobile}}"
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('user.password') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('user.password')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="password"
                                    required
                                />
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="image" class="form-label">@lang('user.image') <span class="text-danger">*</span></label>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="image"
                                    aria-describedby="defaultFormControlHelp"
                                    name="image"
                                    >
                                    @php
                                    $path = public_path().'/backend/img/UserImage/'.$data->image;
                                    @endphp
                                    @if(file_exists($path))
                                    <img src="{{asset('backend/img/UserImage')}}/{{$data->image}}" width="100px" height="100px" alt="">
                                    @endif
                                
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                            <label for="defaultFormControlInput" class="form-label">@lang('user.status')</label>
                                <div class="form-check form-check">
                                    <input
                                    class="form-check-input"
                                    type="radio"
                                    name="status"
                                    id="active"
                                    value="1"
                                    checked
                                    @if($data->status == 1) checked @endif
                                    />
                                    <label class="form-check-label" for="active">@lang('common.active')</label>
                                </div>
                                <div class="form-check form-check">
                                    <input
                                    class="form-check-input"
                                    type="radio"
                                    name="status"
                                    id="inactive"
                                    value="0"
                                    @if($data->status == 0) checked @endif
                                    />
                                    <label class="form-check-label" for="inactive">@lang('common.inactive')</label>
                                </div>
                            </div>


                            <div class="col-12 mt-4 " id="inputSingleBox">
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> @lang('common.submit')</button>
                            </div>

                    </div>

                </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- END PAGE CONTENT-->
@endsection
