<template>
    <div class="box">
        <div class="box-header">
            <h4 class="box-title">CHANGE PASSWORD</h4>
            <p v-if="responseData.show" :class="responseData.status ? 'bg-success response-text' : 'bg-danger response-text'">{{ responseData.text }}</p>
        </div>
        <div class="box-body">
            <form action="#" method="post" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control" v-model="password" name="password">
                    <p class="helper text-danger" v-if="password.length <= 5 && password.length > 0">This password should be at lease 6 digits.</p>
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" class="form-control" v-model="confirmPassword" name="confirm_password">
                    <p class="helper text-danger" v-if="password != confirmPassword && confirmPassword.length > 0">Password does not match.</p>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-info flat btn-sm" type="button" :disabled="!validatePassword" @click="updatePassword">UPDATE PASSWORD</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        data: function() {

            return {
                companyId: null,
                password: "",
                confirmPassword: "",
                responseData: {
                    status: null,
                    text: null,
                    show: false,
                },
            };
        },
        computed: {
            validatePassword: function(){
                if(this.password){
                    return this.password.length > 5 && (this.password == this.confirmPassword);
                }else{
                    return false;
                }
            },
        },

        methods: {
            updatePassword: function(){
                if(this.validatePassword){
                    var app = this;
                    axios.post(this.apiUrl,{
                        password: app.password,
                        company_id: app.companyId,
                    }).then(response => {
                        app.responseData.status = true;
                        app.responseData.text = "Password updated successfully";
                        app.responseData.show = true;
                        setTimeout(function(){
                            app.responseData.show = false;
                            app.responseData.text = null;
                            app.responseData.status = null;
                        },2000);

                    }).catch(e => {
                        console.log(e)
                    });
                }
            }
        },
        created: function() {
            this.companyId = this.items.companyId;
            this.apiUrl = this.items.apiUrl;
            console.log(this.companyId);
        },
        mounted() {
            console.log("Mounted");
        },

    };
</script>
