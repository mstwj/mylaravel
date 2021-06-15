<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

//默认就是goods表.
class Category extends Model
{
    protected $table = 'category'; //指定一个表名
    protected $primaryKey = 'id'; //指定一个ID..
}
