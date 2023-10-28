@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
<h1 class="page-title">@lang('sub_nav_information.create_title')</h1>
@component('components.beardcrumb')
    @slot('page_index')
    @lang('sub_nav_information.create_title')
    @endslot
    @slot('page_link')
    {{route('sub_nav_information.index')}}
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
    {{route('sub_nav_information.index')}}
    @endslot
    @endcomponent

    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">@lang('sub_nav_information.create_title')</div>

                    </div>
                    <div class="ibox-body">
                        <form method="post" action="{{url('sub_nav_information')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                    <div>
                                        <label for="defaultFormControlInput" class="form-label">@lang('nav_item.nav_name')</label>
                                        <select class="form-control" id="nav_id" name="nav_id" onchange="return loadSubNavItem();">
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
                                        <label for="defaultFormControlInput" class="form-label">@lang('sub_nav_item.sub_nav_name')</label>
                                        <select class="form-control" id="sub_nav_id" name="sub_nav_id">
                                            <option value="0">@lang('common.select_one')</option>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                    <div>
                                        <label for="defaultFormControlInput" class="form-label">@lang('sub_nav_information.title_en') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="defaultFormControlInput" placeholder="@lang('sub_nav_information.title_en')" aria-describedby="defaultFormControlHelp" name="title_en" required />
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                    <div>
                                        <label for="defaultFormControlInput" class="form-label">@lang('sub_nav_information.title_bn') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="defaultFormControlInput" placeholder="@lang('sub_nav_information.title_bn')" aria-describedby="defaultFormControlHelp" name="title_bn" required />
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12" id="inputSingleBox">
                                    <div class="form-outline">
                                        <label for="defaultFormControlInput" class="form-label">@lang('sub_nav_information.description_en') <span class="text-danger">*</span></label>
                                        <textarea class="form-control" placeholder="@lang('sub_nav_information.description_en')" id="textAreaExample1" name="description_en">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12" id="inputSingleBox">
                                    <div class="form-outline">
                                        <label for="defaultFormControlInput" class="form-label">@lang('sub_nav_information.description_bn') <span class="text-danger">*</span></label>
                                        <textarea class="form-control" placeholder="@lang('sub_nav_information.description_bn')" id="textAreaExample1" name="description_bn">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                    <div>
                                        <label for="defaultFormControlInput" class="form-label">@lang('common.image') <span class="text-danger">*</span></label>
                                        <span class="text-danger" id="img_span"></span>
                                        <input type="file" class="form-control" id="image" aria-describedby="defaultFormControlHelp" name="image" required />
                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-6 col-12 mt-3">
                                    <label for="defaultFormControlInput" class="form-label">@lang('common.status')</label>
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" name="status" id="active" value="1" checked />
                                        <label class="form-check-label" for="active">@lang('common.active')</label>
                                    </div>
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" name="status" id="inactive" value="0" />
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

    <script>
        $(document).ready(function() {
            FileUpload();
        })

        function FileUpload() {
            let input = document.getElementById("image");
            input.addEventListener('change', () => {
                let files = input.files;

                if (files.length > 0) {
                    if (files[0].size > 2 * 1024 * 1024) {
                        $('#img_span').text('File Size Exceeds 2MB');
                        $('#image').val(null);
                        return;
                    }
                }
                $('#img_span').text('');
            });
        }

        function loadSubNavItem()
        {
            var nav_id = $('#nav_id').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },

                url : '{{url('loadSubNavItem')}}/'+nav_id,
                type: 'GET',
                data: {
                    nav_id
                },
                success: function(data)
                {
                    $('#sub_nav_id').html(data);
                    // alert(data)
                }
            });
        }
    </script>
    <!-- END PAGE CONTENT-->
    @endsection