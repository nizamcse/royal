<template>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group search-form-group">
                        <label>Employee Name</label>
                        <input type="text" v-model="employeeName" :class="employeeId ? 'form-control': 'form-control text-danger'" @keyup="searchEmployee" required>
                        <ul class="search-result" v-if="employeeResults.length">
                            <li v-for="searchResult in employeeResults" @click="selectEmployee(searchResult)">{{ searchResult.name }}</li>
                        </ul>
                        <input type="hidden" name="employee_id" v-model="employeeId">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Leave Type</label>
                        <select name="leave_type_id" class="form-control" v-model="leaveTypeId" required>
                            <option value="">-- Select Leave Type --</option>
                            <option v-for="leaveType in employeeLeaveTypes" :value="leaveType.id">{{ leaveType.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Leave From</label>
                        <datepicker input-class="form-control" v-model="leaveFrom"></datepicker>
                        <input type="hidden" name="from_date" :value="fromDate">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Leave To</label>
                        <datepicker input-class="form-control" v-model="leaveTo"></datepicker>
                        <input type="hidden" name="to_date" :value="toDate">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Allowed Days</label>
                        <input type="text" class="form-control" :value="allowedDays" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success btn-sm" type="submit" :disabled="validateEntry">{{ btnText }}</button>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['items'],

        data: function() {

            return {
                name: "",
                leaveFrom: null,
                leaveTo: null,
                btnText: 'Create Leave',
                employees: [],
                leaveTypes: [],
                employeeId: null,
                employeeResults: [],
                employeeName: "",
                employeeLeaveTypes: [],
                leaveTypeId: "",
            };
        },
        computed: {
            fromDate: function(){
                return this.leaveFrom ? moment(this.leaveFrom).format('YYYY-MM-DD') : '';
            },
            toDate: function(){
                return this.leaveTo ? moment(this.leaveTo).format('YYYY-MM-DD') : '';
            },
            validateEntry: function(){
                if(this.employeeId && this.leaveFrom && this.leaveTo){
                    return false;
                }
                return true;
            },
            allowedDays: function(){
                let diffDays = 0;
                let from = this.leaveFrom;
                let to = this.leaveTo;
                if(from && to){
                    let timeDiff = Math.abs(from.getTime() - to.getTime());
                    diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                }
                return diffDays;
            }
        },

        methods: {
            searchEmployee(){
                this.employeeResults = [];
                this.employeeId = null;

                if(this.employeeName.length){
                    this.employeeResults = this.employees.filter((item) => {
                        return item.name.toUpperCase().search(this.employeeName.toUpperCase()) != -1;
                    });
                }

            },
            selectEmployee(item){
                this.employeeId = item.id;
                this.employeeName = item.name;
                this.employeeResults = [];
                this.employeeLeaveTypes = item.leave_types;
            },
        },
        created: function() {
            this.employees = this.items.employees;
            this.leaveTypes = this.items.leaveTypes;
            let item = this.items.employeeLeave;
            if(item){
                let fromDate = item.from_date.split('-');
                let toDate = item.to_date.split('-');
                this.employeeName = item.employee.name;
                this.employeeId = item.employee.id;
                this.leaveFrom = fromDate.length ? new Date(fromDate[0],toDate[1] - 1,fromDate[2]) : null;
                this.leaveTo = toDate.length ? new Date(toDate[0],toDate[1] - 1,toDate[2]) : null;
                this.btnText = 'Update Leave';
                this.employeeLeaveTypes = item.employee.leave_types;
                this.leaveTypeId = item.leave_type_id;
            }

        },
        mounted() {

        },
    };
</script>
