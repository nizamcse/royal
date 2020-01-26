<?php

namespace App\Observers;

use App\Model\PurchaseOrder;
use App\Model\PurchasePayment;

class PurchasePaymentObserver
{
    /**
     * Handle the purchase payment "created" event.
     *
     * @param  \App\Model\PurchasePayment  $purchasePayment
     * @return void
     */
    public function created(PurchasePayment $purchasePayment)
    {
        $purchase_order = PurchaseOrder::findOrFail($purchasePayment->purchase_order_id);

        $paid_amount = $purchase_order->paid_amount + $purchasePayment->amount;
        $due_amount = $purchase_order->due_amount - $purchasePayment->amount;

        $purchase_order->update([
            'paid_amount'   => $paid_amount,
            'due_amount'    => $due_amount
        ]);
    }

    /**
     * Handle the purchase payment "updated" event.
     *
     * @param  \App\Model\PurchasePayment  $purchasePayment
     * @return void
     */
    public function updated(PurchasePayment $purchasePayment)
    {
        //
    }

    /**
     * Handle the purchase payment "deleted" event.
     *
     * @param  \App\Model\PurchasePayment  $purchasePayment
     * @return void
     */
    public function deleted(PurchasePayment $purchasePayment)
    {
        //
    }

    /**
     * Handle the purchase payment "restored" event.
     *
     * @param  \App\Model\PurchasePayment  $purchasePayment
     * @return void
     */
    public function restored(PurchasePayment $purchasePayment)
    {
        //
    }

    /**
     * Handle the purchase payment "force deleted" event.
     *
     * @param  \App\Model\PurchasePayment  $purchasePayment
     * @return void
     */
    public function forceDeleted(PurchasePayment $purchasePayment)
    {
        //
    }
}
