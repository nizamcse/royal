<template>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h4>PERMISSIONS</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12" v-for="permission in permissions">
                            <button type="button" role="button" class="btn-raised" @click="selectPermission(permission)"><i class="fa fa-check-circle-o"></i> {{ permission.name }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h4>SELECTED PERMISSIONS</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12" v-for="(selectedPermission,index) in selectedPermissions">
                            <input type="hidden" :name="'permissions['+ index +']'" :value="selectedPermission.id">
                            <button type="button" role="button" class="btn-raised" @click="deselectPermission(selectedPermission)"><i class="fa fa-check-circle-o"></i> {{ selectedPermission.name }}</button>
                        </div>
                    </div>
                    <div class="form-group text-right" v-if="selectedPermissions.length" style="margin-top: 15px">
                        <button class="btn btn-sm btn-success" type="submit">CREATE ROLE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['items'],

        data: function() {

            return {
                permissions: [],
                selectedPermissions: [],
            };
        },

        methods: {

            selectPermission: function(permission){
                let index = this.permissions.indexOf(permission);
                this.permissions.splice(index,1);
                this.selectedPermissions.push(permission);
            },
            deselectPermission: function(permission){
                let index = this.selectedPermissions.indexOf(permission);
                this.selectedPermissions.splice(index,1);
                this.permissions.push(permission);
            }

        },
        created: function() {
            this.permissions = this.items.permissions;
            this.selectedPermissions = this.items.selectedPermissions ? this.items.selectedPermissions : [];
        },
        mounted() {
            console.log("Mounted");
        },

    };
</script>
