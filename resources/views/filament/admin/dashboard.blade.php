<x-filament::page>
    <div class="max-w-md mx-auto mt-12 space-y-6">
        {{--        <h1 class="text-xl font-bold text-center">使用 Google 登入</h1>--}}

        <a href="{{ route('login.google') }}"
           class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md shadow-sm">
            <x-heroicon-o-globe-alt class="w-5 h-5 mr-2" />
            使用 Google 登入
        </a>
    </div>
</x-filament::page>