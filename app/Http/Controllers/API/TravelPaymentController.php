<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTravelPaymentRequest;
use App\Http\Resources\TravelPaymentResource;
use App\Models\TravelPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TravelPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return TravelPaymentResource::collection(
            TravelPayment::where('user_id', Auth::user()->id)->get
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTravelPaymentRequest $request
     * @return TravelPaymentResource
     */
    public function store(StoreTravelPaymentRequest $request)
    {
        $request->validated($request->all());
        $travelPayment = TravelPayment::create([
            'user_id' => Auth::user()->id, // or some other user_id? What if auth user is not an approver, does it make any difference?
            'amount' => $request->amount
        ]);

        return new TravelPaymentResource($travelPayment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return TravelPaymentResource | JsonResponse
     */
    public function show($id)
    {
        /*
         * Not clarified who is authorized to perform this action
         */
//        if (Auth::user()->id != $travelPayment->user_id) {
//            return response()->json([
//                'status' => 'An error has occurred...',
//                'message' => 'You are not authorized to perform this action'
//            ], 403);
//        }
        if ($travelPayment = TravelPayment::whereId($id)->first()) {
            return new TravelPaymentResource($travelPayment);
        } else {
            return response()->json([
                'message' => 'Travel Payment not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return TravelPaymentResource | JsonResponse
     */
    public function update(Request $request, $id)
    {
        /*
         * Not clarified who is authorized to perform this action
         */
//        if (Auth::user()->id != $travelPayment->user_id) {
//            return response()->json([
//                'status' => 'An error has occurred...',
//                'message' => 'You are not authorized to perform this action'
//            ], 403);
//        }
        if ($travelPayment = TravelPayment::whereId($id)->first()) {
            $travelPayment->update($request->all());

            return new TravelPaymentResource($travelPayment);
        } else {
            return response()->json([
                'message' => 'Payment not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        /*
         * Not clarified who is authorized to perform this action
         */
//        if (Auth::user()->id != $travelPayment->user_id) {
//            return response()->json([
//                'status' => 'An error has occurred...',
//                'message' => 'You are not authorized to perform this action'
//            ], 403);
//        }
        if ($travelPayment = TravelPayment::whereId($id)->first()) {
            $travelPayment->delete();

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
