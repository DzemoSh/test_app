<template>
    <div class="centerx">
        <vs-popup class="holamundo" v-if="employee" title="Update shift details" :active.sync="activePopup">
            <div>
                <vs-input  style="width:100%" placeholder="Name & Surname" v-model="employee.worker"/>
                <vs-input  style="width:100%" placeholder="Company" v-model="employee.company"/>
    
                <div style="display: flex">
                    <div> Working hours: <vs-input-number style="width:100px" v-model="employee.hours"/> </div>
                    <div> Rate per hour: <vs-input-number style="width:100px"  v-model="employee.rate_per_hour"/> </div>
                    <div> 
                        <p class="mb-1"> Taxable: </p>
                        <vs-switch v-model="employee.taxable"/>
                    </div> 
                </div>
    
                <vs-select
                class="mt-2"
                label="Shift Type"
                v-model="employee.shift_type"
                icon="arrow_downward"
                >
                <vs-select-item :key="index" :value="item" :text="item" v-for="item,index in ['Day', 'Night']" />
                </vs-select>
    
                <vs-select
                class="mt-2"
                label="Status"
                v-model="employee.status"
                icon="arrow_downward"
                >
                <vs-select-item :key="index" :value="item" :text="item" v-for="item,index in ['Pending', 'Complete']" />
                </vs-select>
    
                <!-- Starting Date and Time -->
                <p class="mt-2"> Select Date</p>
                <flat-pickr :config="configdateTimePicker('date')" v-model="employee.date" placeholder="Date & Time"/>
                
                <!-- Starting Date and Time -->
                <p class="mt-2"> Paid at </p>
                <flat-pickr :config="configdateTimePicker('paid_at')" v-model="employee.paid_at" placeholder="Date & Time"/>
    
                <vs-button @click="updateShift"> Update Shift</vs-button>
            </div>
        </vs-popup>
    </div>
    </template>
    
    <script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    
    export default {
        components: {flatPickr},
        props: ['employee'],
        data(){
            return{
                activePopup: false,
            }
        },
        methods: {
            configdateTimePicker(type) {
                let config = {
                    enableTime: type == 'paid_at' ? true : false,
                    dateFormat: type == 'paid_at' ? 'Y/m/d H:i' : 'Y/m/d'
                }
                return config
            },
            updateShift(){
                if(this.employee.date == null || this.employee.worker == '' || this.employee.company == '' || this.employee.hours == 0 || this.employee.rate_per_hour == 0){
                    this.$vs.notify({
                        title:'Error',
                        text:'Please fill in all requirements!',
                        color: 'danger'
                    })
                    return
                }
                this.$emit('updateShift', this.employee)
                this.activePopup = false
            }
        },
    }
    </script>