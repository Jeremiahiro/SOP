<?php

namespace App\Http\Controllers;

use Cloudder;
use App\User;
use App\Activity;
use App\ActivityTags;
use App\ActivityLocations;
use App\leaders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ActivityTagNotification;
use App\Notifications\ActivityTagSmsNotification;
use Image;

class LeadersController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
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

        if($request->from_image != null){

            $from_image = $request->from_image;
            $from_imagetxt = Image::make($from_image);
            $from_imagetxt->text($request->causes, 110, 220, function($font) {   
                $font->color('#fff');  
                $font->size(20);
                $font->align('center');  
            }); 
            $from_imagetxt->save($from_image);
            if($from_imagetxt){
                $from_imagetxt = cloudinary()->upload($from_image->getRealPath())->getSecurePath();
            }
        }


        DB::beginTransaction();

        try {
           

            $activitylocations = ActivityLocations::firstOrCreate([
                'from_address' => $request->from_address,
                'from_location' => $request->from_location,
                'from_latitude' => $request->from_latitude,
                'from_longitude' => $request->from_longitude,
    
                'user_id' => $request->user_id,
                'person_id' => $request->person_id,
                'activity_id' => $request->activity_id,
                'email' => $request->email,

                'start_date' => $start,
                'causes' => $request->causes, 

                'from_image' => $from_imagetxt,
            ]);
    
            DB::commit();

            return redirect()->route('activity.index')->with('success', 'Successful!');

        } catch (\Throwable $th) {
            DB::rollBack();
             return redirect()->back()->with('error', 'OOPS something went wrong');
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
   
    public function editloc($id)
    {
        $activity = Activity::where('id', $id)->get();
        return view('activity.addLocation', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

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
