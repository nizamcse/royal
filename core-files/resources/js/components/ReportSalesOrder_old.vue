<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h4 class="pull-left">SALES ORDER REPORT</h4>
                <div class="pull-right" v-if="getDownloadSalesOrderReportRoute.can"><button class="btn btn-success"><i class="fa fa-arrow-down"></i> Download</button></div>
            </div>
            <div class="box-body">
                <div class="row col-md-12">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Show</label>
                            <select v-model="itemPerPage" class="form-control" @keyup="resetAPI">
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
                                <datepicker v-model="dateFrom" input-class="form-control" :typeable="true" :placeholder="'Select a Date.'" @selected="resetDateFrom"></datepicker>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Date To</label>
                                <datepicker v-model="dateTo" input-class="form-control" :typeable="true" :placeholder="'Select a Date.'" @selected="resetDateTo"></datepicker>
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
                <p><strong>Product:: </strong> {{ good.detailsName != "" ? good.detailsName : "All Products" }}</p>

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
                    <tr>
                        <th>SL#</th>
                        <th>Product Name</th>
                        <th class="text-center">Quantities</th>
                        <th class="text-right">Total Price</th>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right text-capitalize"><strong>Total: </strong></td>
                        <td class="text-right"><strong>20.00</strong></td>
                    </tr>
                </table>
                <pagination @select="paginateSalesOrderReport" :currentPage="currentPage" :lastPage="lastPage" v-if="salesOrderReports.length"></pagination>
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
                dateFrom: null,
                dateTo: null,
                reportGeneratedDate: "",
                itemPerPage: 10,
                lastPage: 1,
                currentPage: 1,
                filledData: {},
                filterProperty:{},
                salesOrderReports: [],

            }
        },
        methods:{
            dateFormatting (time){
                return  moment(time).format("ll");
            },

            resetDateFrom(){
                this.dateFrom = this.dateFrom ? moment(this.dateFrom).format('YYYY-MM-DD') : null;
                this.resetAPI();
            },

            resetDateTo(){
                this.dateTo = this.dateTo ? moment(this.dateTo).format('YYYY-MM-DD') : null;
                this.resetAPI();
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
                this.resetAPI();
            },

            selectCustomer(obj){
                this.customer.id = obj.id;
                this.customer.name = obj.name;
                this.customer.address = obj.address;
                this.customer.contactNo = obj.contact_no;
                this.customerCollections = [];
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
            },

            selectGood(obj){
                this.good.id = obj.id;
                this.good.name = obj.name;
                this.good.detailsName = obj.detail_name;
                this.goodCollections = [];
                this.resetAPI();
            },

            resetAPI(){
                this.filterProperty = {
                    item_per_page: this.itemPerPage,
                    good_id: this.good.id,
                    customer_id: this.customer.id,
                    customer_name: this.customer.name,
                    date_from: this.dateFrom ? moment(this.dateFrom).format('YYYY-MM-DD') : null,
                    date_to: this.dateTo ? moment(this.dateTo).format('YYYY-MM-DD') : null,
                };
                this.filledData = {};
                this.getDownloadSalesOrderReportRoute.route = null;
                const entries = Object.entries(this.filterProperty);
                for (let i=0; i<entries.length; i++) {
                    const [key,value] = entries[i];
                    if(value){
                        this.filledData[key] = value;
                        let param = this.getDownloadSalesOrderReportRoute.route ? '&' + key + '=' + value : this.routes.getDownloadSalesOrderReportRoute.route + '?' + key + '=' + value;
                        this.getDownloadSalesOrderReportRoute.route =  this.getDownloadSalesOrderReportRoute.route ? this.getDownloadSalesOrderReportRoute.route + param : param;
                    }
                }

                this.getSalesOrderReport();
            },

            getSalesOrderReport(){
                axios.post(this.postJsonSalesOrderReportRoute ,this.filledData)
                    .then(result => {
                        this.currentPage = result.data.current_page;
                        this.lastPage = result.data.last_page;
                        // this.salesOrderReports = result.data.data;
                        // console.log('reports:', this.salesOrderReports);
                        console.log('report: ', result.data.data);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            paginateSalesOrderReport: function(page){
                let pageUrl = this.postJsonSalesOrderReportRoute + "?page=" + page;
                axios.post(pageUrl ,this.filledData)
                    .then(result => {
                        this.currentPage = result.data.current_page;
                        this.lastPage = result.data.last_page;
                        this.salesOrderReports = result.data.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            }



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


        }
    }
</script>