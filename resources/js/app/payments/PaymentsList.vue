<template>
    <div>
        <div class="grid grid-cols-4 gap-2">
            <div class="col-span-2">
                <a
                    href="#"
                    @click.prevent="showFilters = !showFilters"
                    class="mb-2 block text-sm tracking-wide font-bold text-red-600 hover:text-red-800"
                >
                    {{ showFilters ? 'Hide' : 'Show' }} Filters
                </a>
                <div v-if="showFilters">
                    <payment-table-filters :buildings="buildings" @apply-filters="applyFilters"/>
                </div>

            </div>
            <div class="col-span-2 flex justify-end space-x-3">
                <div>
                    <app-drop-down label="Bulk Actions">
                        <button @click.prevent="exportSelected"
                                class="block flex items-center space-x-2 class = 'block flex w-full px-4 py-2 space-x-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cool-gray-400"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>Export</span>
                        </button>
                        <button @click.prevent="reverseSelected"
                                class="block flex items-center space-x-2 class = 'block flex w-full px-4 py-2 space-x-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cool-gray-400"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>Reverse</span>
                        </button>
                    </app-drop-down>
                </div>

                <payment-modal :buildings="buildings" @fetch-payments="fetchPayments" v-if="!buildingId"/>
                <payment-show-modal ref="paymentShowModal"/>
            </div>
        </div>
        <div class="mt-3">
            <div class="overflow-hidden border-b border-gray-200 sm:rounded">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" v-model="selectAll">
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Building
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            House
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tenant
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th scope="col"
                            class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Month
                        </th>
                        <th scope="col"
                            class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date Paid
                        </th>
                        <th scope="col"
                            class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="payment in payments" :key="payment.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <input type="checkbox" v-model="selected" :value="payment.id">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ payment.building_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ payment.house_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ payment.tenant_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                            {{ payment.amount.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ payment.month }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ payment.date_paid }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 capitalize">
                            {{ payment.status }}
                        </td>
                        <td class="flex space-x-3 justify-center px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a @click.prevent="printReceipt(payment)" href="#"
                               class="text-indigo-600 hover:text-indigo-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <a @click.prevent="viewPayment(payment)" href="#"
                               class="text-gray-600 hover:text-indigo-900">view</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table-pagination :pagination-data="paginationData" @apply-pagination="applyPagination"
                                  @apply-per-page="applyPerPage"/>
            </div>
        </div>
    </div>
</template>

<script>
import TablePagination from "../../components/TablePagination";
import PaymentTableFilters from "./partials/PaymentTableFIlters";
import PaymentModal from "./partials/PaymentModal";
import AppDropDown from "../../components/Appdropdown";
import PaymentShowModal from "./partials/PaymentShowModal";
import printJS from "print-js";

export default {
    name: 'payments-list',
    components: {
        PaymentShowModal,
        AppDropDown,
        PaymentModal,
        PaymentTableFilters, TablePagination
    },
    props: {
        houseId: {
            required: false,
            type: Number
        },
        buildingId: {
            required: false,
            type: Number
        },
    },
    data() {
        return {
            payments: [],
            paginationData: {},
            perPage: 50,
            selected: [],
            selectAll: false,
            showFilters: false,
            buildings: [],
            filters: {}
        }
    },
    watch: {
        selectAll: {
            handler: function () {
                if (this.selectAll) {
                    this.selected = this.payments.map(payment => payment.id)
                    return
                }
                this.selected = []
            }
        }
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
        applyPagination(data) {
            this.payments = data.data
            this.paginationData = data.pagination
        },
        applyPerPage(data) {
            this.perPage = data
            this.fetchPayments()
        },
        applyFilters(data) {
            this.filters = data
            this.fetchPayments()
        },
        viewPayment(payment) {
            this.$refs.paymentShowModal.paymentId = payment.id
            this.$refs.paymentShowModal.showModal = true
        },
        exportSelected() {
            if (!this.selected.length) {
                this.$toast.error('Select at least one record');
                return
            }
            axios({
                method: 'post',
                url: '/api/payment-export-excel',
                responseType: 'blob',
                data: {payments: this.selected}
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `rent-payments.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(e => {
                this.$toast.error('Something went wrong, try again later');
            })
        },
        printReceipt(payment) {
            axios.get(`/api/print-payment-receipt/${payment.id}`)
                .then(response => {
                    printJS({printable: response.data, type: 'pdf', base64: true})
                }).catch(e => {
                this.$toast.error('Something went wrong, try again later');
            })
        },
        async reverseSelected() {
            if (!this.selected.length) {
                this.$toast.error('Select at least one record');
                return
            }
            try {
                await axios.post(`/api/reverse-payments`, {
                    payments: this.selected
                })
                await this.fetchPayments()
            } catch (e) {
                this.$toast.error('Something went wrong, try again later');
            }
        },

        async fetchPayments() {
            try {
                let response = await axios.get(
                    `/api/payments?per_page=${this.perPage}` +
                    `&building=${this.buildingId ? this.buildingId : this.filters.building ??= ''}` +
                    `&house=${this.houseId ? this.houseId : this.filters.house ??= ''}` +
                    `&status=${this.filters.status ??= 'approved'}` +
                    `&from=${this.filters.from ??= ''}` +
                    `&to=${this.filters.to ??= ''}`
                )
                this.payments = response.data.data
                this.paginationData = response.data.pagination
            } catch (e) {
                this.$toast.error('Something went wrong, try again later');
            }
        }
    },
    created() {
        this.prerequisites()
        this.fetchPayments()
    }
}
</script>