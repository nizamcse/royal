<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title d-block">
                    LIST OF EMPLOYEE SALARIES
                    <a :href="downloadUrl" class="btn btn-sm pull-right btn-warning flat" target="_blank"><i class="fa fa-download"></i> DOWNLOAD</a>
                </h3>
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
                            <select name="month" class="form-control" v-model="filterProperty.month" v-on:change="resetUrl" required>
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
                            <input type="text" name="year" class="form-control" v-on:keyup="resetUrl" v-model="filterProperty.year">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-body" v-if="salaries.length">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#Employee ID</th>
                        <th>Employee Name</th>
                        <th>Basic Salary</th>
                        <th>Bonus</th>
                        <th>Deduction</th>
                        <th>Net Salary</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(salary,index) in salaries">
                        <td>{{ salary.employee_id}}</td>
                        <td>{{ salary.employee ? salary.employee.name : ''}}</td>
                        <td>{{ salary.basic_salary }}</td>
                        <td>{{ salary.bonuses_amount }}</td>
                        <td>{{ salary.deductions_amount }}</td>
                        <td>{{ salary.net_salary }}</td>
                        <td class="text-right">
                            <a :href="view.url + '/' + salary.id" class="btn btn-info btn-xs flat" v-if="view.can"><i class="fa fa-eye"></i> View</a>
                            <button :data-url="deleteSalary.url + '/' + salary.id " class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal" v-if="deleteSalary.can"><i class="fa fa-trash-o"></i> Delete</button>
                            <a :href="download.url + '/' + salary.id " class="btn btn-success btn-xs flat" target="_blank" v-if="download.can"> <i class="fa fa-download"></i> Download</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination @select="paginateSalaries" :currentPage="currentPage" :lastPage="lastPage" v-if="salaries.length"></pagination>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['items'],
        data: function() {
            return {
                employees: [],
                employeeId: null,
                employeeResults: [],
                employeeName: "",
                employee: null,
                apiUrl: null,
                salaries: [],
                filledData: {},
                filterProperty: {
                    month: "",
                    year: new Date().getFullYear(),
                },
                currentPage: 1,
                lastPage: 1,
                view: {},
                deleteSalary: {},
                download: {},
                downloadUrl: null,
            };
        },
        computed: {

        },

        methods: {
            searchEmployee(){
                console.log(this.employeeName);
                this.employeeResults = [];
                this.employeeId = null;
                if(this.employeeName.length){
                    this.employeeResults = this.employees.filter((item) => {
                        return item.name.toUpperCase().search(this.employeeName.toUpperCase()) != -1 || item.id ==this.employeeName;
                    });
                }
                this.resetUrl();

            },
            selectEmployee(item){
                this.employeeId = item.id;
                this.employeeName = item.name;
                this.employeeResults = [];
                this.employee = item;
                this.resetUrl();
            },
            paginateSalaries: function(page){
                var app = this;
                let pageUrl = this.apiUrl + "?page=" + page;
                axios.post(pageUrl ,app.filledData)
                    .then(result => {
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;
                        app.salaries = result.data.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            resetUrl(){
                this.filledData = {};
                const entries = Object.entries(this.filterProperty);
                this.downloadUrl = null;
                for (let i=0; i<entries.length; i++) {
                    const [key,value] = entries[i];
                    if(value){
                        this.filledData[key] = value;
                        let param = this.downloadUrl ? '&' + key + '=' + value : this.apiUrl + '?' + key + '=' + value;
                        this.downloadUrl =  this.downloadUrl ? this.downloadUrl + param : param;
                        console.log(this.downloadUrl,param);
                    }
                }
                if(this.employeeId){
                    this.filledData['employee_id'] = this.employeeId;
                    let param = this.downloadUrl ? '&employee_id=' + this.employeeId : this.apiUrl + '?' + employee_id + '=' + this.employeeId;
                    this.downloadUrl =  this.downloadUrl ? this.downloadUrl + param : param;
                    console.log(this.downloadUrl,param);
                }
                this.getSalaries();
            },
            getSalaries: function(){
                var app =this;
                axios.post(app.apiUrl ,app.filledData)
                    .then(result => {
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;
                        app.salaries = result.data.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            }
        },
        created: function() {
             this.apiUrl = this.items.apiUrl;
             this.downloadUrl = this.items.apiUrl;
             this.view = this.items.view;
             this.deleteSalary = this.items.deleteSalary;
             this.download = this.items.download;
             this.employees = this.items.employees;
             this.getSalaries();
        },
        mounted() {

        },
    };
</script>
