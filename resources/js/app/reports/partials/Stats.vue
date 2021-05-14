<template>
    <div>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Rent Amount
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    71,897
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Unpaid Rent Total
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    58.16%
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Deposit Amount Total
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    24.57%
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Vacant Houses
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    24.57%
                </dd>
            </div>

        </dl>
    </div>
</template>

<script>
export default  {
    name: 'stats'
}
</script>