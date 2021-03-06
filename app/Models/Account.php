<?php

namespace App\Models;

use App\Utils\Traits\MakesHash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Account extends BaseModel
{
    use SoftDeletes;
    use PresentableTrait;
    use MakesHash;

    /**
     * @var string
     */
    protected $presenter = 'App\Models\Presenters\AccountPresenter';

    /**
     * @var array
     */
    protected $fillable = [
        'plan',
        'plan_term',
        'plan_price',
        'plan_paid',
        'plan_started',
        'plan_expires',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'promo_expires',
        'discount_expires',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function default_company()
    {
        return $this->hasOne(Company::class, 'default_company_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
