<template>
    <div>
        <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            @click="showModal=true"
        >
            New House
        </button>

        <Modal v-model="showModal" modalClass="max-width: 700px" title="New House" v-on:before-open="setDefaults">
            <div class="py-3">
                <form class="space-y-3">
                    <app-input v-model="form.name" name="name" :error="errors.name ? errors.name[0] : null"/>

                    <app-input v-model="form.tenant" name="tenant" :error="errors.tenant ? errors.tenant[0] : null"/>

                    <app-input v-model="form.tenant_phone" name="tenant_phone"
                               :error="errors.tenant_phone ? errors.tenant_phone[0] : null"/>

                    <app-input v-model="form.tenant_id" name="tenant_id"
                               :error="errors.tenant_id ? errors.tenant_id[0] : null"/>


                    <app-input v-model="form.rent" name="rent" type="number"
                               :error="errors.rent ? errors.rent[0] : null"/>

                    <app-input v-model="form.deposit" name="deposit" type="number"
                               :error="errors.deposit ? errors.deposit[0] : null"/>

                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click="saveAndNew"
                        >
                            Save and New
                        </button>
                        <button
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            @click.prevent="submit"
                        >
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </Modal>
    </div>
</template>

<script>
import AppInput from "../../../components/inputs/AppInput";

export default {
    name: 'house-modal',
    components: {AppInput},
    props: ['building'],
    data() {
        return {
            showModal: false,
            closeAfterSave: true,
            house: null,
            errors: {},
            form: {}
        }
    },
    methods: {
        submit() {
            axios({
                method: this.house ? 'patch' : 'post',
                url: this.house ? `/api/houses/${this.house.id}` : `/api/houses`,
                data: this.form
            })
                .then(response => {
                    this.resetForm()

                    this.$emit('fetch-houses', true)

                    this.$toast.success('Successfully saved house.');

                    if (this.closeAfterSave) {
                        this.showModal = false
                    }
                }).catch(e => {
                if (e.response.status === 422) {
                    this.errors = e.response.data.errors
                    this.$toast.error('The form submitted has errors');
                    return
                }
                this.$toast.error('Something went wrong try again later');
            })
        },
        saveAndNew() {
            this.closeAfterSave = false
            this.submit()
        },
        resetForm() {
            this.house = null
            this.errors = []
            this.form = {
                building: this.building.id,
                name: '',
                tenant: '',
                tenant_phone: '',
                tenant_id: '',
                rent: this.building.default_rent,
                deposit: this.building.default_deposit,
            }
        },
        setDefaults() {

            this.form = {
                building: this.building.id,
                name: this.house ? this.house.name : '',
                tenant: this.house ? this.house.tenant : '',
                tenant_phone: this.house ? this.house.tenant_phone : '',
                tenant_id: this.house ? this.house.tenant_id : '',
                rent: this.house ? this.house.rent : this.building.default_rent,
                deposit: this.house ? this.house.deposit : this.building.default_deposit,
            }

        }
    },
}
</script>