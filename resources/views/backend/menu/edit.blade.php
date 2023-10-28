@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">@lang('menu.create_title')</h1>
    @component('components.beardcrumb')
    @slot('page_index')
    @lang('menu.create_title')
    @endslot
    @slot('page_link')
    {{route('menu.index')}}
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
    {{route('menu.index')}}
    @endslot
    @endcomponent
</div>
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">@lang('menu.create_title')</div>

                </div>
                <div class="ibox-body">
                    <form method="post" action="{{route('menu.update',$data->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                    <label for="defaultFormControlInput" class="form-label">@lang('menu.select_parent')</label>
                                    <select class="form-control" name="parent_id">
                                        <option value="0">@lang('common.select_one')</option>
                                        @if($parent)
                                        @foreach ($parent as $p)
                                        <option 
                                        value="{{$p->id}}" @if($data->parent_id == $p->id) selected @endif>
                                        @if($lang == 'en'){{$p->menu_name_en}}@elseif($lang=="bn"){{$p->menu_name_bn}}@endif</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    {{-- <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder=""
                                    aria-describedby="defaultFormControlHelp"
                                    /> --}}
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('menu.english_name') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('menu.english_name')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="menu_name_en"
                                    required
                                    value="{{$data->menu_name_en}}"
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('menu.bangla_name') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('menu.bangla_name')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="menu_name_bn"
                                    required
                                    value="{{$data->menu_name_bn}}"
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('menu.route_name') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('menu.route_name')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="route_name"
                                    value="{{$data->route_name}}"

                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('menu.icon')</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('menu.icon')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="icon"
                                    value="{{$data->icon}}"
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('menu.order_by') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('menu.order_by')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="order_by"
                                    required
                                    value="{{$data->order_by}}"
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12 mt-3" id="inputSingleBox">
                            <label for="defaultFormControlInput" class="form-label">@lang('menu.type')</label>
                                <div class="form-check form-check">
                                    <input
                                    class="form-check-input"
                                    type="radio"
                                    name="type"
                                    id="parent"
                                    value="1"
                                    @if($data->type == 1) checked @endif
                                    />
                                    <label class="form-check-label" for="parent">@lang('menu.parent')</label>
                                </div>
                                <div class="form-check form-check">
                                    <input
                                    class="form-check-input"
                                    type="radio"
                                    name="type"
                                    id="module"
                                    value="2"
                                    @if($data->type == 2) checked @endif
                                    />
                                    <label class="form-check-label" for="module">@lang('menu.module')</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                            <label for="defaultFormControlInput" class="form-label">@lang('menu.status')</label>
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
