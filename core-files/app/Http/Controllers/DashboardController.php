<?php

namespace App\Http\Controllers;

use App\Model\PurchaseOrder;
use App\Model\PurchasePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function parchesOverview(){
        $today = Carbon::now()->format('d');
        $last_month = Carbon::now()->format('m');

        $today_parches_amount = PurchasePayment::selectRow(sum('amount'))
            ->whereMonth('payment_date', $today)
            ->get();

        return $today_parches_amount;
    }
}

//SELECT sum(amount) FROM `purchase_payments`
