<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class leaders extends Model
{

    protected $fillable = [
        'name',
        'position', 
        'from_address',
        'from_location', 
        'from_latitude',
        'from_longitude',
        'number',
        'email',
        'avatar',
    ];



     /**
     * Get the activity that the leaders belong to.
     */
    public function activity()
    {
        return $this->belongsTo('App\Activity', 'from_address');
    }
}
