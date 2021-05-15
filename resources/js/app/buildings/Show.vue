<template>
    <div>
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <select id="tabs" name="tabs"
                    class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                <option v-for="tab in tabs" :key="tab.value" :selected="tab.value === selectedTab" :value="tab.value">{{ tab.name }}</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a v-for="tab in tabs" :key="tab.value" href="#" @click.prevent="selectedTab = tab.value"
                       :class="[tab.value === selectedTab ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm']"
                       :aria-current="tab.value === selectedTab ? 'page' : undefined">
                    </a>
                    <span>abc </span>
                </nav>
                <div class="w-full">
                    <div v-if="selectedTab === 'houses'">
                        houses
                    </div>
                    <div v-if="selectedTab === 'tenants'">
                        tenants
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "building-index",
    data() {
        return {
            tabs: [
                {name: 'Houses', value: 'houses'},
                {name: 'Tenants', value: 'tenant'},
            ],
            selectedTab: 'houses'
        }
    }
}
</script>

<style scoped>

</style>