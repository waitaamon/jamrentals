<template>
    <div>
        <div class="grid grid-cols-4 gap-2">
            <div class="col-span-2">


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
                    </app-drop-down>
                </div>
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
            </div>
        </div>
    </div>
</template>

<script>
import AppDropDown from "../../components/Appdropdown";
import PaymentShowModal from "../payments/partials/PaymentShowModal";
import printJS from "print-js";

export default {
    name: 'tenant-payments-table',
    components: {
        PaymentShowModal,
        AppDropDown,
    },
    props: ['tenantId'],
    data() {
        return {
            payments: [],
            selected: [],
            selectAll: false,
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
        async fetchPayments() {
            try {
                let response = await axios.get(`/api/tenant-payments/${this.tenantId}`)
                this.payments = response.data
            } catch (e) {
                this.$toast.error('Something went wrong, try again later');
            }
        }
    },
    created() {
        this.fetchPayments()
    }
}
</script>