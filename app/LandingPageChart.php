<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LandingPageChart extends Model
{
    //

    protected $table='landingpagecharts';
    protected  $fillable=['	fillColor','strokeColor','pointColor','	pointStrokeColor','pointHighlightFill','pointHighlightStroke'];
}
