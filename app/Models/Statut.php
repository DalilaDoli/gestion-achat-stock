<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    protected $guarded=[];

    public function typestatut()
	{
		return $this->belongsTo(Typestatut::class);
	}
}
