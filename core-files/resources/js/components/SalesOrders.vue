<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title d-block">
                    LIST OF SALES ORDERS
                    <a :href="createdUrl" class="btn btn-sm pull-right btn-info flat"><i class="fa fa-plus-circle"></i> CREATE NEW</a>
                    <a :href="downloadUrl" class="btn btn-sm pull-right btn-warning flat" target="_blank"><i class="fa fa-download"></i> DOWNLOAD</a>
                </h3>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Show</label>
                            <select v-model="filterProperty.itemPerPage" class="form-control">
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
                            <input type="text" v-model="filterProperty.id" class="form-control" @keyup="resetUrl">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sales Order No# (Manual Entry)</label>
                            <input type="text" v-model="filterProperty.so_no_manual" class="form-control" @keyup="resetUrl">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Customer Name</label>
                            <input type="text" v-model="filterProperty.name" class="form-control" @keyup="resetUrl">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Customer's Contact No</label>
                            <input type="text" v-model="filterProperty.contact_no" class="form-control" @keyup="resetUrl">
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

        <div class="box">
            <div class="box-body">
                <table id="po-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#ORDER ID</th>
                        <th>DATE</th>
                        <th>CUSTOMER NAME</th>
                        <th>CONTACT NO</th>
                        <th>SO NO#</th>
                        <th>AMOUNT</th>
                        <th class="text-right">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in salesOrders">
                        <td>{{ order.id }}</td>
                        <td>{{ order.sold_out_date }}</td>
                        <td v-if="order.customer">
                            {{ order.customer.name }}
                        </td>
                        <td v-else>{{ order.name }}</td>
                        <td v-if="order.customer">{{ order.customer.contact_no }}</td>
                        <td v-else>{{ order.contact_no }}</td>
                        <td>{{ order.so_no_manual }}</td>
                        <td>{{ order.total_amount }}</td>
                        <td class="text-right">
                            <a :href="view.url + '/' + order.id" class="btn btn-info btn-xs flat" v-if="view.can"><i class="fa fa-eye"></i> View</a>
                            <button :data-url="deleteOrder.url + '/' + order.id " class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal" v-if="deleteOrder.can"><i class="fa fa-trash-o"></i>Delete</button>
                            <a :href="download.url + '/' + order.id " class="btn btn-success btn-xs" target="_blank" v-if="download.can"> <i class="fa fa-download"></i> Download</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination @select="paginateSalesOrders" :currentPage="currentPage" :lastPage="lastPage" v-if="salesOrders.length"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        data: function() {
            return {
                dateFrom: null,
                dateTo: null,
                salesOrders: [],
                apiUrl: "",
                downloadUrl: '#',
                createdUrl: '#',
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
                lastPage: 1,
                currentPage: 1,
                view: {},
                deleteOrder: {},
                download: {},
            };
        },
        methods: {
            resetFromDate: function(date){
                this.fromDate = moment(date).format('YYYY-MM-DD');
                this.resetUrl();
            },
            resetToDate: function(date){
                this.toDate = moment(date).format('YYYY-MM-DD');
                this.resetUrl();
            },
            getSalesOrders: function(){
                var app =this;
                axios.post(app.apiUrl ,app.filledData)
                    .then(result => {
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;
                        app.salesOrders = result.data.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            resetUrl: function(){
                this.filledData = {};
                const entries = Object.entries(this.filterProperty);
                this.downloadUrl = null;
                for (let i=0; i<entries.length; i++) {
                    const [key,value] = entries[i];
                    if(value){
                        this.filledData[key] = value;
                        let param = this.downloadUrl ? '&' + key + '=' + value : this.apiUrl + '?' + key + '=' + value;
                        this.downloadUrl =  this.downloadUrl ? this.downloadUrl + param : param;
                    }
                }
                if(this.fromDate){
                    this.filledData['date_from'] = this.fromDate;
                    let param = this.downloadUrl ? '&from_date=' + this.fromDate : this.apiUrl + '?from_date=' + this.fromDate;
                    this.downloadUrl =  this.downloadUrl ? this.downloadUrl + param : param;
                }
                if(this.toDate){
                    this.filledData['date_to'] = this.toDate;
                    let param = this.downloadUrl ? '&to_date=' + this.toDate : this.apiUrl + '?to_date=' + this.toDate;
                    this.downloadUrl =  this.downloadUrl ? this.downloadUrl + param : param;
                }

                this.getSalesOrders();
            },
            paginateSalesOrders: function(page){
                var app = this;
                let pageUrl = this.apiUrl + "?page=" + page;
                axios.post(pageUrl ,app.filledData)
                    .then(result => {
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;
                        app.salesOrders = result.data.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            }
        },
        created(){
            console.log("Items",this.items);
            this.apiUrl = this.items.apiUrl;
            this.createdUrl = this.items.createUrl;
            this.view = this.items.view;
            this.deleteOrder = this.items.deleteOrder;
            this.download = this.items.download;
            this.getSalesOrders();
            this.downloadUrl = this.items.apiUrl;
        },
        mounted() {

        },
    };
</script>
