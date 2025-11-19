<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestEdit extends Model
{
    protected $fillable = [
        'class_number',
        'class_number_practical',
        'class_name',
        'group_url',
        'note'
    ];
    
}
