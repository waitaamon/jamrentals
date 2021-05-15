<template>
    <div>
        <label :for="name" class="block text-sm font-medium text-gray-700 capitalize">{{ formattedName }}</label>
        <div class="mt-1">
            <textarea
                v-bind="$attrs"
                :name="name"
                :id="name"
                :value="value"
                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                :class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : error}"
                @input="$emit('input', $event.target.value)"
            ></textarea>
        </div>
        <p v-if="error" class="mt-2 text-sm text-red-600" :id="`${name}-error`">{{ error }}</p>
    </div>
</template>

<script>
export default {
    name: 'app-textarea',
    props: {
        name: {
            required: true,
            type: String,
        },
        value: {
            required: false,
            default: null,
        },
        error: {
            required: false,
            type: String,
            default: "",
        },
    },
    computed: {
        formattedName() {
            return this.name.replace(/_/g, " ")
        }
    }
}
</script>