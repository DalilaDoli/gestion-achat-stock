<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DtCommande
 * 
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property int $commande_id
 * @property int $qte
 * @property string $prix_u
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Article $article
 * @property Commande $commande
 *
 * @package App\Models
 */
class DtCommande extends Model
{
	protected $table = 'dt_commandes';

	protected $guarded = [];


	public function article()
	{
		return $this->belongsTo(Article::class);
	}

	public function commande()
	{
		return $this->belongsTo(Commande::class);
	}
}
