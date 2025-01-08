<!DOCTYPE html>
<html lang="ar" dir="ltr">
@include('super_admin.layout.meta')

@yield('style')

    <body
    x-data="main"
    class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
    :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ?  'dark' : '', $store.app.menu, $store.app.layout,$store.app.rtlClass]"
    >
    @include('super_admin.layout.loader')
    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        @include('super_admin.layout.sidebar')
        <div class="main-content flex min-h-screen flex-col">
            @include('super_admin.layout.header')
            <div class="dvanimation animate__animated p-6" :class="[$store.app.animation]">
                @yield('content')
            </div>
            @include('super_admin.layout.footer')
        </div>
    </div>
    @include('super_admin.layout.script')
    @yield('script')
</body>

</html>
