<template>
<div class="centerx">
    <vs-popup class="holamundo"  title="Enter the details for the new shift" :active.sync="activePopup">
        <div>
            <vs-input  style="width:100%" placeholder="Name & Surname" v-model="worker"/>
            <vs-input  style="width:100%" placeholder="Company" v-model="company"/>

            <div style="display: flex">
                <div> Working hours: <vs-input-number style="width:100px" v-model="hours"/> </div>
                <div> Rate per hour: <vs-input-number style="width:100px"  v-model="rate_per_hour"/> </div>
                <div> 
                    <p class="mb-1"> Taxable: </p>
                    <vs-switch v-model="taxable"/>
                </div> 
            </div>

            <vs-select
            class="mt-2"
            label="Shift Type"
            v-model="shift_type"
            icon="arrow_downward"
            >
            <vs-select-item :key="index" :value="item" :text="item" v-for="item,index in ['Day', 'Night']" />
            </vs-select>

            <vs-select
            class="mt-2"
            label="Status"
            v-model="status"
            icon="arrow_downward"
            >
            <vs-select-item :key="index" :value="item" :text="item" v-for="item,index in ['Pending', 'Complete']" />
            </vs-select>

            <!-- Starting Date and Time -->
            <p class="mt-2"> Select Date</p>
            <flat-pickr :config="configdateTimePicker('date')" v-model="date" placeholder="Date & Time"/>
            
            <!-- Starting Date and Time -->
            <p class="mt-2"> Paid at </p>
            <flat-pickr :config="configdateTimePicker('paid_at')" v-model="paid_at" placeholder="Date & Time"/>

            <vs-button @click="addShift"> Add Shift</vs-button>
        </div>
    </vs-popup>
</div>
</template>

<script>
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
    components: {flatPickr},
    data(){
        return{
            activePopup: false,
            worker: '',
            date: null,
            company: '',
            hours: 0,
            rate_per_hour: 0,
            taxable: false,
            status: 'Pending',
            shift_type: 'Day',
            paid_at: null
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
        addShift(){
            if(this.date == null || this.worker == '' || this.company == '' || this.hours == 0 || this.rate_per_hour == 0){
                this.$vs.notify({
                    title:'Error',
                    text:'Please fill in all requirements!',
                    color: 'danger'
                })
                return
            }
            this.$emit('createShift', {
                worker: this.worker,
                company: this.company,
                date: this.date,
                hours: this.hours,
                rate_per_hour: this.rate_per_hour,
                taxable: this.taxable,
                status: this.status,
                shift_type: this.shift_type,
                paid_at: this.paid_at
            })
            this.activePopup = false
            this.resetInputs()
        },
        resetInputs(){
            this.worker = '',
            this.company = '',
            this.date = null,
            this.hours = 0,
            this.rate_per_hour = 0,
            this.taxable = false,
            this.status = 'Pending',
            this.shift_type = 'Day',
            this.paid_at = null
        }
    },
}
</script>