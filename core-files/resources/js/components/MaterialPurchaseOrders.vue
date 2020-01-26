<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h2 class="pull-left">MATERIAL PURCHASE ORDERS</h2>
                <div class="pull-right">
                    <a v-if="createPurchaseOrderRoute.can" :href="createPurchaseOrderRoute.route" target="_blank" class="btn btn-success"><i class="fa fa-pencil-square"></i> Create New Order</a>
                    <a v-if="getDownloadMaterialPurchaseOrdersRoute.can" :href="downloadRoute" target="_blank" class="btn btn-warning"><i class="fa fa-download"></i> Download</a>
                </div>
                <div class="col-md-12"  v-if="statusMassage.classType">
                    <div :class="'alert alert-dismissible alert-'+statusMassage.classType" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ statusMassage.text }}
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Show</label>
                            <select class="form-control" v-model="itemPerPage" @change="setItemPerPage">
                                <option value="10">10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>PO NO (By System)</label>
                            <input type="text" class="form-control" v-model="purchaseOrderId" @keyup="setPurchaseOrderId">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>CHALAN NO (Manual Entry)</label>
                            <input type="text" class="form-control" v-model="challanNoManual" @keyup="setChallanNoManual" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Vendor Name</label>
                            <input type="text" class="form-control" v-model="vendorName" @keyup="setVendorName">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date From</label>
                            <datepicker input-class="form-control" v-model="dateFrom" :typeable="true" @selected="setDateFrom"></datepicker>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date To</label>
                            <datepicker input-class="form-control" v-model="dateTo" :typeable="true" @selected="setDateTo"></datepicker>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>SL#</th>
                        <th>PO NO</th>
                        <th>CH NO</th>
                        <th>Date</th>
                        <th>Vendor</th>
                        <th>Amount</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for=" (item, index) in materialPurchaseOrders.data">
                        <td>{{ index+1 }}</td>
                        <td>{{ item.id }}</td>
                        <td>{{ item.challan_no_mannual }}</td>
                        <td>{{ item.purchase_date }}</td>
                        <td>{{ item.vendor.name }}</td>
                        <td>{{ item.amount ? parseFloat(item.amount).toFixed(2) : 0.00 }}</td>
                        <td>{{ item.paid_amount ? parseFloat(item.paid_amount).toFixed(2) : 0.00 }}</td>
                        <td>{{ item.due_amount ? parseFloat(item.due_amount).toFixed(2) : 0.00 }}</td>
                        <td>
                            <a v-if="showPurchaseOrderRoute.can" :href="setShowRoute(item.id)" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>
                            <a v-if="editPurchaseOrderRoute.can" :href="setEditRoute(item.id)" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <button v-if="deletePurchaseOrderRoute.can" @click="deleteMaterialPurchaseOrder(item.id)"  class="btn btn-danger btn-sm" :disabled="deletingMaterialPurchaseOrder[item.id]"><i class="fa fa-trash"></i>{{ deletingMaterialPurchaseOrder[item.id] ? " Deleting..." : " Delete" }}</button>
                            <a v-if="getDownloadMaterialPurchaseOrderRoute.can" :href="setDownloadRoute(item.id)" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i> Download</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination3 :data="materialPurchaseOrders" @pagination-change-page="getMaterialPurchaseOrders" :limit="5"></pagination3>
            </div>
        </div>

    </div>
