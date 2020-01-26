<?php

namespace App\Observers;

use App\Model\InventoryItem;
use App\Model\ProductTransition;

class ProductTransitionObserver
{
    /**
     * Handle the product transition "created" event.
     *
     * @param  \App\ProductTransition  $productTransition
     * @return void
     */
    public function created(ProductTransition $productTransition)
    {
        $inventory_item = InventoryItem::where([
            'id'   => $productTransition->inventory_item_id,
        ])->firstOrFail();
        if($productTransition->transition_type == 'PROD'){
            $parent = ProductTransition::findOrFail($productTransition->parent_id);
            $d_u_quantity = ProductTransition::where('parent_id','=',$parent->id)->sum('quantity');
            $remaining_quantity =  ProductTransition::where('parent_id','=',$productTransition->parent_id)
                ->oRwhere('id','=',$productTransition->parent_id)->sum('quantity');
            $parent->update([
                'r_w_quantity'    => $remaining_quantity,
                'd_u_quantity'    => abs($d_u_quantity),
            ]);
        }

        if($productTransition->transition_type == 'POD' || $productTransition->transition_type == 'PSD'){
            $total_quantity = ProductTransition::where('inventory_item_id','=',$productTransition->inventory_item_id)->sum('quantity');
            $inventory_item->update([
                'quantity'          => $total_quantity,
            ]);
            if($productTransition->parent_id){
                $parent = ProductTransition::findOrFail($productTransition->parent_id);
                $r_w_quantity = ProductTransition::where('parent_id','=',$productTransition->parent_id)
                    ->oRwhere('id','=',$productTransition->parent_id)->sum('quantity');
                $parent->update([
                    'r_w_quantity'    => $r_w_quantity,
                ]);
            }
            $productTransition->fill([
                'r_w_quantity'  => abs($productTransition->quantity)
            ])->save();
        }
    }

    /**
     * Handle the product transition "updated" event.
     *
     * @param  \App\ProductTransition  $productTransition
     * @return void
     */
    public function updated(ProductTransition $productTransition)
    {
        if($productTransition->transition_type == 'POD' || $productTransition->transition_type == 'PSD'){
            $inventory_item = InventoryItem::where([
                'id'   => $productTransition->inventory_item_id,
            ])->firstOrFail();

            $total_quantity = ProductTransition::where('inventory_item_id','=',$productTransition->inventory_item_id)->sum('quantity');

            $inventory_item->update([
                'quantity'          => $total_quantity,
            ]);
        }
    }

    /**
     * Handle the product transition "deleted" event.
     *
     * @param  \App\ProductTransition  $productTransition
     * @return void
     */
    public function deleted(ProductTransition $productTransition)
    {

        $inventory_item = InventoryItem::where([
            'id'   => $productTransition->inventory_item_id,
        ])->firstOrFail();

        $total_quantity = ProductTransition::where('inventory_item_id','=',$productTransition->inventory_item_id)->sum('quantity');
        $inventory_item->update([
            'quantity'          => $total_quantity,
        ]);
    }

    /**
     * Handle the product transition "restored" event.
     *
     * @param  \App\ProductTransition  $productTransition
     * @return void
     */
    public function restored(ProductTransition $productTransition)
    {

        $inventory_item = InventoryItem::where([
            'id'   => $productTransition->inventory_item_id,
        ])->firstOrFail();

        $total_quantity = ProductTransition::where('inventory_item_id','=',$productTransition->inventory_item_id)->sum('quantity');
        $inventory_item->update([
            'quantity'          => $total_quantity,
        ]);
    }

    /**
     * Handle the product transition "force deleted" event.
     *
     * @param  \App\ProductTransition  $productTransition
     * @return void
     */
    public function forceDeleted(ProductTransition $productTransition)
    {

        $inventory_item = InventoryItem::where([
            'id'   => $productTransition->inventory_item_id,
        ])->firstOrFail();

        $total_quantity = ProductTransition::where('inventory_item_id','=',$productTransition->inventory_item_id)->sum('quantity');
        $inventory_item->update([
            'quantity'          => $total_quantity,
        ]);
    }
}
