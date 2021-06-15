<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

//默认就是goods表.
//[mysqld]
//skip-grant-tables
//用户名root 密码:111111
class TempPhone extends Model
{
    protected $table = 'temp_phone'; //指定一个表名
    protected $primaryKey = 'id'; //指定一个ID..
    public $timestamps = false;
}
