<?php

namespace App\Http\Controllers;

use App\Model\ProducedGood;
use App\Model\Production;
use App\Model\ProductionGood;
use Illuminate\Http\Request;

class ProductionGoodController extends Controller
{
    public function create($company_id,$id){

        $production = Production::where([
            ['company_id','=',$company_id],
            ['id','=',$id]
        ])->firstOrFail();

        $produced_goods = ProducedGood::with(['good'])->where([
            ['production_id','=',$id]
        ])->get();

        return view('admin.production.release-production-product')->with([
            'produced_goods'    => $produced_goods,
            'production'        => $production
        ]);
    }

    public function store(Request $request,$company_id,$id){
        $production = Production::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->firstOrFail();
        $products = $request->input('products') ? $request->input('products') : [];
        foreach ($products as $product){
            $rel_qty = 0;
            if($product['released_qty'] <=0)
                continue;
            $produced_good = ProducedGood::findOrFail($product['id']);

            ProductionGood::create([
                'produced_good_id'  => $produced_good->id,
                'quantity'          => $product['released_qty'],
                'good_id'           => $produced_good->good_id
            ]);

        }


        return redirect()->route('productions',['company_id' => $request->route('company_id')])->withMessage([
            'status'    => true,
            'text'      => 'Successfully created production release products.'
        ]);
    }
}
