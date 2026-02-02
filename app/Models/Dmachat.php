<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dmachat
 * 
 * @property int $id
 * @property string $code
 * @property Carbon $date
 * @property int $fournisseur_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Fournisseur $fournisseur
 * @property User $user
 * @property Collection|Commande[] $commandes
 * @property Collection|DtDmachat[] $dt_dmachats
 *
 * @package App\Models
 */
class Dmachat extends Model
{
	protected $table = 'dmachats';

	protected $guarded = [];


	public function fournisseur()
	{
		return $this->belongsTo(Fournisseur::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function commandes()
	{
		return $this->hasMany(Commande::class);
	}

	public function dt_dmachats()
	{
		return $this->hasMany(DtDmachat::class,'dmachat_id');
	}

	public function statuts()
	{
		return $this->hasMany(Statut::class,'num_id');
	}

}
