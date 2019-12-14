<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    public $table = 'clients';

    public $fillable = ['id', 'first_name', 'last_name', 'phone', 'image', 'email'];
}//-- end of model
