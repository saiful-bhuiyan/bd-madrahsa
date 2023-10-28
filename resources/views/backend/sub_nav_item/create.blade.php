@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">@lang('sub_nav_item.create_title')</h1>
    @component('components.beardcrumb')
    @slot('page_index')
    @lang('sub_nav_item.create_title')
    @endslot
    @slot('page_link')
    {{route('sub_nav_item.index')}}
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
    {{route('sub_nav_item.index')}}
    @endslot
    @endcomponent
</div>
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">@lang('sub_nav_item.create_title')</div>

                </div>
                <div class="ibox-body">
                    <form method="post" action="{{route('sub_nav_item.store')}}">
                        @csrf
                        <div class="row">

                        <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                    <label for="defaultFormControlInput" class="form-label">@lang('nav_item.nav_name_en')</label>
                                    <select class="form-control" name="nav_id" required>
                                        <option value="0">@lang('common.select_one')</option>
                                        @if($nav)
                                        @foreach ($nav as $n)
                                        <option value="{{$n->id}}">@if($lang == 'en'){{$n->nav_name_en}}@elseif($lang=="bn"){{$n->nav_name_bn}}@endif</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('sub_nav_item.sub_nav_name_en')
                                     <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('sub_nav_item.sub_nav_name_en')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="sub_nav_name_en"
                                    required
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('sub_nav_item.sub_nav_name_bn') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('sub_nav_item.sub_nav_name_bn')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="sub_nav_name_bn"
                                    required
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('sub_nav_item.route_name') </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('sub_nav_item.route_name')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="route_name"
                                    
                                />
                                </div>
                            </div>                            

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('common.order_by') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('common.order_by')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="order_by"
                                    required
                                />
                                </div>
                            </div>

                            
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                            <label for="defaultFormControlInput" class="form-label">@lang('common.status')</label>
                                <div class="form-check form-check">
                                    <input
                                    class="form-check-input"
                                    type="radio"
                                    name="status"
                                    id="active"
                                    value="1"
                                    checked
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
