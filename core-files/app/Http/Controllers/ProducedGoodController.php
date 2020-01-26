<?php

namespace App\Http\Controllers;

use App\Model\Good;
use App\Model\ProducedGood;
use App\Model\Production;
use App\Model\ProductionGood;
use Illuminate\Http\Request;

class ProducedGoodController extends Controller
{
    public function create($company_id,$id){
        $production = Production::where([
            'company_id'    => $company_id,
            'id'            => $id
        ])->firstOrFail();
        $goods = Good::whereDoesntHave('producedGoods',function($q)use($id){
            $q->where('production_id','=',$id);
        })->get();

        return view('admin.production.create-production-product')->with([
            'production'    => $production,
            'goods'         => $goods
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
            $produced_good = ProducedGood::create([
                'production_id'     => $production->id,
                'good_id'           => $product['id'],
                'produced_quantity' => $product['produced_qty'],
                'remaining_quantity' => $product['produced_qty'],
            ]);
            ProductionGood::create([
                'produced_good_id'  => $produced_good->id,
                'quantity'          => $product['released_qty'],
                'good_id'           => $produced_good->good_id
            ]);

        }


        return redirect()->route('productions',['company_id' => $request->route('company_id')])->withMessage([
            'status'    => true,
            'text'      => 'Successfully created production products.'
        ]);

    }

}
