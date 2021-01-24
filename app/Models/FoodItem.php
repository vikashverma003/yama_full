<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
     //
    protected $table = 'food_item';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'food_name', 'group_name','food_type','price','taxes','hide','image','sub_group','building_id','floor_id'
    ];

    public function create_food_item($data){      
         $createdItem= self::create(
            [
                'food_name'=>$data['food_name']??null,
                'group_name' => $data['group_name']??null,
                'food_type'=>  $data['food_type']??null,
                'price' =>  $data['price']??null,
                'taxes' =>  $data['taxes']??null,
                'building_id' =>  $data['building_id']??null,
                'floor_id' =>  $data['floor_id']??null,
                'hide' =>  $data['hide']??null,
                'image' =>  $data['image']??null,
                'sub_group' =>  $data['sub_group']??null,
            ]
        );
       return $createdItem;
    }
}
