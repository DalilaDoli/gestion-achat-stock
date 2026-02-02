<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reception
 * 
 * @property int $id
 * @property string $code
 * @property Carbon $date
 * @property string $Num_bl
 * @property int $fournisseur_id
 * @property int $user_id
 * @property int $commande_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Commande $commande
 * @property Fournisseur $fournisseur
 * @property User $user
 * @property Collection|DtReception[] $dt_receptions
 *
 * @package App\Models
 */
class Reception extends Model
{
	protected $table = 'receptions';

	protected $guarded = [];


	public function commande()
	{
		return $this->belongsTo(Commande::class);
	}

	public function fournisseur()
	{
		return $this->belongsTo(Fournisseur::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function dt_receptions()
	{
		return $this->hasMany(DtReception::class);
	}

	public function statuts()
	{
		return $this->hasMany(Statut::class,'num_id');
	}
}
