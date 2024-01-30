<?php

namespace Database\Factories;

use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PeriodFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected $model = Period::class;

    public function definition(): array
    {
        $beginDate = Carbon::now()->setYear(fake()->numberBetween(2000, 2023))->setMonth(fake()->numberBetween(1, 12))->startOfMonth();

        $endDate = $beginDate->copy()->endOfMonth();

        return [
            'begin_date' => $beginDate,
            'end_date' => $endDate,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */

}
