<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company_id)
    {
        $customers = Customer::where('company_id',$company_id)->orderBy('name','asc')->get();
        return view('admin.customer.index')->with('customers', $customers);

    }

    public function getJsonCustomers($company_id){

        $customers_query = Customer::where('company_id', '=' ,$company_id)->orderBy('name','asc');
        $customers =$customers_query->get();
        return response()->json($customers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'  => 'required',
            'contact_no'  => 'required',
            'address'  => 'required',
        ]);
        Customer::create($request->all());
        return redirect()->back()->withSuccess("Customer has saved successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($company_id, $id)
    {
        //
    }

    public function getJsonCustomer($company_id, $id){
        $customer = Customer::where([
                'company_id'    => $company_id,
                'id'            => $id,
            ])->first();
        return response()->json($customer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update($company_id, $id, Request $request)
    {
        $request->all();
        $this->validate($request,[
            'name'  => 'required',
            'contact_no'  => 'required',
            'address'  => 'required',
        ]);
        Customer::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->update($request->only('name','contact_no','address'));
        return redirect()->back()->withSuccess("Customer has updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($company_id, $id)
    {
        Customer::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->delete();
        return redirect()->back()->withSuccess("Customer has deleted successfully.");
    }
}
