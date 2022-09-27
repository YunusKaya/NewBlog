<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public function articleCount()
    {
        return $this->hasMany('App\Models\Article','catagoryID','id')->count();
        //Mağlanacağımız Model // MAğlanacağımız Sütü //Bağlanacak ID
    }
}
