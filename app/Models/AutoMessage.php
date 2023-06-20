<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Models\Group;
use App\Models\ScheduleContact;
use DB;

class AutoMessage extends Model
{
    protected $table = "auto_reply_settings";
    public $timestamps = false;
}
