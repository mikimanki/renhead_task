<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovePaymentRequest;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    /**
     * @param ApprovePaymentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approvePayment(ApprovePaymentRequest $request)
    {
        if (Auth::user()->type != 'APPROVER') {
            return response()->json([
                'status' => 'An error has occurred...',
                'message' => 'You are not authorized to perform this action'
            ], 403);
        }
        if ($request->type == 'payment') {
            $result = Auth::user()->paymentApprovals()->attach(
                $request->payment_id,
                [ 'status' => $request->status]
            );
        } else {
            $result = Auth::user()->travelPaymentApprovals()->attach(
                $request->payment_id,
                [ 'status' => $request->status]
            );
        }

        return $result;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportAllApprovers()
    {
        $sum = [];
        $approvers = User::where('type', 'APPROVER')->get();

        foreach ($approvers as $approver) {
            $sum[$approver->id] = 0;
            foreach ($approver->payments()->get() as $payment) {
                if ($payment->isApproved()) {
                    $sum[$approver->id] += $payment->total_amount;
                }
            }
            foreach ($approver->travelPayments()->get() as $travelPayment) {
                if ($travelPayment->isApproved()) {
                    $sum[$approver->id] = (float)$sum[$approver->id] + (float)$travelPayment->amount;
                }
            }
        }

        return response()->json([
            'report' => $sum
        ]);

    }

    public function isApproved(Request $request)
    {
        $payment = new Payment();
        return $payment->isApproved();
    }
}
