<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class sub_academic_detail extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];
}
