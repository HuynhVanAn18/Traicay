<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Login extends Authenticatable
{
	public $timestamps = false;
	protected $fillable = [
		  'admin_email',  'admin_password',  'admin_name','admin_phone'
	];
	protected $primaryKey = 'admin_id';
	protected $table = 'tbl_admin';
	
	public function roles(){
		return $this->belongsToMany(
			Roles::class,
			'login_roles', // pivot table name
			'login_admin_id', // this model's key in pivot
			'roles_id_roles' // related model's key in pivot
		);
	}
	public function getAuthPassword(){
		return $this->admin_password;
	}
	public function hasAnyRoles($roles){
		return null !== $this->roles()->whereIn('name',$roles)->first();
	}
	public function hasRole($role){
		return null !== $this->roles()->where('name',$role)->first();
	}
}

