@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">@lang('sub_academic_detail.index_title')</h1>
    @component('components.beardcrumb')
    @slot('page_index')
    @lang('sub_academic_detail.create_title')
    @endslot
    @slot('page_link')
    {{route('sub_academic_detail.create')}}
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
    {{route('sub_academic_detail.create')}}
    @endslot
    @endcomponent
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">

            <div class="ibox-title">@lang('sub_academic_detail.index_title')</div>
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
                            <th>@lang('academic_detail.title')</th>
                            <th>@lang('sub_academic_detail.item_name')</th>
                            <th>@lang('sub_academic_detail.title')</th>
                            <th>@lang('sub_academic_detail.description')</th>
                            <th>@lang('common.status')</th>
                            <th>@lang('common.image')</th>
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
                    use App\Models\sub_academic_detail;
                    $trashed = sub_academic_detail::onlyTrashed()->get();
                    $i = 1;
                    @endphp

                    <table class="table " id="example-table">
                        <thead>
                          <tr>
                            <th>@lang('common.sl')</th>
                            <th>@lang('sub_academic_detail.item_name')</th>
                            <th>@lang('sub_academic_detail.title')</th>
                            <th>@lang('sub_academic_detail.description')</th>
                            <th>@lang('common.action')</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if($trashed)
                            @foreach ($trashed as $v)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    @if($lang == 'en') {{$v->item_name_en}} @elseif($lang == 'bn') {{$v->item_name_bn}} @endif
                                </td>
                                <td>
                                    @if($lang == 'en') {{$v->title_en}} @elseif($lang == 'bn') {{$v->title_bn}} @endif
                                </td>
                                <td>
                                    @if($lang == 'en') {{$v->description_en}} @elseif($lang == 'bn') {{$v->description_bn}} @endif
                                </td>
                                <td>
                                    <a onclick="return confirmation();" class="btn btn-warning btn-sm" href="{{url('retrive_sub_academic_detail')}}/{{$v->id}}"><i class="fa fa-repeat"></i></a>
                                    <a onclick="return confirmation();" class="btn btn-danger btn-sm" href="{{url('sub_academic_detail_per_delete')}}/{{$v->id}}"><i class="fa fa-trash"></i></a>
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
          ajax: "{{ route('sub_academic_detail.index') }}",
          columns: [
              {data: 'sl', name: 'sl'},
              {data: 'academic_detail', name: 'academic_detail'},
              {data: 'item_name', name: 'item_name'},
              {data: 'title', name: 'title'},
              {data: 'description', name: 'description'},
              {data: 'status', name: 'status'},
              {data: 'image', name: 'image'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

    });
  </script>

<script>

    function subAcademicDetailStatusChange(id)
    {
        // alert(id);

        if(id > 0)
        {
            var message = @json( __('sub_academic_detail.status_message') );
            var message_type = @json(__('common.success'));
            $.ajax({
                header : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },

                url : '{{ url('subAcademicDetailStatusChange') }}/'+id,

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
