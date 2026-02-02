<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Typemouvement
 * 
 * @property int $id
 * @property string $code
 * @property string $libelle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Mouvement[] $mouvements
 *
 * @package App\Models
 */
class Typemouvement extends Model
{
	protected $table = 'typemouvements';

	protected $guarded = [];

	public function mouvements()
	{
		return $this->hasMany(Mouvement::class);
	}
}
