<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //
    protected $table = 'vendors';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'logo','description','gst_number','food','license_number','vendor_type'
    ];

    public function create_vendor($data){      
         $createdVendor= self::create(
            [
                'name'=>$data['name']??null,
                'logo' => $data['logo']??null,
                'description'=>  $data['description']??null,
                'gst_number' =>  $data['gst_number']??null,
                'food' =>  $data['food']??null,
                'license_number' =>  $data['license_number']??null,
                'vendor_type' =>  $data['vendor_type']??null,
            ]
        );
       return $createdVendor;
    }

}
