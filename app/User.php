<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Userinfo as UserResourceinfo;
use Hash;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password','device_token','role','account_status','phone_code','phone_number','last_name','profile_image','random','rating','time_zone','owner_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function createUser($data){
           
         $createdUsers= self::create(
            [
                'first_name'        =>  $data['first_name']??null,
                'last_name'         =>  $data['last_name']??null,
                'email'             =>  $data['email']??null,
                'password'          =>  Hash::make('123456'),
                'profile_image'     =>  $data['profile'],
                'role'              =>  '4',
               
                
            ]
        );

       return $createdUsers;
    }
    
    
    

    public function createPassportToken($user){
        return $user->createToken('YamaApp')->accessToken;
    }
}
