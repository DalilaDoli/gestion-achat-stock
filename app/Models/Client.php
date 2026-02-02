<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
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
 * @property Collection|Consomation[] $consomations
 *
 * @package App\Models
 */
class Client extends Model
{
	protected $table = 'clients';

	protected $guarded = [];

	public function consomations()
	{
		return $this->hasMany(Consomation::class);
	}
}
