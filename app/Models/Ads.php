<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
   public $timestamps = false; //set time to false
    protected $fillable = [
		'ads_name', 'ads_link','ads_image', 'ads_desc','ads_status'
    ];
    protected $primaryKey = 'ads_id';
 	protected $table = 'tbl_ads';
}
