<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $nom
 * @property string $username
 * @property string $password
 * @property int $personnel_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Personnel $personnel
 * @property Collection|Commande[] $commandes
 * @property Collection|Consomation[] $consomations
 * @property Collection|Dmachat[] $dmachats
 * @property Collection|DtDmachat[] $dt_dmachats
 * @property Collection|Reception[] $receptions
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	// protected $table = 'users';

	protected $guarded = [];


	
	public function personnel()
	{
		return $this->belongsTo(Personnel::class);
	}

	public function commandes()
	{
		return $this->hasMany(Commande::class);
	}

	public function consomations()
	{
		return $this->hasMany(Consomation::class);
	}

	public function dmachats()
	{
		return $this->hasMany(Dmachat::class);
	}

	public function dt_dmachats()
	{
		return $this->hasMany(DtDmachat::class);
	}

	public function receptions()
	{
		return $this->hasMany(Reception::class);
	}
}
