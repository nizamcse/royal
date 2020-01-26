<?php

namespace App\Observers;

use App\Model\SalesOrder;
use App\Model\SalesPayment;

class SalesPaymentObserver
{
    /**
     * Handle the sales payment "created" event.
     *
     * @param  \App\Model\SalesPayment  $salesPayment
     * @return void
     */
    public function created(SalesPayment $salesPayment)
    {
        $sales_order = SalesOrder::findOrFail($salesPayment->sales_order_id);

        $paid_amount = $sales_order->paid_amount + $salesPayment->amount;
        $due_amount = $sales_order->due_amount - $salesPayment->amount;

        $sales_order->update([
            'paid_amount'   => $paid_amount,
            'due_amount'    => $due_amount
        ]);
    }

    /**
     * Handle the sales payment "updated" event.
     *
     * @param  \App\Model\SalesPayment  $salesPayment
     * @return void
     */
    public function updated(SalesPayment $salesPayment)
    {
        //
    }

    /**
     * Handle the sales payment "deleted" event.
     *
     * @param  \App\Model\SalesPayment  $salesPayment
     * @return void
     */
    public function deleted(SalesPayment $salesPayment)
    {
        //
    }

    /**
     * Handle the sales payment "restored" event.
     *
     * @param  \App\Model\SalesPayment  $salesPayment
     * @return void
     */
    public function restored(SalesPayment $salesPayment)
    {
        //
    }

    /**
     * Handle the sales payment "force deleted" event.
     *
     * @param  \App\Model\SalesPayment  $salesPayment
     * @return void
     */
    public function forceDeleted(SalesPayment $salesPayment)
    {
        //
    }
}
