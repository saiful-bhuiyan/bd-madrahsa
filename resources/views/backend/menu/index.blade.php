@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">@lang('menu.index_title')</h1>
    @component('components.beardcrumb')
    @slot('page_index')
    @lang('menu.create_title')
    @endslot
    @slot('page_link')
    {{route('menu.create')}}
    @endslot


    @slot('btn_class')
    btn-info
    @endslot


    @slot('btn_target')

    @endslot
    @slot('icon')
    fa fa-plus
    @endslot


    @slot('btn_name')
    @lang('common.create')
    @endslot
    @slot('btn_link')
    {{route('menu.create')}}
    @endslot
    @endcomponent
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">

            <div class="ibox-title">@lang('menu.index_title')</div>
        </div>
        <div class="ibox-body">
            <ul class="nav nav-tabs tabs-line">
                <li class="nav-item">
                    <a class="nav-link active" href="#all" data-toggle="tab"><i class="fa fa-bars"></i> @lang('common.all')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#deleted" data-toggle="tab"><i class="fa fa-trash"></i> @lang('common.deleted')</a>
                </li>
            </ul>

            <div class="tab-content">

                {{-- all --}}
                <div class="tab-pane fade show active" id="all">

                <table class="table table-responsive data-table" id="">
                        <thead>
                          <tr>
                            <th>@lang('common.sl')</th>
                            <th>@lang('menu.parent')</th>
                            <th>@lang('menu.menu_name')</th>
                            <th>@lang('menu.icon')</th>
                            <th>@lang('menu.route_name')</th>
                            <th>@lang('menu.order_by')</th>
                            <th>@lang('menu.status')</th>
                            <th>@lang('common.action')</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                      </table>

                </div>


                {{-- deleted --}}
                <div class="tab-pane" id="deleted">

                    @php
                    use App\Models\menu;
                    $trashed = menu::onlyTrashed()->get();
                    $i = 1;
                    @endphp

                    <table class="table " id="example-table">
                        <thead>
                          <tr>
                            <th>@lang('common.sl')</th>
                            <th>@lang('menu.parent')</th>
                            <th>@lang('menu.menu_name')</th>
                            <th>@lang('menu.icon')</th>
                            <th>@lang('menu.route_name')</th>
                            <th>@lang('menu.order_by')</th>
                            <th>@lang('common.action')</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if($trashed)
                            @foreach ($trashed as $v)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    @if($v->parent_id > 0)

                                    @php
                                    $parent = menu::where('id',$v->parent_id)->first();
                                    @endphp



                                    @if($lang == 'en') {{$parent->menu_name_en}} @elseif($lang == 'bn') {{$parent->menu_name_bn}} @endif

                                    @endif

                                </td>
                                <td>
                                    @if($lang == 'en') {{$v->menu_name_en}} @elseif($lang == 'bn') {{$v->menu_name_bn}} @endif
                                </td>
                                <td>
                                    <i class="{{$v->icon}}"></i>
                                </td>
                                <td>
                                    {{$v->route_name}}
                                </td>
                                <td>
                                    {{$v->order_by}}
                                </td>
                                <td>
                                    <a onclick="return confirmation();" class="btn btn-warning btn-sm" href="{{url('retrive_menu')}}/{{$v->id}}"><i class="fa fa-repeat"></i></a>
                                    <a onclick="return confirmation();" class="btn btn-danger btn-sm" href="{{url('menu_per_delete')}}/{{$v->id}}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                      </table>

                </div>

            </div>

        </div>
    </div>

</div>
<!-- END PAGE CONTENT-->

<script type="text/javascript">
    $(function () {

      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('menu.index') }}",
          columns: [
              {data: 'sl', name: 'sl'},
              {data: 'parent', name: 'parent'},
              {data: 'menu_name', name: 'menu_name'},
              {data: 'icon', name: 'icon'},
              {data: 'route_name', name: 'route_name'},
              {data: 'order_by', name: 'order_by'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

    });
  </script>

<script>

    function menuStatusChange(id)
    {
        // alert(id);

        if(id > 0)
        {
            var message = @json( __('menu.status_message') );
            var message_type = @json(__('common.success'));
            $.ajax({
                header : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },

                url : '{{ url('menuStatusChange') }}/'+id,

                type : 'GET',

                success : function(data)
                {
                    toastr.success(message, message_type);
                }
            });
        }
    }

  </script>



@endsection
