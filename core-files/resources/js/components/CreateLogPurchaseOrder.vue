<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h2><strong>CREATE LOG PURCHASE ORDER</strong></h2>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <h4>ORDER DETAILS</h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" v-model="vendor.name" @keyup="searchVendor" :class="vendor.id ? 'form-control': 'form-control text-danger'" placeholder="Example: Mr. Alam | Alam Enterprise" :required="true">
                            <ul class="search-result" v-if="vendorCollections.length" >
                                <li v-for="item in vendorCollections" @click="selectVendors(item)">{{ item.name }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Supplier Address</label>
                            <input type="text" v-model="vendor.address" class="form-control"  readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Supplier Number</label>
                            <input type="text" v-model="vendor.contactNo" class="form-control"  readonly>
                        </div>
                    </div>

                </div>
                <div class="row" v-if="hasVendor">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Chalan No# (Manual Entry)</label>
                            <input type="text" v-model="challanNoMannual" class="form-control" placeholder="Example: 1000">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Additional Chalan No# (Extra Manual)</label>
                            <input type="text" v-model="additionalChallanNoMannual" class="form-control" placeholder="If more than one, separate by comma.">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Purchase Date <span class="text-danger">*</span></label>
                            <datepicker v-model="purchaseDate" input-class="form-control" :required="true" :typeable="!hasPurChaseDate" :placeholder="'Select a Date. Example: 1 Jan 2000'" @selected="setPurchaseDate"></datepicker>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box" v-if="hasPurChaseDate">
            <div class="box-header">
                <h4>PRODUCT DETAILS</h4>
                <div :class="'alert alert-dismissible alert-'+statusMassage.classType" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ statusMassage.text }}
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select v-model="categoryId" class="form-control" v-on:change="changeGrade">
                                <option :value="null">Select Category</option>
                                <option v-for="item in categories"  :value="item.id">{{ item.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Radius</label>
                            <input type="text" class="form-control" placeholder="Radius" v-model="addableLogItem.radius" v-on:keyup="changeGrade" :required="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Height</label>
                            <input type="text" class="form-control" v-model="addableLogItem.height" placeholder="Height" :required="true">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Quantity(Area)</label>
                            <input type="text" class="form-control" :value="area()" placeholder="Area" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Grade</label>
                            <input type="text" class="form-control" placeholder="Grade" v-model="addableLogItem.gradeName" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Unit Price</label>
                            <input type="text" class="form-control" placeholder="Unit Price" v-model="addableLogItem.gradePricePerUnit" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control" :value="amount()" placeholder="Amount" readonly>
                        </div>
                    </div>
                    <div class="col-md-2" v-if="enableAddButton">
                        <div class="form-group" style="margin-top: 25px">
                            <button class="btn btn-block btn-info" type="submit" :disabled="savingLogItem" @click="resetAPI">{{ savingLogItem ? "Saving..." : "+ ADD"}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box"  v-if="logItems.length">
            <div class="box-header">
                LOG ITEMS
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered list-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Radius</th>
                                <th>Height</th>
                                <th>Quantity (Area)</th>
                                <th>Grade</th>
                                <th>Amount</th>
                                <th class="w-100">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="(item,index) in logItems">
                                <td>{{ index+1 }}</td>
                                <td>{{ getCategoryName(item.categoryId) }}</td>
                                <td>{{ item.radius }}</td>
                                <td>{{ item.height }}</td>
                                <td>{{ item.quantity.toFixed(2) }}</td>
                                <td>{{ item.grade }}</td>
                                <td>{{ item.TotalAmount.toFixed(2) }}</td>
                                <td class="text-right"><button class="btn btn-xs btn-danger" :disabled="deletingLogItem[item.id]" @click="removeLogItem(item.id)">{{deletingLogItem[item.id] ? "deleting..." : "REMOVE" }}</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-success" :disabled="savingOrder" @click="saveOrder()" >{{ savingOrder ? "Saving Order ..." : "SAVE ORDER"}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['token','draft','routes'],

        data: function () {
            return {
                getJsonVendorsRoute: null,
                getJsonCategoriesRoute: null,
                getJsonGradesRoute: null,
                postJsonLogItemRoute: null,
                deleteJsonLogItemRoute: null,
                postJsonSavePurchaseOrderRoute: null,
                statusMassage: {
                    classType: null,
                    text: null,
                },
                vendors: [],
                vendorCollections: [],
                vendor:{
                    id: null,
                    name: null,
                    address: null,
                    contactNo: null,
                },
                challanNoMannual: null,
                additionalChallanNoMannual: null,
                purchaseDate: null,
                categories: [],
                grades: [],
                categoryId: null,
                logItems: [],
                addableLogItem: {
                    radius: null,
                    height: null,
                    gradeId: null,
                    gradeName: null,
                    gradePricePerUnit: null,
                },
                existingProperty:{
                    purchase_order_id: null,
                    vendor_id: null,
                    challan_no_mannual: null,
                    additional_challan_no_mannual: null,
                    purchase_date: null,
                },
                filledData: {},
                savingLogItem: false,
                deletingLogItem: [],
                savingOrder: false,
            };
        },

        methods: {
            initVendors(){
                axios.get(this.getJsonVendorsRoute).then((response) => {
                    this.vendors = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            initCategories(){
                axios.get(this.getJsonCategoriesRoute).then((response) => {
                    this.categories = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            initGrades(){
                axios.get(this.getJsonGradesRoute).then((response) => {
                    this.grades = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            searchVendor(){
                if (this.vendor.name.length){
                    this.vendorCollections = this.vendors.filter((item) => {
                        return item.name.toUpperCase().search(this.vendor.name.toUpperCase()) != -1;
                    });
                } else{
                    this.vendorCollections = [];
                    this.vendor.id= null;
                    this.vendor.address = "";
                    this.vendor.contactNo = "";
                }
            },
            selectVendors(obj){
                this.vendor.id = obj.id;
                this.vendor.name = obj.name;
                this.vendor.address = obj.address;
                this.vendor.contactNo = obj.contact_no;
                this.vendorCollections = [];
            },
            setPurchaseDate(date){
                let SelectedDate = moment(date).format('YYYY-MM-DD');
                this.purchaseDate = SelectedDate ? SelectedDate : null;
            },
            changeGrade(){
                this.addableLogItem.gradeName = null;
                this.addableLogItem.gradePricePerUnit = null;

                if(!this.addableLogItem.radius){
                    return;
                }

                let lr = parseFloat(this.addableLogItem.radius);

                for (let i=0; i<this.grades.length; i++){
                    if((lr >= this.grades[i].min_radius && lr <= this.grades[i].max_radius) && this.grades[i].category_id == this.categoryId ){
                        this.addableLogItem.gradeId = this.grades[i].id;
                        this.addableLogItem.gradeName = this.grades[i].name;
                        this.addableLogItem.gradePricePerUnit = this.grades[i].price_per_unit;
                        return;
                    }
                }
            },
            area(){
                let r = this.addableLogItem.radius ? parseFloat(this.addableLogItem.radius) : 0;
                let h = this.addableLogItem.height ? parseFloat(this.addableLogItem.height) : 0;
                return parseFloat((r*r*h)/2304).toFixed(2);
            },
            amount() {
                let logUnitPrice = this.addableLogItem.gradePricePerUnit ? this.addableLogItem.gradePricePerUnit : 0;
                let logArea = this.area();
                let price = logUnitPrice * logArea ;
                return parseFloat(price).toFixed(2);
            },
            resetAPI(){
                this.filledData = {};
                this.filledData._token = this.token;
                if (this.existingProperty.purchase_order_id){
                    this.filledData.purchase_order_id = this.existingProperty.purchase_order_id;
                }
                if(this.vendor.id !== this.existingProperty.vendor_id){
                    this.filledData.vendor_id = this.vendor.id;
                }
                if(this.challanNoMannual !== this.existingProperty.challan_no_mannual){
                    this.filledData.challan_no_mannual = this.challanNoMannual;
                }
                if (this.additionalChallanNoMannual !== this.existingProperty.additional_challan_no_mannual){
                    this.filledData.additional_challan_no_mannual = this.additionalChallanNoMannual;
                }
                if (this.purchaseDate !== this.existingProperty.purchase_date) {
                    this.filledData.purchase_date = this.purchaseDate;
                }
                if (this.categoryId) {
                    this.filledData.category_id = this.categoryId;
                }
                if(this.addableLogItem.radius){
                    this.filledData.radius = this.addableLogItem.radius;
                }
                if(this.addableLogItem.height){
                    this.filledData.height = this.addableLogItem.height;
                }
                if(this.addableLogItem.gradeName){
                    this.filledData.grade = this.addableLogItem.gradeName;
                }
                if(this.addableLogItem.gradePricePerUnit){
                    this.filledData.price_per_unit = this.addableLogItem.gradePricePerUnit;
                }

                this.postLogItem();
            },

            postLogItem(){
                this.savingLogItem = true;
                axios.post(this.postJsonLogItemRoute ,this.filledData)
                    .then(result => {
                        this.statusMassage = { classType: "success", text: "Log Item added successfully."};
                        this.existingProperty.purchase_order_id = result.data.purchase_order.id;
                        this.existingProperty.vendor_id = result.data.purchase_order.vendor_id;
                        this.existingProperty.challan_no_mannual = result.data.purchase_order.challan_no_mannual;
                        this.existingProperty.additional_challan_no_mannual= result.data.purchase_order.additional_challan_no_mannual;
                        this.existingProperty.purchase_date = result.data.purchase_order.purchase_date;
                        this.addLogItem(result.data.log_item);
                        this.addableLogItem = {
                            radius: null,
                            height: null,
                            gradeId: null,
                            gradeName: null,
                            gradePricePerUnit: null,
                        };
                    })
                    .catch(e => {
                        console.log(e);
                        this.statusMassage = { classType: "danger", text: "Something Wrong! Try again."};
                    })
                    .finally(()=>{
                        this.savingLogItem = false;
                    });
            },

            addLogItem(obj) {
                this.logItems.push({
                    id: obj.id,
                    categoryId: obj.category_id,
                    radius: obj.radius,
                    height: obj.height,
                    quantity: obj.quantity,
                    grade: obj.grade,
                    unitPrice: obj.price_per_unit,
                    TotalAmount: obj.total_price,
                });
            },

            getCategoryName(id){
                for (let i=0; i<this.categories.length; i++){
                    if(this.categories[i].id == id){
                        return this.categories[i].name;
                    }
                }
                return "";
            },

            removeLogItem(id){
                this.deletingLogItem[id] = true;
                this.filledData= {};
                this.filledData._token = this.token;
                this.filledData._method = "DELETE";
                this.filledData.id = id;

                axios.post(this.deleteJsonLogItemRoute+"/"+id, this.filledData)
                    .then(result => {
                        this.statusMassage = { classType: "success", text: "Log Item deleted successfully."};

                        this.logItems.splice(this.logItems.findIndex(ele=>ele.id === id),1);
                    })
                    .catch(e => {
                        console.log(e);
                        this.statusMassage = { classType: "danger", text: "Something Wrong! Try again."};
                    })
                    .finally(()=>{
                        this.deletingLogItem[id] = false;
                    });
            },

            saveOrder(){
                this.savingOrder = true;
                this.filledData= {};

                this.filledData._token = this.token;
                if (this.existingProperty.purchase_order_id){
                    this.filledData.purchase_order_id = this.existingProperty.purchase_order_id;
                }
                if(this.vendor.id !== this.existingProperty.vendor_id){
                    this.filledData.vendor_id = this.vendor.id;
                }
                if(this.challanNoMannual !== this.existingProperty.challan_no_mannual){
                    this.filledData.challan_no_mannual = this.challanNoMannual;
                }
                if (this.additionalChallanNoMannual !== this.existingProperty.additional_challan_no_mannual){
                    this.filledData.additional_challan_no_mannual = this.additionalChallanNoMannual;
                }
                if (this.purchaseDate !== this.existingProperty.purchase_date) {
                    this.filledData.purchase_date = this.purchaseDate;
                }
                axios.post(this.postJsonSavePurchaseOrderRoute, this.filledData)
                    .then(result => {
                        window.location.href = result.data.redirect_route;
                    })
                    .catch(e => {
                        console.log(e);
                        this.statusMassage = { classType: "danger", text: "Something Wrong! Try again."};
                    })
                    .finally(()=>{
                        this.savingOrder = false;
                    });
            },

            initDraft(){
                const draft = this.draft;
                if(Object.keys(draft).length === 0){
                    return;
                }
                this.vendor = {
                    id: draft.vendor.id,
                    name: draft.vendor.name,
                    address: draft.vendor.address,
                    contactNo: draft.vendor.contact_no,
                };
                this.challanNoMannual = draft.challan_no_mannual;
                this.additionalChallanNoMannual = draft.additional_challan_no_mannual;
                this.purchaseDate = draft.purchase_date;
                this.existingProperty = {
                    purchase_order_id: draft.id,
                    vendor_id: draft.vendor.id,
                    challan_no_mannual: draft.challan_no_mannual,
                    additional_challan_no_mannual: draft.additional_challan_no_mannual,
                    purchase_date: draft.purchase_date,
                };
                draft.logs.forEach(element => {
                    this.addLogItem(element);
                });
            }

        },

        created() {
            this.getJsonVendorsRoute = this.routes.getJsonVendors;
            this.getJsonCategoriesRoute = this.routes.getJsonCategories;
            this.getJsonGradesRoute = this.routes.getJsonGrades;
            this.postJsonLogItemRoute = this.routes.postJsonLogItem;
            this.deleteJsonLogItemRoute = this.routes.deleteJsonLogItem;
            this.postJsonSavePurchaseOrderRoute = this.routes.postJsonSavePurchaseOrder;
            this.initVendors();
            this.initCategories();
            this.initGrades();
            if (this.draft){
                this.initDraft()
            }
        },
        computed:{
            hasVendor(){
                if(this.vendor.id){
                    return true;
                }else {
                    this.purchaseDate = null;
                    return false;
                }
            },
            hasPurChaseDate(){
                if (this.purchaseDate){
                    this.setPurchaseDate(this.purchaseDate);
                    return true;
                }else {
                    this.categoryId = null;
                    return  false;
                }
            },
            enableAddButton(){
                if (this.amount() != 0.00) {
                    return true;
                }else {
                    return false;
                }
            },
        }
    }
</script>
