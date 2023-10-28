@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">@lang('notice_board.create_title')</h1>
    @component('components.beardcrumb')
    @slot('page_index')
    @lang('notice_board.create_title')
    @endslot
    @slot('page_link')
    {{route('notice_board.index')}}
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
    {{route('notice_board.index')}}
    @endslot
    @endcomponent
</div>
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">@lang('notice_board.create_title')</div>

                </div>
                <div class="ibox-body">
                    <form method="post" action="{{route('notice_board.update',$data->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="row">

                        <div class="col-lg-6 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('notice_board.title_en') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('notice_board.title_en')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="title_en"
                                    required
                                    value="{{$data->title_en}}"
                                />
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('notice_board.title_bn') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('notice_board.title_bn')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="title_bn"
                                    required
                                    value="{{$data->title_bn}}"
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('common.pdf_file') <span class="text-danger">*</span></label>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="pdf_file"
                                    aria-describedby="defaultFormControlHelp"
                                    name="pdf_file"
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

<script>

$(document).ready(function(){
    FileUpload();
})

function FileUpload()
{
    let input = document.getElementById("image");
    input.addEventListener('change', () => {
    let files = input.files;
    
    if(files.length > 0) {
        if(files[0].size > 2 * 1024 * 1024){
            $('#img_span').text('File Size Exceeds 2MB');
            $('#image').val(null);
            return;
        }
    }
    $('#img_span').text('');
    });
}

</script>
<!-- END PAGE CONTENT-->
@endsection
