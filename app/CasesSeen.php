<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CasesSeen extends Model
{
    protected $table    = 'cases_seen';
    protected $fillable = ['cid','uid'];
	protected $primaryKey = ['cid','uid'];
	public $incrementing = false;
	const UPDATED_AT = "when";
	const CREATED_AT = "when";
}
