<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mouvement
 * 
 * @property int $id
 * @property int $typemouvement_id
 * @property Carbon $date_mouv
 * @property int $num_id
 * @property int $article_id
 * @property int $qte_mouv
 * @property string $pmp
 * @property int $emplacement_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Article $article
 * @property Emplacement $emplacement
 * @property Typemouvement $typemouvement
 * @property Collection|Inventaire[] $inventaires
 *
 * @package App\Models
 */
class Mouvement extends Model
{
	protected $table = 'mouvements';

	protected $guarded = [];


	public function article()
	{
		return $this->belongsTo(Article::class);
	}

	public function emplacement()
	{
		return $this->belongsTo(Emplacement::class);
	}

	public function typemouvement()
	{
		return $this->belongsTo(Typemouvement::class);
	}

	public function inventaires()
	{
		return $this->hasMany(Inventaire::class);
	}
}
