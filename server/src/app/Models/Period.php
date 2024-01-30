<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Period extends Model
{
    use hasFactory;

    /**
     * @var array|array[]
     */
    public $timestamps = false;

    public static array $rules = [
        'begin_date' => ['required', 'date', 'unique'],
        'end_date' => ['required', 'date',  'unique']
    ];
    protected $fillable = [
        'begin_date',
        'end_date',
    ];
}
