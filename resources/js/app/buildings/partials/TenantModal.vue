<template>
    <div v-if="building">
        <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            @click="showModal=true"
        >
            New Tenant
        </button>

        <Modal v-model="showModal" modalClass="max-width: 700px" title="New House" v-on:before-open="setDefaults">
            <div class="py-3">
                <form class="space-y-3">
                    <div>
                        <label for="house" class="block text-sm font-medium text-gray-700">House</label>
                        <div class="mt-1">
                            <multiselect
                                v-model="form.house"
                                :options="houses"
                                id="house"
                                trackBy="id"
                                label="name"
                                name="house"
                                placeholder="select house"
                            ></multiselect>
                        </div>
                        <p v-if="errors.house" class="mt-2 text-sm text-red-600" id="house-error">
                            {{ errors.house[0] }}
                        </p>
                    </div>

                    <app-input v-model="form.name" name="name" :error="errors.name ? errors.name[0] : null"/>

                    <app-input v-model="form.id_number" name="id_number" type="number"
                               :error="errors.id_number ? errors.id_number[0] : null"/>

                    <app-input v-model="form.phone" name="phone" type="text"
                               :error="errors.phone ? errors.phone[0] : null"/>

                    <app-input v-model="form.deposit" name="deposit" type="number"
                               :error="errors.deposit ? errors.deposit[0] : null"/>

                    <app-input v-model="form.incurred_cost" name="incurred_cost" type="number"
                               :error="errors.incurred_cost ? errors.incurred_cost[0] : null"/>

                    <app-textarea v-model="form.note" name="note" :error="errors.note ? errors.note[0] : null"/>

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
import AppTextarea from "../../../components/inputs/AppTextarea";

export default {
    name: 'tenant-modal',
    components: {AppTextarea, AppInput},
    props: ['building'],
    data() {
        return {
            showModal: false,
            closeAfterSave: true,
            tenant: null,
            houses: null,
            errors: {},
            form: {}
        }
    },
    watch: {
        'form.house': {
            handler: function () {
                this.form.deposit = this.form.house.deposit
            }
        }
    },
    methods: {
        submit() {
            axios({
                method: this.tenant ? 'patch' : 'post',
                url: this.tenant ? `/api/tenants/${this.tenant.id}` : `/api/tenants`,
                data: {
                    ...this.form,
                    house: this.form.house.id
                }
            })
                .then(response => {
                    this.resetForm()

                    this.$emit('fetch-tenants', true)

                    this.$toast.success('Successfully saved tenant.');

                    this.showModal = !this.closeAfterSave

                    this.closeAfterSave = true

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
            this.tenant = null
            this.errors = []
            this.form = {
                house: '',
                name: '',
                phone: '',
                id_number: '',
                note: '',
                incurred_cost: 0,
                deposit: 0,
            }
        },
        setDefaults() {

            this.form = {
                house: this.tenant ? this.houses.find(house => house.id === this.tenant.house_id) : '',
                name: this.tenant ? this.tenant.name : '',
                phone: this.tenant ? this.tenant.phone : '',
                id_number: this.tenant ? this.tenant.id_number : '',
                note: this.tenant ? this.tenant.note : '',
                incurred_cost: this.tenant ? this.tenant.incurred_cost : '',
                deposit: this.tenant ? this.tenant.deposit : '',
            }

        }
    },
    mounted() {
        this.$root.$on('housesUpdated', data => {
            this.houses = data.filter(house => !house.is_occupied)
        });
    },
}
</script>