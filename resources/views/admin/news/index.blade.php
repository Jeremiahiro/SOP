@extends('layouts.admin')

@section('custom-style')
<!--<link href="{{ asset('frontend/css/splash.css') }}" rel="stylesheet">-->
<!--<link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">-->

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
@php $no = 1; @endphp


<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-12">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Admin News</h1>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">

        {{--@foreach($news as $key => $allusers)--}}
        <div class="col-md-3">
            <div class="card">
                <img class="card-img-top" src="https://i.imgur.com/hrS2McC.png" alt="Card image cap">
                <div class="card-body">
                    <h4 class="card-title mb-2">Card Image Title</h4>
                    <p class="m-0 p-0">20-17-2021</p>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
        {{-- @endforeach--}}

      
    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
<div class="clearfix"></div>

@endsection
@section('script')
<!--Local Stuff-->
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

<script src="{{ asset('adminAssets/js/lib/data-table/datatables.min.js')}}"></script>
<script src="{{ asset('adminAssets/js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('adminAssets/js/lib/data-table/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('adminAssets/js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
<script src="{{ asset('adminAssets/js/lib/data-table/jszip.min.js')}}"></script>
<script src="{{ asset('adminAssets/js/lib/data-table/vfs_fonts.js')}}"></script>
<script src="{{ asset('adminAssets/js/lib/data-table/buttons.html5.min.js')}}"></script>
<script src="{{ asset('adminAssets/js/lib/data-table/buttons.print.min.js')}}"></script>
<script src="{{ asset('adminAssets/js/lib/data-table/buttons.colVis.min.js')}}"></script>
<script src="{{ asset('adminAssets/js/init/datatables-init.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#bootstrap-data-table-export').DataTable();
    });

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
