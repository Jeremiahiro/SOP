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

<section class="mb-5 py-3">

    <div class="container">
        <p class="mb-2 pb-4">
            <a href="{{ url()->previous() }}" class="text-white">
                <img src="{{ asset('/frontend/img/svg/back_blue.svg') }}" alt="go back">
            </a>
        </p>
    </div>

    <div>

        @foreach($leaders as $key => $lead)
        <div class="container">
            <img src="{{ $lead['avatar'] }}" class="avatar avatar-lg border border-primary" alt="Activity Tag">
            <h1 class="">{{ $lead['name'] }}</h1>
            <p>{{ $lead['position'] }}</p>
        </div>
     @endforeach


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

<script type="text/javascript">
    var page = 1;
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page) {
        $.ajax({
                url: '?page=' + page,
                type: "get",
                beforeSend: function () {
                    $('.load-activity').removeClass('d-none');
                }
            })
            .done(function (data) {
                if (data.html == " ") {
                    $('.load-activity').html("No more records found");
                    return;
                }
                $('.load-activity').addClass('d-none');
                $("#activity-list").append(data.activities);
                $("#tagged-list").append(data.istagged);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('server not responding...');
            });
    }

</script>

@endsection
@section('footer')
@include('partials.mobile.footer.footer')
@endsection
