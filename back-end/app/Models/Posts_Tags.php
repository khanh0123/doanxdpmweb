<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Posts_tags extends Model
{
    protected $table = 'posts_tags';
	public $timestamp = false;

}