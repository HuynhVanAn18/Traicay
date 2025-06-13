<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visiter extends Model
{
   public $timestamps = false; //set time to false
    protected $fillable = [
    	'ip_address', 'date_visiter'
    ];
    protected $primaryKey = 'id_visiter';
 	protected $table = 'tbl_visiter';
}
