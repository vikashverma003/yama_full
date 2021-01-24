<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    //
     protected $table = 'buildings';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_name', 'image','link','floor','space'
    ];

    public function create_buildings($data){      
         $createdBuilding= self::create(
            [
                'building_name'=>$data['building_name']??null,
                'image' => $data['image']??null,
                'link'=>  $data['link']??null,
                'floor' =>  $data['floor']??null,
                'space' =>  $data['space']??null,
            ]
        );

       return $createdBuilding;
    }

}
