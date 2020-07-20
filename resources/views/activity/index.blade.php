@extends('layouts.app')

@section('custom-style')
    <link href="{{ asset('frontend/css/splash.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
@endsection

@section('header')
@include('partials.mobile.header.header-white')
@endsection

@section('web-content')
    <h1 class="text-center">Please use a mobile device</h1>
@endsection

@section('mobile-content')

<section class="mb-5 py-3">
    @foreach ($activities as $index => $activity)
    <div class="">
        <div class="container py-3 d-flex justify-content-around">
            <div class="w-25">
                <p class="m-0 py-1 f-12 bold">{{ $activity['start_date']->format('H:i A') }}</p>
                <div class="vl ml-5"></div>
                <p class="m-0 py-1 f-12 bold">{{ $activity['end_date']->format('H:i A') }}</p>
            </div>
            <div class="{{ $index % 2 == 0 ? 'route_white' : 'route_purple' }} route p-3">
                <div class="f-14 pb-2">
                    <h6 class="m-0 bold f-10">Route & Interactions</h6>
                    <a class="" data-toggle="modal" data-target="#tagModal-{{ $activity->id }}">
                        {{-- <div class="mb-0 pb-0 bold">PARK & SHOP</div> --}}
                        <div class="m-0 bold">{{ \Illuminate\Support\Str::limit($activity->from_location, 30) }}</div>
                    </a>
                </div>
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <div class="w-80">
                        <a href="" data-toggle="modal" data-target="#tagModal-{{ $activity->id }}">
                            <img class="rounded"
                            src="https://maps.googleapis.com/maps/api/staticmap?size=200x60&zoom=16&center={{ $activity->from_location }}&format=png&style=feature:road.highway%7Celement:geometry%7Cvisibility:simplified%7Ccolor:0xffffff&style=feature:transit.line%7Cvisibility:simplified%7Ccolor:dfd2ae&style=feature:road.highway%7Celement:labels.text.stroke%7Cvisibility:on%7Ccolor:db8555&style=feature:road.highway%7Celement:labels.text.fill%7Cvisibility:on%7Ccolor:806b63&key={{env('GOOGLE_API_KEY')}}"
                            alt="">
                        </a>
                    </div>
                    <div class="">
                        <a class="f-8 bold" data-toggle="modal" data-target="#tagModal-{{ $activity->id }}">
                            MAP VIEW
                        </a>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="avatar-icon">
                        @foreach ($activity->tags->take(4) as $index => $person)
                        <img src="{{ $person->avatar }}" class="activity_avatar" alt="Activity Tag">
                        @endforeach
                        @if ($activity->tags->count() > 4)
                        <a class="bold" data-toggle="modal" data-target="#tagModal-{{ $activity->id }}">
                            <span class="bold">+{{ $activity->tags->count() - 4 }}</span>
                        </a>
                        @endif
                    </div>
                    <div class="">
                        <a href="{{ route('activity.edit', 1) }}" class="add-svg">
                            <svg viewBox="0 0 469.33333 469.33333" width="15" height="15" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m437.332031 192h-160v-160c0-17.664062-14.335937-32-32-32h-21.332031c-17.664062 0-32 14.335938-32 32v160h-160c-17.664062 0-32 14.335938-32 32v21.332031c0 17.664063 14.335938 32 32 32h160v160c0 17.664063 14.335938 32 32 32h21.332031c17.664063 0 32-14.335937 32-32v-160h160c17.664063 0 32-14.335937 32-32v-21.332031c0-17.664062-14.335937-32-32-32zm0 0" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('activity.modals.activitySelection')

    @endforeach
</section>

@endsection
@section('script')
<script>
    var maps = [];
    var markers = [];

    var style = [{
            elementType: "geometry",
            stylers: [{
                color: "#242f3e"
            }]
        },
        {
            elementType: "labels.text.stroke",
            stylers: [{
                color: "#242f3e"
            }]
        },
        {
            elementType: "labels.text.fill",
            stylers: [{
                color: "#746855"
            }]
        },
        {
            featureType: "administrative.locality",
            elementType: "labels.text.fill",
            stylers: [{
                color: "#d59563"
            }]
        },
        {
            featureType: "poi",
            elementType: "labels.text.fill",
            stylers: [{
                color: "#d59563"
            }]
        },
        {
            featureType: "poi.park",
            elementType: "geometry",
            stylers: [{
                color: "#263c3f"
            }]
        },
        {
            featureType: "poi.park",
            elementType: "labels.text.fill",
            stylers: [{
                color: "#6b9a76"
            }]
        },
        {
            featureType: "road",
            elementType: "geometry",
            stylers: [{
                color: "#38414e"
            }]
        },
        {
            featureType: "road",
            elementType: "geometry.stroke",
            stylers: [{
                color: "#212a37"
            }]
        },
        {
            featureType: "road",
            elementType: "labels.text.fill",
            stylers: [{
                color: "#9ca5b3"
            }]
        },
        {
            featureType: "road.highway",
            elementType: "geometry",
            stylers: [{
                color: "#746855"
            }]
        },
        {
            featureType: "road.highway",
            elementType: "geometry.stroke",
            stylers: [{
                color: "#1f2835"
            }]
        },
        {
            featureType: "road.highway",
            elementType: "labels.text.fill",
            stylers: [{
                color: "#f3d19c"
            }]
        },
        {
            featureType: "transit",
            elementType: "geometry",
            stylers: [{
                color: "#2f3948"
            }]
        },
        {
            featureType: "transit.station",
            elementType: "labels.text.fill",
            stylers: [{
                color: "#d59563"
            }]
        },
        {
            featureType: "water",
            elementType: "geometry",
            stylers: [{
                color: "#17263c"
            }]
        },
        {
            featureType: "water",
            elementType: "labels.text.fill",
            stylers: [{
                color: "#515c6d"
            }]
        },
        {
            featureType: "water",
            elementType: "labels.text.stroke",
            stylers: [{
                color: "#17263c"
            }]
        }
    ]

    function initMap() {
        var $maps = $('.map');

        $.each($maps, function (i, value) {
            var cen = {
                lat: parseFloat($(value).attr('lat')),
                lng: parseFloat($(value).attr('lng'))
            };

            var mapDivId = $(value).attr('id');

            maps[mapDivId] = new google.maps.Map(document.getElementById(mapDivId), {
                zoom: 15,
                center: cen,
                styles: style,
            });

            markers[mapDivId] = new google.maps.Marker({
                position: cen,
                map: maps[mapDivId],
            });
        })
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&callback=initMap" async defer>
</script>

@endsection
@section('footer')
@include('partials.mobile.footer.footer')
@endsection
