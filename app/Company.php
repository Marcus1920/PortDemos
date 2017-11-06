<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {
	protected $fillable = array("name", "address", "company_number", "company_email", "contact_number", "contact_email");
}
