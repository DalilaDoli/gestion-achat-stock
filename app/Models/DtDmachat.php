<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DtDmachat
 * 
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property int $dmachat_id
 * @property int $qte
 * @property string $prix_u
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Article $article
 * @property Dmachat $dmachat
 * @property User $user
 *
 * @package App\Models
 */
class DtDmachat extends Model
{
	protected $table = 'dt_dmachats';

	protected $guarded = [];

	public function article()
	{
		return $this->belongsTo(Article::class);
	}

	public function dmachat()
	{
		return $this->belongsTo(Dmachat::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
