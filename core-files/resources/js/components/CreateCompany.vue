<template>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Admin Name *</label>
                            <input type="text" class="form-control" name="admin_name" v-model="user.name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" v-model="user.email" @keyup="findUser" required>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="!user.id">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" v-model="user.password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" v-model="user.confirmPassword" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-sm btn-info" :disabled="validateInputs">Create Company</button>
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
                    password: "",
                    confirmPassword: "",
                },
                apiUrl: "",
            };
        },
        computed: {
            validEmail: function () {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(this.user.email);
            },
            validatePassword: function(){
                if(!this.user.id){
                    return this.user.password.length > 5 && (this.user.password == this.user.confirmPassword);
                }else{
                    return true;
                }
            },
            validateName: function(){
                return this.user.name.length > 0;
            },
            validateInputs: function(){
                console.log(this.validEmail,this.validatePassword,this.validateName);
                if(this.validEmail && this.validateName && this.validatePassword){
                    return false;
                }
                else{
                    return true;
                }
            }
        },

        methods: {
            findUser: function(){
                this.user.id = null;
                var app =this;
                console.log(this.user.email);
                if(this.validEmail){
                    axios.post(this.apiUrl,{
                        email: app.user.email,
                    }).then(response => {
                        if(response.data){
                            app.user.id = response.data.id;
                            app.user.name = response.data.name;
                        }
                    }).catch(e => {
                        this.errors.push(e)
                    });
                }
            },
        },
        created: function() {
            this.apiUrl = this.items.apiUrl;
        },
        mounted() {
            console.log("Mounted");
        },

    };
</script>
