<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title d-block">
                    LIST OF PURCHASE ORDERS
                    <a :href="createdUrl" class="btn btn-sm pull-right btn-info flat"><i class="fa fa-plus-circle"></i> CREATE NEW</a>
                    <a :href="downloadUrl" class="btn btn-sm pull-right btn-warning flat" target="_blank"><i class="fa fa-download"></i> DOWNLOAD</a>
                </h3>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Show</label>
                            <select v-model="filterProperty.itemPerPage" class="form-control">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>PO NO (By System)</label>
                            <input type="text" v-model="filterProperty.id" class="form-control" @keyup="resetUrl">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>CHALAN NO (Manual Entry)</label>
                            <input type="text" v-model="filterProperty.challan_no_mannual" class="form-control" @keyup="resetUrl">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Vendor Name</label>
                            <input type="text" v-model="filterProperty.vendor_name" class="form-control" @keyup="resetUrl">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date From</label>
                            <datepicker input-class="form-control" v-model="dateFrom" @selected="resetFromDate"></datepicker>
                            <input id="from-date" type="hidden" name="from_date" :value="fromDate">
                        </div>
                    </div>
                    <div class="col-md-2">
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
                        <th>PO NO</th>
                        <th>CH NO</th>
                        <th>Vendor</th>
                        <th>Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(order,index) in purchaseOrders">
                        <td>{{ order.id }}</td>
                        <td>{{ order.challan_no_mannual }}</td>
                        <td>{{ order.vendor ? order.vendor.name : '' }}</td>
                        <td>{{ order.amount }}</td>
                        <td>{{ order.paid_amount }}</td>
                        <td>{{ order.due_amount }}</td>
                        <td class="text-right">
                            <a :href="view.url + '/' + order.id" class="btn btn-info btn-xs flat" v-if="view.can"><i class="fa fa-eye"></i> View</a>
                            <a :href="edit.url + '/' + order.id" class="btn btn-warning btn-xs flat" v-if="edit.can"><i class="fa fa-pencil"></i> Edit</a>
                            <button :data-url="deleteOrder.url + '/' + order.id " class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal" v-if="deleteOrder.can"><i class="fa fa-trash-o"></i>Delete</button>
                            <a :href="download.url + '/' + order.id " class="btn btn-success btn-xs" target="_blank" v-if="download.can"> <i class="fa fa-download"></i> Download</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination @select="paginatePurchaseOrders" :currentPage="currentPage" :lastPage="lastPage" v-if="purchaseOrders.length"></pagination>
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
                purchaseOrders: [],
                apiUrl: "",
                downloadUrl: '#',
                createdUrl: '#',
                fromDate: null,
                toDate: null,
                filterProperty: {
                    challan_no_mannual: null,
                    id: null,
                    vendor_name: null,
                    date_from: null,
                    date_to: null,
                    itemPerPage: 10,
                },
                filledData: {},
                lastPage: 1,
                currentPage: 1,
                view: {},
                edit: {},
                deleteOrder: {},
                download: {},
            };
        },
        computed: {

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
            getPurchaseOrders: function(){
                var app =this;
                axios.post(app.apiUrl ,app.filledData)
                    .then(result => {
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;
                        app.purchaseOrders = result.data.data;

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

                this.getPurchaseOrders();
            },
            paginatePurchaseOrders: function(page){
                var app = this;
                let pageUrl = this.apiUrl + "?page=" + page;
                axios.post(pageUrl ,app.filledData)
                    .then(result => {
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;
                        app.purchaseOrders = result.data.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            }
        },
        created: function() {
            this.apiUrl = this.items.apiUrl;
            this.createdUrl = this.items.createUrl;
            this.view = this.items.view;
            this.edit = this.items.edit;
            this.deleteOrder = this.items.deleteOrder;
            this.download = this.items.download;
            this.getPurchaseOrders();
            this.downloadUrl = this.items.apiUrl;
            console.log(this.items.download);
        },
        mounted() {

        },
    };
</script>
