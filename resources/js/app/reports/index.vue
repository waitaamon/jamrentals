<template>
    <div>
        <div class="py-4 grid grid-cols-5 gap-2">
            <div class="col-span-2">
                <label for="building" class="block text-sm font-medium text-gray-700">Building</label>
                <div class="mt-1">
                    <multiselect
                        v-model="filters.building"
                        :options="buildings"
                        id="building"
                        trackBy="id"
                        label="name"
                        name="building"
                        placeholder="select building"
                    ></multiselect>
                </div>
            </div>
            <div class="col-span-2">
                <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                <div class="mt-1">
                    <month-picker-input
                        id="month"
                        class="w-full"
                        :no-default="true"
                        :input-pre-filled="true"
                        :default-month="currentMonth"
                        :default-year="currentYear"
                        v-model="filters.month"
                    ></month-picker-input>

                </div>
            </div>
            <div class="col-span-1 flex items-center">
                <button
                    type="button"
                    class="mt-4 inline-flex items-center px-2.5 py-2 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    @click.prevent="applyFilters"
                >
                    Apply Filters
                </button>
            </div>
        </div>

        <div v-if="building">
            <div class="mt-4">
                <stats :stats="stats"/>
            </div>
            <div class="mt-4">
                <app-tabs>
                    <app-tab
                        v-for="(tab, index) in tabs"
                        :key="index"
                        :name="tab.name"
                        :selected="index === 0"
                    >
                        <div class="mt-4">
                            <payments-report-table-list :payments="building.payments" v-if="tab.value === 'payments'"/>
                            <unpaid-invoices-report-table :invoices="building.unpaid_invoices" v-if="tab.value === 'unpaid'" />
                        </div>
                    </app-tab>
                </app-tabs>
            </div>
        </div>
    </div>
</template>

<script>
import {MonthPickerInput} from 'vue-month-picker'
import Stats from "./partials/Stats";
import AppTabs from "../../components/tabs/AppTabs";
import AppTab from "../../components/tabs/AppTab";
import PaymentsReportTableList from "./partials/PaymentReportTable";
import UnpaidInvoicesReportTable from "./partials/UnpaidInvoiceReportTable";

export default {
    name: 'reports-index',
    components: {UnpaidInvoicesReportTable, PaymentsReportTableList, Stats, MonthPickerInput, AppTab, AppTabs},
    data() {
        return {
            buildings: [],
            building: null,
            stats: null,
            filters: {
                building: '',
                month: '',
            },
            tabs: [
                {name: 'Payments', value: 'payments'},
                {name: 'Unpaid Rent', value: 'unpaid'},
                {name: 'Deposit', value: 'deposit'},
                {name: 'Vacant Houses', value: 'vacant'},
            ],
        }
    },
    computed: {
        currentMonth() {
            let date = new Date();
            return date.getMonth() + 1
        },
        currentYear() {
            let date = new Date();
            return date.getFullYear()
        },
    },
    methods: {
        async prerequisites() {
            try {
                let response = await axios.get('/api/payment-prerequisites')
                this.buildings = response.data.buildings
            } catch (e) {
                this.$toast.error('Something went wrong try again later');
            }
        },
        async applyFilters() {
            if (!this.filters.building || !this.filters.month) {
                this.$toast.error('Select all filters');
                return
            }

            let month = `${this.filters.month.year}-${this.filters.month.monthIndex}-1`

            try {
                let response = await axios.get(`/api/report?building=${this.filters.building.id}&month=${month}`)
                this.building = response.data
            } catch (e) {
                this.$toast.error('Something went wrong try again later');
            }
        },
        resetFilters() {
            this.filters = {
                building: '',
                month: '',
            }
        },
    },
    created() {
        this.prerequisites()
    }
}
</script>