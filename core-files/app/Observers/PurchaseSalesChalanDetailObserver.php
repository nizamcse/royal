<?php

namespace App\Observers;

use App\Model\ProductionProduct;
use App\Model\PurchaseSalesChalanDetail;
use App\Model\PurchaseSalesDetail;

class PurchaseSalesChalanDetailObserver
{
    /**
     * Handle the sales chalan detail "created" event.
     *
     * @param  \App\Model\PurchaseSalesChalanDetail  $purchaseSalesChalanDetail
     * @return void
     */
    public function created(PurchaseSalesChalanDetail $purchaseSalesChalanDetail)
    {
        $sales_order_detail = PurchaseSalesDetail::findOrFail($purchaseSalesChalanDetail->purchase_sales_detail_id);
        if($purchaseSalesChalanDetail->chalan->type == 4){
            $returned_quantity = $sales_order_detail->returned_quantity + $purchaseSalesChalanDetail->received_qty;
            $sales_order_detail->update([
                'returned_quantity'    => $returned_quantity,
            ]);
        }else{
            $delivered_qty = $sales_order_detail->delivered_quantity + $purchaseSalesChalanDetail->received_qty;
            $remaining_quantity = $sales_order_detail->remaining_quantity - $purchaseSalesChalanDetail->received_qty;
            $sales_order_detail->update([
                'delivered_quantity'    => $delivered_qty,
                'remaining_quantity'    => $remaining_quantity,
            ]);
        }
    }

    /**
     * Handle the sales chalan detail "updated" event.
     *
     * @param  \App\Model\PurchaseSalesChalanDetail  $purchaseSalesChalanDetail
     * @return void
     */
    public function updated(PurchaseSalesChalanDetail $purchaseSalesChalanDetail)
    {
        //
    }

    /**
     * Handle the sales chalan detail "deleted" event.
     *
     * @param  \App\Model\PurchaseSalesChalanDetail  $purchaseSalesChalanDetail
     * @return void
     */
    public function deleted(PurchaseSalesChalanDetail $purchaseSalesChalanDetail)
    {
        //
    }

    /**
     * Handle the sales chalan detail "restored" event.
     *
     * @param  \App\Model\PurchaseSalesChalanDetail  $purchaseSalesChalanDetail
     * @return void
     */
    public function restored(PurchaseSalesChalanDetail $purchaseSalesChalanDetail)
    {
        //
    }

    /**
     * Handle the sales chalan detail "force deleted" event.
     *
     * @param  \App\Model\PurchaseSalesChalanDetail  $purchaseSalesChalanDetail
     * @return void
     */
    public function forceDeleted(PurchaseSalesChalanDetail $purchaseSalesChalanDetail)
    {
        //
    }
}
