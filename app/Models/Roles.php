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
		return $this->belongsToMany(
			Login::class,
			'login_roles', // pivot table name
			'roles_id_roles', // this model's key in pivot
			'login_admin_id' // related model's key in pivot
		);
	}
	public function users()
{
	return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
}
}
