<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

//默认就是goods表.
class PdtImages extends Model
{
    protected $table = 'pdt_images'; //指定一个表名
    protected $primaryKey = 'id'; //指定一个ID..
}
