<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSettings extends Model
{
    protected $table = "contact_custom_settings";
	public $timestamps = false;
	protected $fillable = ['account_id', 'custom_0_name'];
	protected $primaryKey = 'account_id';
	const CREATED_AT = null;
	const UPDATED_AT = null;
}
