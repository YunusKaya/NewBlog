<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    //
    use SoftDeletes;
    public function getCatagory()
    {
        return $this->hasOne('App\Models\category','id','catagoryID');
    }
}
