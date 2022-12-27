<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Payment;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(10)->create();

         foreach (User::all() as $user) {
            Payment::factory(120)->create(['user_id' => $user->id]);
            TravelPayment::factory(120)->create(['user_id' => $user->id]);
         }
         $approvers = User::where('type', 'APPROVER')->get();
         $someApprover = User::where('type', 'APPROVER')->first();
         $someApproverPayments = Payment::where('user_id', $someApprover->id)->get()->random(30)->all();

        /**
         *  Assert at least one approver has approved payments
         */
         foreach ($someApproverPayments as $someApproverPayment) {
             foreach ($approvers as $approver) {
                 PaymentApproval::factory()->create([
                     'user_id' => $approver->id,
                     'payment_id' => $someApproverPayment->id,
                     'payment_type' => Payment::class,
                     'status' => 'APPROVED'
                 ]);
             }
         }

        $someApproverTravelPayments = TravelPayment::where('user_id', $someApprover->id)->get()->random(30)->all();
        foreach ($someApproverTravelPayments as $someApproverTravelPayment) {
            foreach ($approvers as $approver) {
                PaymentApproval::factory()->create([
                    'user_id' => $approver->id,
                    'payment_id' => $someApproverTravelPayment->id,
                    'payment_type' => TravelPayment::class,
                    'status' => 'APPROVED'
                ]);
            }
        }
    }
}
