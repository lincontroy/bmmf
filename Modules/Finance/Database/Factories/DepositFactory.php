<?php

namespace Modules\Finance\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Finance\App\Enums\DepositEnum;
use Modules\Finance\App\Models\Deposit;

class DepositFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Deposit::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => fake()->randomElement([
                1,
                4,
            ]),
            'user_id' => fake()->randomElement([
                'EZGQEC7C',
                'DZH0AWDZ',
            ]),
            'date' => Carbon::now(),
            'method' => 'paypal',
            'amount' => fake()->randomElement([500.000, 1000.000]),
            'fees' => fake()->randomElement([5, 10]),
            'status' => fake()->randomElement([
                DepositEnum::CONFIRM->value,
                DepositEnum::PENDING->value,
                DepositEnum::PROCESSING->value,
            ])
        ];
    }
}

