<?php

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;
use App\Models\Contract;
use App\Models\Payment;
use Database\Seeders\UserSeeder;
use Database\Seeders\ContractSeeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\PaymentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // استدعاء الـ Seeders لإنشاء البيانات الأساسية
        $this->call([
            UserSeeder::class,
            PropertySeeder::class,
            ContractSeeder::class,
            PaymentSeeder::class,
        ]);

        // إنشاء 15 مستخدم (بعضهم ملاك وبعضهم مستأجرين)
        $users = User::factory()->count(15)->create();

        // تحديد الملاك والمستأجرين
        $landlords = $users->where('role', 'landlord');
        $tenants = $users->where('role', 'tenant');

        // التأكد من وجود مستأجرين قبل محاولة الربط
        if ($tenants->count() === 0) {
            $this->command->warn("⚠️ لا يوجد مستأجرون! تأكد من تحديث UserFactory لإنشاء مستأجرين.");
            return;
        }

        // إنشاء 10 عقارات
        $properties = Property::factory()->count(10)->create();

        foreach ($properties as $property) {
            // ربط العقار بـ 1-3 ملاك عشوائيين
            $randomLandlords = $landlords->random(rand(1, 3));
            foreach ($randomLandlords as $landlord) {
                $property->users()->attach($landlord->id, ['role' => 'landlord']);
            }

            // اختيار مستأجر عشوائي فقط إذا كان هناك مستأجرين
            if ($tenants->count() > 0) {
                $tenant = $tenants->random();
                $property->users()->attach($tenant->id, ['role' => 'tenant']);

                // إنشاء عقد بين المستأجر والعقار
                Contract::factory()->create([
                    'property_id' => $property->id,
                    'tenant_id' => $tenant->id,
                ]);
            }
        }

        // إنشاء 20 عملية دفع عشوائية
        Payment::factory()->count(20)->create();
    }
}