</template>
<script>

    export default {
        props: ['token','routes'],

        data:function () {
            return {
                getJsonMaterialPurchaseOrdersRoute: null,
                getDownloadMaterialPurchaseOrdersRoute:{
                    route: null,
                    can: 0,
                },
                getDownloadMaterialPurchaseOrderRoute:{
                    route: null,
                    can: 0,
                },
                createPurchaseOrderRoute: {
                    route: null,
                    can: 0,
                },
                showPurchaseOrderRoute: {
                    route: null,
                    can: 0,
                },
                editPurchaseOrderRoute: {
                    route: null,
                    can: 0,
                },
                deletePurchaseOrderRoute: {
                    route: null,
                    can: 0,
                },
                statusMassage: {
                    classType: null,
                    text: null,
                },

                itemPerPage: 10,
                purchaseOrderId: null,
                challanNoManual: null,
                vendorName: null,
                dateFrom: null,
                dateTo: null,
                filterProperty:{
                    itemPerPage: null,
                    purchaseOrderId: null,
                    challanNoManual: null,
                    vendorName: null,
                    dateFrom: null,
                    dateTo: null,
                },
                filledData: {},
                downloadRoute: null,
                materialPurchaseOrders: {},
                deletingMaterialPurchaseOrder: [],
            }
        },
        methods:{
            setItemPerPage(){
                this.filterProperty.itemPerPage = this.itemPerPage ? this.itemPerPage : 10;
                this.resetFilledData();
            },
            setPurchaseOrderId(){
                this.filterProperty.purchaseOrderId = this.purchaseOrderId ? this.purchaseOrderId : null;
                this.resetFilledData();
            },

            setChallanNoManual(){
                this.filterProperty.challanNoManual = this.challanNoManual ? this.challanNoManual : null;
                this.resetFilledData();
            },

            setVendorName(){
                this.filterProperty.vendorName = this.vendorName ? this.vendorName : null;
                this.resetFilledData();
            },

            setDateFrom(date){
                let dateFrom = moment(date).format('YYYY-MM-DD');
                this.filterProperty.dateFrom = dateFrom ? dateFrom : null;
                this.dateFrom = dateFrom;
                this.resetFilledData();
            },

            setDateTo(date){
                let dateTo = moment(date).format('YYYY-MM-DD');
                this.filterProperty.dateTo = dateTo ? dateTo : null;
                this.dateTo = dateTo;
                this.resetFilledData();
            },

            setShowRoute(id){
                return this.showPurchaseOrderRoute.route+"/"+id;
            },

            setEditRoute(id){
                return this.editPurchaseOrderRoute.route+"/"+id;
            },

            setDownloadRoute(id){
                return this.getDownloadMaterialPurchaseOrderRoute.route+"/"+id;
            },

            deleteMaterialPurchaseOrder(id){
                this.deletingMaterialPurchaseOrder[id] = true;
                this.filledData = {};
                this.filledData._token = this.token;
                this.filledData._method = "DELETE";
                let route = this.deletePurchaseOrderRoute.route + "/" + id;

                axios.post(route, this.filledData)
                    .then(result => {
                        this.statusMassage = { classType: "success", text: "Success! Record deleted successfully."};
                        window.location.href = result.data.redirect_route;
                    })
                    .catch(e => {
                        console.log(e);
                        this.statusMassage = { classType: "danger", text: "Something Wrong! Try again."};
                    })
                    .finally(()=>{
                        this.deletingMaterialPurchaseOrder[id] = false;
                    });
            },


            resetFilledData(){
                this.filledData = {};

                if(this.filterProperty.itemPerPage){
                    this.filledData.item_per_page = this.filterProperty.itemPerPage;
                }
                if (this.filterProperty.purchaseOrderId){
                    this.filledData.id = this.filterProperty.purchaseOrderId;
                }
                if (this.filterProperty.challanNoManual){
                    this.filledData.challan_no_mannual = this.filterProperty.challanNoManual;
                }
                if (this.filterProperty.vendorName){
                    this.filledData.vendor_name = this.filterProperty.vendorName;
                }
                if (this.filterProperty.dateFrom){
                    this.filledData.date_from = this.filterProperty.dateFrom;
                }
                if (this.filterProperty.dateTo){
                    this.filledData.date_to = this.filterProperty.dateTo;
                }

                this.generateDownloadUrl();
                this.getMaterialPurchaseOrders(1);

            },

            getMaterialPurchaseOrders(page){
                let route = this.getJsonMaterialPurchaseOrdersRoute + "?page=" + page;
                let paramsData = this.filledData;
                axios.get(route ,{
                    params: {
                        ...paramsData
                    }
                })
                    .then(result => {
                        this.materialPurchaseOrders = result.data.material_purchase_orders;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },

            generateDownloadUrl(){
                this.downloadRoute = null;
                let downloadUrl = null;
                const entries = Object.entries(this.filledData);
                for (let i=0; i<entries.length; i++) {
                    const [key,value] = entries[i];
                    if(value){
                        let param = downloadUrl ? '&' + key + '=' + value : this.getDownloadMaterialPurchaseOrdersRoute.route + '?' + key + '=' + value;
                        downloadUrl =  downloadUrl ? downloadUrl + param : param;
                    }
                }
                this.downloadRoute = downloadUrl;
                if(this.downloadRoute == null){
                    this.downloadRoute = this.getDownloadMaterialPurchaseOrdersRoute.route;
                }

            }
        },
        created() {
            this.getJsonMaterialPurchaseOrdersRoute = this.routes.getJsonMaterialPurchaseOrders;

            this.getDownloadMaterialPurchaseOrdersRoute.route = this.routes.getDownloadMaterialPurchaseOrders.route;
            this.getDownloadMaterialPurchaseOrdersRoute.can = this.routes.getDownloadMaterialPurchaseOrders.can ? this.routes.getDownloadMaterialPurchaseOrders.can : 0  ;
            this.getDownloadMaterialPurchaseOrderRoute.route = this.routes.getDownloadMaterialPurchaseOrder.route;
            this.getDownloadMaterialPurchaseOrderRoute.can = this.routes.getDownloadMaterialPurchaseOrder.can ? this.routes.getDownloadMaterialPurchaseOrder.can : 0  ;
            this.createPurchaseOrderRoute.route = this.routes.createPurchaseOrder.route;
            this.createPurchaseOrderRoute.can = this.routes.createPurchaseOrder.can ? this.routes.createPurchaseOrder.can : 0;
            this.showPurchaseOrderRoute.route = this.routes.showPurchaseOrder.route;
            this.showPurchaseOrderRoute.can = this.routes.showPurchaseOrder.can ? this.routes.showPurchaseOrder.can : 0;
            this.editPurchaseOrderRoute.route = this.routes.editPurchaseOrder.route;
            this.editPurchaseOrderRoute.can = this.routes.editPurchaseOrder.can ? this.routes.editPurchaseOrder.can : 0;
            this.deletePurchaseOrderRoute.route = this.routes.deletePurchaseOrder.route;
            this.deletePurchaseOrderRoute.can = this.routes.deletePurchaseOrder.can ? this.routes.deletePurchaseOrder.can : 0;

            this.resetFilledData();
        },
        computed:{

        }


    }

</script>