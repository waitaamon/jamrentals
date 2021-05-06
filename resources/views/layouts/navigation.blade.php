

<nav class="bg-indigo-600 border-b border-indigo-300 border-opacity-25 lg:border-none">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="relative h-16 flex items-center justify-between lg:border-b lg:border-indigo-400 lg:border-opacity-25">
            <div class="px-2 flex items-center lg:px-0">
                <div class="flex-shrink-0">
                    <img class="block h-8 w-8" src="https://tailwindui.com/img/logos/workflow-mark-indigo-300.svg"
                         alt="Workflow">
                </div>
                <div class="hidden lg:block lg:ml-10">
                    <div class="flex space-x-4">

                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('building.index')" :active="request()->routeIs('building.index')">
                            {{ __('Buildings') }}
                        </x-nav-link>

                        <x-nav-link :href="route('payment.index')" :active="request()->routeIs('payment.index')">
                            {{ __('Payments') }}
                        </x-nav-link>

                        <x-nav-link :href="route('report.index')" :active="request()->routeIs('report.index')">
                            {{ __('Reports') }}
                        </x-nav-link>

                    </div>
                </div>
            </div>
            <div class="flex lg:hidden">

            </div>
            <div class="hidden lg:block lg:ml-4">
                <div class="flex items-center space-x-4">
                    <div class="font-medium text-base text-gray-300">{{ Auth::user()->name }}</div>
                    <div class="">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="font-medium text-base text-red-300 hover:text-red-400 focus::text-red-400"
                               href="{{route('logout')}}"
                               onclick="event.preventDefault();
                               this.closest('form').submit();"
                            >
                                {{ __('Log out') }}
                            </a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>
