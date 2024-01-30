<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tariff extends Model
{
    use hasFactory;

    /**
     * @var array|array[]
     */
    public $timestamps = false;

    public static array $rules = [
        'period_id' => ['required', 'unique'],
        'price_per_cubic_meter' => ['required'],
    ];
    protected $fillable = [
        'period_id',
        'price_per_cubic_meter',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
}
