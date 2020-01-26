<?php

namespace App\Observers;

use App\Model\InventoryItem;
use App\Model\ProductionMaterial;
use App\Model\PurchaseOrderDetail;

class ProductionMaterialObserver
{
    /**
     * Handle the production material "created" event.
     *
     * @param  \App\Model\ProductionMaterial  $productionMaterial
     * @return void
     */
    public function created(ProductionMaterial $productionMaterial)
    {
        $po_detail = PurchaseOrderDetail::where('id','=',$productionMaterial->purchase_order_detail_id)
            ->firstOrFail();
        $used_quantity = $po_detail->used_quantity + $productionMaterial->used_quantity;
        $wasted_quantity = $po_detail->wasted_quantity + $productionMaterial->wasted_quantity;
        $remaining_quantity = $po_detail->remaining_quantity - ($used_quantity + $wasted_quantity);

        $po_detail->update([
            'remaining_quantity'    => $remaining_quantity,
            'used_quantity'         => $used_quantity,
            'wasted_quantity'       => $wasted_quantity
        ]);

        $inventory_item = InventoryItem::findOrFail($productionMaterial->inventory_item_id);

        $quantity = $inventory_item->quantity - ($used_quantity + $wasted_quantity);

        $inventory_item->update([
            'quantity'  => $quantity
        ]);
    }

    /**
     * Handle the production material "updated" event.
     *
     * @param  \App\Model\ProductionMaterial  $productionMaterial
     * @return void
     */
    public function updated(ProductionMaterial $productionMaterial)
    {
        //
    }

    /**
     * Handle the production material "deleted" event.
     *
     * @param  \App\Model\ProductionMaterial  $productionMaterial
     * @return void
     */
    public function deleted(ProductionMaterial $productionMaterial)
    {
        //
    }

    /**
     * Handle the production material "restored" event.
     *
     * @param  \App\Model\ProductionMaterial  $productionMaterial
     * @return void
     */
    public function restored(ProductionMaterial $productionMaterial)
    {
        //
    }

    /**
     * Handle the production material "force deleted" event.
     *
     * @param  \App\Model\ProductionMaterial  $productionMaterial
     * @return void
     */
    public function forceDeleted(ProductionMaterial $productionMaterial)
    {
        //
    }
}
