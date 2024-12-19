<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainee extends Model

{	
	protected $table = 'trainees';
    protected $primaryKey = 'nisn_trainee';
    protected $fillable = [
    	'nisn_trainee', 'nama_trainee', 'email_trainee', 'no_hp_trainee', 'ttl_trainee', 'jns_kelamin_trainee', 'alamat_trainee', 'departemen_trainee', 'foto_trainee', 'status_trainee', 'id_user', 'id_departemen'
    ];
}
