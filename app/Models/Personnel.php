<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Personnel
 * 
 * @property int $id
 * @property string $matricule
 * @property string $nom
 * @property string $prenom
 * @property string $fonction
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Personnel extends Model
{
	protected $table = 'personnels';

	protected $guarded = [];

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
