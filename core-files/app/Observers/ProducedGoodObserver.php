<?php

namespace App\Observers;

use App\Model\Good;
use App\Model\ProducedGood;

class ProducedGoodObserver
{
    /**
     * Handle the produced good "created" event.
     *
     * @param  \App\Model\ProducedGood  $producedGood
     * @return void
     */
    public function created(ProducedGood $producedGood)
    {
        $good = Good::findOrFail($producedGood->good_id);
        $goods_value = $producedGood->produced_quantity * $good->price;
        $producedGood->fill([
            'produced_goods_value'  => $goods_value,
            'unite_price'           => $good->price
        ])->save();
    }

    /**
     * Handle the produced good "updated" event.
     *
     * @param  \App\Model\ProducedGood  $producedGood
     * @return void
     */
    public function updated(ProducedGood $producedGood)
    {
        //
    }

    /**
     * Handle the produced good "deleted" event.
     *
     * @param  \App\Model\ProducedGood  $producedGood
     * @return void
     */
    public function deleted(ProducedGood $producedGood)
    {
        //
    }

    /**
     * Handle the produced good "restored" event.
     *
     * @param  \App\Model\ProducedGood  $producedGood
     * @return void
     */
    public function restored(ProducedGood $producedGood)
    {
        //
    }

    /**
     * Handle the produced good "force deleted" event.
     *
     * @param  \App\Model\ProducedGood  $producedGood
     * @return void
     */
    public function forceDeleted(ProducedGood $producedGood)
    {
        //
    }
}
