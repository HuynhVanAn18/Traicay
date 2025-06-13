<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'cate_blog_id','post_title','post_views','post_slug', 'post_desc', 'post_content','post_meta_desc','post_keywords','post_image','post_status'
    ];
    protected $primaryKey = 'post_id';
 	protected $table = 'tbl_posts';
 	public function cate_post(){
 		return $this->belongsTo('App\Models\Cateblog','cate_blog_id');
 	}
}
