<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typestatut extends Model
{
    protected $guarded=[];

    public function statuts()
	{
		return $this->hasMany(Statut::class);
	}
}
