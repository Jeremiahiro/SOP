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



            @if ($endss->count())
            @foreach ($endss as $activity)
            @if ($activity->start_date != null)
            <div class="py-2 px-0">
                <div class="container d-flex justify-content-around align-items-center">
                    <div class="w-25">
                        <p class="m-0 py-1 f-12 bold">
                            {{ $activity['start_date']->format('H:i A') }}
                        </p>
    
                        @foreach($activity->locs->take(1) as $person)
                        <div class="vl mr-4"></div>
                        <p class="m-0 py-2 f-12 bold">
                            {{ Carbon\Carbon::parse($person->start_date)->format('H:i A') }}
                        </p>
                        @endforeach
                    </div>
                    <div class="{{ auth()->user()->id == $activity->user_id ? 'route_white' : 'route_purple' }} route p-3">
                        <div class="f-14 pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 bold f-10">Route & Interactions</h6>
                                <div>
                                    @if (auth()->user()->id == $activity->user_id)
                                    <a href="" class="sub-menu" data-toggle="modal"
                                        data-target="#activityMenu-{{ $activity->id }}">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    @else
                                    <img src="{{ $activity->owner->avatar }}" class="sub-menu avatar avatar-xs"
                                        alt="Activity Tag">
                                    @endif
                                </div>
                            </div>
                            <a class="" data-toggle="modal" data-target="#tagModal-{{ $activity->id }}">
                                <div id="panel1" class="mb-0 pb-0 bold text-uppercase">
                                    {{ \Illuminate\Support\Str::limit($activity->from_location, 25) }}</div>
                                <div class="f-12 m-0 regular">
                                    {{ \Illuminate\Support\Str::limit($activity->from_address, 40) }}
                                </div>
                            </a>
                        </div>
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <div class="w-100">
                                @if ($activity->from_image != null)
                                <a href="" data-toggle="modal" data-target="#activitySelectionModal-{{ $activity->id }}">
                                    <img id="sharelink"
                                        style="width: 100%; height:100px; overflow:hidden; object-fit: cover;"
                                        src="{{ $activity->from_image }}" alt="">
                                </a>
                                @endif
                            </div>
                        </div>
    
                        <div class="pb-2">
                            <a href="{{"getlead/".$activity['id']}}" class="add_svg">
                                <i class="fa fa-map-marker mr-2"></i>
                            </a>
                            <a href="" data-toggle="modal" data-target="#shareMenu-{{ $activity->id }}">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            </a>
                        </div>
    
    
                        <div class="d-flex justify-content-between">
                            <div class="">
                                @if($activity->tags->count())
                                @foreach($activity->tags->take(4) as $index => $person)
                                <img src="{{ $person->avatar }}" class="avatar avatar-xs" alt="Activity Tag">
                                @endforeach
                                @if($activity->tags->count() > 4)
                                <a class="regular" data-toggle="modal"
                                    data-target="#activitySelectionModal-{{ $activity->id }}">
                                    <span class="regular">+{{ $activity->tags->count() - 4 }}</span>
                                </a>
                                @endif
                                @endif
                            </div>
                            <div class="">
                                @if (auth()->user()->id == $activity->user_id)
                                <a href="{{ route('activity.edit', $activity->id) }}" class="add_svg">
                                    <img class="icon_blue" src="{{ asset('frontend/img/svg/plus_blue.svg' ) }}"
                                        alt="Edit Activity">
                                    <img class="icon_white" src="{{ asset('frontend/img/svg/plus_white.svg' ) }}"
                                        alt="Edit Activity">
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
    
                @if (auth()->user()->id == $activity->user_id)
                @include('partials.modals.activity.activityMenu')
                @include('partials.modals.activity.shareMenu')
                @include('partials.modals.activity.deleteActivity')
                @include('partials.modals.activity.archiveActivity')
                @endif
                @include('partials.modals.activity.activitySelection')
            </div>
            @else
            <div>
                <h4 class="text-black">There is no result for this search</h4>
            </div>
            @endif
            @endforeach
            @endif


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
