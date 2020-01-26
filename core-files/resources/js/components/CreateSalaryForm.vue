<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="box" v-if="bonuses.length">
                    <div class="box-header bg-aqua">
                        <h4>BONUSES</h4>
                    </div>
                    <div class="box-body">
                        <ul class="list-group bonus-list-group">
                            <li class="list-group-item" v-for="bonus in bonuses">
                                <a v-on:click="selectBonus(bonus)">{{ bonus.name }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box" v-if="deductions.length">
                    <div class="box-header bg-orange">
                        <h4>DEDUCTIONS</h4>
                    </div>
                    <div class="box-body">
                        <ul class="list-group deduction-list-group">
                            <li class="list-group-item" v-for="deduction in deductions">
                                <a v-on:click="selectDeduction(deduction)">{{ deduction.name }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group search-form-group">
                                    <label>EMPLOYEE NAME/ID</label>
                                    <input type="text" v-model="employeeName" :class="employeeId ? 'form-control': 'form-control text-danger'" @keyup="searchEmployee" required>
                                    <ul class="search-result" v-if="employeeResults.length">
                                        <li v-for="searchResult in employeeResults" @click="selectEmployee(searchResult)">{{ searchResult.name }}</li>
                                    </ul>
                                    <input type="hidden" name="employee_id" v-model="employeeId">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>SELECT MONTH</label>
                                    <select name="month" class="form-control" v-model="monthId" v-on:change="getDetails" required>
                                        <option value="">-- Select Month --</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>YEAR</label>
                                    <input type="text" name="year" class="form-control" v-on:keyup="getDetails" v-model="year">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" v-if="salaryDetails">
                            <tbody>
                            <tr class="bg-success">
                                <td>01</td>
                                <td><strong>TOTAL DAYS</strong></td>
                                <td class="text-right">{{ salaryDetails.totalDays }}</td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td><strong>TOTAL VACATION</strong></td>
                                <td class="text-right">{{ salaryDetails.vacation }}</td>
                            </tr>
                            <tr class="bg-info">
                                <td>03</td>
                                <td><strong>WORKING DAYS</strong></td>
                                <td class="text-right">{{ salaryDetails.should_attend }}</td>
                            </tr>

                            <tr>
                                <td>04</td>
                                <td><strong>TOTAL LAVES</strong></td>
                                <td class="text-right">{{ salaryDetails.total_leaves }}</td>
                            </tr>
                            <tr>
                                <td>05</td>
                                <td><strong>TOTAL WEEKEND</strong></td>
                                <td class="text-right">{{ salaryDetails.total_weekends }}</td>
                            </tr>
                            <tr class="bg-warning">
                                <td>06</td>
                                <td><strong>TOTAL ATTEND</strong></td>
                                <td class="text-right">{{ salaryDetails.total_attend }}</td>
                            </tr>
                            <tr class="bg-danger">
                                <td>07</td>
                                <td><strong>LATE ATTENDANCE</strong></td>
                                <td class="text-right">{{ salaryDetails.lately_attend }}</td>
                            </tr>
                            <tr class="bg-s">
                                <td>08</td>
                                <td><strong>TOTAL WORKING HOUR</strong></td>
                                <td class="text-right">{{ salaryDetails.total_working_hour }}</td>
                            </tr>
                            <tr class="bg-s">
                                <td>09</td>
                                <td><strong>MINIMUM WORKING HOUR</strong></td>
                                <td class="text-right">{{ salaryDetails.minimum_working_hour }}</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><strong>EXTRA WORKING DAYS/HOUR</strong></td>
                                <td class="text-right">{{ salaryDetails.extra_working_hour }}</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td><strong>BASIC SALARY</strong></td>
                                <td class="text-right">{{ salaryDetails.basic_salary }}</td>
                            </tr>
                            <tr class="bg-aqua"  v-if="selectedBonuses.length">
                                <td colspan="3">BONUSES</td>
                            </tr>
                            <tr v-if="selectedBonuses.length" v-for="(selectedBonus,i) in selectedBonuses">
                                <td><button class="btn btn-danger" type="button"  v-on:click="deselectBonus(i)">X</button></td>
                                <td><strong>{{ selectedBonus.name }}<input type="hidden" :name="'bonuses['+ i +'][id]'" :value="selectedBonus.id"></strong></td>
                                <td class="text-right"><input type="text" class="text-right" :name="'bonuses['+ i +'][amount]'" v-model="selectedBonuses[i].amount" v-on:keyup="spliceBonuses(selectedBonus,i)" required></td>
                            </tr>
                            <tr class="bg-orange" v-if="selectedDeductions.length">
                                <td colspan="3">DEDUCTIONS</td>
                            </tr>
                            <tr v-if="selectedDeductions.length" v-for="(selectedDeduction,i) in selectedDeductions">
                                <td><button class="btn btn-danger" type="button" v-on:click="deselectDeduction(i)">X</button></td>
                                <td>
                                    <strong>{{ selectedDeduction.name }}</strong>
                                    <input type="hidden" :name="'deductions['+ i +'][id]'" :value="selectedDeductions.id">
                                </td>
                                <td class="text-right"><input class="text-right" type="text" :name="'deductions['+ i +'][amount]'" v-model="selectedDeductions[i].amount" v-on:keyup="spliceDeduction(selectedDeduction,i)" required></td>
                            </tr>
                            <tr class="bg-success">
                                <td colspan="2">Net Salary</td>
                                <td class="text-right">{{ netSalary }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="form-group text-right">
                            <button class="btn btn-success btn-sm flat" type="submit">{{ btnText }}</button>
                        </div>
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
                btnText: 'CREATE SALARY',
                employees: [],
                employeeId: null,
                employeeResults: [],
                employeeName: "",
                monthId: "",
                year: new Date().getFullYear(),
                employee: null,
                apiUrl: null,
                salaryDetails: null,
                bonuses: [],
                deductions: [],
                selectedBonuses: [],
                selectedDeductions: [],

            };
        },
        computed: {
            netSalary: function(){
                let bonusesAmount = [];
                let deductionsAmount = [];

                Object.entries(this.selectedBonuses).forEach(([key, val]) => {
                    bonusesAmount.push(val.amount)
                });

                Object.entries(this.selectedDeductions).forEach(([key, val]) => {
                    deductionsAmount.push(val.amount)
                });

                let sumBonuses = bonusesAmount.reduce(function(total, num){ return parseFloat(total) + parseFloat(num) }, 0);
                let sumDeductions = deductionsAmount.reduce(function(total, num){ return parseFloat(total) + parseFloat(num) }, 0);
                if(this.employee)
                    return parseFloat(this.employee.salary) + parseFloat(sumBonuses) - parseFloat(sumDeductions);
                return 0;
            }
        },

        methods: {
            searchEmployee(){
                this.employeeResults = [];
                this.employeeId = null;

                if(this.employeeName.length){
                    this.employeeResults = this.employees.filter((item) => {
                        return item.name.toUpperCase().search(this.employeeName.toUpperCase()) != -1 || item.id ==this.employeeName;
                    });
                }

            },
            selectEmployee(item){
                this.employeeId = item.id;
                this.employeeName = item.name;
                this.employeeResults = [];
                this.employee = item;
                this.getDetails();
            },
            selectBonus(item){
                if(!this.searchSelectedBonuses(item.id)){
                    let bonus = item;
                    bonus.amount = 0;
                    this.selectedBonuses.push(bonus);
                }
            },
            deselectBonus(i){
                let bonus = this.selectedBonuses[i];
                this.selectedBonuses.splice(i,1);
            },
            selectDeduction(item){
                if(!this.searchSelectedDeductions(item.id)){
                    let deduction = item;
                    item.amount = 0;
                    this.selectedDeductions.push(deduction);
                }
            },
            deselectDeduction(i){
                this.selectedDeductions.splice(i,1);
            },
            searchSelectedBonuses(id){
                for (let i=0; i<this.selectedBonuses.length; i++){
                    if(this.selectedBonuses[i].id == id)
                        return true;
                }
                return false;
            },
            searchSelectedDeductions(id){
                for (let i=0; i<this.selectedDeductions.length; i++){
                    if(this.selectedDeductions[i].id == id)
                        return true;
                }
                return false;
            },
            spliceDeduction(item,index){
                this.selectedDeductions.splice(index,1,item);
            },
            spliceBonuses(item,index){
                this.selectedBonuses.splice(index,1,item);
            },
            getDetails: function(){
                var app =this;
                this.salaryDetails = null;
                if(this.employeeId && this.year && this.monthId){
                    let data = {
                        employee_id : this.employeeId,
                        year: this.year,
                        month: this.monthId
                    };
                    console.log(data);
                    axios.post(app.apiUrl ,data)
                        .then(result => {
                            app.salaryDetails = result.data;
                        })
                        .catch(e => {
                            console.log(e);
                        });
                }
            },

        },
        created: function() {
            this.employees = this.items.employees;
            this.apiUrl = this.items.apiUrl;
            this.bonuses = this.items.bonuses ? this.items.bonuses : [];
            this.deductions = this.items.deductions ? this.items.deductions : [];
            console.log(this.items);
        },
        mounted() {

        },
    };
</script>
