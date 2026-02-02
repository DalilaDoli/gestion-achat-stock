<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DtReception
 * 
 * @property int $id
 * @property int $article_id
 * @property int $reception_id
 * @property int $qte_recu
 * @property string $pmp
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Article $article
 * @property Reception $reception
 *
 * @package App\Models
 */
class DtReception extends Model
{
	protected $table = 'dt_receptions';

	protected $guarded = [];

	
	public function article()
	{
		return $this->belongsTo(Article::class);
	}

	public function reception()
	{
		return $this->belongsTo(Reception::class);
	}
}
