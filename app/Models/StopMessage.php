<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Models\Group;
use App\Models\ScheduleContact;
use DB;

class StopMessage extends Model
{
    protected $table = "account_opt_settings";
    public $timestamps = false;
}
