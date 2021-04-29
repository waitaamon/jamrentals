<template>
    <div>
        <div class="flex justify-end">
            <house-modal :building="building" @fetch-houses="fetchHouses" ref="houseModal"/>
        </div>
        <div class="mt-3">
            <div class="overflow-hidden border-b border-gray-200 sm:rounded">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox">
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
                            <input type="checkbox">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                            {{ house.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ house.tenant }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ house.rent.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ house.deposit.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-500">
                            <span :class="{'text-red-500': !house.is_occupied}">{{ house.is_occupied ? 'Occupied' : 'Vacant' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a :href="`/houses/${house.id}`" class="text-indigo-600 hover:text-indigo-900">View</a>
                            <a href="#" class="text-red-300 hover:text-red-500" @click.prevent="editHouse(house)">Edit</a>
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

export default {
    name: 'houses-list',
    components: {HouseModal, TablePagination},
    props: ['building'],
    data() {
        return {
            houses: [],
            paginationData: {},
            perPage: 50,
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
        async fetchHouses() {
            try {
                let response = await axios.get(`/api/houses?per_page=${this.perPage}&building=${this.building.id}`)
                this.houses = response.data.data
                this.paginationData = response.data.pagination
            } catch (e) {
                console.error('could not fetch houses')
            }
        }
    },
    created() {
        this.fetchHouses()
    }
}
</script>