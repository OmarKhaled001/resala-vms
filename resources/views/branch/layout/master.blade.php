<!DOCTYPE html>
<html lang="ar" dir="ltr">
@include('branch.layout.meta')

@yield('style')
    
@livewireStyles
    <body
    x-data="main"
    class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
    :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ?  'dark' : '', $store.app.menu, $store.app.layout,$store.app.rtlClass]"
    >
    @include('branch.layout.loader')
    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        @include('branch.layout.sidebar')
        <div class="main-content flex min-h-screen flex-col">
            @include('branch.layout.header')
            <div class="dvanimation animate__animated p-6" :class="[$store.app.animation]">
                @yield('content')
            </div>
            @include('branch.layout.footer')
        </div>
    </div>
    @include('branch.layout.script')
    @yield('script')
    @livewireScripts

</body>

</html>
