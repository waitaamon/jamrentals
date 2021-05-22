
<div>
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Rent Payment
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $house->payments_sum }}
            </dd>
        </div>

        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Unpaid Rent
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $building->vacant_houses_count }}
            </dd>
        </div>

        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
            <dt class="text-sm font-medium text-gray-500 truncate">
                Total Previous Tenants
            </dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                {{ $building->occupied_houses_count }}
            </dd>
        </div>
    </dl>
</div>
