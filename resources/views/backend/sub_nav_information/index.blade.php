@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">@lang('sub_nav_information.index_title')</h1>
    @component('components.beardcrumb')
    @slot('page_index')
    @lang('sub_nav_information.create_title')
    @endslot
    @slot('page_link')
    {{route('sub_nav_information.create')}}
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
    {{route('sub_nav_information.create')}}
    @endslot
    @endcomponent
</div>
<div class="page-content fade-in-up">
    <div class="ibox">
        <div class="ibox-head">

            <div class="ibox-title">@lang('sub_nav_information.index_title')</div>
        </div>
        <div class="ibox-body">
            <ul class="nav nav-tabs tabs-line">
                <li class="nav-item">
                    <a class="nav-link active" href="#all" data-toggle="tab"><i class="fa fa-bars"></i> @lang('common.all')</a>
                </li>
            </ul>

            <div class="tab-content">

                {{-- all --}}
                <div class="tab-pane fade show active" id="all">

                    <table class="table table-responsive data-table" id="">
                        <thead>
                          <tr>
                            <th>@lang('common.sl')</th>
                            <th>@lang('nav_item.nav_name')</th>
                            <th>@lang('sub_nav_item.sub_nav_name')</th>
                            <th>@lang('sub_nav_information.title')</th>
                            <th>@lang('sub_nav_information.description')</th>
                            <th>@lang('common.status')</th>
                            <th>@lang('common.image')</th>
                            <th>@lang('common.action')</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

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
          ajax: "{{ route('sub_nav_information.index') }}",
          columns: [
              {data: 'sl', name: 'sl'},
              {data: 'nav_id', name: 'nav_id'},
              {data: 'sub_nav_id', name: 'sub_nav_id'},
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

    function subNavInfoStatusChange(id)
    {
        // alert(id);

        if(id > 0)
        {
            var message = @json( __('sub_nav_information.status_message') );
            var message_type = @json(__('common.success'));
            $.ajax({
                header : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },

                url : '{{ url('subNavInfoStatusChange') }}/'+id,

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
