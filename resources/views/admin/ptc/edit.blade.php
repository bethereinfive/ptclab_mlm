@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form role="form" method="POST" action="{{ route("admin.ptc.update",$ptc->id) }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="IfrOr" value="{{ $ptc->IfrOr }}">

                    <div class="row">
                       <div class="form-group col-md-8">
                        <label>@lang('Title of the Ad')</label>
                        <input type="text" name="title" class="form-control" value="{{ $ptc->title }}" placeholder="@lang('Title')" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>@lang('Amount')</label>
                        <div class="input-group">
                            <input type="number" step="any" name="amount" class="form-control" value="{{ getAmount($ptc->amount) }}" placeholder="@lang('User will get ...')" required>
                            <div class="input-group-text"> {{ $general->cur_text }} </div>
                        </div>
                    </div>


                    <div class="form-group col-md-4">
                        <label>@lang('Duration')</label>
                        <div class="input-group">
                            <input type="number" name="duration" class="form-control" value="{{ $ptc->duration }}" placeholder="@lang('Duration')" required>
                            <div class="input-group-text">@lang('SECONDS')</div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>@lang('Maximum Show')</label>
                        <div class="input-group">
                            <input type="number" name="max_show" class="form-control" value="{{ $ptc->max_show }}" placeholder="@lang('Maximum Show') " required>
                            <div class="input-group-text">@lang('Times')</div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>@lang('Status')</label>
                        <select class="form-control" name="status" @disabled($ptc->status == 3) required>
                            <option value="">@lang('Select One')</option>
                            <option value="1">@lang('Active / Approve')</option>
                            <option value="2">@lang('Pending / Under Review')</option>
                            <option value="0">@lang('Inactive')</option>
                            <option value="3">@lang('Reject')</option>
                        </select>
                        @if($ptc->status == 3) <input type="hidden" name="status" value="3"> @endif
                    </div>
                </div>


                <div class="row pt-5 mt-5 border-top">
                    <div class="form-group col-md-4">
                        <label for="ads_type">@lang('Advertisement Type')</label>
                        <input type="hidden" name="ads_type" value="{{$ptc->ads_type}}">
                        <div class="pt-3">
                            @php echo $ptc->typeBadge @endphp
                        </div>
                    </div>

                    @if($ptc->IfrOr=='iframe')



                    @if($ptc->ads_type == 1)

                    <div class="form-group col-md-8">
                        <label>@lang('Link') <span class="text-danger">*</span></label>
                        <input type="text" name="website_link" class="form-control" value="{{ $ptc->ads_body }}" placeholder="@lang('http://example.com')">
                    </div>
                    @elseif($ptc->ads_type == 2)

                    <div class="form-group col-md-4 ">
                        <label>@lang('Banner')</label>
                        <input type="file" class="form-control"  name="banner_image">
                    </div>

                       <div class="form-group col-md-4 ">

                        <label>@lang('Current Banner') <span class="text-danger">*</span></label>
                        <img src="{{ getImage(getFilePath('ptc').'/'.$ptc->ads_body) }}" class="w-100">

                    </div>

                    @elseif($ptc->ads_type == 3)

                    <div class="form-group col-md-8">
                        <label>@lang('Script') <span class="text-danger">*</span></label>
                        <textarea  name="script" class="form-control">{{ $ptc->ads_body }}</textarea>
                    </div>

                    @else
                        <div class="form-group col-md-8">
                            <label>@lang('Youtube Embaded Link') <span class="text-danger">*</span></label>
                            <input type="text" name="youtube" class="form-control" value="{{ $ptc->ads_body }}">
                        </div>
                    @endif


                    @else
                    <div class="form-group col-md-12">
                        <label>@lang('Description') <span class="text-danger">*</span></label>
                        <textarea class="tinymce-editor" name="ads_body">{{ $ptc->ads_body }}</textarea>

                    </div>

                    @php
                       $filesSupports = json_decode($ptc->filesSupports);
                    @endphp

                    <div class="form-group col-md-12">
                        <label class="form-label">@lang('Prove Files')</label>
                        <select class="select2-multi-select form-control" name="filesSupports[]" multiple>
                            <option @if(is_array($filesSupports))  @if(in_array('jpg', $filesSupports)) selected @endif @endif value="jpg">JPG</option>
                            <option @if(is_array($filesSupports))  @if(in_array('jpeg', $filesSupports)) selected @endif @endif value="jpeg">JPEG</option>
                            <option @if(is_array($filesSupports))  @if(in_array('png', $filesSupports)) selected @endif @endif value="png">PNG</option>
                            <option @if(is_array($filesSupports))  @if(in_array('mp4', $filesSupports)) selected @endif @endif value="mp4">MP4</option>
                            <option @if(is_array($filesSupports))  @if(in_array('pdf', $filesSupports)) selected @endif @endif value="pdf">PDF</option>
                            <option @if(is_array($filesSupports))  @if(in_array('doc', $filesSupports)) selected @endif @endif value="doc">DOC</option>
                            <option @if(is_array($filesSupports))  @if(in_array('docx', $filesSupports)) selected @endif @endif value="docx">DOCX</option>
                            <option @if(is_array($filesSupports))  @if(in_array('txt', $filesSupports)) selected @endif @endif value="txt">TXT</option>
                            <option @if(is_array($filesSupports))  @if(in_array('xlx', $filesSupports)) selected @endif @endif value="xlx">XLX</option>
                            <option @if(is_array($filesSupports))  @if(in_array('xlsx', $filesSupports)) selected @endif @endif value="xlsx">XLSX</option>
                            <option @if(is_array($filesSupports))  @if(in_array('csv', $filesSupports)) selected @endif @endif value="csv">CSV</option>
                        </select>

                    </div>



                    @endif



                </div>
                <div class="form-group col-md-12 mt-3">
                    <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('breadcrumb-plugins')
<a href="{{ route('admin.ptc.index') }}" class="btn btn-outline--primary btn-sm"><i class="las la-undo"></i> @lang('Back') </a>
@endpush


@push('script')
<script src="https://cdn.tiny.cloud/1/nhnny39zzu3w0euy077ojdf9gk1n3mjpkobk25i228rt3qkz/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    (function($){
        "use strict";
        $('#ads_type').change(function(){
            var adType = $(this).val();
            if (adType == 1) {
                $("#websiteLink").removeClass('d-none');
                $("#bannerImage").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").addClass('d-none');
            } else if (adType == 2) {
                $("#bannerImage").removeClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").addClass('d-none');
            } else if(adType == 3) {
                $("#bannerImage").addClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").removeClass('d-none');
                $("#youtube").addClass('d-none');
            } else {
                $("#bannerImage").addClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").removeClass('d-none');
            }
        }).change();

        $('[name=status]').val('{{ $ptc->status }}');
    })(jQuery);




        tinymce.init({
            selector: 'textarea.tinymce-editor',
            height: 300,
            menubar: false,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });







</script>
@endpush
