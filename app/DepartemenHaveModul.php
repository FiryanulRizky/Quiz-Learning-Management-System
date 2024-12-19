<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartemenHaveModul extends Model
{
    protected $table = 'departemen_have_moduls';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_departemen', 'id_modul', 'created_at', 'updated_at'];
}
