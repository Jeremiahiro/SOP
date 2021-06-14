@extends('layouts.app')

@section('custom-style')
<link href="{{ asset('frontend/css/splash.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<script src="{{ asset('frontend/jquery/activityValidation.js') }}"></script>
<script src="{{ asset('frontend/jquery/activityDatePicker.js') }}"></script>

<script src="{{ asset('frontend/jquery/formTagging.js') }}"></script>
<script src="{{ asset('frontend/jquery/google-location-autocomplete.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places&callback=initialize"
    type="text/javascript" async defer></script>

<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/amsify.suggestags.css') }}">
<script type="text/javascript" src="{{ asset('frontend/jquery/jquery.amsify.suggestags.js') }}">
</script>
@endsection

@section('web-content')
<script type="text/javascript">
    window.location = "{{ route('map.view') }}"; //here double curly bracket

</script>
@endsection

@section('content')

<section class="mb-5 p-3 mt-3 bg-white splash rounded">

    <div class="container">
       <!-- <p class="blue-text fw-14">Filter</p><!-->
    </div>

    <div class="container blue-text">
        <form method="POST" action="{{ route('activitysearch.store') }}" id="activitysearch" name="activitysearch"
            autocomplete="off" enctype="multipart/form-data">
            @csrf

            <div class="form-group row py-1 mb-0">
                <div class="">
                    <label for="location_1" class="f-18 col-md-12 text-md-left">
                        {{ __('Location') }}
                    </label>
                </div>
                <div class="col-lg-12">
                    <input id="address_1" type="search"
                        class="blue-input input rounded-0 @error('from_address') is-invalid @enderror"
                        name="from_address" value="{{ old('from_address') }}" required autocomplete="off"
                        placeholder="Location">
                    <input type="hidden" name="from_location" class="" id="location_1"
                        value="{{ old('from_location') }}">
                    <input type="hidden" name="from_latitude" class="" id="latitude_1"
                        value="{{ old('from_latitude') }}">
                    <input type="hidden" name="from_longitude" class="" id="longitude_1"
                        value="{{ old('from_longitude') }}">
                    @error('from_location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span class="invalid-feedback" id="fromAlert" role="alert">
                        <strong class="text-danger regular">
                            Selected location not available on Google Map</strong>
                    </span>
                </div>
            </div>

            <hr>

            <div class="form-group row py-1 mb-0">
                <div class="col-lg-12">
                    <div class="range-wrap">
                        <div class="d-flex">
                            <label for="location_1" class="f-18 px-0 mb-0 col-md-12 text-md-left">
                                {{ __('Maximum Distance') }}
                            </label>
                            <output name="distance" class="bubble"></output>
                        </div>
                        <input type="range" name="distance" class="range" min="10" max="1000">
                        
                    </div>
                </div>
            </div>

            <hr>

            <div class="row form-group">
                <label for="when" class="f-18 col-md-12 text-md-left">
                    {{ __('Causes') }}
                </label>
                <div class="flex-row d-flex activitysearchdate justify-content-center w-100">
                    <div class="col-md-12">
                        <div class="input-group date input-daterange">
                            <select class="f-14 regular input blue-input input1 rounded-0" data-live-search="true" name="causes" id="causes" required="">
                                <option value="Violence">Violence</option>
                                <option value="Election Violence">Election Violence</option>
                                <option value="Street Violence">Street Violence</option>
                                <option value="Violence on women">Violence on women</option>
                                <option value="Social Injustice">Social Injustice</option>
                                <option value="Health">Health</option>
                                <option value="Gender Equality">Gender Equality</option>
                                <option value="" selected="">Select Cause</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="form-group row py-1">
                <div class="">
                    <label for="location_1" class="f-18 col-md-12 text-md-left">
                        {{ __('Date') }}
                    </label>
                </div>
                <div class="col-lg-12 activitysearchdate">
                    <div class="input-group date input-daterange">
                        <input type="text"
                            class="f-14 regular blue-text input blue-input input1 rounded-0"
                            name="start_date" placeholder="Start Date/Time" id="startDate"
                            value="{{ date('d-m-Y H:i', strtotime('+1 hour')) }}" readonly>
                        <input type="text" class="f-14 regular input blue-input ml-1 input2 rounded-0"
                            name="end_date" placeholder="End Date/Time" id="endDate"
                            value="{{ date('d-m-Y H:i', strtotime('+2 hour +20 minutes')) }}" readonly>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="form-group pull-right">
                    <button type="submit" class="btn f-14 rounded blue-btn px-3 text-white">Search</button>
                </div>
            </div>
        </form>

    </div>
 
</section>



@endsection
@section('script')
<script type="text/javascript">
    const allRanges = document.querySelectorAll(".range-wrap");
    allRanges.forEach(wrap => {
        const range = wrap.querySelector(".range");
        const bubble = wrap.querySelector(".bubble");

        range.addEventListener("input", () => {
            setBubble(range, bubble);
        });
        setBubble(range, bubble);
    });

    function setBubble(range, bubble) {
        const val = range.value;
        const min = range.min ? range.min : 0;
        const max = range.max ? range.max : 1000;
        const newVal = Number(((val - min) * 1000) / (max - min));
        bubble.innerHTML = val;

        // Sorta magic numbers based on size of the native UI thumb
        bubble.style.left = `calc(${newVal}% + (${8 - newVal * 0.15}px))`;
    }

</script>

@endsection
@section('footer')
@include('partials.mobile.footer.footer')
@endsection
