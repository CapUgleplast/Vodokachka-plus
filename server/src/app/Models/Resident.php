<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resident extends Model
{
    use hasFactory;

    /**
     * @var array|array[]
     */
    public $timestamps = false;

    public static array $rules = [
        'fio' => ['required', 'max:255'],
        'area' => ['required'],
        'start_date' => ['required', 'date']
    ];
    protected $fillable = [
        'fio',
        'area',
        'start_date',
    ];
}
