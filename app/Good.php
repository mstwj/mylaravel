<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//默认就是goods表.
class Good extends Model
{
    protected $table = 'good'; //指定一个表名
    protected $primaryKey = 'id'; //指定一个ID..
    //public $timestamps = false; //指定不要默认的2个字段..


}
