<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Consomation
 * 
 * @property int $id
 * @property string $code
 * @property Carbon $date
 * @property int $client_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Client $client
 * @property User $user
 * @property Collection|DtConsomation[] $dt_consomations
 *
 * @package App\Models
 */
class Consomation extends Model
{
	protected $table = 'consomations';

	protected $guarded = [];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function dt_consomations()
	{
		return $this->hasMany(DtConsomation::class);
	}
}
