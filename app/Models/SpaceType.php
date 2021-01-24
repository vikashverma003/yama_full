<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceType extends Model
{
    //
      protected $table = 'space_types';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category'
    ];
}
