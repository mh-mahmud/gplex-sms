<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispositionCode extends Model
{
    protected $table='sms_disposition_code';
    public $timestamps = false;
    protected $primaryKey = 'disposition_id';
	
}