<template>
<div>
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                    <label>Show</label>
                    <select class="form-control">
                        <option value="10">10</option>
                        <option value="10">15</option>
                        <option value="10">20</option>
                        <option value="10">25</option>
                        <option value="10">50</option>
                        <option value="10">100</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Order No# (By System)</label>
                        <input type="text" class="form-control" v-model="filterProperty.id" @keyup="resetUrl">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sales Order No# (Manual Entry)</label>
                        <input type="text" class="form-control" v-model="filterProperty.so_no_manual" @keyup="resetUrl">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" class="form-control"  v-model="filterProperty.name" @keyup="resetUrl">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Customer's Contact No</label>
                        <input type="text"  class="form-control" v-model="filterProperty.contact_no" @keyup="resetUrl">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date From</label>
                        <datepicker input-class="form-control" v-model="dateFrom" @selected="resetFromDate"></datepicker>
                        <input id="from-date" type="hidden" name="from_date" :value="fromDate">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date To</label>
                        <datepicker input-class="form-control" v-model="dateTo" @selected="resetToDate"></datepicker>
                        <input id="to-date" type="hidden" name="to_date" :value="toDate">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-body">
        <table id="sales-orders" class="table table-bordered table-striped">
            <thead>
            <tr>
            <th>PSO NO (By System)</th>
            <th>PSO NO (Manual Entry)</th>
            <th>DATE</th>
            <th>CUSTOMER NAME</th>
            <th>CONTACT NO</th>
            <th>AMOUNT</th>
            <th class="text-right">ACTION</th>
            </tr>
            </thead>
        <tbody>
        <tr v-for="sales_order in sales_orders">
            <td>{{ sales_order.id }}</td>
            <td>{{ sales_order.so_no_manual  }}</td>
            <td>{{ sales_order.sold_out_date }}</td>
            <td v-if="sales_order.customer">
                {{ sales_order.customer.name }}
            </td>
            <td v-else>{{ sales_order.name }}</td>
            <td v-if="sales_order.customer">{{ sales_order.customer.contact_no }}</td>
            <td v-else>{{ sales_order.contact_no }}</td>
            <td>{{ sales_order.total_amount }}</td>
            <td class="text-right">
                <a :href="ShowPurchaseSalesOrder+ '/' + sales_order.id" class="btn btn-xs btn-info"><i class="fa fa-expand"></i> View</a>
                <a href="#" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                <a :href="DownloadPurchaseSalesOrder+ '/' + sales_order.id" class="btn btn-xs btn-success" target="_blank"><i class="fa fa-download"></i> Download</a>
            </td>
        </tr>
        </tbody>
        </table>
        <div class="text-center">
            <pagination2 @pagechanged="onPageChange" :currentPage="currentPage" :total="total" :lastPage="lastPage" :totalPages="totalPages" v-if="sales_orders.length"></pagination2>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props:['items'],
    data(){
        return{
            dateFrom: null,
            dateTo: null,
            pageUrl:'',
            GetPurchaseSalesOrder:'',
            PurchaseSalesOrder:'',
            ShowPurchaseSalesOrder:'',
            DownloadPurchaseSalesOrder:'#',
            sales_orders:[],
            currentPage:1,
            lastPage:1,
            total:null,
            totalPages:null,
            fromDate: null,
            toDate: null,
            filterProperty: {
                id: null,
                so_no_manual: null,
                name: null,
                contact_no: null,
                date_from: null,
                date_to: null,
                itemPerPage: 10,
            },
            filledData: {},
        }
    },
    methods:{
        resetFromDate: function(date){
            this.fromDate = moment(date).format('YYYY-MM-DD');
            this.resetUrl();
        },
        resetToDate: function(date){
            this.toDate = moment(date).format('YYYY-MM-DD');
            this.resetUrl();
        },
        getPurchaseSalesOrders(){
            axios.post(this.GetPurchaseSalesOrder ,this.filledData)
                .then(response => {
                    this.currentPage = response.data.current_page;
                    this.lastPage = response.data.last_page;
                    this.total = response.data.total;
                    this.totalPages = this.lastPage;
                    this.sales_orders = response.data.data;
                    this.onPageChange(1);
                })
                .catch(e => {
                    console.log(e);
                });
        },
        onPageChange(page){
            this.pageUrl = this.items.GetPurchaseSalesOrder +'?page='+page;
            axios.post(this.pageUrl,this.filledData).
                then(response=>{
                    this.currentPage = response.data.current_page;
                    this.lastPage = response.data.last_page;
                    this.total = response.data.total;
                    this.totalPages = this.lastPage;
                    this.sales_orders = response.data.data;
                    // console.log("sales_orders :",this.sales_orders );
            }).catch(er=>console.log("error",er));
        },
        resetUrl(){
            this.filledData = {};
            const entries = Object.entries(this.filterProperty);
            this.DownloadPurchaseSalesOrder = null;
            for (let i=0; i<entries.length; i++) {
                const [key,value] = entries[i];
                if(value){
                    this.filledData[key] = value;
                    let param = this.DownloadPurchaseSalesOrder ? '&' + key + '=' + value : this.GetPurchaseSalesOrder + '?' + key + '=' + value;
                    this.DownloadPurchaseSalesOrder =  this.DownloadPurchaseSalesOrder ? this.DownloadPurchaseSalesOrder + param : param;
                }
            }
            if(this.fromDate){
                this.filledData['date_from'] = this.fromDate;
                let param = this.DownloadPurchaseSalesOrder ? '&from_date=' + this.fromDate : this.GetPurchaseSalesOrder + '?from_date=' + this.fromDate;
                this.DownloadPurchaseSalesOrder =  this.DownloadPurchaseSalesOrder ? this.DownloadPurchaseSalesOrder + param : param;
            }
            if(this.toDate){
                this.filledData['date_to'] = this.toDate;
                let param = this.DownloadPurchaseSalesOrder ? '&to_date=' + this.toDate : this.GetPurchaseSalesOrder + '?to_date=' + this.toDate;
                this.DownloadPurchaseSalesOrder =  this.DownloadPurchaseSalesOrder ? this.DownloadPurchaseSalesOrder + param : param;
            }

            this.getPurchaseSalesOrders();
        }
    },
    created(){
        console.log("items",this.items);
        this.DownloadPurchaseSalesOrder=this.items.DownloadPurchaseSalesOrder;
        this. PurchaseSalesOrder = this.items.PurchaseSalesOrder;
        this.ShowPurchaseSalesOrder = this.items.ShowPurchaseSalesOrder;
        this.GetPurchaseSalesOrder = this.items.GetPurchaseSalesOrder;
        this.onPageChange(1);
    }
}
</script>

<style>

</style>