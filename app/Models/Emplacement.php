<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Emplacement
 * 
 * @property int $id
 * @property string $code
 * @property string $libelle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Article[] $articles
 *
 * @package App\Models
 */
class Emplacement extends Model
{
	protected $table = 'emplacements';

	protected $guarded = [];

	public function articles()
	{
		return $this->hasMany(Article::class);
	}
}
