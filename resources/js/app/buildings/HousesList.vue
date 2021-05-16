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
            <house-modal :building="building" @fetch-houses="fetchHouses" ref="houseModal"/>
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
                            Tenant
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rent
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Deposit
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Is Occupied
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="house in houses" :key="house.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <input type="checkbox" v-model="selected" :value="house.id">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                            {{ house.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ house.tenant_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ house.rent.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ house.deposit.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-500">
                            <span :class="{'text-red-500': !house.is_occupied}">{{
                                    house.is_occupied ? 'Occupied' : 'Vacant'
                                }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a :href="`/houses/${house.id}`" class="text-indigo-600 hover:text-indigo-900">View</a>
                            <a href="#" class="text-red-300 hover:text-red-500"
                               @click.prevent="editHouse(house)">Edit</a>
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
import HouseModal from "./partials/HouseModal";
import AppDropDown from "../../components/Appdropdown";

export default {
    name: 'houses-list',
    components: {AppDropDown, HouseModal, TablePagination},
    props: ['building'],
    data() {
        return {
            houses: [],
            paginationData: {},
            perPage: 50,
            selected: [],
            selectAll: false
        }
    },
    watch: {
        selectAll: {
            handler: function (val) {
                this.selected = val ? this.houses.map(house => house.id) : []
            }
        }
    },
    methods: {
        applyPagination(data) {
            this.houses = data.data
            this.paginationData = data.pagination
        },
        applyPerPage(data) {
            this.perPage = data
            this.fetchHouses()
        },
        editHouse(house) {
            this.$refs.houseModal.house = house
            this.$refs.houseModal.showModal = true
        },

        async markVacant() {
            if (!this.selected.length) {
                this.$toast.error('Select at least one record');
                return
            }
            try {
                await axios.post('/api/house-mark-vacant', {
                    houses: this.selected
                })

                await this.fetchHouses()

                this.$toast.success('Successfully marked selected houses as vacant');
            } catch (e) {
                this.$toast.error('Could not mark houses as vacant');
            }
        },
        async fetchHouses() {
            try {
                let response = await axios.get(`/api/houses?per_page=${this.perPage}&building=${this.building.id}`)

                this.houses = response.data.data

                this.paginationData = response.data.pagination

                this.$root.$emit('housesUpdated', this.houses);

            } catch (e) {
                this.$toast.error('Something went wrong try again later');
            }
        }
    },
    created() {
        this.fetchHouses()
    }
}
</script>