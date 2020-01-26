<?php

namespace App\Observers;

use App\Model\PurchaseOrderDetail;
use App\Model\PurchaseSalesDetail;

class PurchaseSalesDetailObserver
{
    /**
     * Handle the purchase sales detail "created" event.
     *
     * @param  \App\Model\PurchaseSalesDetail  $purchaseSalesDetail
     * @return void
     */
    public function created(PurchaseSalesDetail $purchaseSalesDetail)
    {
        $po_detail = PurchaseOrderDetail::findOrFail($purchaseSalesDetail->po_detail_id);
        $sold_quantity = $po_detail->sold_quantity + $purchaseSalesDetail->quantity;
        $remaining_quantity = $po_detail->remaining_quantity - $purchaseSalesDetail->quantity;

        $po_detail->update([
            'sold_quantity'         => $sold_quantity,
            'remaining_quantity'    => $remaining_quantity
        ]);
    }

    /**
     * Handle the purchase sales detail "updated" event.
     *
     * @param  \App\Model\PurchaseSalesDetail  $purchaseSalesDetail
     * @return void
     */
    public function updated(PurchaseSalesDetail $purchaseSalesDetail)
    {
        $old_data = $purchaseSalesDetail->getOriginal();
        $cr_qty = $old_data['remaining_quantity'] - $purchaseSalesDetail->remaining_quantity;
        if($old_data['remaining_quantity'] < $purchaseSalesDetail->remaining_quantity){
            $po_detail = PurchaseOrderDetail::findOrFail($purchaseSalesDetail->po_detail_id);
            $sold_quantity = $po_detail->sold_quantity - $cr_qty;
            $remaining_quantity = $po_detail->remaining_quantity + $cr_qty;

            $po_detail->update([
                'sold_quantity'         => $sold_quantity,
                'remaining_quantity'    => $remaining_quantity
            ]);
        }

    }

    /**
     * Handle the purchase sales detail "deleted" event.
     *
     * @param  \App\Model\PurchaseSalesDetail  $purchaseSalesDetail
     * @return void
     */
    public function deleted(PurchaseSalesDetail $purchaseSalesDetail)
    {
        //
    }

    /**
     * Handle the purchase sales detail "restored" event.
     *
     * @param  \App\Model\PurchaseSalesDetail  $purchaseSalesDetail
     * @return void
     */
    public function restored(PurchaseSalesDetail $purchaseSalesDetail)
    {
        //
    }

    /**
     * Handle the purchase sales detail "force deleted" event.
     *
     * @param  \App\Model\PurchaseSalesDetail  $purchaseSalesDetail
     * @return void
     */
    public function forceDeleted(PurchaseSalesDetail $purchaseSalesDetail)
    {
        //
    }
}
