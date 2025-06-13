<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cateblog extends Model
{
  	public $timestamps = false; //set time to false
    protected $fillable = [
    	'cate_blog_name', 'cate_blog_desc', 'cate_blog_status','cate_blog_slug'
    ];
    protected $primaryKey = 'cate_blog_id';
 	protected $table = 'tbl_category_blog';
}
