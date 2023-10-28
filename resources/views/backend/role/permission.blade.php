@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">@lang('role.create_title')</h1>
    @component('components.beardcrumb')
    @slot('page_index')
    @lang('role.create_title')
    @endslot
    @slot('page_link')
    {{route('role.index')}}
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
    {{route('role.index')}}
    @endslot
    @endcomponent
</div>
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
        <form method="post" action="{{url('setPermission')}}">
        @csrf

        <input type="hidden" name="role_id" value="{{$role_id}}">

        <div class="ibox">
                <div class="ibox-head">
                <div class="ibox-title">
                <input type="checkbox" name="" value="" id="checkAll" >
                <label for="checkAll">@lang('common.select_all')</label>
                </div>
                </div>
            </div>

            @if($module)
            @foreach($module as $m)

            @php 
            $check = DB::table('module_has_permissions')->where('module_id',$m->id)->where('role_id',$role_id)->first();
            if($check)
            {
                $check_id = $check->module_id;
            }
            else
            {
                $check_id = NULL;
            }
            @endphp

            <div class="ibox">
                <div class="ibox-head">
                <div class="ibox-title">
                <input @if($check_id == $m->id) checked @endif class="menuCheckbox" type="checkbox" name="module[]" value="{{$m->id}}" id="moduleMenu{{$m->id}}">
                        <label for="moduleMenu{{$m->id}}">@if($lang == 'en') {{$m->menu_name_en}} @elseif($lang == 'bn') {{$m->menu_name_bn}} @endif</label>
                </div>
                </div>
            </div>


            @endforeach
            @endif

            @if($parent_menu)
            @foreach($parent_menu as $p)

            @php 
            $check = DB::table('parent_has_permissions')->where('parent_id',$p->id)->where('role_id',$role_id)->first();
            if($check)
            {
                $check_id = $check->parent_id;
            }
            else
            {
                $check_id = NULL;
            }
            @endphp

            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">
                        <input @if($check_id == $p->id) checked @endif class="menuCheckbox" type="checkbox" name="parent_menu[]" value="{{$p->id}}" id="parentMenu{{$p->id}}">
                        <label for="parentMenu{{$p->id}}">@if($lang == 'en') {{$p->menu_name_en}} @elseif($lang == 'bn') {{$p->menu_name_bn}} @endif</label>
                    </div>

                </div>
                <div class="ibox-body">
                    <div class="row">
                   @if($sub_menu)
                    @foreach($sub_menu as $s)
                        @if($s->parent_id == $p->id)

                        @php 
                            $check = DB::table('module_has_permissions')->where('module_id',$s->id)->where('role_id',$role_id)->first();

                            if($check)
                            {
                                $check_id = $check->module_id;
                            }
                            else
                            {
                                $check_id = NULL;
                            }
                        @endphp

                        <div class="col-lg-3 col-12">
                            <input @if($check_id == $s->id) checked @endif class="menuCheckbox" type="checkbox" name="module[]" value="{{$s->id}}" id="subMenu{{$s->id}}">
                            <label for="subMenu{{$s->id}}">@if($lang == 'en') {{$s->menu_name_en}} @elseif($lang == 'bn') {{$s->menu_name_bn}} @endif</label>
                        </div>
                        @endif
                    @endforeach
                   @endif
                   </div>
                        

                </div>
                </div>


                @endforeach
                @endif


                <div class="ibox-body">    
                    <button type="submit" class="btn btn-success btn-block">@lang('common.submit')</button>
                </div>
            </form>
        </div>

    </div>
</div>
<script>

    $("#checkAll").change(function(){
        if ($('#checkAll').is(':checked')) {
            $('.menuCheckbox').prop('checked',true);
        } else {
            $('.menuCheckbox').prop('checked',false);
        }       
    });

</script>
<!-- END PAGE CONTENT-->
@endsection
