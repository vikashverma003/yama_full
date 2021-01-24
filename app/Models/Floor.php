<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    //
     protected $table = 'floors';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_id','number_of_rooms','floor_name','floor_number','area','image'
    ];
    
     public function add_floor_building($data){      
         $createdFloor= self::create(
            [
                'building_id'=>$data['building_id']??null,
                'number_of_rooms' =>  $data['number_of_rooms']??null,
                'floor_name' =>  $data['floor_name']??null,
                'floor_number' =>  $data['floor_number']??null,
                'area' =>  $data['area']??null,
                'image' =>  $data['image']??null,
            ]
        );

       return $createdFloor;
    }


}
