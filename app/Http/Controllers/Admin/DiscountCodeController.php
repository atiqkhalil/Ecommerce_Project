<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DiscountCoupon;
use App\Http\Controllers\Controller;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $discountCoupons = DiscountCoupon::latest();

        if (!empty($request->keyword)) {
            $discountCoupons = $discountCoupons->where('name', 'like', '%' . $request->keyword . '%');
            $discountCoupons = $discountCoupons->orWhere('code', 'like', '%' . $request->keyword . '%');
        }        

        $discountCoupons =  $discountCoupons->paginate(10);
        return view('admin.coupon.list',compact('discountCoupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required|in:0,1',
            'starts_at' => [
                'required',
                'date_format:Y-m-d H:i:s',
                function ($attribute, $value, $fail) {
                    $now = Carbon::now();
                    $startsAt = Carbon::createFromFormat('Y-m-d H:i:s', $value);
                    if ($startsAt->lte($now)) {
                        $fail('The starting date must be greater than the current date.');
                    }
                },
            ],
            'expires_at' => [
                'required',
                'date_format:Y-m-d H:i:s',
                function ($attribute, $value, $fail) use ($request) {
                    if (!empty($request->starts_at)) {
                        $startsAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);
                        $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $value);
                        if ($expiresAt->lte($startsAt)) {
                            $fail('The expiry date must be greater than the start date.');
                        }
                    }
                },
            ],
        ]);

        $discountCode = new DiscountCoupon();
        $discountCode->code = $request->code;
        $discountCode->name = $request->name;
        $discountCode->description = $request->description;
        $discountCode->max_uses = $request->max_uses;
        $discountCode->max_uses_user = $request->max_uses_user;
        $discountCode->type = $request->type;
        $discountCode->discount_amount = $request->discount_amount;
        $discountCode->min_amount = $request->min_amount;
        $discountCode->status = $request->status;
        $discountCode->starts_at = $request->starts_at;
        $discountCode->expires_at = $request->expires_at;
        $discountCode->save();

        return redirect()->route('discountcode.index')->with('success', 'Coupon Code Generated Successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupondetails = DiscountCoupon::find($id);
        return view('admin.coupon.edit',compact('coupondetails'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required|in:0,1',
            'starts_at' => [
                'required',
                'date_format:Y-m-d H:i:s',
                function ($attribute, $value, $fail) {
                    $now = Carbon::now();
                    $startsAt = Carbon::createFromFormat('Y-m-d H:i:s', $value);
                    if ($startsAt->lte($now)) {
                        $fail('The starting date must be greater than the current date.');
                    }
                },
            ],
            'expires_at' => [
                'required',
                'date_format:Y-m-d H:i:s',
                function ($attribute, $value, $fail) use ($request) {
                    if (!empty($request->starts_at)) {
                        $startsAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);
                        $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $value);
                        if ($expiresAt->lte($startsAt)) {
                            $fail('The expiry date must be greater than the start date.');
                        }
                    }
                },
            ],
        ]);

        $discountCode = DiscountCoupon::find($id);
        $discountCode->code = $request->code;
        $discountCode->name = $request->name;
        $discountCode->description = $request->description;
        $discountCode->max_uses = $request->max_uses;
        $discountCode->max_uses_user = $request->max_uses_user;
        $discountCode->type = $request->type;
        $discountCode->discount_amount = $request->discount_amount;
        $discountCode->min_amount = $request->min_amount;
        $discountCode->status = $request->status;
        $discountCode->starts_at = $request->starts_at;
        $discountCode->expires_at = $request->expires_at;
        $discountCode->save();

        return redirect()->route('discountcode.index')->with('success', 'Coupon Code Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discountCoupon = DiscountCoupon::find($id);
        $discountCoupon->delete();

        return redirect()->route('discountcode.index')->with('success', 'Coupon Code Deleted Successfully!');
    }
}
