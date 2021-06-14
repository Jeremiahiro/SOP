
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
                    <a class="" data-toggle="modal" data-target="#tagModal-{{ $activity->id }}">
                        <div id="panel1" class="mb-0 pb-0 bold text-uppercase">
                            {{ \Illuminate\Support\Str::limit($activity->from_location, 25) }}</div>
                        <div class="f-12 m-0 regular">
                            {{ \Illuminate\Support\Str::limit($activity->from_address, 40) }}
                        </div>
                    </a>
                    <div>
                        @if (auth()->user()->id == $activity->user_id)
                        <a href="" class="sub-menu" data-toggle="modal" data-target="#activityMenu-{{ $activity->id }}">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        @else
                        <img src="{{ $activity->owner->avatar }}" class="sub-menu avatar avatar-xs" alt="Activity Tag">
                        @endif
                    </div>
                </div>
            </div>
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <div class="w-100">
                    @if ($activity->from_image != null)
                    <a href="" data-toggle="modal" data-target="#activitySelectionModal-{{ $activity->id }}">
                        <img id="sharelink" style="width: 100%; height:100px; overflow:hidden; object-fit: cover;" src="{{ $activity->from_image }}" alt="">
                    </a>
                    @endif
                    <!--<a href="" data-toggle="modal" data-target="#activitySelectionModal-{{ $activity->id }}">
                        <img class="rounded"
                            src="https://maps.googleapis.com/maps/api/staticmap?size=200x60&zoom=16&center={{ $activity->to_location }}&format=png&maptype=roadmap&style=element:geometry%7Ccolor:0x242f3e&style=element:labels.text.fill%7Ccolor:0x746855&style=element:labels.text.stroke%7Ccolor:0x242f3e&style=feature:administrative.locality%7Celement:labels.text.fill%7Ccolor:0xd59563&style=feature:poi%7Celement:labels.text.fill%7Ccolor:0xd59563&style=feature:poi.park%7Celement:geometry%7Ccolor:0x263c3f&style=feature:poi.park%7Celement:labels.text.fill%7Ccolor:0x6b9a76&style=feature:road%7Celement:geometry%7Ccolor:0x38414e&style=feature:road%7Celement:geometry.stroke%7Ccolor:0x212a37&style=feature:road%7Celement:labels.text.fill%7Ccolor:0x9ca5b3&style=feature:road.highway%7Celement:geometry%7Ccolor:0x746855&style=feature:road.highway%7Celement:geometry.stroke%7Ccolor:0x1f2835&style=feature:road.highway%7Celement:labels.text.fill%7Ccolor:0xf3d19c&style=feature:transit%7Celement:geometry%7Ccolor:0x2f3948&style=feature:transit.station%7Celement:labels.text.fill%7Ccolor:0xd59563&style=feature:water%7Celement:geometry%7Ccolor:0x17263c&style=feature:water%7Celement:labels.text.fill%7Ccolor:0x515c6d&style=feature:water%7Celement:labels.text.stroke%7Ccolor:0x17263c&key={{ env('GOOGLE_API_KEY') }}"
                            alt="">
                    </a>-->
                </div>
            </div>

            <div class="pb-2">
                <a href="{{"getlead/".$activity['id']}}" class="add_svg ">
                    <i class="fa fa-map-marker mr-2"></i>
                </a>
                <a href=""  data-toggle="modal" data-target="#shareMenu-{{ $activity->id }}">
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
                    <a class="regular" data-toggle="modal" data-target="#activitySelectionModal-{{ $activity->id }}">
                        <span class="regular">+{{ $activity->tags->count() - 4 }}</span>
                    </a>
                    @endif
                    @endif
                </div>
                <div class="">
                    @if (auth()->user()->id == $activity->user_id)
                    <a href="{{ route('activity.edit', $activity->id) }}" class="add_svg">
                        <img class="icon_blue" src="{{ asset('frontend/img/svg/plus_blue.svg' ) }}" alt="Edit Activity">
                        <img class="icon_white" src="{{ asset('frontend/img/svg/plus_white.svg' ) }}"
                            alt="Edit Activity">
                    </a>
                    @endif
                </div>
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
