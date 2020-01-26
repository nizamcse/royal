<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h4 class="pull-left">SALES ORDER REPORT</h4>
                <div class="pull-right" v-if="getDownloadSalesOrderReportRoute.can"><a :href="downloadReportRoute" target="_blank" class="btn btn-success"><i class="fa fa-arrow-down"></i> Download</a></div>
            </div>
            <div class="box-body">
                <div class="row col-md-12">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Show</label>
                            <select v-model="itemPerPage" class="form-control" @change="setItemPerPage">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Product</label>
                            <input type="text" class="form-control" v-model="good.detailsName"  @keyup="searchGood"  placeholder="All">
                            <ul class="search-result" v-if="goodCollections.length">
                                <li v-for="result in goodCollections" v-on:click="selectGood(result)">{{ result.detail_name }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Customer</label>
                            <input type="text" class="form-control" v-model="customer.name" @keyup="searchCustomer" placeholder="All">
                            <ul class="search-result" v-if="customerCollections.length">
                                <li v-for="customerResult in customerCollections" @click="selectCustomer(customerResult)">{{ customerResult.name }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Date From</label>
                                <datepicker v-model="dateFrom" input-class="form-control" :typeable="true" :placeholder="'Select a Date.'" @selected="setDateFrom"></datepicker>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Date To</label>
                                <datepicker v-model="dateTo" input-class="form-control" :typeable="true" :placeholder="'Select a Date.'" @selected="setDateTo"></datepicker>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header text-center">
                <h3>{{ companyName }}</h3>
                <h4>Sales Order Report</h4>
            </div>
            <div class="box-body ">
                <p><strong>Customer: </strong> {{ customer.name != "" ? customer.name : "All Customers" }}</p>
                <p><strong>Product: </strong> {{ good.detailsName != "" ? good.detailsName : "All Products" }}</p>

                <table class="table">
                    <tr>
                        <td><strong>Date From: </strong>{{ dateFrom != null ? dateFormatting(dateFrom) : "" }}</td>
                        <td><strong>Date To: </strong> {{ dateTo != null ? dateFormatting(dateTo) : "" }}</td>
                        <td><strong>Report Generated at: </strong>{{ reportGeneratedDate }}</td>
                    </tr>
                </table>
                <hr>
                <div style="margin-bottom:20px;"></div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>SL#</th>
                            <th>Product Name</th>
                            <th class="text-center">Quantities</th>
                            <th class="text-center">Unit Name</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for=" (item, index) in salesOrderReports.data">
                            <td>{{ index+1 }}</td>
                            <td :class="deletedDataColorClass(item.good.deleted_at)">{{ item.good ? item.good.detail_name : "null" }} {{ item.good.deleted_at != null ? "[Deleted]" : "" }}</td>
                            <td class="text-center">{{ item.quantities ? item.quantities : 0}}</td>
                            <td class="text-center">{{ item.good ? item.good.unit.name : "null"}}</td>
                            <td class="text-center">{{ item.good ? item.good.price : 0}}</td>
                            <td class="text-right">{{ item.sold_total ? parseFloat(item.sold_total).toFixed(2) : 0}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right text-capitalize"><strong>Total: </strong></td>
                            <td class="text-right"><strong>{{ totalSoldPrice }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                <pagination3 :data="salesOrderReports" @pagination-change-page="getSalesOrderReport" :limit="5"></pagination3>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['items', 'routes'],
        data: function () {
            return {
                companyName: "",
                getJsonCustomersRoute: "",
                getJsonGoodsRoute: "",
                postJsonSalesOrderReportRoute: "",
                getDownloadSalesOrderReportRoute:{
                    route: "",
                    can:0,
                },
                customer: {
                    id: null,
                    name: "",
                    address: "",
                    contactNo: "",
                },
                customers: [],
                customerCollections: [],
                good: {
                    id: null,
                    name: "",
                    detailsName: "",
                },
                goods: [],
                goodCollections: [],
                itemPerPage: 10,
                dateFrom: null,
                dateTo: null,
                reportGeneratedDate: null,
                filledData: {},
                filterProperty: {
                    item_per_page: null,
                    good_id: null,
                    customer_id: null,
                    customer_name: null,
                    date_from: null,
                    date_to: null,
                },
                salesOrderReports: {},
                downloadRoute: null,


            }
        },
        methods:{
            deletedDataColorClass(data){
                return data != null ? "text-danger" : ""
            },
            dateFormatting (time){
                return  moment(time).format("ll");
            },

            initCustomers(){
                axios.get(this.getJsonCustomersRoute).then((response) => {
                    this.customers = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },

            initGoods(){
                axios.get(this.getJsonGoodsRoute).then((response) => {
                    this.goods = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },

            setItemPerPage(){
                this.filterProperty.item_per_page = this.itemPerPage ? this.itemPerPage : 10;
                this.resetAPI();
            },

            setDateFrom(date){
                this.dateFrom = moment(date).format('YYYY-MM-DD');
                this.filterProperty.date_from = this.dateFrom ? this.dateFrom : null;
                this.resetAPI();
            },

            setDateTo(date){
                this.dateTo = moment(date).format('YYYY-MM-DD');
                this.filterProperty.date_to = this.dateTo ? this.dateTo : null;
                this.resetAPI();
            },

            searchCustomer(){
                if (this.customer.name.length){
                    this.customerCollections = this.customers.filter((item) => {
                        return item.name.toUpperCase().search(this.customer.name.toUpperCase()) != -1;
                    });
                } else{
                    this.customerCollections = [];
                    this.customer.id= null;
                    this.customer.address = "";
                    this.customer.contactNo = "";
                }
                this.filterProperty.customer_name = this.customer.name ? this.customer.name : null;
                this.filterProperty.customer_id = this.customer.id ? this.customer.id : null;
                this.resetAPI();
            },

            selectCustomer(obj){
                this.customer.id = obj.id;
                this.customer.name = obj.name;
                this.customer.address = obj.address;
                this.customer.contactNo = obj.contact_no;
                this.customerCollections = [];
                this.filterProperty.customer_id = obj.id;
                this.filterProperty.customer_name = null;
                this.resetAPI();
            },

            searchGood() {
                if(this.good.detailsName.length){
                    this.goodCollections = this.goods.filter((item) => {
                        return item.detail_name.toUpperCase().search(this.good.detailsName.toUpperCase()) != -1;
                    });
                }else{
                    this.goodCollections =[];
                    this.good.id = null;
                    this.good.name = "";
                    this.good.detailsName = "";
                }
                this.filterProperty.good_id = this.good.id ? this.good.id : null;
                this.resetAPI();
            },

            selectGood(obj){
                this.good.id = obj.id;
                this.good.name = obj.name;
                this.good.detailsName = obj.detail_name;
                this.goodCollections = [];
                this.filterProperty.good_id = obj.id;
                this.resetAPI();
            },

            resetAPI(){

                this.filledData = {};
                this.downloadRoute = null; ;
                const entries = Object.entries(this.filterProperty);
                for (let i=0; i<entries.length; i++) {
                    const [key,value] = entries[i];
                    if(value){
                        this.filledData[key] = value;
                        let param = this.downloadRoute ? '&' + key + '=' + value : this.routes.getDownloadSalesOrderReportRoute.route + '?' + key + '=' + value;
                        this.downloadRoute =  this.downloadRoute ? this.downloadRoute + param : param;
                    }
                }
                this.getSalesOrderReport(1);
            },

            getSalesOrderReport(page){
                let route = this.postJsonSalesOrderReportRoute + "?page=" + page;
                axios.post(route ,this.filledData)
                    .then(result => {
                        this.salesOrderReports = result.data.sales_order_report;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },


        },
        created(){
            this.companyName = this.items.companyName;
            this.reportGeneratedDate = moment().format("lll");
            this.getJsonGoodsRoute = this.routes.getJsonGoodsRoute;
            this.getJsonCustomersRoute = this.routes.getJsonCustomersRoute;
            this.postJsonSalesOrderReportRoute = this.routes.postJsonSalesOrderReportRoute;
            this.getDownloadSalesOrderReportRoute.route = this.routes.getDownloadSalesOrderReportRoute.route;
            this.getDownloadSalesOrderReportRoute.can = this.routes.getDownloadSalesOrderReportRoute.can;
            this.initGoods();
            this.initCustomers();
            this.resetAPI();
        },
        computed:{
            totalSoldPrice(){
                let total = 0.00;
                if (this.salesOrderReports.data) {
                    for(let i =0; i < this.salesOrderReports.data.length; i++ ){
                        total = total + parseFloat(this.salesOrderReports.data[i].sold_total);
                    }
                }
                return total.toFixed(2);
            },

            downloadReportRoute(){
                return this.downloadRoute != null ? this.downloadRoute : this.getDownloadSalesOrderReportRoute.route;
            }
        }
    }
</script>