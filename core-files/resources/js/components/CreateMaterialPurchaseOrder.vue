<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h2><strong>CREATE MATERIAL PURCHASE ORDER HI</strong></h2>
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
                                <li v-for="item in vendorCollections" @click="selectVendor(item)">{{ item.name }}</li>
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
                <div  v-if="statusMassage.classType">
                    <div :class="'alert alert-dismissible alert-'+statusMassage.classType" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ statusMassage.text }}
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="product-type">Material Type <span class="text-danger">*</span></label>
                            <select id="product-type" class="form-control" v-model="materialType" :required="true">
                                <option value="1">Raw Material</option>
                                <option value="2">Other Material</option>
                            </select>
                        </div>
                    </div>
                    <div :class="isOtherMaterial ? 'col-md-3' : 'col-md-6'" v-if="hasMaterialType">
                        <div class="form-group">
                            <label>Material Name <span class="text-danger">*</span></label>
                            <input type="text" v-model="material.name" @keyup="searchMaterial" :class="material.id ? 'form-control': 'form-control text-danger'" placeholder="Example: 1/2 Elbow G.I" :required="true">
                            <ul class="search-result" v-if="materialCollections.length" >
                                <li v-for="item in materialCollections" @click="selectMaterial(item)">{{ item.name }}</li>
                            </ul>
                        </div>
                    </div>
                    <div :class="isOtherMaterial? 'col-md-2' :'col-md-3'" v-if="hasMaterialType">
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" class="form-control" v-model="material.unitName" readonly>
                        </div>
                    </div>
                    <div class="col-md-2" v-if="isOtherMaterial && hasMaterial">
                        <div class="form-group">
                            <label>Thickness  <span class="text-danger">*</span></label>
                            <input type="text" v-model="addableMaterialItem.thickness" class="form-control" placeholder="Example: 1.00" :required="true" >
                        </div>
                    </div>
                    <div class="col-md-2" v-if="isOtherMaterial && hasMaterial">
                        <div class="form-group">
                            <label>Size <span class="text-danger">*</span></label>
                            <input type="text" v-model="addableMaterialItem.size" class="form-control" placeholder="Example: 24x32" :required="true">
                        </div>
                    </div>
                </div>
                <div class="row" v-if="hasMaterial">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Quantity <span class="text-danger">*</span></label>
                            <input type="text" v-model="addableMaterialItem.quantity" class="form-control" placeholder="Example: 123" :required="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Unit Price <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" v-model="addableMaterialItem.pricePerUnit" placeholder="Example: 100.00" :required="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control" :value="amount" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class=" pull-right col-md-2" v-if="enableAddButton">
                        <div class="form-group">
                            <button class="btn btn-block btn-info" type="submit" :disabled="savingMaterialItem" @click="setFilterData">{{ savingMaterialItem ? "Saving..." : "+ ADD"}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box"  v-if="hasMaterialItems">
            <div class="box-header">
                MATERIAL ITEMS
            </div>
            <div class="box-body">
                <div class="row" v-if="rawMaterialItems.length">
                    <div class="col-md-12">
                        <h4>RAW MATERIAL ITEMS</h4>
                        <table class="table table-bordered list-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Amount</th>
                                <th class="w-100">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="(item,index) in rawMaterialItems">
                                <td>{{ index+1 }}</td>
                                <td>{{ item.materialName }}</td>
                                <td>{{ item.unit }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>{{ item.pricePerUnit }}</td>
                                <td>{{ item.amount }}</td>
                                <td class="text-right"><button class="btn btn-xs btn-danger" :disabled="deletingRawMaterialItem[item.id]" @click="removeMaterialItem(item)">{{deletingRawMaterialItem[item.id] ? "deleting..." : "REMOVE" }}</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" v-if="otherMaterialItems.length">
                    <div class="col-md-12">
                        <h4>OTHER MATERIAL ITEMS</h4>
                        <table class="table table-bordered list-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Thickness</th>
                                <th>Size</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Amount</th>
                                <th class="w-100">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="(item,index) in otherMaterialItems">
                                <td>{{ index+1 }}</td>
                                <td>{{ item.materialName }}</td>
                                <td>{{ item.thickness }}</td>
                                <td>{{ item.size }}</td>
                                <td>{{ item.unit }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>{{ item.pricePerUnit }}</td>
                                <td>{{ item.amount }}</td>
                                <td class="text-right"><button class="btn btn-xs btn-danger" :disabled="deletingOtherMaterialItem[item.id]" @click="removeMaterialItem(item)">{{deletingOtherMaterialItem[item.id] ? "deleting..." : "REMOVE" }}</button></td>
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
        props: ['token', 'routes', 'draft'],
        data: function () {
            return {
                getJsonVendorsRoute: null,
                getJsonMaterialsRoute: null,
                postJsonMaterialItemRoute: null,
                deleteJsonMaterialItemRoute: null,
                postJsonSavePurchaseOrderRoute: null,

                statusMassage: {
                    classType: null,
                    text: null,
                },

                materialType: null,
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
                materials: [],
                materialCollections: [],
                material:{
                    id: null,
                    name: null,
                    unitId: null,
                    unitName: null
                },
                addableMaterialItem: {
                    thickness: null,
                    size: null,
                    quantity: null,
                    pricePerUnit: null,
                    amount: null,
                },
                existingProperty:{
                    purchase_order_id: null,
                    vendor_id: null,
                    challan_no_mannual: null,
                    additional_challan_no_mannual: null,
                    purchase_date: null,
                },
                filledData: {},
                savingMaterialItem: false,
                deletingMaterialItem: [],
                savingOrder: false,
                rawMaterialItems: [],
                otherMaterialItems: [],
                deletingRawMaterialItem: [],
                deletingOtherMaterialItem: [],


            }
        },

        methods: {
            initVendors(){
                axios.get(this.getJsonVendorsRoute).then((response) => {
                    this.vendors = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            initMaterials(){
                axios.get(this.getJsonMaterialsRoute).then((response) => {
                    this.materials = response.data;
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
            selectVendor(obj){
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

            searchMaterial(){
                if (this.material.name.length){
                    this.materialCollections = this.materials.filter((item) => {
                        return item.name.toUpperCase().search(this.material.name.toUpperCase()) != -1;
                    });
                } else{
                    this.materialCollections = [];
                    this.material.id= null;
                    this.material.name = "";
                    this.material.unitId = null;
                    this.material.unitName = "";
                }
            },
            selectMaterial(obj){
                this.material.id = obj.id;
                this.material.name = obj.name;
                this.material.unitId = obj.unit_id;
                this.material.unitName = obj.unit.name;
                this.materialCollections = [];
            },

            setFilterData(){
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
                if(this.materialType){
                    this.filledData.material_type = this.materialType;
                }
                if(this.material.id){
                    this.filledData.material_id = this.material.id;
                }
                if(this.material.unitId){
                    this.filledData.unit_id = this.material.unitId;
                }
                if(this.addableMaterialItem.thickness){
                    this.filledData.thickness = this.addableMaterialItem.thickness;
                }
                if(this.addableMaterialItem.size){
                    this.filledData.size = this.addableMaterialItem.size;
                }
                if(this.addableMaterialItem.quantity){
                    this.filledData.quantity = this.addableMaterialItem.quantity;
                }
                if(this.addableMaterialItem.pricePerUnit){
                    this.filledData.price_per_pnit = this.addableMaterialItem.pricePerUnit;
                }

                this.postMaterialItem()
            },
            postMaterialItem(){
                this.savingMaterialItem = true;
                axios.post(this.postJsonMaterialItemRoute ,this.filledData)
                    .then(result => {
                        this.statusMassage = { classType: "success", text: "Material Item added successfully."};
                        this.existingProperty.purchase_order_id = result.data.purchase_order.id;
                        this.existingProperty.vendor_id = result.data.purchase_order.vendor_id;
                        this.existingProperty.challan_no_mannual = result.data.purchase_order.challan_no_mannual;
                        this.existingProperty.additional_challan_no_mannual= result.data.purchase_order.additional_challan_no_mannual;
                        this.existingProperty.purchase_date = result.data.purchase_order.purchase_date;

                        this.addMaterialItem(result.data.material_item);
                        this.addableMaterialItem = {
                            thickness: null,
                            size: null,
                            quantity: null,
                            pricePerUnit: null,
                            amount: null,
                        };
                        this.material = {
                            id: null,
                            name: null,
                            unitId: null,
                            unitName: null
                        };
                    })
                    .catch(e => {
                        console.log(e);
                        this.statusMassage = { classType: "danger", text: "Something Wrong! Try again."};
                    })
                    .finally(()=>{
                        this.savingMaterialItem = false;
                    });
            },

            addMaterialItem(obj) {
                if(obj.material_type == 1){
                    this.rawMaterialItems.push({
                        id: obj.id,
                        materialType: obj.material_type,
                        materialName: obj.raw_material.name,
                        unit: obj.unit.name,
                        pricePerUnit: obj.price_per_unit ? parseFloat(obj.price_per_unit).toFixed(2) : 0.00,
                        quantity: obj.quantity ? parseFloat(obj.quantity).toFixed(2) : 0.00,
                        amount: obj.amount ? parseFloat(obj.amount).toFixed(2) : 0.00,
                    });
                }else if (obj.material_type == 2){
                  this.otherMaterialItems.push({
                      id: obj.id,
                      materialType: obj.material_type,
                      materialName: obj.raw_material.name,
                      thickness: obj.inventory_item.thickness,
                      size: obj.inventory_item.size,
                      unit: obj.unit.name,
                      pricePerUnit: obj.price_per_unit ? parseFloat(obj.price_per_unit).toFixed(2) : 0.00,
                      quantity: obj.quantity ? parseFloat(obj.quantity).toFixed(2) : 0.00,
                      amount: obj.amount ? parseFloat(obj.amount).toFixed(2) : 0.00,
                  });
                }
            },
            removeMaterialItem(item){
                let materialType = item.materialType;
                if (materialType == 1){
                    this.deletingRawMaterialItem[item.id] = true;
                } else if(materialType == 2){
                    this.deletingOtherMaterialItem[item.id] = true;
                }
                this.filledData= {};
                this.filledData._token = this.token;
                this.filledData._method = "DELETE";
                this.filledData.id = item.id;

                axios.post(this.deleteJsonMaterialItemRoute+"/"+item.id, this.filledData)
                    .then(result => {
                        this.statusMassage = { classType: "success", text: "Material Item deleted successfully."};

                        if (materialType == 1){
                            this.rawMaterialItems.splice(this.rawMaterialItems.findIndex(ele=>ele.id === item.id),1);
                        } else if(materialType == 2){
                            this.otherMaterialItems.splice(this.otherMaterialItems.findIndex(ele=>ele.id === item.id),1);
                        }
                    })
                    .catch(e => {
                        console.log(e);
                        this.statusMassage = { classType: "danger", text: "Something Wrong! Try again."};
                    })
                    .finally(()=>{
                        if (materialType == 1){
                            this.deletingRawMaterialItem[item.id] = false;
                        } else if(materialType == 2){
                            this.deletingOtherMaterialItem[item.id] = false;
                        }
                    });
            },

            saveOrder(){
                this.savingOrder = true;
                this.filledData= {};

                this.filledData._token = this.token;
                if (this.existingProperty.purchase_order_id){
                    this.filledData.purchase_order_id = this.existingProperty.purchase_order_id;
                }else{
                    this.statusMassage = { classType: "danger", text: "Something Wrong! Try again."};
                    this.savingOrder = false;
                    return;
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
                draft.materials.forEach(element => {
                    this.addMaterialItem(element);
                });
            },

        },
        created(){
            this.getJsonVendorsRoute = this.routes.getJsonVendors;
            this.getJsonMaterialsRoute = this.routes.getJsonMaterials;
            this.postJsonMaterialItemRoute = this.routes.postJsonMaterialItem;
            this.deleteJsonMaterialItemRoute = this.routes.deleteJsonMaterialItem;
            this.postJsonSavePurchaseOrderRoute = this.routes.postJsonSavePurchaseOrder;
            this.initVendors();
            this.initMaterials();
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
                    return  false;
                }
            },
            hasMaterialType(){
                if(this.materialType){
                    return true;
                }else {
                    return false;
                }
            },
            hasMaterial(){
                if(this.material.id){
                    return true;
                }else{
                    return false;
                }
            },
            isOtherMaterial(){
                if(this.materialType ==2 ){
                    return true;
                }
                else{
                    this.addableMaterialItem.thickness = null;
                    this.addableMaterialItem.size = null;
                    return false;
                }
            },
            amount(){
                let p = this.addableMaterialItem.quantity ? parseFloat(this.addableMaterialItem.quantity) : 0;
                let q = this.addableMaterialItem.pricePerUnit ? parseFloat(this.addableMaterialItem.pricePerUnit) : 0;
                this.addableMaterialItem.amount = parseFloat(p*q).toFixed(2);
                return this.addableMaterialItem.amount;
            },
            enableAddButton(){
                if(this.materialType == 1 && (parseFloat(this.addableMaterialItem.amount))){
                    return  true;
                }else if (this.materialType == 2 && (parseFloat(this.addableMaterialItem.amount) && (this.addableMaterialItem.thickness && this.addableMaterialItem.size))) {
                    return true;
                }else {
                    return false;
                }
            },
            hasMaterialItems(){
                if(this.otherMaterialItems.length || this.rawMaterialItems.length){
                    return true;
                }else {
                    return false;
                }
            }
        }
    }
</script>
