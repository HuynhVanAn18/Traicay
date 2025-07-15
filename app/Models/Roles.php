<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
     public $timestamps = false; //set time to false
    protected $fillable = [
    	'name'
    ];
    protected $primaryKey = 'id_roles';
 	protected $table = 'tbl_roles';

 	public function admin(){
 		return $this->belongsToMany('App\Models\Login');
 	}
	public function users()
{
    return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
}
}
