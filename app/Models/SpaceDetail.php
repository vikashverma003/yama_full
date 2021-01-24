<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceDetail extends Model
{
    
    //
         protected $table = 'space_details';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_id', 'floor_id','space_number','space_name','image','space_type'
    ];

    public function create_space_detail($data){      
         $createdSpace= self::create(
            [
                'building_id'=>$data['building_id']??null,
                'floor_id' => $data['floor_id']??null,
                'space_number'=>  $data['space_number']??null,
                'space_name' =>  $data['space_name']??null,
                'image' =>  $data['image']??null,
                'space_type' =>  $data['space_type']??null,

            ]
        );

       return $createdSpace;
    }
}
