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
                            Invoiced Amount
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Paid
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Balance
                        </th>
                        <th scope="col"
                            class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Month
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="invoice in invoices" :key="invoice.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <input type="checkbox" v-model="selected" :value="invoice.id">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ invoice.building_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ invoice.house_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ invoice.tenant_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                            {{ invoice.amount.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                            {{ invoice.paid.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                            {{ invoice.balance.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ invoice.month }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import AppDropDown from "../../../components/Appdropdown";

export default {
    name: 'unpaid-invoices-report-table',
    components: {
        AppDropDown,
    },
    props: ['invoices'],
    data() {
        return {
            selected: [],
            selectAll: false,
        }
    },
    watch: {
        selectAll: {
            handler: function () {
                if (this.selectAll) {
                    this.selected = this.invoices.map(invoice => invoice.id)
                    return
                }
                this.selected = []
            }
        }
    },
    methods: {

        exportSelected() {
            if (!this.selected.length) {
                this.$toast.error('Select at least one record');
                return
            }
            axios({
                method: 'post',
                url: '/api/unpaid-invoices-export-excel',
                responseType: 'blob',
                data: {invoices: this.selected}
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `unpaid-invoices.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).catch(e => {
                this.$toast.error('Something went wrong, try again later');
            })
        },
    },
}
</script>