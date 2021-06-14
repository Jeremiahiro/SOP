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


<!-- Content -->
<div class="content">
    <div>
        <p class="mb-2 pb-4">
            <a href="{{ url()->previous() }}" class="text-white">
                <img src="{{ asset('/frontend/img/svg/back_blue.svg') }}" alt="go back">
            </a>
        </p>
    </div>
    <!-- Animated -->
    <div class="animated fadeIn">

        <div class="row">

            <div class="col-md-12">
                <section class="card">
                    <form enctype="multipart/form-data">
                        @csrf

                        <input class="d-none" type="text" name="id" value="{{ $user->id }}" id="id">
                        <div class="bg-dark p-5">
                            <div class="corner-ribon black-ribon">
                                <i class="fa fa-user"></i>
                            </div>

                            <div class="media">
                                <a href="#">
                                    <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;"
                                        alt="" src="{{ $user->avatar }}">
                                </a>
                                <div class="media-body">
                                    <h2 class="text-white display-6">{{ $user->name }}</h2>
                                    <p class="text-light">{{ $user->username }}</p>
                                </div>
                            </div>



                        </div>
                        <div class="weather-category twt-category">
                            <ul>
                                <li class="active">
                                    <h5>{{ $user->email }}</h5>
                                    Email
                                </li>
                                <li>
                                    <h5>{{ $user->age_range }}</h5>
                                    Age Range
                                </li>
                                <li>
                                    <h5>{{ $user->gender }}</h5>
                                    Gender
                                </li>
                                <hr>
                                <li>
                                    <h5>{{ $user->phone }}</h5>
                                    Phone Number
                                </li>
                                <li>
                                    <!--<h4>
                                        <input id="role" name="role" style="border:; text-align:center;" type="text"
                                            value="{{ $user->role }}">
                                    </h4>-->
                                    <h5>{{ $user->role }}</h5>
                                    Role
                                </li>
                            </ul>
                        </div>
                        <footer class="twt-footer">
                            <div class="d-flex flex-row-reverse">
                                <a class="px-3" href={{ url()->previous() }}>
                                    <button type="button" class="btn btn-danger btn-sm"><i
                                            class="fa fa-rss"></i>&nbsp;Cancel</button>
                                </a>

                                <button type="submit" name="submit" id="submit" value="submit"
                                    class="btn btn-success btn-sm pl-3"><i class="fa fa-magic"></i>&nbsp; Update</button>
                            </div>

                        </footer>
                    </form>
                </section>
            </div>
        </div>
        <div class="clearfix"></div>

    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
<div class="clearfix"></div>

@endsection
@section('script')
<!--Local Stuff-->
<script>
    jQuery(document).ready(function ($) {
        "use strict";

        // Pie chart flotPie1
        var piedata = [{
                label: "Desktop visits",
                data: [
                    [1, 32]
                ],
                color: '#5c6bc0'
            },
            {
                label: "Tab visits",
                data: [
                    [1, 33]
                ],
                color: '#ef5350'
            },
            {
                label: "Mobile visits",
                data: [
                    [1, 35]
                ],
                color: '#66bb6a'
            }
        ];

        $.plot('#flotPie1', piedata, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    innerRadius: 0.65,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        threshold: 1
                    },
                    stroke: {
                        width: 0
                    }
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            }
        });
        // Pie chart flotPie1  End
        // cellPaiChart
        var cellPaiChart = [{
                label: "Direct Sell",
                data: [
                    [1, 65]
                ],
                color: '#5b83de'
            },
            {
                label: "Channel Sell",
                data: [
                    [1, 35]
                ],
                color: '#00bfa5'
            }
        ];
        $.plot('#cellPaiChart', cellPaiChart, {
            series: {
                pie: {
                    show: true,
                    stroke: {
                        width: 0
                    }
                }
            },
            legend: {
                show: false
            },
            grid: {
                hoverable: true,
                clickable: true
            }

        });
        // cellPaiChart End
        // Line Chart  #flotLine5
        var newCust = [
            [0, 3],
            [1, 5],
            [2, 4],
            [3, 7],
            [4, 9],
            [5, 3],
            [6, 6],
            [7, 4],
            [8, 10]
        ];

        var plot = $.plot($('#flotLine5'), [{
            data: newCust,
            label: 'New Data Flow',
            color: '#fff'
        }], {
            series: {
                lines: {
                    show: true,
                    lineColor: '#fff',
                    lineWidth: 2
                },
                points: {
                    show: true,
                    fill: true,
                    fillColor: "#ffffff",
                    symbol: "circle",
                    radius: 3
                },
                shadowSize: 0
            },
            points: {
                show: true,
            },
            legend: {
                show: false
            },
            grid: {
                show: false
            }
        });
        // Line Chart  #flotLine5 End
        // Traffic Chart using chartist
        if ($('#traffic-chart').length) {
            var chart = new Chartist.Line('#traffic-chart', {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                series: [
                    [0, 18000, 35000, 25000, 22000, 0],
                    [0, 33000, 15000, 20000, 15000, 300],
                    [0, 15000, 28000, 15000, 30000, 5000]
                ]
            }, {
                low: 0,
                showArea: true,
                showLine: false,
                showPoint: false,
                fullWidth: true,
                axisX: {
                    showGrid: true
                }
            });

            chart.on('draw', function (data) {
                if (data.type === 'line' || data.type === 'area') {
                    data.element.animate({
                        d: {
                            begin: 2000 * data.index,
                            dur: 2000,
                            from: data.path.clone().scale(1, 0).translate(0, data.chartRect
                                .height()).stringify(),
                            to: data.path.clone().stringify(),
                            easing: Chartist.Svg.Easing.easeOutQuint
                        }
                    });
                }
            });
        }
        // Traffic Chart using chartist End
        //Traffic chart chart-js
        if ($('#TrafficChart').length) {
            var ctx = document.getElementById("TrafficChart");
            ctx.height = 150;
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                    datasets: [{
                            label: "Visit",
                            borderColor: "rgba(4, 73, 203,.09)",
                            borderWidth: "1",
                            backgroundColor: "rgba(4, 73, 203,.5)",
                            data: [0, 2900, 5000, 3300, 6000, 3250, 0]
                        },
                        {
                            label: "Bounce",
                            borderColor: "rgba(245, 23, 66, 0.9)",
                            borderWidth: "1",
                            backgroundColor: "rgba(245, 23, 66,.5)",
                            pointHighlightStroke: "rgba(245, 23, 66,.5)",
                            data: [0, 4200, 4500, 1600, 4200, 1500, 4000]
                        },
                        {
                            label: "Targeted",
                            borderColor: "rgba(40, 169, 46, 0.9)",
                            borderWidth: "1",
                            backgroundColor: "rgba(40, 169, 46, .5)",
                            pointHighlightStroke: "rgba(40, 169, 46,.5)",
                            data: [1000, 5200, 3600, 2600, 4200, 5300, 0]
                        }
                    ]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }

                }
            });
        }
        //Traffic chart chart-js  End
        // Bar Chart #flotBarChart
        $.plot("#flotBarChart", [{
            data: [
                [0, 18],
                [2, 8],
                [4, 5],
                [6, 13],
                [8, 5],
                [10, 7],
                [12, 4],
                [14, 6],
                [16, 15],
                [18, 9],
                [20, 17],
                [22, 7],
                [24, 4],
                [26, 9],
                [28, 11]
            ],
            bars: {
                show: true,
                lineWidth: 0,
                fillColor: '#ffffff8a'
            }
        }], {
            grid: {
                show: false
            }
        });
        // Bar Chart #flotBarChart End
    });

</script>

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
