<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Userinfo;
use App\Models\Userimage;
use URL;
class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->role =='doctor'){
        $age='';
        }else{
       $data= Userinfo::where('user_id',$this->id)->first();
       
       if(!empty($data->born)){
        $born =$data->born;
       }else{
        $born ='';
       }
       
       if(!empty($data->gender)){
        $gender=$data->gender;
       }else{
        $gender ='';
       }
       $today = date('Y-m-d');
            $diff = date_diff(date_create($born), date_create($today));
            $age=$diff->format('%y');
        }
//echo $this->id;
//die();
        if($this->role =='patient'){
        if(!empty($this->id)){
            $data= Userinfo::where('user_id',$this->id)->first();
            if(!empty($data->id)){
            $gender=$data->gender;
            $born=$data->born;
            $fathername=$data->fathername;
            $chronic_illness=$data->chronic_illness;
            $chronic_yes=explode(',',$data->chronic_yes);
            $consume_medicines=$data->consume_medicines;
            $consume_medicines_yes= explode(',',$data->consume_medicines_yes);

            $allergic_medication=$data->allergic_medication;
            $allergic_medication_yes=explode(',',$data->allergic_medication_yes);
            $fractures=$data->fractures;
            $fractures_yes=explode(',',$data->fractures_yes);

            $supervison=$data->supervison;
            $supervison_yes=explode(',',$data->supervison_yes);

            $address1=$data->address1;
            $address2=$data->address2;
            $interior_house=$data->interior_house;
            $exterior_house=$data->exterior_house;
            $zipcode=$data->zipcode;
            $country=$data->country;

            $marital_status=$data->marital_status;
            $education_level=$data->education_level;
        }
        }else{
            $gender='';
        }
    }
         if(!empty($this->id)){
            $datas= Userimage::where('user_id',$this->id)->first();
           if(!empty($datas->upload_id)){
            $upload_id=$datas->upload_id;

            $url= URL::to('/');
            $img=$url.'/'.$upload_id;
        }else{
            $img='';
         }
        }
        if(!empty($this->occupation)){
            $occupation=$this->occupation;
        }else{
            $occupation='';
        }

        return [
            'id' => $this->id,
            // $this->mergeWhen(config('constants.role.USER') ==$this->role, [
            //     'first_name'  => $this->name,
            //     'last_name'  => $this->last_name,
            //     ]),
            'first_name'  => $this->name,
            'age'         => $age,
            //'last_name'  => $this->last_name,
            'email' =>  $this->email,
            'role'      =>  $this->role,
            'profile_image'=>  is_null($this->profile_image)?'':env('APP_URL')."".env('IMAGE_UPLOAD_PATH').''.$this->profile_image,
            'phone_code'      => $this->phone_code,
             $this->mergeWhen(config('constants.role.USER')==$this->role, [
            'gender'          => $gender??null,
            'born'            => $born??null,
            'fathername'      => $fathername??null,
            'chronic_illness' => $chronic_illness??null,
            'marital_status'  => $marital_status??null,
            'education_level' => $education_level??null,
            'chronic_yes'     => $chronic_yes??null,
            'consume_medicines'=>$consume_medicines??null,
            'consume_medicines_yes'=>$consume_medicines_yes??null,
            'allergic_medication'=>$allergic_medication??null,
            'allergic_medication_yes'=>$allergic_medication_yes??null,
            'fractures'=>$fractures??null,
            'supervison'=> $supervison??null,
            'supervison_yes'=>$supervison_yes??null,
            'fractures_yes'=>$fractures_yes??null,
            'address1'=>$address1??null,
            'address2'=>$address2??null,
            'interior_house'=>$interior_house??null,
            'exterior_house'=>$exterior_house??null,
            'zipcode'=>$zipcode??null,
            'country'=>$country??null,
                    ]),
           
            'user_identification'=>$img,
            'phone_number'       => $this->phone_number,
            'occupation'         => $occupation,
            'verify_action'      => $this->skip,
            'is_complete'        => $this->is_complete,
            'is_notify'          => $this->is_notify,
            'paid_consultation'  => $this->paid_consultation,
            'free_consultation'  => $this->free_consultation,

            $this->mergeWhen($this->access_token, [
            'access_token'    => $this->access_token,
            ]),

            'otp'             => $this->when($this->otp,$this->otp),
            'location'        => $this->when(
             $this->relationLoaded('location'),
            function () {
                return new Location($this->location);
            }
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'business'   => $this->when(
                $this->relationLoaded('business'),
                function () {
                    return new Business($this->business);
                }
            )
        ];
    }
}
