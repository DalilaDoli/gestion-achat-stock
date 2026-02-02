<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventaire
 * 
 * @property int $id
 * @property int $mouvement_id
 * @property int $article_id
 * @property int $qte_art
 * @property int $qte_last
 * @property Carbon $date_inv
 * @property Carbon $date_first_art
 * @property int $num_id
 * @property string $pmp
 * @property string $prix_u_achat
 * @property int $emplacement_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Article $article
 * @property Emplacement $emplacement
 * @property Mouvement $mouvement
 *
 * @package App\Models
 */
class Inventaire extends Model
{
	protected $table = 'inventaires';

	protected $guarded = [];

	

	public function article()
	{
		return $this->belongsTo(Article::class);
	}

	public function emplacement()
	{
		return $this->belongsTo(Emplacement::class);
	}

	public function mouvement()
	{
		return $this->belongsTo(Mouvement::class);
	}
}
