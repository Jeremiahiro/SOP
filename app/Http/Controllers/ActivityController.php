<?php

namespace App\Http\Controllers;

use Cloudder;
use App\User;
use App\Activity;
use App\ActivityTags;
use App\leaders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ActivityTagNotification;
use App\Notifications\ActivityTagSmsNotification;
use Image;

class ActivityController extends Controller
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
    public function index(Request $request)
    {
        $user = Auth::user();



        $istagged = Activity::whereHas('tags', function($query) use($user){
                                    $query->wherePersonId($user->id);
                                })->latest('created_at')->simplePaginate(10);

        $activities = Activity::with('tags')->latest('updated_at')->simplePaginate(10);
       
        if ($request->ajax()) {
            $activities = view('activity.partials.activity-list-view', compact('activities', 'istagged'))->render();
            return response()->json([
                'activities'=>$activities,
                'istagged'=>$istagged,
                ]);
        }
        return view('activity.index', compact('activities', 'istagged'));
    }



    public function getAdd(Request $request)
    {
        $leaders = leaders::where('from_address', $request->from_address)->get();
        return view('activity.leaders', compact('leaders'));
    }
    
 


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('activity.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateActivity($request);

        $start = Carbon::parse($request->start_date)->format('Y-m-d H:i');
        $end = Carbon::parse($request->end_date)->format('Y-m-d H:i');

        if($request->from_image != null){

            $from_image = $request->from_image;
            $from_imagetxt = Image::make($from_image);
            $from_imagetxt->text($request->causes, 110, 220, function($font) {   
                $font->color('#fff');  
                $font->file('frontend/font/Gilroy-Bold.woff');
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
           

            $activity = Activity::firstOrCreate([
                'from_address' => $request->from_address,
                'from_location' => $request->from_location,
                'from_latitude' => $request->from_latitude,
                'from_longitude' => $request->from_longitude,
    
                'to_address' => $request->to_address,
                'to_location' => $request->to_location,
                'to_latitude' => $request->to_latitude,
                'to_longitude' => $request->to_longitude,

                'causes' => $request->causes, 

                'start_date' => $start,
                'end_date' => $end,

                'from_image' => $from_imagetxt,
                'to_image' => $request->to_image,
    
                'user_id' => auth()->user()->id,
            ]);
    
            if ($activity->wasRecentlyCreated) {
                // for existing users

                if($request->tags != null) {
                    $tags = explode(",", $request->tags);
                    foreach($tags as $person) {
                        $existingUser = User::where('username', $person)->first();


                        if ($existingUser) {
                            $activityTag = new ActivityTags;

                            $activityTag->user_id = Auth::user()->id;
                            $activityTag->activity_id = $activity->id;
                            $activityTag->name = $existingUser->name;
                            $activityTag->email = $existingUser->email;
                            $activityTag->phone = $existingUser->phone;
                            $activityTag->person_id = $existingUser->id;
                            $activityTag->avatar = $existingUser->avatar;
                           
                            $activityTag->save();
                        
                            $details = [
                                'greeting' => 'Hi ' . $existingUser->name,
                                'body' => 'You were tagged in an activity',
                                'action' => 'click here to see',
                                'activity_id' => $activity->id,
                            ];


                             $existingUser->notify(new \App\Notifications\ActivityTagNotification($details));
                          
                            
                        } 
                    }
                } 
    
                // for users not on the platform
                if($request->name != null) {
                    $name = $request->name;
                    $email = $request->email;
                    $phone = $request->phone;
    
                    foreach($name as $key => $value) {
                        $existingUser = User::where('email', $email[$key])->first();
                        if ($existingUser) {
                            $activityTag = new ActivityTags;
                            $activityTag->activity_id   = $activity->id;
                            $activityTag->person_id     = $existingUser->id;
                            $activityTag->name          = $existingUser->name;
                            $activityTag->user_id       = Auth::user()->id;
                            $activityTag->save();

                            $details = [
                                'greeting' => 'Hi ' . $existingUser->name,
                                'body' => 'You were tagged in an activity',
                                'action' => 'click here to see',
                                'activity_id' => $activity->id,
                            ];
                            $existingUser->notify(new ActivityTagNotification($details));

                        } elseif ($name[$key] != null) {
                            $activityTag = new ActivityTags;
                            $activityTag->name          = $name[$key];
                            $activityTag->email         = $email[$key];
                            $activityTag->phone         = $phone[$key];
                            $activityTag->activity_id   = $activity->id;
                            $activityTag->user_id       = Auth::user()->id;
                            $activityTag->save();

                            $details = [
                                'greeting' => 'Hi ' . $name[$key],
                                'body' => 'You were tagged in an activity',
                                'action' => 'click here to see',
                                'activity_id' => $activity->id,
                            ];

                            if($email[$key] != null){
                                $activityTag->notify(new ActivityTagNotification($details));
                            } elseif($phone[$key] != null) {
                                $activityTag->notify(new ActivityTagSmsNotification($details));
                            }
                        } 
                    }
                }
            
            } else {
                return redirect()->back()->with('error', 'Activity was recently created');
            }
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
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {

        return view('activity.show', compact('activity'));
    }


  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        return view('activity.edit', compact('activity'));
    }

   
    public function addLoc($id)
    {
        $activity = Activity::where('id', $id)->get(); 
        return view('activity.addLocation', compact('activity'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        if($activity->user_id == auth()->user()->id){

            if($request->name[0] != null || $request->tags != null)
            {
                DB::beginTransaction();
                try {
                    // for existing users
                    if($request->tags != null) {
                        $tags = explode(",", $request->tags);
                        foreach($tags as $person) {
                            $existingUser = User::where('username', $person)->first();
                            if ($existingUser) {
                                $existingTag = ActivityTags::where('person_id', $existingUser->id)->where('activity_id', $activity->id)->first();
                                if(!$existingTag){
                                    $activityTag = new ActivityTags;
                                    $activityTag->activity_id   = $activity->id;
                                    $activityTag->person_id     = $existingUser->id;
                                    $activityTag->name          = $existingUser->name;
                                    $activityTag->user_id       = Auth::user()->id;
                                    $activityTag->save();

                                    $details = [
                                        'greeting' => 'Hi ' . $existingUser->name,
                                        'body' => 'You were tagged in an activity',
                                        'action' => 'click here to see',
                                        'activity_id' => $activity->id,
                                    ];
                                    $existingUser->notify(new ActivityTagNotification($details));
                                } 
                            } 
                        }
                    }
        
                    // for users not on the platform
                    $name = $request->name;
                    $email = $request->email;
                    $phone = $request->phone;
    
                    if($name != null) {
                        foreach($name as $key => $value) {
                            $existingUser = User::where('email', $email[$key])->first();
                            if ($existingUser) {
                                $existingTag = ActivityTags::where('person_id', $existingUser->id)->where('activity_id', $activity->id)->first();
                                if(!$existingTag){
                                    $activityTag = new ActivityTags;
                                    $activityTag->activity_id   = $activity->id;
                                    $activityTag->person_id     = $existingUser->id;
                                    $activityTag->name          = $existingUser->name;
                                    $activityTag->user_id       = Auth::user()->id;
                                    $activityTag->save();

                                    $details = [
                                        'greeting' => 'Hi ' . $existingUser->name,
                                        'body' => 'You were tagged in an activity',
                                        'action' => 'click here to see',
                                        'activity_id' => $activity ->id,
                                    ];
                                    $existingUser->notify(new ActivityTagNotification($details));
                                }
                             
                            } elseif ($name[$key] != null) {
                                $existingTag = ActivityTags::where('name', $name[$key])->where('activity_id', $activity->id)->first();
                                if(!$existingTag){
                                    $activityTag = new ActivityTags;
                                    $activityTag->name          = $name[$key];
                                    $activityTag->email         = $email[$key];
                                    $activityTag->phone         = $phone[$key];
                                    $activityTag->activity_id   = $activity->id;
                                    $activityTag->user_id       = Auth::user()->id;
                                    $activityTag->save();

                                    $details = [
                                        'greeting' => 'Hi ' . $name[$key],
                                        'body' => 'You were tagged in an activity',
                                        'action' => 'click here to see',
                                        'activity_id' => $activity->id,
                                    ];
                                    if($email[$key] != null){
                                        $activityTag->notify(new ActivityTagNotification($details));
                                    } elseif($phone[$key] != null) {
                                        $activityTag->notify(new ActivityTagSmsNotification($details));
                                    }
                                }
                            }
                        }
                    }
                    DB::commit();
                    return redirect()->route('activity.index')->with('success', 'Activity Updated Successfuly!');
    
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'OOps something went wrong');
                } 
            } else {
                return redirect()->back()->with('error', 'Entry fields cannot be null');
            }
        }
        return redirect()->back()->with('info', 'Unauthorized Access!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $activity = Activity::withTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success', 'Successful');
    }

    /**
     * Archive activity using softDelete.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function archive(Request $request, $id)
    {
        $activity = Activity::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Successful');
    }

    /**
     * Unarchive activity using softDelete.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function unarchive(Request $request, $id)
    {
        $activity = Activity::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', 'Successful');
    }

    public function validateActivity(Request $request)
    {

		$rules = [
            'from_latitude' => 'required',
            'to_latitude' => 'required',
            'activity_tags.*.name' => 'sometimes',
            'activity_tags.*.email' => 'sometimes',
            'activity_tags.*.phone' => 'sometimes',
        ];

        $messages = [
            'from_latitude' => 'Select location from the menu',
            'to_latitude' => 'Select location from the menu',
        ];
         
		$this->validate($request, $rules, $messages);
    }

     /**
     * Show the search page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function calendar()
    {
        return view('activity.calendar');
    }


    /**
     * Show list of Activities based on calendar Sort.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendarActivity(Request $request)
    {

        // $date = Carbon::parse($request->query)->format('Y-m-d');
        $date = ($request->query);

        $response = [
            'success' => true,
            'date' => $date,
            "message" => 'Successful'
        ];
        return response()->json($response, 201);
        // if($request->ajax()) {
        //     $data = Activity::where('created_at', 'LIKE', $request->day_cell.'%')
        //         ->get();
        //     $output = '';
        //     if (count($data)>0) {
        //         $output = '<div class="row" style="display: block; position: relative; z-index: 1">';
        //         foreach ($data as $activity){
        //             $output .= '<div class="container">';
        //             $output .= '<div class="py-1">';
        //             $output .= '<p>'.$activity->from_location.'';
        //             $output .= '</p>';
        //             $output .= '</div>';
        //             $output .= '</div>';
        //         }
        //         $output .= '</div>';
        //     } else {
        //         $output .= '<p class="regular text-gray f-16">'.'No Activity'.'</p>';
        //     }
        //     return $output;
        // }
    }
}
