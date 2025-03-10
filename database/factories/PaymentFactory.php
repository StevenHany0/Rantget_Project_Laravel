<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
use App\Models\Contract;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'contract_id' => Contract::factory(), // إنشاء عقد وهمي مرتبط
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'payment_method' => 'Visa',
            'card_number' => $this->faker->creditCardNumber(),
            'payment_date' => Carbon::now()->subMonths(rand(0, 12)), // تاريخ عشوائي خلال السنة الماضية
            'status' => $this->faker->randomElement(['Completed', 'Pending', 'Failed'])
        ];
    }
}
