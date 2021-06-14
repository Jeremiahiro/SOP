<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Activity;
use App\UserLocation;
use App\ActivityTags;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ActivitySearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('components.activitysearch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $start = Carbon::parse($request->start_date)->format('Y-m-d H:i');
        $end = Carbon::parse($request->end_date)->format('Y-m-d H:i');

        if($request->from_address != null){
            $from_address = $request->from_address;
            $from_location = $request->from_location;
            $from_latitude = $request->from_latitude;
            $from_longitude = $request->from_longitude;
            $distance = $request->distance;
            $causes = $request->causes;


            $endss = Activity::whereRaw("( 6371 * acos ( cos ( radians(".$from_latitude.") ) * cos( radians( from_latitude ) ) * cos( radians( from_longitude ) - radians(".$from_longitude.") ) + sin ( radians(".$from_latitude.") ) * sin( radians( from_latitude ) ) ) <= ".$distance.")")
            ->whereBetween('created_at', [$start, $end])
            ->where('causes', '=', $causes)->get();
        
            return view('components.activitysearch.result',  compact(['endss']));
        } 
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
