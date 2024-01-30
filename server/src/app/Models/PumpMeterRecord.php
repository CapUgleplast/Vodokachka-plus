<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PumpMeterRecord extends Model
{
    use hasFactory;

    /**
     * @var array|array[]
     */
    public $timestamps = false;

    public $table = 'pump_meter_records';
    public static array $rules = [
        'period_id' => ['required', 'unique'],
        'amount_volume' => ['required'],
    ];
    protected $fillable = [
        'period_id',
        'amount_volume',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
}
