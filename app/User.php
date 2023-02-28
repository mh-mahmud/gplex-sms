<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'user';

    function __construct()
    {
      $pbxDbName = config('database.pbx_db_name');
      $this->table = $pbxDbName . '.user';
    }
    
    /**
     * skip remember token when login/logout
     */
    public function setRememberToken($value)
    {
    }
    /**
     * define primary key
     */
    protected $primaryKey = 'userid';
}
