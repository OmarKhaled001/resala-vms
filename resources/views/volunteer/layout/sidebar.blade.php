<div :class="{ 'dark text-white-dark': $store.app.semidark }">
    <nav x-data="sidebar"
        class="sidebar fixed bottom-0 top-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
        <div class="h-full bg-white dark:bg-[#0e1726]">
            <div class="flex items-center justify-between px-4 py-3">
                <a href="{{ route('volunteer.index') }}" class="main-logo flex shrink-0 items-center">
                    <img class="ml-[5px] w-8 flex-none" src="{{ asset('assets') }}/images/logo.svg" alt="image" />
                    <span
                        class="align-middle text-2xl font-semibold rtl:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline">VMS</span>
                </a>
                <a href="javascript:;"
                    class="collapse-icon flex h-8 w-8 items-center rounded-full transition duration-300 hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10"
                    @click="$store.app.toggleSidebar()">
                    <svg class="m-auto h-5 w-5" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
            <ul class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 overflow-y-auto overflow-x-hidden p-4 py-0 font-semibold"
            x-data="{ activeDropdown: '{{ request()->routeIs('volunteer.index') ? 'dashboard' : '' }}' }">
            <li class="nav-item">
                <a href="{{ route('volunteer.index') }}" class="{{ request()->routeIs('volunteer.index') ? 'active' : '' }} group">
                    <div class="flex items-center">
                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5"
                                d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                fill="currentColor" />
                            <path
                                d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
                                fill="currentColor" />
                        </svg>
                        <span
                            class="text-black rtl:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">الرئيسية</span>
                    </div>
                </a>
            </li>
        
        
        
            <li class="nav-item">
                <ul x-data="{ activeDropdown: '{{ request()->routeIs('volunteer.event.*') ? 'events' : '' }}' }">
                    <li class="nav-item">
                        <ul>
                            <li class="menu nav-item">
                                <button type="button" class="nav-link group" 
                                        :class="{'active': activeDropdown === 'events'}" 
                                        @click="activeDropdown === 'events' ? activeDropdown = null : activeDropdown = 'events'">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.42229 20.6181C10.1779 21.5395 11.0557 22.0001 12 22.0001V12.0001L2.63802 7.07275C2.62423 7.09491 2.6107 7.11727 2.5974 7.13986C2 8.15436 2 9.41678 2 11.9416V12.0586C2 14.5834 2 15.8459 2.5974 16.8604C3.19479 17.8749 4.27063 18.4395 6.42229 19.5686L8.42229 20.6181Z" fill="currentColor"></path>
                                            <path opacity="0.7" d="M17.5774 4.43152L15.5774 3.38197C13.8218 2.46066 12.944 2 11.9997 2C11.0554 2 10.1776 2.46066 8.42197 3.38197L6.42197 4.43152C4.31821 5.53552 3.24291 6.09982 2.6377 7.07264L11.9997 12L21.3617 7.07264C20.7564 6.09982 19.6811 5.53552 17.5774 4.43152Z" fill="currentColor"></path>
                                            <path opacity="0.5" d="M21.4026 7.13986C21.3893 7.11727 21.3758 7.09491 21.362 7.07275L12 12.0001V22.0001C12.9443 22.0001 13.8221 21.5395 15.5777 20.6181L17.5777 19.5686C19.7294 18.4395 20.8052 17.8749 21.4026 16.8604C22 15.8459 22 14.5834 22 12.0586V11.9416C22 9.41678 22 8.15436 21.4026 7.13986Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">الأحداث</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90': activeDropdown === 'events'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </button>
                                <ul x-show="activeDropdown === 'events'" x-collapse="" class="sub-menu text-gray-500" style="display: block;">
                                    <li>
                                        <a href="{{ route('volunteer.event.index') }}" 
                                           class="{{ request()->routeIs('volunteer.event.index') ? 'active' : '' }}">الكل</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('volunteer.event.create') }}" 
                                           class="{{ request()->routeIs('volunteer.event.create') ? 'active' : '' }}">إضافة</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </li>
            <li class="nav-item">
                <ul x-data="{ activeDropdown: '{{ request()->routeIs('volunteer.vol.*') ? 'vols' : '' }}' }">
                    <li class="nav-item">
                        <ul>
                            <li class="menu nav-item">
                                <button type="button" class="nav-link group" 
                                        :class="{'active': activeDropdown === 'vols'}" 
                                        @click="activeDropdown === 'vols' ? activeDropdown = null : activeDropdown = 'vols'">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle opacity="0.5" cx="15" cy="6" r="3" fill="currentColor"></circle>
                                            <ellipse opacity="0.5" cx="16" cy="17" rx="5" ry="3" fill="currentColor"></ellipse>
                                            <circle cx="9.00098" cy="6" r="4" fill="currentColor"></circle>
                                            <ellipse cx="9.00098" cy="17.001" rx="7" ry="4" fill="currentColor"></ellipse>
                                        </svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">المتطوعين</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90': activeDropdown === 'vols'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </button>
                                <ul x-show="activeDropdown === 'vols'" x-collapse="" class="sub-menu text-gray-500" style="display: block;">
                                    <li>
                                        <a href="{{ route('volunteer.vol.index') }}" class="{{ request()->routeIs('volunteer.vol.index') ? 'active' : '' }}">الكل</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('volunteer.vol.teemWork') }}" class="{{ request()->routeIs('volunteer.vol.teemWork') ? 'active' : '' }}">فريق العمل</a>
                                    </li>
                                    <li>
                                        {{-- <a href="{{ route('volunteer.vol.create') }}" class="{{ request()->routeIs('volunteer.vol.create') ? 'active' : '' }}">استمارة تطوع</a> --}}
                                    </li>
                                    <li>
                                        {{-- <a href="{{ route('volunteer.vol.index') }}" class="{{ request()->routeIs('volunteer.vol.index') ? 'active' : '' }}">التعديلات </a> --}}
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </li>
        </ul>
        
        </div>
    </nav>
</div>
