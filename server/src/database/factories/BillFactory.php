<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\Period;
use App\Models\PumpMeterRecord;
use App\Models\Resident;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class BillFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected $model = Bill::class;

    public function definition(): array
    {
        $period = Period::inRandomOrder()->first()->id;

        $resident_id = Resident::inRandomOrder()->first()->id;

        $resident_area = Resident::find($resident_id)->area;

        $tariff = Tariff::where('period_id', '=', $period)->first();
        $pumpMeterRecord = PumpMeterRecord::where('period_id', '=', $period)->first();

        if(!$pumpMeterRecord){
            $pumpMeterRecord = new PumpMeterRecord();
            $pumpMeterRecord->period_id = $period;
            $pumpMeterRecord->amount_volume = fake()->numberBetween(500, 1000);
            $pumpMeterRecord->save();
        }

        $totalWaterConsumption = $pumpMeterRecord->amount_volume;

        $residentArea = $resident_area;

        if(!$tariff){
            $tariff = new Tariff();
            $tariff->period_id = $period;
            $tariff->price_per_cubic_meter = fake()->numberBetween(500, 1000);
            $tariff->save();
        }

        $tariffPrice = $tariff->price_per_cubic_meter;

        $amountRub = ($totalWaterConsumption / $residentArea) * $tariffPrice;

        return [
            'period_id' => $period,
            'resident_id' => $resident_id,
            'amount_rub' => $amountRub
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */

}
