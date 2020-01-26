<?php

namespace App\Providers;

use App\Model\Attendance;
use App\Model\Leave;
use App\Model\MonthlyLeave;
use App\Model\ProducedGood;
use App\Model\Production;
use App\Model\ProductionGood;
use App\Model\ProductionMaterial;
use App\Model\ProductTransition;
use App\Model\PurchaseOrderDetail;
use App\Model\PurchasePayment;
use App\Model\PurchaseSalesChalanDetail;
use App\Model\PurchaseSalesDetail;
use App\Model\SalesChalanDetail;
use App\Model\SalesPayment;
use App\Model\Vacation;
use App\Observers\AttendanceObserver;
use App\Observers\LeaveObserver;
use App\Observers\MonthlyLeaveObserver;
use App\Observers\ProducedGoodObserver;
use App\Observers\ProductionGoodObserver;
use App\Observers\ProductionMaterialObserver;
use App\Observers\ProductionObserver;
use App\Observers\ProductTransitionObserver;
use App\Observers\PurchaseOrderDetailObserver;
use App\Observers\PurchasePaymentObserver;
use App\Observers\PurchaseSalesChalanDetailObserver;
use App\Observers\PurchaseSalesDetailObserver;
use App\Observers\SalesChalanDetailObserver;
use App\Observers\SalesPaymentObserver;
use App\Observers\VacationObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        PurchaseOrderDetail::observe(PurchaseOrderDetailObserver::class);
        ProductionGood::observe(ProductionGoodObserver::class);
        PurchasePayment::observe(PurchasePaymentObserver::class);
        SalesPayment::observe(SalesPaymentObserver::class);
        SalesChalanDetail::observe(SalesChalanDetailObserver::class);
        ProducedGood::observe(ProducedGoodObserver::class);
        Attendance::observe(AttendanceObserver::class);
        ProductionMaterial::observe(ProductionMaterialObserver::class);
        PurchaseSalesDetail::observe(PurchaseSalesDetailObserver::class);
        PurchaseSalesChalanDetail::observe(PurchaseSalesChalanDetailObserver::class);
        Vacation::observe(VacationObserver::class);
        MonthlyLeave::observe(MonthlyLeaveObserver::class);
        Leave::observe(LeaveObserver::class);
        Production::observe(ProductionObserver::class);
        ProductTransition::observe(ProductTransitionObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
