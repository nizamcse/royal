<?php

namespace App\Observers;

use App\Model\PurchaseOrder;

class PurchaseOrderObserver
{
    /**
     * Handle the purchase order "created" event.
     *
     * @param  \App\Model\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function created(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the purchase order "updated" event.
     *
     * @param  \App\Model\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function updated(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the purchase order "deleted" event.
     *
     * @param  \App\Model\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function deleted(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the purchase order "restored" event.
     *
     * @param  \App\Model\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function restored(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Handle the purchase order "force deleted" event.
     *
     * @param  \App\Model\PurchaseOrder  $purchaseOrder
     * @return void
     */
    public function forceDeleted(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
