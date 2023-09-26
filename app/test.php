<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class test extends Model
{
    public $timestamps = false;
    protected $fillable = [
       'id_test',
       'name',
       'id_staff'
    ];
    protected $primaryKey = 'id_test';
    protected $table = 'test';
}
