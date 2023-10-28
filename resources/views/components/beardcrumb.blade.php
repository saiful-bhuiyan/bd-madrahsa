
<div class="row">

    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{url('/dashboard')}}">@lang('common.dashboard')</a>
            </li>
            <li class="breadcrumb-item"><a href="{{$page_link}}">{{$page_index}}</a></li>
        </ol>
    </div>

    <div class="col-6" style="text-align: right">

    <a class="btn {{$btn_class}} btn-sm" target="{{$btn_target}}" href="{{$btn_link}}"><i class="{{$icon}}"></i> {{$btn_name}}</a>

    </div>
</div>
