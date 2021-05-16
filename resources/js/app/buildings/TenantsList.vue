<template>
    <div>
        <div class="flex justify-end space-x-3">
            <div>
                <app-drop-down label="Bulk Actions">
                    <button @click.prevent="markVacant"
                            class="block flex items-center space-x-2 class = 'block flex w-full px-4 py-2 space-x-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>Mark as Vacant</span>
                    </button>
                </app-drop-down>
            </div>
            <tenant-modal :building="building" @fetch-tenants="fetchTenants" ref="tenantModal"/>
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
                            Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            House
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Id Number
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Phone Number
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Balance
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="tenant in tenants" :key="tenant.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <input type="checkbox" v-model="selected" :value="tenant.id">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                            {{ tenant.name }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ tenant.house_name }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ tenant.id_number }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ tenant.phone }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ tenant.balance.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a :href="`/tenants/${tenant.id}`" class="text-indigo-600 hover:text-indigo-900">View</a>
                            <a href="#" class="text-red-300 hover:text-red-500"
                               @click.prevent="editTenant(tenant)">Edit</a>
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
import AppDropDown from "../../components/Appdropdown";
import TenantModal from "./partials/TenantModal";

export default {
    name: 'tenants-list',
    components: {TenantModal, AppDropDown, TablePagination},
    props: ['building'],
    data() {
        return {
            tenants: [],
            paginationData: {},
            perPage: 50,
            selected: [],
            selectAll: false
        }
    },
    watch: {
        selectAll: {
            handler: function (val) {
                this.selected = val ? this.tenants.map(tenant => tenant.id) : []
            }
        }
    },
    methods: {
        applyPagination(data) {
            this.tenants = data.data
            this.paginationData = data.pagination
        },
        applyPerPage(data) {
            this.perPage = data
            this.fetchTenants()
        },
        editTenant(tenant) {
            this.$refs.tenantModal.tenant = tenant
            this.$refs.tenantModal.showModal = true
        },

        async markVacant() {
            if (!this.selected.length) {
                this.$toast.error('Select at least one record');
                return
            }
            try {
                await axios.post('/api/tenant-mark-vacant', {
                    tenants: this.selected
                })

                await this.fetchTenants()

                this.$toast.success('Successfully marked selected tenants as vacant');
            } catch (e) {
                this.$toast.error('Could not mark tenants as vacant');
            }
        },
        async fetchTenants() {
            try {
                let response = await axios.get(`/api/tenants?per_page=${this.perPage}&building=${this.building.id}`)
                this.tenants = response.data.data
                this.paginationData = response.data.pagination
            } catch (e) {
                this.$toast.error('Something went wrong try again later');
            }
        }
    },
    created() {
        this.fetchTenants()
    }
}
</script>