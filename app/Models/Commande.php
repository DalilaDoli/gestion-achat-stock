<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commande
 * 
 * @property int $id
 * @property string $code
 * @property Carbon $date
 * @property int $fournisseur_id
 * @property int $user_id
 * @property int $dmachat_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Dmachat $dmachat
 * @property Fournisseur $fournisseur
 * @property User $user
 * @property Collection|DtCommande[] $dt_commandes
 * @property Collection|Reception[] $receptions
 *
 * @package App\Models
 */
class Commande extends Model
{
	protected $table = 'commandes';

	protected $guarded = [];


	public function dmachat()
	{
		return $this->belongsTo(Dmachat::class);
	}

	public function fournisseur()
	{
		return $this->belongsTo(Fournisseur::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function dt_commandes()
	{
		return $this->hasMany(DtCommande::class);
	}

	public function receptions()
	{
		return $this->hasMany(Reception::class);
	}

	public function statuts()
	{
		return $this->hasMany(Statut::class,'num_id');
	}
}
