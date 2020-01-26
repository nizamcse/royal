<template>
    <div class="row">
        <input type="hidden" name="user_id" v-model="user.id">
        <div class="col-md-4">
            <div class="form-group">
                <label>Company Name *</label>
                <input type="text" class="form-control" name="name" v-model="company.name" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Contact No</label>
                <input type="text" class="form-control" name="contact_no" v-model="company.contactNo">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="address" v-model="company.address">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" v-model="company.email">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group search-form-group">
                <label>Admin Name</label>
                <input type="text" class="form-control" name="admin_name" v-model="user.name" @keyup="searchAdminByName" autocomplete="off" required>
                <ul class="search-result" v-if="admins.length && cursorStatus ==1">
                    <li class="user-li" v-for="admin in admins" @click="selectAdmin(admin)">
                        <span class="name">{{ admin.name }}</span>
                        <span class="email">{{ admin.email }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group search-form-group">
                <label>Admin Email</label>
                <input type="email" class="form-control" name="admin_email" v-model="user.email" @keyup="searAdminByEmail" required>
                <ul class="search-result" v-if="admins.length  && cursorStatus ==2">
                    <li class="user-li" v-for="admin in admins" @click="selectAdmin(admin)">
                        <span class="name">{{ admin.name }}</span>
                        <span class="email">{{ admin.email }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Change Logo</label>
                <input type="file" name="logo">
            </div>
        </div>
        <div class="col-md-2" v-if="company.logo">
            <img :src="company.logo" alt="" class="img-responsive">
        </div>
        <div class="col-md-12">
            <div class="form-group text-right">
                <button class="btn btn-info btn-sm flat" type="submit" :disabled="validateInputs">UPDATE COMPANY</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        data: function() {

            return {
                user: {
                    name: "",
                    email: "",
                    id: null,
                },
                company: {
                    name: "",
                    email: "",
                    contactNo: "",
                    address: "",
                    logo: "",
                },
                cursorStatus: 0,
                apiUrl: "",
                admins: [],
                password: null,
                confirmPassword: null,
            };
        },
        computed: {
            validatePassword: function(){
                if(this.password){
                    return this.password.length > 5 && (this.password == this.confirmPassword);
                }else{
                    return true;
                }
            },
            validateName: function(){
                return this.company.name.length > 0;
            },
            validateInputs: function(){

                if(this.user.id && this.validateName){
                    return false;
                }
                else{
                    return true;
                }
            }
        },

        methods: {

            searchAdminByName: function(){
                var app = this;
                this.cursorStatus =1;
                this.user.email = "";
                this.user.id = null;
                if(this.user.name && this.user.name.length > 1){
                    axios.post(this.apiUrl,{
                        name: app.user.name,
                    }).then(response => {
                        app.admins = response.data;
                    }).catch(e => {
                        console.log(e)
                    });
                }
            },
            searAdminByEmail: function(){
                var app = this;
                this.user.name = "";
                this.user.id = null;
                this.cursorStatus = 2;
                if(this.user.email && this.user.email.length > 1){
                    axios.post(this.apiUrl,{
                        email: app.user.email,
                    }).then(response => {
                        app.admins = response.data;
                    }).catch(e => {
                        console.log(e)
                    });
                }
            },
            selectAdmin: function(admin){
                this.user.id = admin.id;
                this.user.email = admin.email;
                this.user.name = admin.name;
                this.cursorStatus = 0;
            }

        },
        created: function() {
            this.user.name = this.items.user.name;
            this.user.email = this.items.user.email;
            this.user.id = this.items.user.id;
            this.company.name =  this.items.company.name;
            this.company.email =  this.items.company.email;
            this.company.address =  this.items.company.address;
            this.company.contactNo =  this.items.company.contact_no;
            this.company.logo =  this.items.company.logo;
            this.apiUrl = this.items.apiUrl;
        },
        mounted() {
            console.log("Mounted");
        },

    };
</script>
