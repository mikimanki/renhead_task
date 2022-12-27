<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return PaymentResource::collection(
            Payment::where('user_id', Auth::user()->id)->get
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePaymentRequest $request
     * @return PaymentResource
     */
    public function store(StorePaymentRequest $request)
    {
        $request->validated($request->all());
        $payment = Payment::create([
            'user_id' => Auth::user()->id, // or some other user_id? What if auth user is not an approver, does it make any difference?
            'total_amount' => $request->total_amount
        ]);

        return new PaymentResource($payment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return PaymentResource | JsonResponse
     */
    public function show($id)
    {
        /*
         * Not clarified who is authorized to perform this action
         */
//        if (Auth::user()->id != $payment->user_id) {
//            return response()->json([
//                'status' => 'An error has occurred...',
//                'message' => 'You are not authorized to perform this action'
//            ], 403);
//        }
        if ($payment = Payment::whereId($id)->first()) {
            return new PaymentResource($payment);
        } else {
            return response()->json([
                'message' => 'Payment not found'
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return PaymentResource | JsonResponse
     */
    public function update(Request $request, $id)
    {
        /*
         * Not clarified who is authorized to perform this action
         */
//        if (Auth::user()->id != $payment->user_id) {
//            return response()->json([
//                'status' => 'An error has occurred...',
//                'message' => 'You are not authorized to perform this action'
//            ], 403);
//        }
        if ($payment = Payment::whereId($id)->first()) {
            $payment->update($request->all());

            return new PaymentResource($payment);
        } else {
            return response()->json([
                'message' => 'Payment not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        /*
         * Not clarified who is authorized to perform this action
         */
//        if (Auth::user()->id != $payment->user_id) {
//            return response()->json([
//                'status' => 'An error has occurred...',
//                'message' => 'You are not authorized to perform this action'
//            ], 403);
//        }
        if ($payment = Payment::whereId($id)->first()) {
            $payment->delete();

            return response()->json([
                'message' => 'Payment deleted'
            ]);
        } else {
            return response()->json([
                'message' => 'Payment not found'
            ]);
        }
    }
}
