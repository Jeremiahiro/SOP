<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        
        $activity = Activity::all();
        $causes = Activity::whereNotNull('causes')->count();
        return view('admin.index', compact('user', 'activity', 'causes'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showData($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', ['user'=>$user]); 
    }


    public function showData1($id)
    {
        $user = Activity::where('user_id', $id)->get();
        return view('admin.user.activity', ['user'=>$user]); 
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
    public function update(Request $request)
    {
        
         try {

            $user = User::find($request->id);

             $user->update([
                 'role' => $request['role'],
             ]);

             $user->save();
     
             return view('admin.index')->with('message', 'Event Updated  Succesfully!'); 
             
         } catch (\Throwable $th) {
    
             throw $th;
             $response = [
               'success' => false,
               'message' => "OOPS! Something fucking wennt wrong"
             ];
             return response()->json($response, 422);
         }
    
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
