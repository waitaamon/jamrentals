<template>
    <app-tabs>
        <app-tab
            v-for="(tab, index) in tabs"
            :key="index"
            :name="tab.value"
            :selected="index === 0"
        >
            <div class="mt-4">
                <houses-list v-if="tab.value === 'houses'" :building="building"/>
                <tenants-list v-if="tab.value === 'tenants'" :building="building"/>
            </div>
        </app-tab>
    </app-tabs>
</template>

<script>
import AppTabs from "../../components/tabs/AppTabs";
import AppTab from "../../components/tabs/AppTab";
import TenantsList from "./TenantsList";
import HousesList from "./HousesList";

export default {
    name: "building-index",
    components: {HousesList, TenantsList, AppTab, AppTabs},
    props: ['building'],
    data() {
        return {
            tabs: [
                {name: 'Houses', value: 'houses'},
                {name: 'Tenants', value: 'tenants'},
            ],
        }
    }
}
</script>

<style scoped>

</style>