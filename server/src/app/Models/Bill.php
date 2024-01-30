<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use hasFactory;

    /**
     * @var array|array[]
     */
    public $timestamps = false;

    public static array $rules = [
        'period_id' => ['required', 'unique'],
        'resident_id' => ['required'],
        'amount_rub' => ['required']
    ];
    protected $fillable = [
        'resident_id',
        'period_id',
        'amount_rub',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}
