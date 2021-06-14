<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'news_title',
        'news_date', 
        'news_caption',
        'news_address', 
        'news_location',
        'news_latitude',
        'news_longitude',
        'news_image',
        'mews_video',
        'news_gif',
    ];

}
