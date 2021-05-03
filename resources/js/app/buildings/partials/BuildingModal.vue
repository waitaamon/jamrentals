<template>
    <div>
        <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            @click="showModal=true"
        >
            New Building
        </button>

        <Modal v-model="showModal" modalClass="max-width: 700px" title="New Building" v-on:before-open="setDefaults">
            <div class="py-3">
                <form class="space-y-3">
                    <app-input v-model="form.name" name="name" :error="errors.name ? errors.name[0] : null"/>

                    <app-input v-model="form.location" name="location"
                               :error="errors.location ? errors.location[0] : null"/>


                    <app-input v-model="form.default_rent" name="default_rent" type="number"
                               :error="errors.default_rent ? errors.default_rent[0] : null"/>

                    <app-input v-model="form.default_deposit" name="default_deposit" type="number"
                               :error="errors.default_deposit ? errors.default_deposit[0] : null"/>

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
    name: 'building-modal',
    components: {AppInput},
    data() {
        return {
            showModal: false,
            closeAfterSave: true,
            building: null,
            errors: {},
            form: {
                name: '',
                location: '',
                default_rent: '',
                default_deposit: '',
            }
        }
    },
    methods: {
        submit() {
            axios({
                method: this.building ? 'patch' : 'post',
                url: this.building ? `api/buildings/${this.building.id}` : `api/buildings`,
                data: this.form
            })
                .then(response => {
                    this.resetForm()

                    this.$emit('fetch-buildings', true)

                    this.$toast.success('Successfully saved building.');

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
            this.building = null
            this.errors = []
            this.form = {
                name: '',
                location: '',
                default_rent: '',
                default_deposit: '',
            }
        },
        setDefaults() {
            this.form.name = this.building ? this.building.name : ''
            this.form.location = this.building ? this.building.location : ''
            this.form.default_rent = this.building ? this.building.default_rent : ''
            this.form.default_deposit = this.building ? this.building.default_deposit : ''
        }
    },
}
</script>