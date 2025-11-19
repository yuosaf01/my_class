<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
	'class_number',
	'class_number_practical',
	'class_name',
	'group_url',
	'note'
    ];

    public function requests() {

        return $this->hasMany(RequestEdit::class);

    }

    public function reports() {

        return $this->hasMany(Report::class, 'class_number', 'class_number');

    }

}
