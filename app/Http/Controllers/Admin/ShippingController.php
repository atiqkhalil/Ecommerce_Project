<?php

namespace App\Http\Controllers\admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;

class ShippingController extends Controller
{
    public function create(){
        $countries = Country::get();
        $shippingCharges = ShippingCharge::select('shipping_charges.*','countries.name')
                    ->leftJoin('countries','countries.id','shipping_charges.country_id')->get();
        return view('admin.shipping.create',compact('countries', 'shippingCharges'));
    }

    public function store(Request $request){
        $request->validate([
            'country' => 'required',
            'amount' => 'required|numeric',
        ]);

        $count = ShippingCharge::where('country_id',$request->country)->count();

        if($count>0){
            return redirect()->route('shipping.create')->with('error','Shipping Already Added!');
        }

        $shipping = new ShippingCharge;
        $shipping->country_id = $request->country;
        $shipping->amount = $request->amount;
        $shipping->save();

        return redirect()->route('shipping.create')->with('success','Shipping Added Successfully!');
    }

    public function edit($id){
        $shippingCharge = ShippingCharge::find($id);

        $countries = Country::get();
        return view('admin.shipping.edit',compact('shippingCharge','countries'));
    }

    public function editsave(Request $request,$id){
        $request->validate([
            'country' => 'required',
            'amount' => 'required|numeric',
        ]);

        $shipping = ShippingCharge::findOrFail($id);
        $shipping->country_id = $request->country;
        $shipping->amount = $request->amount;
        $shipping->save();

        return redirect()->route('shipping.create')->with('success','Shipping Updated Successfully!');

    }

    public function delete($id){
        $shippingCharge = ShippingCharge::findOrFail($id);
        $shippingCharge->delete();
        return redirect()->route('shipping.create')->with('success','Shipping Deleted Successfully!');
    }
}
