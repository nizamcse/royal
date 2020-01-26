
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//import datetime from 'vuejs-datetimepicker';
//import datetime from 'vue-datetime-picker';
//import Datetime from 'vue-datetime'
import {Datetime} from 'vue-datetime'

import Datepicker from 'vuejs-datepicker';
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.component('report-sales-order', require('./components/ReportSalesOrder.vue').default);

Vue.component('create-purchase-order', require('./components/CreatePurchaseOrder.vue').default);
Vue.component('edit-purchase-order', require('./components/EditPurchaseOrder.vue').default);
Vue.component('create-production', require('./components/CreateProduction.vue').default);
Vue.component('create-production-product', require('./components/CreateProductionProduct.vue').default);
Vue.component('create-product-release', require('./components/CreateProductionProductRelease.vue').default);
Vue.component('date-time', require('./components/DatetimeInput.vue').default);
Vue.component('create-sales-order', require('./components/CreateSalesOrder.vue').default);
Vue.component('create-purchase-sales-order', require('./components/CreatePurchaseSalesOrder.vue').default);
Vue.component('purchase-sales-order', require('./components/PurchaseSalesOrder.vue').default);
Vue.component('create-sales-chalan', require('./components/CreateSalesChalan.vue').default);
Vue.component('upper-part-create-sales-chalan', require('./components/UpperPartCreateSalesChalan.vue').default);
Vue.component('show-vendor', require('./components/ShowVendor.vue').default);
Vue.component('create-sales-return-chalan', require('./components/CreateSalesReturnChalan.vue').default);
Vue.component('create-journal', require('./components/CreateJournal.vue').default);
Vue.component('update-journal', require('./components/UpdateJournal.vue').default);
Vue.component('create-transaction', require('./components/CreateTransaction.vue').default);
Vue.component('create-company', require('./components/CreateCompany.vue').default);
Vue.component('create-sales-payment', require('./components/CreateSalesPayment.vue').default);
Vue.component('create-purchase-payment', require('./components/CreatePurchasePayment.vue').default);
Vue.component('create-role', require('./components/CreateRole.vue').default);
Vue.component('vacation-form', require('./components/VacationForm.vue').default);
Vue.component('leave', require('./components/Leave.vue').default);
Vue.component('create-leave', require('./components/CreateLeaveForm.vue').default);
Vue.component('create-salary', require('./components/CreateSalaryForm.vue').default);
Vue.component('account-statement', require('./components/AccountStatement.vue').default);
Vue.component('update-company', require('./components/UpdateCompany.vue').default);
Vue.component('update-password', require('./components/UpdatePassword.vue').default);
Vue.component('attendance-report', require('./components/AttendanceReport.vue').default);
Vue.component('pagination', require('./components/Pagination.vue').default);
Vue.component('pagination2', require('./components/Pagination2.vue').default);
Vue.component('purchase-order', require('./components/PurchaseOrders.vue').default);
Vue.component('sales-order', require('./components/SalesOrders.vue').default);
Vue.component('journals', require('./components/Journals.vue').default);
Vue.component('employee-salaries', require('./components/EmployeeSalaries.vue').default);
Vue.component('create-account-closing', require('./components/CreateAccountClosing.vue').default);
Vue.component('auto-complete', require('./components/Autocomplete.vue').default);
Vue.component('create-log-purchase-order', require('./components/CreateLogPurchaseOrder.vue').default);
Vue.component('edit-log-purchase-order', require('./components/EditLogPurchaseOrder.vue').default);
Vue.component('log-purchase-orders', require('./components/LogPurchaseOrders.vue').default);
Vue.component('create-material-purchase-order', require('./components/CreateMaterialPurchaseOrder.vue').default);
Vue.component('material-purchase-orders', require('./components/MaterialPurchaseOrders.vue').default);
Vue.component('edit-material-purchase-order', require('./components/EditMaterialPurchaseOrder.vue').default);
Vue.component('datetime', Datetime);
Vue.component('datepicker', Datepicker);
Vue.component('pagination3', require('laravel-vue-pagination'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});


// var purchaseOrder = document.getElementById("select-sales-order");
// if(purchaseOrder){
//     purchaseOrder.onchange = function () {
//         var so_id = this.value;
//         if(app.$refs.getSalesOrderItem){
//             app.$refs.getSalesOrderItem.loadItems(so_id);
//         }
//     }
// }
