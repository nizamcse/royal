<template>
    <div>
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label name="product_type" for="exampleFormControlSelect1">Product Type</label>
                    <select class="form-control" id="exampleFormControlSelect1" @change="selectedValue">
                        <option :value="0">All</option>
                        <option :value="1">Log</option>
                        <option :value="2">Row Material</option>
                        <option :value="3">Other Material</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <div v-if="product_type == 2 || product_type == 3" class="form-group search-form-group" >
                        <label>Raw Materials</label>
                        <input type="text" name="raw_material_id" v-model="material.name" :class="material.name ? 'form-control': 'form-control text-danger'" @keyup="searchMaterials" required>
                        <ul class="search-result" v-if="rawMaterialsNameResults.length">
                            <li v-for="searchResult in rawMaterialsNameResults" @click="selectMaterials(searchResult)">{{ searchResult.name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Contact No</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(vendor, index) in vendors">
                        <td>
                            {{ index+1 }}
                        </td>
                        <td>

                            {{vendor.id}}
                        </td>
                        <td>
                            <a :href='vendorProfileUri + "/" + vendor.id'>{{vendor.name}}</a>

                        </td>
                        <td>
                            {{vendor.contact_no}}
                        </td>
                        <td>
                            {{vendor.address}}
                        </td>
                        <td>
                            <div class="row justify-content-center">
                                <button :data-id="vendor.id" class="btn btn-primary btn-sm flat btn-edit"
                                    data-toggle="modal" data-target="#edit-vendor"><i class="fa fa-edit"></i>
                                    Edit</button>
                                <button :data-url='deleteVendorUri + "/" + vendor.id'
                                    class="btn btn-danger btn-sm flat btn-delete" data-toggle="modal"
                                    data-target="#delete-content-modal"> <i class="fa fa-trash-o"></i> Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div id="paginationApp">
                    <pagination2 :totalPages="this.totalPages"
                                 :total="this.total"
                                 :lastPage="lastPage"
                                 :currentPage="currentPage"
                                 @pagechanged="onPageChange" v-if="vendors.length && !product_type ">
                    </pagination2>
                <div v-if="product_type">
                    <pagination2 :totalPages="this.totalPages"
                                 :total="this.total"
                                 :lastPage="lastPage"
                                 :currentPage="currentPage"
                                 @pagechanged="onPageChange" v-if="vendors.length >=10  && product_type ">
                    </pagination2>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    export default {
        props: ["items"],
        data(){
            return {
                vendors: this.items.vendors ? this.items.vendors:[],
                vendorProfileUri: null,
                deleteVendorUri: null,
                getVendorIdUri:null,
                getVendorsUri: null,
                product_type: null,
                otherMaterials: null,
                getDataOrder: [],
                lastPage: 1,
                currentPage: 1,
                next_page_url:"",
                filledData: {},
                total:null,
                totalPages:null,
                materials:[],
                material:{},
                rawMaterialsNameResults:[],
                rawMaterialsIDResults:[]
            }
        },
        methods: {
            selectedValue(e){
                this.product_type = e.target.value;
                this.material= {};
                this.onPageChange(1);
            },
            onPageChange(page) {
                let pageUrl = this.getVendorsUri;
                const data = {
                    page,
                    product_type: this.product_type,
                };
                if(this.material){
                    data.raw_material_id = this.material.id;
                }
                axios.get(pageUrl ,{
                    params:{
                        ...data
                    }
                }).then(response => {
                        this.currentPage = response.data.vendors.current_page;
                        this.lastPage = response.data.vendors.last_page;
                        this.next_page_url=response.data.vendors.next_page_url;
                        this.total = response.data.vendors.total;
                        this.totalPages = response.data.vendors.last_page;
                        this.materials = response.data.materials;
                        this.vendors = response.data.vendors.data;
                        console.log("vendors", this.vendors);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            searchMaterials(){
                if(this.material && this.material.name.length){
                    this.rawMaterialsNameResults = this.materials.filter((item)=>{
                        if(!item.name){
                            return false;
                        }
                        if(item.name.toUpperCase() == this.material.name.toUpperCase()){
                            return this.rawMaterialsNameResults;
                        }
                        else{
                            return item.name.toUpperCase().search(this.material.name.toUpperCase()) != -1;
                        }
                    });
                }else{
                    this.rawMaterialsNameResults = [];
                }
            },
            selectMaterials(item){
                this.material = item;
                // console.log(this.material);
                this.rawMaterialsNameResults=[];
                this.onPageChange(1);
            },

        },
        created() {
            /*
            this.vendors =JSON.parse(this.items);
            this.currentPage = this.items.vendors.current_page;
            this.lastPage = this.items.vendors.last_page;
            this.total = this.items.vendors.total;
            this.totalpage = this.items.vendors.total_page;
            */
            this.vendorProfileUri = this.items.vendorProfileUri;
            this.getVendorIdUri = this.items.getVendorIdUri;
            this.deleteVendorUri = this.items.deleteVendorUri;
            this.getVendorsUri = this.items.getVendorsUri;
            console.log("profile",this.vendorProfileUri);
            this.onPageChange(1);
        }
    }

</script>
<style scoped>
    #paginationApp {
        font-family: Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #367FA9;
        margin-top: 30px;
    }

</style>
