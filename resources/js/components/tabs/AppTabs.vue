<template>
    <div>
        <nav class="bg-white px-8 pt-2 border-b border-gray-200">
            <div class="-mb-px flex space-x-8">
                <a v-for="tab in tabs"
                   class="no-underline border-b-2 border-transparent uppercase tracking-wide font-medium text-gray-600 text-xs py-3"
                   :class="{'border-indigo-400 font-bold text-gray-800':tab.isActive }"
                   :href="tab.href" @click="selectTab(tab)"
                   :key="tab.name"
                >
                    {{ tab.name }}
                </a>
            </div>
        </nav>

        <div class="tabs-details">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {tabs: []};
    },

    created() {
        this.tabs = this.$children;
    },

    methods: {
        selectTab(selectedTab) {
            this.tabs.forEach(tab => {
                tab.isActive = (tab.href === selectedTab.href);
            });
        }
    }
}
</script>