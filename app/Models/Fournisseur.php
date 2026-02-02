<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fournisseur
 * 
 * @property int $id
 * @property string $code
 * @property string $nom
 * @property string $adresse
 * @property string $rc
 * @property string $ai
 * @property string $nif
 * @property string $payment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Commande[] $commandes
 * @property Collection|Dmachat[] $dmachats
 * @property Collection|Reception[] $receptions
 *
 * @package App\Models
 */
class Fournisseur extends Model
{
	protected $table = 'fournisseurs';

	protected $guarded = [];

	public function commandes()
	{
		return $this->hasMany(Commande::class);
	}

	public function dmachats()
	{
		return $this->hasMany(Dmachat::class);
	}

	public function receptions()
	{
		return $this->hasMany(Reception::class);
	}
}
