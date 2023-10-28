@extends('backend.layouts.master')
@section('body')
<!-- START PAGE CONTENT-->
<div class="page-heading">
    <h1 class="page-title">@lang('teacher_crud.create_title')</h1>
    @component('components.beardcrumb')
    @slot('page_index')
    @lang('teacher_crud.create_title')
    @endslot
    @slot('page_link')
    {{route('teacher_crud.index')}}
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
    {{route('teacher_crud.index')}}
    @endslot
    @endcomponent
</div>
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">@lang('teacher_crud.create_title')</div>

                </div>
                <div class="ibox-body">
                    <form method="post" action="{{route('teacher_crud.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                        <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('teacher_crud.headline_en') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('teacher_crud.headline_en')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="headline_en"
                                    required
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('teacher_crud.headline_bn') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('teacher_crud.headline_bn')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="headline_bn"
                                    required
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('teacher_crud.title_en') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('teacher_crud.title_en')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="title_en"
                                    required
                                />
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('teacher_crud.title_bn') <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="defaultFormControlInput"
                                    placeholder="@lang('teacher_crud.title_bn')"
                                    aria-describedby="defaultFormControlHelp"
                                    name="title_bn"
                                    required
                                />
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6 col-12" id="inputSingleBox">
                                <div class="form-outline">
                                <label for="defaultFormControlInput" class="form-label">@lang('teacher_crud.description_en') <span class="text-danger">*</span></label>
                                    <textarea class="form-control" placeholder="@lang('teacher_crud.description_en')" id="textAreaExample1" name="description_en" required>
      
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12" id="inputSingleBox">
                                <div class="form-outline">
                                <label for="defaultFormControlInput" class="form-label">@lang('teacher_crud.description_bn') <span class="text-danger">*</span></label>
                                    <textarea class="form-control" placeholder="@lang('teacher_crud.description_bn')" id="textAreaExample1" name="description_bn" required>
                                   
                                    </textarea>
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

                            <div class="col-lg-4 col-md-6 col-12" id="inputSingleBox">
                                <div>
                                <label for="defaultFormControlInput" class="form-label">@lang('common.image') <span class="text-danger">*</span></label>
                                <span class="text-danger" id="img_span"></span>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="image"
                                    aria-describedby="defaultFormControlHelp"
                                    name="image"
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
