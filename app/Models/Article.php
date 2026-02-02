<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * 
 * @property int $id
 * @property string $code
 * @property string $libelle
 * @property int $qte
 * @property string $pmp
 * @property int $famillearticle_id
 * @property int $emplacement_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Emplacement $emplacement
 * @property Famillearticle $famillearticle
 * @property Collection|DtCommande[] $dt_commandes
 * @property Collection|DtConsomation[] $dt_consomations
 * @property Collection|DtDmachat[] $dt_dmachats
 * @property Collection|DtReception[] $dt_receptions
 *
 * @package App\Models
 */
class Article extends Model
{
	protected $table = 'articles';

	protected $guarded = [];


	public function emplacement()
	{
		return $this->belongsTo(Emplacement::class);
	}

	public function famillearticle()
	{
		return $this->belongsTo(Famillearticle::class);
	}

	public function dt_commandes()
	{
		return $this->hasMany(DtCommande::class);
	}

	public function dt_consomations()
	{
		return $this->hasMany(DtConsomation::class);
	}

	public function dt_dmachats()
	{
		return $this->hasMany(DtDmachat::class);
	}

	public function dt_receptions()
	{
		return $this->hasMany(DtReception::class);
	}
}
