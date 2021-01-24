<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodMenu extends Model
{
    protected $table = 'food_menu';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_name', 'barcode','item_group','sub_group','sale_price','tax','discount','min_stock','re_order','gst','hide','delete_status','image','food_description'
    ];

    public function createInventory($data){
      
         $createdUser= self::create(
            [
                'item_name'      =>  $data['item_name']??null,
                'barcode'        =>  $data['barcode']??null,
                'item_group'     =>  $data['item_group']??null,
                'sub_group'      =>  $data['sub_group']??null,
                'sale_price'     =>  $data['sale_price']??null,
                'tax'            =>  $data['tax']??null,
                'discount'       =>  $data['discount']??null,
                'min_stock'      =>  $data['min_stock']??null,
                're_order'       =>  $data['re_order']??null,
                'gst'            =>  $data['gst']??null,
                'image'            =>  $data['image']??null,
                'food_description'  =>  $data['food_description']??null,

            ]
        );

       return $createdUser;
    }
}
