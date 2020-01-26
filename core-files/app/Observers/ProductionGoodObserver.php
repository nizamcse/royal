<?php

namespace App\Observers;

use App\Model\ProducedGood;
use App\Model\Production;
use App\Model\ProductionGood;
use App\Model\ProductionProduct;

class ProductionGoodObserver
{
    /**
     * Handle the production good "created" event.
     *
     * @param  \App\Model\ProductionGood  $productionGood
     * @return void
     */
    public function created(ProductionGood $productionGood)
    {
        $production_product = ProductionProduct::where('good_id','=',$productionGood->good_id)->first();
        if($production_product){
            $quantity = $production_product->quantity + $productionGood->quantity;

            $production_product->update([
                'quantity'  => $quantity
            ]);
        }else{
            ProductionProduct::create([
                'good_id'   => $productionGood->good_id,
                'quantity'  => $productionGood->quantity
            ]);
        }


        $produced_good = ProducedGood::findOrFail($productionGood->produced_good_id);

        $released_quantity = $produced_good->released_quantity + $productionGood->quantity;
        $remaining_quantity = $produced_good->remaining_quantity - $productionGood->quantity;
        $produced_good->update([
            'released_quantity'     => $released_quantity,
            'remaining_quantity'    => $remaining_quantity
        ]);

        $remains = ProducedGood::where('remaining_quantity','>',0)->count();

        if($remains == 0){
            Production::findOrFail($produced_good->production_id)->update([
                'status'    => 1
            ]);
        }

    }

    /**
     * Handle the production good "updated" event.
     *
     * @param  \App\Model\ProductionGood  $productionGood
     * @return void
     */
    public function updated(ProductionGood $productionGood)
    {
        //
    }

    /**
     * Handle the production good "deleted" event.
     *
     * @param  \App\Model\ProductionGood  $productionGood
     * @return void
     */
    public function deleted(ProductionGood $productionGood)
    {
        //
    }

    /**
     * Handle the production good "restored" event.
     *
     * @param  \App\Model\ProductionGood  $productionGood
     * @return void
     */
    public function restored(ProductionGood $productionGood)
    {
        //
    }

    /**
     * Handle the production good "force deleted" event.
     *
     * @param  \App\Model\ProductionGood  $productionGood
     * @return void
     */
    public function forceDeleted(ProductionGood $productionGood)
    {
        //
    }
}
