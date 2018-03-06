<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'name',
	];

	public function transactions()
	{
		return $this->hasMany('App\Transaction');
	}
}
