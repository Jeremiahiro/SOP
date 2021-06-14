<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class ActivityLocations extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'from_latitude', 
        'email',
        'from_longitude',
        'from_address', 
        'from_location', 
        'from_image',
        'user_id',
        'activity_id', 
        'person_id',
        'start_date',
        'causes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ ];

     /**
     * Get the user that owns the activity location.
     */
    public function owner()
    {
        return $this->belongsTo('App\User',);
    }

     /**
     * Get the activity that the location belong to.
     */
    public function activity()
    {
        return $this->belongsTo('App\Activity', 'activity_id');
    }

     /**
     * Get the activity that the location belong to.
     */
    public function loced()
    {
        return $this->belongsTo('App\User', 'person_id');
    }

        /**
     * Get the activity that the location belong to.
     */
    public function loccing()
    {
        return $this->belongsTo('App\Activity', 'user_id');
    }
}
