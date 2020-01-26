<template>
    <div>
        <div class="box">
            <div class="box-header">PRODUCTION INFORMATION</div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Starting Time</label>
                            <input type="hidden" name="start_at" :value="startingTime">
                            <datetime type="datetime" format="yyyy-MM-dd HH:mm:ss" input-class="form-control" v-model="startTime" use12-hour>
                            </datetime>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ending Time</label>
                            <input type="hidden" name="end_at" :value="endingTime">
                            <datetime type="datetime" format="yyyy-MM-dd HH:mm:ss" input-class="form-control" v-model="endTime" use12-hour>
                            </datetime>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Total Labour</label>
                            <input type="text" name="total_labour" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Total Labour Cost</label>
                            <input type="text" name="total_labour_cost" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Utility Cost</label>
                            <input type="text" name="utility_cost" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Other Cost</label>
                            <input type="text" name="other_cost" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="checkbox icheck" style="margin-top:30px; font-size: 16px; padding-left:20px">
                                <label>
                                    <input type="checkbox" name="good_produced" v-model="goodProduced">  Production Nill
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" v-if="goodProduced">
                        <label>Comment</label>
                        <textarea name="comment" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="box" v-if="!goodProduced">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="product-type">Product Type</label>
                            <select id="product-type" class="form-control" v-model="productType" v-on:change="selectProductType">
                                <option value="">Select</option>
                                <option value="1">Log</option>
                                <option value="2">Row Material</option>
                                <option value="3">Other Material</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Chalan No / PO No</label>
                            <input type="text" class="form-control" v-model="formData.chalanNo">
                        </div>
                    </div>
                    <div class="col-md-3" v-if="productType ==1">
                        <div class="form-group search-form-group" style="color: #000;">
                            <label>Log No</label>
                            <input type="number" v-model="formData.logNo" :class="formData.id ? 'form-control': 'form-control text-danger'" @keyup="searchLog">
                            <ul class="search-result" v-if="logResults.length">
                                <li v-for="logResult in logResults" @click="selectLog(logResult)">{{ logResult.log_no }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="productType !=1">
                        <div class="form-group search-form-group" style="color: #000;">
                            <label>Name</label>
                            <input type="text" v-model="formData.name" :class="formData.id ? 'form-control': 'form-control text-danger'" @keyup="searchMaterial">
                            <ul class="search-result" v-if="materialResults.length">
                                <li v-for="materialResult in materialResults" @click="selectMaterial(materialResult)">{{ materialResult.name }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2" v-if="productType ==1">
                        <div class="form-group">
                            <label>Previous Radius</label>
                            <input type="text" class="form-control" v-model="formData.oldRadius" disabled>
                        </div>
                    </div>
                    <div class="col-md-2" v-if="productType ==1">
                        <div class="form-group">
                            <label>Previous Height</label>
                            <input type="text" class="form-control" v-model="formData.oldHeight" disabled>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="productType ==1">
                        <div class="form-group">
                            <label>Previous Quantity</label>
                            <input type="text" class="form-control" v-model="formData.oldArea" disabled>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="productType ==1">
                        <div class="form-group">
                            <label>New Radius</label>
                            <input type="number" class="form-control" v-model="formData.newRadius">
                        </div>
                    </div>
                    <div class="col-md-3" v-if="productType ==1">
                        <div class="form-group">
                            <label>New Height</label>
                            <input type="number" class="form-control" v-model="formData.newHeight">
                        </div>
                    </div>
                    <div class="col-md-3" v-if="productType ==1">
                        <div class="form-group">
                            <label>New Quantity</label>
                            <input type="text" class="form-control" :value="newArea" disabled>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="productType ==3">
                        <div class="form-group">
                            <label>Thickness</label>
                            <input type="text" class="form-control" v-model="formData.thickness" disabled>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="productType ==3">
                        <div class="form-group">
                            <label>Size</label>
                            <input type="text" class="form-control" v-model="formData.size" disabled>
                        </div>
                    </div>
                    <div class="col-md-2" v-if="productType !=1">
                        <div class="form-group">
                            <label>Used Qty</label>
                            <input type="text" class="form-control" v-model="formData.quantity">
                        </div>
                    </div>
                    <div class="col-md-2" v-if="productType !=1">
                        <div class="form-group">
                            <label>Wasted Qty</label>
                            <input type="text" class="form-control" v-model="formData.wastedQuantity">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 pull-right">
                        <div class="form-group text-right" style="margin-top: 20px">
                            <button type="button" class="btn btn-block btn-info" @click="addItem" :disabled="!validateForm()">ADD</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box" v-if="!goodProduced">
            <div class="box-header">LIST OF LOGS <span class="badge badge-square badge-success pull-right">TOTAL LOG: {{ totalLog }} Sft.</span></div>
            <div class="box-body">
                <table class="table table-bordered list-table">
                    <thead>
                    <tr>
                        <th>Old Radius</th>
                        <th>Old Height</th>
                        <th>Old Qty</th>
                        <th>New Radius</th>
                        <th>New Height</th>
                        <th>New Qty</th>
                        <th class="w-100">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in logItems">
                        <td>
                            {{ item.oldRadius }}
                            <input type="hidden" :name="'log['+ index +'][challan_no_mannual]'" :value="item.chalanNo">
                            <input type="hidden" :name="'log['+ index +'][id]'" :value="item.id">
                        </td>
                        <td>{{ item.oldHeight }}</td>
                        <td>{{ item.oldArea }} </td>
                        <td>{{ item.newRadius }} <input type="hidden" :name="'log['+ index +'][new_radius]'" :value="item.newRadius"></td>
                        <td>{{ item.newHeight }} <input type="hidden" :name="'log['+ index +'][new_height]'" :value="item.newHeight"></td>
                        <td>{{ item.newArea }} <input type="hidden" :name="'log['+ index +'][new_quantity]'" :value="item.newArea"></td>
                        <td class="text-right"><button class="btn btn-xs btn-danger" @click="removeLogItem(index)">-</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box" v-if="!goodProduced">
            <div class="box-header">LIST OF RAW MATERIALS</div>
            <div class="box-body">
                <table class="table table-bordered list-table">
                    <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th class="w-100">Unit Price</th>
                        <th class="w-100">Quantity</th>
                        <th class="w-100">Wasted Quantity</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(rawMaterialItem,index) in rawMaterialItems">
                        <th>
                            {{ rawMaterialItem.name }}
                            <input type="hidden" :name="'raw_material['+ index +'][parent_id]'" :value="rawMaterialItem.id">
                            <input type="hidden" :name="'raw_material['+ index +'][challan_no_mannual]'" :value="rawMaterialItem.chalanNo">
                        </th>
                        <th>{{ rawMaterialItem.unit }}</th>
                        <th>{{ rawMaterialItem.price }} <input type="hidden" :name="'raw_material['+ index +'][price]'" :value="rawMaterialItem.price"></th>
                        <th>{{ rawMaterialItem.quantity }}<input type="hidden" :name="'raw_material['+ index +'][quantity]'" :value="rawMaterialItem.quantity"></th>
                        <th>{{ rawMaterialItem.wastedQuantity }}<input type="hidden" :name="'raw_material['+ index +'][wasted_quantity]'" :value="rawMaterialItem.wastedQuantity"></th>
                        <th>
                            {{ rawMaterialItem.amount }}
                            <input type="hidden" :name="'raw_material['+ index +'][amount]'" :value="rawMaterialItem.amount">
                            <input type="hidden" :name="'raw_material['+ index +'][thickness]'">
                            <input type="hidden" :name="'raw_material['+ index +'][size]'">
                            <input type="hidden" :name="'raw_material['+ index +'][type]'" value="1">
                        </th>
                        <th class="text-right"><button class="btn btn-xs btn-danger" @click="removeRowMaterialItem(index)">-</button></th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box" v-if="!goodProduced">
            <div class="box-header">LIST OF OTHER MATERIALS</div>
            <div class="box-body">
                <table class="table table-bordered list-table">
                    <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Thickness</th>
                        <th>Size</th>
                        <th>Unit</th>
                        <th class="w-100">Unit Price</th>
                        <th class="w-100">Quantity</th>
                        <th class="w-100">Wasted Quantity</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(rawMaterialItem,index) in otherMaterialItems">
                        <th>
                            {{ rawMaterialItem.name }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][parent_id]'" :value="rawMaterialItem.id">
                            <input type="hidden" :name="'raw_material['+ index +'][po_id]'" :value="rawMaterialItem.chalanNo">
                        </th>
                        <th>{{ rawMaterialItem.thickness }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][thickness]'" :value="rawMaterialItem.thickness"></th>
                        <th>{{ rawMaterialItem.size }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][size]'" :value="rawMaterialItem.size"></th>
                        <th>{{ rawMaterialItem.unit }}</th>
                        <th>{{ rawMaterialItem.price }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][price]'" :value="rawMaterialItem.price"></th>
                        <th>{{ rawMaterialItem.quantity }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][quantity]'" :value="rawMaterialItem.quantity"></th>
                        <th>{{ rawMaterialItem.wastedQuantity }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][wasted_quantity]'" :value="rawMaterialItem.wastedQuantity"></th>
                        <th>
                            {{ rawMaterialItem.amount }}
                            <input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][amount]'" :value="rawMaterialItem.amount">
                            <input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][type]'" value="2">
                        </th>

                        <th class="text-right"><button class="btn btn-xs btn-danger" @click="removeOtherItem(index)">-</button></th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <div class="form-group text-right">
                    <button class="btn btn-info" type="submit">CREATE PRODUCTION</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['items'],
        data: function () {
            return {
                productType: 1,
                startTime: "",
                endTime: "",
                disableAddButton: true,
                goodProduced: false,
                formData: {
                    productType: null,
                    chalanNo: null,
                    logNo: null,
                    oldRadius: null,
                    oldHeight: null,
                    oldArea: null,
                    newRadius: null,
                    newHeight: null,
                    name: null,
                    thickness: null,
                    size: null,
                    quantity: null,
                    wastedQuantity: null,
                    remQuantity: null,
                    id: null,
                    type: null,
                    amount: null,
                    price: null,
                },
                logs: [],
                logResults: [],
                logItems: [],
                materials: [],
                materialResults: [],
                rawMaterialItems: [],
                otherMaterialItems: [],
            }
        },

        computed: {
            newArea: function(){
                let r = this.formData.newRadius ? parseFloat(this.formData.newRadius) : 0;
                let h = this.formData.newHeight ? parseFloat(this.formData.newHeight) : 0;
                return parseFloat((r*r*h)/2304).toFixed(2);
            },
            totalLog: function(){
                let total = 0.0;
                for (let i=0; i<this.logItems.length; i++){
                    total = parseFloat(total) + parseFloat(this.logItems[i].newArea);
                }
                return total;
            },
            startingTime: function(){
                return this.startTime ? moment(this.startTime).format('DD-MM-YYYY HH:mm:ss') : '';
            },
            endingTime: function(){
                return this.endTime ? moment(this.endTime).format('DD-MM-YYYY HH:mm:ss') : '';
            },
        },

        methods: {
            selectProductType: function(){
                let pType = parseInt(this.productType);
                this.resetForm();
                this.productType = pType;
                if(pType ==1){
                    return this.formData.newRadius && this.formData.newHeight && this.formData.id;
                }else{
                    return this.formData.quantity && this.formData.id;
                }

            },
            validateForm: function(){
                let pType = parseInt(this.productType);
                if(pType ==1){
                    return this.formData.newRadius && this.formData.newHeight && this.formData.id;
                }else{
                    return this.formData.quantity && this.formData.id;
                }
                this.productType = pType;
            },
            searchMaterial: function(){
                let materialType = this.productType -1;
                this.materialResults = [];
                if(this.formData.name && this.formData.name.length){
                    this.materialResults = this.materials.filter((item) => {
                        console.log(item,materialType,this.productType,this.formData.name)
                        if(item.name.toUpperCase() == this.formData.name.toUpperCase() && materialType == item.material_type){
                            this.selectMaterial(item);
                        }
                        else{
                            return item.name.toUpperCase().search(this.formData.name.toUpperCase()) != -1 && materialType == item.material_type;
                        }
                    });
                }
            },

            selectMaterial: function(material){
                console.log(material)
                this.materialResults = [];
                this.formData.id = material.id;
                this.formData.name = material.name;
                this.formData.thickness = material.thickness;
                this.formData.size = material.size;
                this.formData.chalanNo = material.po_id;
                this.formData.remQuantity = material.remaining_quantity;
                this.formData.price = material.price;
            },

            searchLog: function(){
                this.logResults = [];
                console.log(this.logs,this.formData.logNo && this.formData.chalanNo)
                if(this.formData.logNo && this.formData.chalanNo){
                    this.logResults = this.logs.filter((item) => {
                        return item.challan_no_mannual == this.formData.chalanNo && item.log_no == this.formData.logNo;
                    });
                }
            },

            selectLog: function(log){
                this.logResults = [];
                this.formData.logNo = log.log_no;
                this.formData.oldHeight = log.height;
                this.formData.oldRadius = log.radius;
                this.formData.oldArea = log.quantity;
                this.formData.id = log.id;
                this.formData.chalanNo = log.challan_no_mannual;
            },

            addItem: function() {
                this.formData.newArea = this.newArea;
                if(this.productType ==1){
                    this.logItems.push(this.formData);
                }else if(this.productType ==2){
                    let quantity = parseInt(this.formData.quantity) + parseInt(this.formData.wastedQuantity)
                    let amount = parseInt(this.formData.price) * parseInt(quantity)
                    this.formData.amount = amount
                    this.rawMaterialItems.push(this.formData);
                }else if(this.productType ==3){
                    let quantity = parseInt(this.formData.quantity) + parseInt(this.formData.wastedQuantity)
                    let amount = parseInt(this.formData.price) * parseInt(quantity)
                    this.formData.amount = amount
                    this.otherMaterialItems.push(this.formData);
                }
                this.resetForm();
            },

            removeLogItm: function(i){},

            resetForm: function(){
                this.formData = {
                    productType: null,
                    chalanNo: null,
                    logNo: null,
                    oldRadius: null,
                    oldHeight: null,
                    oldArea: null,
                    newRadius: null,
                    newHeight: null,
                    name: null,
                    thickness: null,
                    size: null,
                    quantity: null,
                    wastedQuantity: null,
                    id: null,
                    type: null,
                    remQuantity: null,
                    price: null,
                };
                this.formData.chalanNo = chalanNo;

            },
            initGoods(){
                axios.get(this.items.materialUrl).then((response) => {
                    this.materials = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },

        },
        created: function () {
            this.logs = this.items.logs;
            this.initGoods();
            console.log('Hello Json')
        },

        mounted() {
            console.log('Create Production Component mounted.')
        }
    }
</script>
