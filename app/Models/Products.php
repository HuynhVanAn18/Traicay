<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'product_name', 'category_id', 'brand_id','product_desc','product_slug','product_content','product_price','product_qty','product_sold','product_image','product_status','product_name_en','product_content_en','product_views'
    ];
    protected $primaryKey = 'product_id';
 	protected $table = 'tbl_product';
 	public function category(){
 		return $this->belongsTo('App\Models\Category','category_id');
 	}
}
