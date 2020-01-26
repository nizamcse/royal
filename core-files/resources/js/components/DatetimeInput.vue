<template>
    <div>
        <datetime type="time" :format="format" input-class="form-control" v-model="time" use12-hour>
        </datetime>
        <input type="hidden" :name="inputName" :value="inputValue">
    </div>
</template>

<script>
    export default {

        props: ['inputs'],
        data: function () {
            return {
                time: "",
                format: "HH:mm",
                inputName: "",
            }
        },

        computed: {

            inputValue: function(){
                return this.time ? moment(this.time).format(this.format) : '';
            },
        },

        methods: {


        },
        created: function () {
            this.format = this.inputs.format;
            this.inputName = this.inputs.name;
        },

        mounted() {
            console.log('Time input Component mounted')
        }
    }
</script>
