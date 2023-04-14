@extends($activeTemplate.'layouts.master')
@section('content')
<div class="text-end mb-3">
    <a href="{{ route('user.ptc.ads') }}" class="btn btn--base btn-sm">@lang('My Advertisements')</a>
</div>
<div class="card custom--card">
    <div class="card-body">
        <form role="form" method="POST" action="{{ route("user.ptc.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-12">
                    <label class="form-label">@lang('Title of the Ad')</label>
                    <input type="text" name="title" class="form-control form--control form-control form--control-lg" value="{{ old('title') }}" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="ads_type" class="form-label">@lang('Advertisement Type')</label>
                    <div class="form--select">
                        <select class="form-select" id="ads_type" name="ads_type" required>
                            <option value="1" {{ old('ads_type')==1?'selected':'' }}>@lang('Link / URL')</option>
                            <option value="2" {{ old('ads_type')==2?'selected':'' }}>@lang('Banner / Image')</option>
                            <option value="3" {{ old('ads_type')==3?'selected':'' }}>@lang('Script / Code')</option>
                            <option value="4" {{ old('ads_type')==4?'selected':'' }}>@lang('Youtube Embeded Link')</option>
                            <option value="5" {{ old('ads_type')==5?'selected':'' }}>@lang('Facebook')</option>
                        </select>
                    </div>
                    <pre class="text--danger">@lang('Price per ad') <span class="price-per-ad"></span> {{ $general->cur_text }}</pre>
                </div>
                <div class="form-group col-md-8" id="websiteLink">
                    <label class="form-label">@lang('Link')</label>
                    <input type="text" name="website_link" class="form-control form--control" value="{{ old('website_link') }}" placeholder="@lang('http://example.com')">
                </div>


                <div class="form-group col-md-8" id="Facebook">
                    <label>@lang('Link')</label>
                    <input type="text" name="website_link" class="form-control" value="{{ old('website_link') }}" placeholder="@lang('http://example.com')">
                </div>

                <div class="form-group col-md-8" id="youtube">
                    <label class="form-label">@lang('Youtube Embeded Link')</label>
                    <input type="text" name="youtube" class="form-control form--control" value="{{ old('youtube') }}" placeholder="@lang('https://www.youtube.com/embed/your_code')">
                </div>
                <div class="form-group col-md-8 d-none" id="bannerImage">
                    <label class="form-label">@lang('Banner')</label>
                    <input type="file" class="form-control form--control"  name="banner_image">
                </div>
                <div class="form-group col-md-8 d-none" id="script">
                    <label class="form-label">@lang('Script')</label>
                    <textarea  name="script" class="form-control form--control" rows="5">{{ old('script') }}</textarea>
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">@lang('Duration')</label>
                    <div class="input-group">
                        <input type="number" name="duration" class="form-control form--control" value="{{ old('duration') }}" required>
                        <div class="input-group-text">@lang('SECONDS')</div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">@lang('Maximum Show')</label>
                    <div class="input-group">
                        <input type="number" name="max_show" class="form-control form--control" value="{{ old('max_show') }}" required>
                        <div class="input-group-text">@lang('Times')</div>
                    </div>
                    <pre class="text--danger"><span class="total-price"></span> {{ $general->cur_text }} @lang('will cut from your balance')</pre>
                </div>
            </div>
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn--base btn--lg w-100">@lang('Submit')</button>
            </div>
        </form>
    </div>
</div>
@endsection


@push('script')
<script>
    (function($){
        "use strict";
        var price = 0
        $('#ads_type').change(function(){
            var adType = $(this).val();
            if (adType == 1) {
                $("#websiteLink").removeClass('d-none');
                $("#bannerImage").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").addClass('d-none');
                price = {{ @$general->ads_setting->ad_price->url }}
            } else if (adType == 2) {
                $("#bannerImage").removeClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").addClass('d-none');
                price = {{ @$general->ads_setting->ad_price->image }}
            } else if(adType == 3) {
                $("#bannerImage").addClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").removeClass('d-none');
                $("#youtube").addClass('d-none');
                price = {{ @$general->ads_setting->ad_price->script }}
            } else if(adType == 5) {
                $("#bannerImage").addClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").addClass('d-none');
                $("#Facebook").removeClass('d-none');
                price = {{ @$general->ads_setting->ad_price->Facebook }}
            } else {
                $("#bannerImage").addClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").removeClass('d-none');
                price = {{ @$general->ads_setting->ad_price->youtube ?? 0}}
            }
            $('.price-per-ad').text(price);
            $('[name=max_show]').trigger('input');
        }).change();

        $('[name=max_show]').on('input', function () {
            var maxShow = $(this).val();
            var totalPrice = price * maxShow;
            $('.total-price').text(totalPrice);
        });

    })(jQuery);
</script>
@endpush