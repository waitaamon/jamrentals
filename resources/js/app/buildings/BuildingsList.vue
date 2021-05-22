<template>
    <div>
        <div class="flex justify-end">
            <building-modal @fetch-buildings="fetchBuildings" ref="buildingModal"/>
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
                            Location
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Default Rent
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Default Deposit
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Houses
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="building in buildings" :key="building.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <input type="checkbox">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                            {{ building.name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ building.location }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ building.default_rent.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ building.default_deposit.toLocaleString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ building.houses_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center space-x-3">
                            <a :href="`/buildings/${building.id}`" class="text-indigo-600 hover:text-indigo-900">
                               View
                            </a>
                            <a href="#" class="text-red-300 hover:text-red-500" @click.prevent="editBuilding(building)">Edit</a>
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
import BuildingModal from "./partials/BuildingModal";

export default {
    name: 'buildings-list',
    components: {BuildingModal, TablePagination},
    data() {
        return {
            buildings: [],
            paginationData: {},
            perPage: 50,
        }
    },
    methods: {
        applyPagination(data) {
            this.buildings = data.data
            this.paginationData = data.pagination
        },
        applyPerPage(data) {
            this.perPage = data
            this.fetchBuildings()
        },
        editBuilding(building) {
            this.$refs.buildingModal.building = building
            this.$refs.buildingModal.showModal = true
        },
        async fetchBuildings() {
            try {
                let response = await axios.get(`/api/buildings?per_page=${this.perPage}`)
                this.buildings = response.data.data
                this.paginationData = response.data.pagination
            } catch (e) {
                console.error('could not fetch buildings')
            }
        }
    },
    created() {
        this.fetchBuildings()
    }
}
</script>