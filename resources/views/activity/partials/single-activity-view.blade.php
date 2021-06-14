<div>
    <div>

        <div class="">
            <div class="w-100 py-2">
                <div id="activityCarouselIndicators{{ $activity->id }}" class="carousel" data-ride="carousel">
                    <div class="carousel-inner">
                        @if ($activity->from_image != null)
                        <div class="carousel-item active">
                            <div class="d-flex justify-content-between bold mb-3">
                                <div class="d-flex">
                                    <img src="{{ asset('/frontend/img/svg/map-pin-markedwhite.svg') }}" alt="map-pin">
                                    <div class="ml-1">
                                        <h3 class="m-0 p-0 f-16">{{ $activity->from_location }}</h3>
                                        <p class="m-0 p-0 f-10 regular">{{ $activity->from_address }}</p>
                                    </div>
                                </div>
                                <p class="f-9">
                                    {{ $activity['start_date']->format('g:i A') }}
                                </p>
                            </div>
                            <div class="map-img map-lg rounded" style="overflow: hidden !important;">
                                <img src="{{ $activity->from_image }}" alt="">
                            </div>
                            <div class="pt-4">
                                <p style="right:0px;" class="m-0 px-0 bold f-10 position-absolute">
                                    {{ $activity['start_date']->format('d M, Y') }}</p>

                                <div class="accordion" id="seeMapAccordion">
                                    <div id="seeMap" class="pb-3">
                                        <p class="m-0 px-0 bold text-left f-12n">
                                            <span class="bg-none collapsed" data-toggle="collapse"
                                                data-target="#collapseSeeMap" aria-expanded="false"
                                                aria-controls="collapseSeeMap">
                                                <i class="fa fa-street-view mr-2" aria-hidden="true"></i> See Map
                                            </span>
                                        </p>
                                    </div>

                                    <div class="card-body  p-0">
                                        <div id="collapseSeeMap" class="collapse" aria-labelledby="seeMap"
                                            data-parent="#seeMapAccordion">
                                            <div class="">
                                                <div class="map map-lg rounded" id="map-{{ $activity->id }}"
                                                    fLat="{{ $activity->from_latitude }}"
                                                    fLng="{{ $activity->from_longitude }}"
                                                    tLat="{{ $activity->to_latitude }}"
                                                    tLng="{{ $activity->to_longitude }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        @endif

                        @foreach($activity->locs as $person)
                        @if ($person->from_image != null)
                        <div class="carousel-item">
                            <div class="d-flex justify-content-between bold mb-3">
                                <div class="d-flex">
                                    <img src="{{ asset('/frontend/img/svg/map-pin-markedwhite.svg') }}" alt="map-pin">
                                    <div class="ml-1">
                                        <h3 class="m-0 p-0 f-16">{{ $person->from_location }}</h3>
                                        <p class="m-0 p-0 f-10 regular">{{ $person->from_address }}</p>
                                    </div>
                                </div>
                                <p class="f-9">
                                    {{ Carbon\Carbon::parse($person->start_date)->format('H:i A') }}
                                </p>
                            </div>
                            <div class="map-img map-lg rounded" style="overflow: hidden !important;">
                                <img src="{{ $person->from_image }}" alt="">
                            </div>
                            <div class="pt-4">
                                <p style="right:0px;" class="m-0 px-0 bold f-10 position-absolute">
                                    {{ Carbon\Carbon::parse($person->start_date)->format('d M, Y') }}</p>

                                <div class="accordion" id="seeMapAccordion">
                                    <div id="seeMap" class="pb-3">
                                        <p class="m-0 px-0 bold text-left f-12n">
                                            <span class="bg-none collapsed" data-toggle="collapse"
                                                data-target="#collapseSeeMap" aria-expanded="false"
                                                aria-controls="collapseSeeMap">
                                                <i class="fa fa-street-view mr-2" aria-hidden="true"></i> See Map
                                            </span>
                                        </p>
                                    </div>

                                    <div class="card-body  p-0">
                                        <div id="collapseSeeMap" class="collapse" aria-labelledby="seeMap"
                                            data-parent="#seeMapAccordion">
                                            <div class="">
                                                <div class="map map-lg rounded" id="map-{{ $person->id }}"
                                                    fLat="{{ $person->from_latitude }}"
                                                    fLng="{{ $person->from_longitude }}"
                                                    tLat="{{ $person->to_latitude }}"
                                                    tLng="{{ $person->to_longitude }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @foreach($activity->locs as $person)
                    @if ($activity->from_image = null || $person->from_image != null)
                    <a style="height: 300px;" class="carousel-control-prev text-white"
                        href="#activityCarouselIndicators{{ $activity->id }}" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon text-white" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a style="height: 300px;" class="carousel-control-next text-white"
                        href="#activityCarouselIndicators{{ $activity->id }}" role="button" data-slide="next">
                        <span class="carousel-control-next-icon text-white" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between ">
            <div class="pb-1">
                <a style="color: #fff !important" href="{{"getlead/".$activity['id']}}">
                    <i class="fa fa-map-marker mr-2"></i>
                </a>
                <a style="color: #fff !important" target="_blank"
                    href="http://twitter.com/share?text=I am vocal about {{ $activity->causes }}&url=http://127.0.0.1:8000#sharelink">
                    <i class="fa fa-twitter mx-2"></i>
                </a>
                <a style="color: #fff !important" target="_blank"
                    href="https://www.facebook.com/sharer/sharer.php?u=http://127.0.0.1:8000#{{ $activity->causes }}">
                    <i class="fa fa-facebook mx-2" aria-hidden="true"></i>
                </a>
                <a style="color: #fff !important"
                    href="whatsapp://send?text=http://127.0.0.1:8000#{{ $activity->causes }}">
                    <i class="fa fa-whatsapp mx-2" aria-hidden="true"></i>
                </a>
            </div>
            <div class="pt-0">
                <a class="btn bg-white blue-text f-12"
                    href="{{ route('leaders.show', [ $activity->from_address]) }}">Who needs to see this!</a>
            </div>
        </div>
        <hr>

        <div class="py-2">
            <h4 class="m-0 bold f-12 mb-3">Witnesses</h4>
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    @foreach($activity->tags->chunk(6) as $tags)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="height: 110px;">
                        @foreach($tags->chunk(3) as $persons)
                        <div class="row p-1">
                            @foreach($persons as $person)
                            <div class="col col-4 m-0">
                                <div class="d-flex align-items-center">
                                    @if($person->person_id != null )
                                    <div>
                                        <a href="{{ route('dashboard.show', $person->tagged->uuid) }}"
                                            class="f-9 bold text-primary">
                                            <img src="{{ $person->tagged->avatar }}"
                                                class="avatar avatar-sm border border-primary" alt="Activity Tag">
                                        </a>
                                    </div>
                                    <div class="ml-1">
                                        <a href="{{ route('dashboard.show', $person->tagged->uuid) }}"
                                            class="f-9 bold text-primary">
                                            <p class="f-12 mb-0 bold text-capitalize text-white">
                                                {{ \Illuminate\Support\Str::limit($person->tagged->username, 8) }}
                                            </p>
                                        </a>
                                    </div>
                                    @else
                                    <div>
                                        <img src="{{ $person->avatar }}" class="avatar avatar-sm" alt="Activity Tag">
                                    </div>
                                    <div class="ml-1">
                                        <p class="f-12 mb-0 bold text-capitalize">
                                            {{ \Illuminate\Support\Str::limit($person->name, 8) }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>

                <ol class="carousel-indicators" style="top: 90%">
                    @foreach($activity->tags->chunk(6) as $tags)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}">
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>

    </div>
</div>
