@extends('layouts.app')

@section('title')
Activities
@endsection

@section('custom-style')
<link href="{{ asset('frontend/css/splash.css') }}" rel="stylesheet">
<script src="{{ asset('frontend/jquery/map-view.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6BiYGAj-3dAd58vdTSp5eBisD7C52q-Q&callback=initMap" async defer>
</script>
@endsection

@section('web-content')
<script type="text/javascript">
    window.location = "{{ route('map.view') }}";

</script>
@endsection

@section('content')


<section class="mb-5 py-3">

    <div class="activityTab">
        <ul class="m-3 f-12 nav d-flex justify-content-between">
            <li class="active">
                <a data-toggle="tab" href="#activity" class="text-primary active">Timeline</a>
            </li>
            <li><a data-toggle="tab" href="#tagged" class="text-primary">Tagged in</a></li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane in active" id="activity">
            <div id="activity-list">
                <!--<div class="container px-4">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-between">
                            <img src="https://res.cloudinary.com/iro/image/upload/v1595613322/avatar.png"
                                class="sub-menu avatar avatar-xs mx-0" alt="Activity Tag">
                            <p class="p-2 m-0 f-10">Daniel Eche</p>
                        </div>
                        <a href="" class="sub-menu" data-toggle="modal" data-target="">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                    </div>
                    <p class="pt-3 text-dark f-10">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Totam ea
                        ratione corrupti molestias atque quia ab ullam quisquam illum suscipit maxime dolor, est culpa
                        necessitatibus dolore,
                        voluptas impedit odio quos.</p>
                    <hr class="border-blue" />
                </div>-->
                @include('activity.partials.activity-list-view')
            </div>
            <div class="text-center mb-5">
                <div class="spinner-grow text-primary load-activity d-none" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="tagged">
            <div id="tagged-list">
                @include('activity.partials.tagged')
            </div>
            <div class="text-center mb-5">
                <div class="spinner-grow text-primary load-activity d-none" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
@section('script')
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
