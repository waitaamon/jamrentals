<template>
    <div class="grid grid-cols-4 gap-4 bg-gray-50 p-2 rounded">
        <div class="col-span-2">
            <label for="building" class="block text-sm font-medium text-gray-700">Building</label>
            <multiselect
                v-model="filters.building"
                :options="buildings"
                id="building"
                trackBy="id"
                label="name"
                placeholder=""
                @select="updateHouses"
            ></multiselect>
        </div>
        <div class="col-span-2">
            <label for="house" class="block text-sm font-medium text-gray-700">House</label>
            <multiselect
                v-model="filters.house"
                :options="houses"
                id="house"
                trackBy="id"
                label="name"
                placeholder=""
            ></multiselect>
        </div>
        <div class="col-span-2">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select v-model="filters.status" id="status" name="status"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option v-for="status in statuses" :key="status" class="capitalize">{{ status }}</option>
            </select>
        </div>
        <div class="col-span-2">
            <label for="tenant" class="block text-sm font-medium text-gray-700">Tenants</label>
            <multiselect
                v-model="filters.tenant"
                :options="tenants"
                id="tenant"
                trackBy="id"
                label="name"
                placeholder=""
            ></multiselect>
        </div>
        <div class="col-span-2">
            <div>
                <label for="from" class="block text-sm font-medium text-gray-700">From</label>
                <input type="date" v-model="filters.from" id="from" name="from"
                       class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            </div>
        </div>
        <div class="col-span-2">
            <div>
                <label for="to" class="block text-sm font-medium text-gray-700">To</label>
                <input type="date" v-model="filters.to" id="to" name="to"
                       class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            </div>
        </div>
        <div class="col-span-2 flex justify-start items-center">
            <a @click.prevent="resetFilters" href="#" class="block capitalize text-red-300 text-sm hover:text-red-400">clear
                filters</a>
        </div>
        <div class="col-span-4"></div>
    </div>
</template>

<script>
export default {
    name: "payment-table-filters",
    props: ['buildings'],
    data() {
        return {
            statuses: ['approved', 'reversed'],
            filters: {},
            houses: [],
            tenants: [],
        }
    },
    watch: {
        filters: {
            deep: true,
            handler: function () {
                this.applyFilters()
            }
        }
    },
    methods: {
        updateHouses(building, id) {
            this.houses = building.houses
        },
        resetFilters() {
            this.filters = {
                building: '',
                house: '',
                status: 'approved',
                from: '',
                to: '',
            }
        },
        applyFilters() {
            let data = {
                building: this.filters.building ? this.filters.building.id : '',
                house: this.filters.house ? this.filters.house.id : '',
                status: this.filters.status,
                from: this.filters.from,
                end: this.filters.to
            }

            this.$emit('apply-filters', data)
        },
        created() {
            this.resetForm()
        }
    },
}
</script>