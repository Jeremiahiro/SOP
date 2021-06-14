


@extends('layouts.app')

@section('title')
Add Activity
@endsection
@section('custom-style')
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

@section('header')

@endsection

@section('web-content')
<script type="text/javascript">
    window.location = "{{ route('map.view') }}";

</script>
@endsection

@section('content')

<div class="container pt-4">
  <p class="mx-2">
    @if (url()->current() == url()->previous())
    <a href="{{ route('activity.index') }}" class="">
        <img src="{{ asset('/frontend/img/svg/back_blue.svg') }}" alt="go back">
    </a>
    @else
    <a href="{{ url()->previous() }}" class="">
        <img src="{{ asset('/frontend/img/svg/back_blue.svg') }}" alt="go back">
    </a>
    @endif

</p>
<p class="f-12 bold">Add More Activities</p>   
</div>


<div id="alert">
    @if($errors->any())
    <div class="alert alert-danger text-danger" role="alert">
        <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" class="text-danger">&times;</span>
        </button>
        <strong class="text-danger">Error! Select a valid location(s)</strong>
    </div>
    @endif
</div>


<section>
    <div class="container text-primary mb-5 pt-0">
        <div class="ml-0">
            <label for="location_1" class="f-24 col-md-12 text-md-left px-0">
                {{ __('Where') }}
            </label>
        </div>
    

        <div class="py-4 activity">
            <form method="POST" action="{{ route('leaders.store') }}" id="activitForm" name="activity"
                autocomplete="off" enctype="multipart/form-data">
                @csrf

                <div id="startTour" class="">
                    @foreach($activity as $key => $act)
                        <input class="d-none" type="text" name="activity_id" value="{{ $act->id }}" id="activity_id">
                        <input type="text" class="d-none" name="user_id" value="{{ $act->user_id }}" id="user_id">
                        <input type="text" class="d-none" name="person_id" value="{{ $act->user_id }}" id="person_id">
                        <input type="text" class="d-none" name="email" value="{{ $act->user_id }}" id="email">
                    @endforeach
                    <div class="row mb-4 form-group">
                        <div class="flex-row d-flex justify-content-center w-100">
                            <div class="col-md-12">
                                <div>
                                    <input id="address_1" type="search"
                                        class="blue-input input rounded-0 @error('from_address') is-invalid @enderror"
                                        name="from_address" value="{{ old('from_address') }}" required autocomplete="off"
                                        placeholder="From">
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
                                <div class="f-24 border collapse additional-info-collapse" id="collapseFromInfo">
                                    <div class="d-flex justify-content-between p-2">
                                        <div class="col-12 text-center">
                                            <label for="from_image" class="">
                                                <span>
                                                    Add Image
                                                    @include('activity.partials.cam')
                                                </span>
                                            </label>
                                            <input type="hidden" name="from_image" id="from_image_value" value="">
                                            <input type="file" name="from_image" class="d-none avatar-input" id="from_image"
                                                value="" accept="image/*" data-type="from_image" required>
                                            <div id="fromImagePreviewDiv" class="d-none tx_effect">
                                                <div class="img_preview text-center mx-auto">
                                                    <img src="http://placehold.it/100" alt="Location Image Preview"
                                                        class="loc_img_preview" id="fromImagePreview">
                                                </div>
                                                <div class="text-right">
                                                    <i class="fa fa-times text-danger" id="removeFromImage"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>

                <div class="ml-0">
                    <div class="row mb-4 form-group">
                        <label for="when" class="f-24 col-md-12 text-md-left">
                            {{ __('When') }}
                        </label>
                        <div class="flex-row d-flex justify-content-center w-100">
                            <div class="col-md-12">
                                <div class="input-group date input-daterange">
                                    <input type="text" class="f-14 regular input blue-input input1 rounded-0"
                                        name="start_date" placeholder="Start Date/Time" id="startDate"
                                        value="{{ date('d-m-Y H:i', strtotime('+1 hour')) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 form-group">
                        <label for="when" class="f-24 col-md-12 text-md-left">
                            {{ __('Causes') }}
                        </label>
                        <div class="flex-row d-flex justify-content-center w-100">
                            <div class="col-md-12">
                                <div class="input-group date input-daterange">
                                    <select class="f-14 regular input blue-input input1 rounded-0"
                                        data-live-search="true" name="causes" id="causes" required="">
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
                </div>
           

                <div class="">
                    <div class="form-group pull-right">
                        <button type="submit" class="btn f-14 rounded blue-btn px-3 text-white">ADD</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('partials.mobile.footer.footer')
</section>

@include('partials.modals.upload.uploadModal')

@endsection
@section('script')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>

<script id="document-template" type="text/x-handlebars-template">
    <div class="delete_add_more_item d-flex justify-content-between" id="delete_add_more_item">
        

        <div class="form-group row w-100">
            <div class="col-md-6 mb-1">
                    <input id="address_1" type="search"
                        class="blue-input input rounded-0 "
                        name="from_address" value="@{{ address_1 }}" required autocomplete="off"
                        placeholder="From">
                    <input type="hidden" name="from_location" class="" id="location_1"
                        value="@{{ location_1 }}">
                    <input type="hidden" name="from_latitude" class="" id="latitude_1"
                        value="@{{ latitude_1 }}">
                    <input type="hidden" name="from_longitude" class="" id="longitude_1"
                        value="@{{ longitude_1 }}">

                    <input type="hidden" name="from_image" id="from_image_value" value="@{{ from_image_value}}">
                    <input type="hidden" name="from_image" class="d-none avatar-input" id="from_image"
                    value="@{{ from_image_value}}" accept="image/*" data-type="from_image" required>
            </div>
        </div>

        <div>
            <button type="button" class="btn removeaddmore remove m-0 p-0"><img src="{{ asset('/frontend/img/svg/removebtn.svg') }}" alt="remove"></button>
        </div>
    </div>
 </script>

<script type="text/javascript">
    $(document).on('click', '#addMore', function () {

        $('.table').show();


        var address_1 = $("#address_1").val();
        var location_1 = $("#location_1").val();
        var latitude_1 = $("#latitude_1").val();
        var longitude_1 = $("#longitude_1").val();
        var from_image_value = $("#from_image_value").val();
        var from_image = $("#from_image").val();
        var fromImagePreview = $("#fromImagePreview").val();
        var task_name = $("#task_name").val();
        var cost = $("#cost").val();
        var source = $("#document-template").html();
        var template = Handlebars.compile(source);

        var data = {
            address_1: address_1,
            location_1: location_1,
            latitude_1: latitude_1,
            longitude_1: longitude_1,
            from_image_value: from_image_value,
            from_image: from_image,
            fromImagePreview: fromImagePreview,
            task_name: task_name,
            cost: cost
        }


        var html = template(data);
        $("#addRow").append(html)

        total_ammount_price();
    });

    $(document).on('click', '.removeaddmore', function (event) {
        $(this).closest('.delete_add_more_item').remove();
        total_ammount_price();
    });

    function total_ammount_price() {
        var sum = 0;
        $('.cost').each(function () {
            var value = $(this).val();
            if (value.length != 0) {
                sum += parseFloat(value);
            }
        });
        $('#estimated_ammount').val(sum);
    }

</script>

@endsection

