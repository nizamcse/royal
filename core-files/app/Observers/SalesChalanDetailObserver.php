<?php

namespace App\Observers;

use App\Model\ProductionProduct;
use App\Model\SalesChalanDetail;
use App\Model\SalesOrderDetail;

class SalesChalanDetailObserver
{
    /**
     * Handle the sales chalan detail "created" event.
     *
     * @param  \App\Model\SalesChalanDetail  $salesChalanDetail
     * @return void
     */
    public function created(SalesChalanDetail $salesChalanDetail)
    {
        $sales_order_detail = SalesOrderDetail::findOrFail($salesChalanDetail->sales_order_details_id);
        if($salesChalanDetail->chalan->type){
            $returned_quantity = $sales_order_detail->returned_quantity + $salesChalanDetail->received_qty;
            $sales_order_detail->update([
                'returned_quantity'    => $returned_quantity,
            ]);

            $production_product = ProductionProduct::where('good_id','=',$sales_order_detail->good_id)->first();
            if($production_product){
                $quantity = $production_product->quantity + $salesChalanDetail->received_qty;
                $production_product->update([
                    'quantity'  => $quantity
                ]);
            }else{
                ProductionProduct::create([
                    'good_id'   => $sales_order_detail->good_id,
                    'quantity'  => $salesChalanDetail->received_qty
                ]);
            }

        }else{
            $delivered_qty = $sales_order_detail->delivered_quantity + $salesChalanDetail->received_qty;
            $remaining_quantity = $sales_order_detail->remaining_quantity - $salesChalanDetail->received_qty;
            $sales_order_detail->update([
                'delivered_quantity'    => $delivered_qty,
                'remaining_quantity'    => $remaining_quantity,
            ]);

            $production_product = ProductionProduct::where('good_id','=',$sales_order_detail->good_id)->first();
            if($production_product){
                $quantity = $production_product->quantity - $salesChalanDetail->received_qty;

                $production_product->update([
                    'quantity'  => $quantity
                ]);
            }else{
                ProductionProduct::create([
                    'good_id'   => $sales_order_detail->good_id,
                    'quantity'  => $salesChalanDetail->received_qty * (-1)
                ]);
            }

        }
    }

    /**
     * Handle the sales chalan detail "updated" event.
     *
     * @param  \App\Model\SalesChalanDetail  $salesChalanDetail
     * @return void
     */
    public function updated(SalesChalanDetail $salesChalanDetail)
    {
        //
    }

    /**
     * Handle the sales chalan detail "deleted" event.
     *
     * @param  \App\Model\SalesChalanDetail  $salesChalanDetail
     * @return void
     */
    public function deleted(SalesChalanDetail $salesChalanDetail)
    {
        //
    }

    /**
     * Handle the sales chalan detail "restored" event.
     *
     * @param  \App\Model\SalesChalanDetail  $salesChalanDetail
     * @return void
     */
    public function restored(SalesChalanDetail $salesChalanDetail)
    {
        //
    }

    /**
     * Handle the sales chalan detail "force deleted" event.
     *
     * @param  \App\Model\SalesChalanDetail  $salesChalanDetail
     * @return void
     */
    public function forceDeleted(SalesChalanDetail $salesChalanDetail)
    {
        //
    }
}
