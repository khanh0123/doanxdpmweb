<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_group_permission extends Model
{
    protected $table = 'admin_group_permission';
    protected $fillable = ['gad_id','per_id'];
    protected $primaryKey = 'gad_id';
    public $incrementing = false;
}
