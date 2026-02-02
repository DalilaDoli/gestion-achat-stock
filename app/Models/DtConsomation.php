<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DtConsomation
 * 
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property int $consomation_id
 * @property int $qte
 * @property string $pmp
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Article $article
 * @property Consomation $consomation
 *
 * @package App\Models
 */
class DtConsomation extends Model
{
	protected $table = 'dt_consomations';

	protected $guarded = [];


	public function article()
	{
		return $this->belongsTo(Article::class);
	}

	public function consomation()
	{
		return $this->belongsTo(Consomation::class);
	}
}
