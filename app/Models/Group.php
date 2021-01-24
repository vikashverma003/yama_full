<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'group';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'heading', 'description','image','restaurant_id'
    ];

    public function creategroup($data){
      
         $createdUser= self::create(
            [
                'heading'        =>  $data['heading']??null,
                'description'    =>  $data['description']??null,
                'restaurant_id'  =>  $data['restaurants']??null,
                'image'          =>  $data['image']??null,
            ]
        );

       return $createdUser;
    }
}
