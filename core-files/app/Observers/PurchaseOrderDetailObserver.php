<?php

namespace App\Observers;

use App\Model\InventoryItem;
use App\Model\PurchaseOrderDetail;

class PurchaseOrderDetailObserver
{
    /**
     * Handle the purchase order detail "created" event.
     *
     * @param  \App\PurchaseOrderDetail  $purchaseOrderDetail
     * @return void
     */
    public function created(PurchaseOrderDetail $purchaseOrderDetail)
    {
        $inventory_item = InventoryItem::where([
            'id'   => $purchaseOrderDetail->inventory_item_id,
        ])->firstOrFail();

        $quantity = $inventory_item->quantity + $purchaseOrderDetail->quantity;
        $inventory_item->update([
            'quantity'          => $quantity,
        ]);
    }

    /**
     * Handle the purchase order detail "updated" event.
     *
     * @param  \App\PurchaseOrderDetail  $purchaseOrderDetail
     * @return void
     */
    public function updated(PurchaseOrderDetail $purchaseOrderDetail)
    {
        $old_data = $purchaseOrderDetail->getOriginal();
        $cr_qty = $old_data['remaining_quantity'] - $purchaseOrderDetail->remaining_quantity;

        $inventory_item = InventoryItem::where([
            'id'   => $purchaseOrderDetail->inventory_item_id,
        ])->firstOrFail();

        $quantity = $inventory_item->quantity - $cr_qty;
        $inventory_item->update([
            'quantity'          => $quantity,
        ]);
    }


    public function deleting(PurchaseOrderDetail $purchaseOrderDetail){
    }

    /**
     * Handle the purchase order detail "deleted" event.
     *
     * @param  \App\PurchaseOrderDetail  $purchaseOrderDetail
     * @return void
     */
    public function deleted(PurchaseOrderDetail $purchaseOrderDetail)
    {
        //dd($purchaseOrderDetail);
        $inventory_item = InventoryItem::where([
            'id'   => $purchaseOrderDetail->inventory_item_id,
        ])->first();
        if($purchaseOrderDetail->remaining_quantity > 0){
            $quantity = $inventory_item->quantity - $purchaseOrderDetail->remaining_quantity;
        }else{
            $quantity = $inventory_item->quantity - $purchaseOrderDetail->quantity;
        }
        if($inventory_item){
            $inventory_item->update([
                'quantity'          => $quantity,
            ]);
        }
    }

    /**
     * Handle the purchase order detail "restored" event.
     *
     * @param  \App\PurchaseOrderDetail  $purchaseOrderDetail
     * @return void
     */
    public function restored(PurchaseOrderDetail $purchaseOrderDetail)
    {
        //
    }

    /**
     * Handle the purchase order detail "force deleted" event.
     *
     * @param  \App\PurchaseOrderDetail  $purchaseOrderDetail
     * @return void
     */
    public function forceDeleted(PurchaseOrderDetail $purchaseOrderDetail)
    {
        //
    }
}
