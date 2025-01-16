<div :class="{ 'dark text-white-dark': $store.app.semidark }">
    <nav x-data="sidebar"
        class="sidebar fixed bottom-0 top-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
        <div class="h-full bg-white dark:bg-[#0e1726]">
            <div class="flex items-center justify-between px-4 py-3">
                <a href="{{ route('super_admin.index') }}" class="main-logo flex shrink-0 items-center">
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
            x-data="{ activeDropdown: '{{ request()->routeIs('super_admin.index') ? 'dashboard' : '' }}' }">
            <li class="nav-item">
                <a href="{{ route('super_admin.index') }}" class="{{ request()->routeIs('super_admin.index') ? 'active' : '' }} group">
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
        
        
            <h2 class="-mx-4 mb-1 flex items-center bg-white-light/30 px-7 py-3 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                <svg class="hidden h-5 w-4 flex-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>الهيكل</span>
            </h2>
            <li class="nav-item">
                <ul x-data="{ activeDropdown: '{{ request()->routeIs('super_admin.branch.*') ? 'branches' : '' }}' }">
                    <li class="nav-item">
                        <ul>
                            <li class="menu nav-item">
                                <button type="button" class="nav-link group" 
                                        :class="{'active': activeDropdown === 'branches'}" 
                                        @click="activeDropdown === 'branches' ? activeDropdown = null : activeDropdown = 'branches'">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5" d="M19.7165 20.3624C21.143 19.5846 22 18.5873 22 17.5C22 16.3475 21.0372 15.2961 19.4537 14.5C17.6226 13.5794 14.9617 13 12 13C9.03833 13 6.37738 13.5794 4.54631 14.5C2.96285 15.2961 2 16.3475 2 17.5C2 18.6525 2.96285 19.7039 4.54631 20.5C6.37738 21.4206 9.03833 22 12 22C15.1066 22 17.8823 21.3625 19.7165 20.3624Z" fill="currentColor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 8.51464C5 4.9167 8.13401 2 12 2C15.866 2 19 4.9167 19 8.51464C19 12.0844 16.7658 16.2499 13.2801 17.7396C12.4675 18.0868 11.5325 18.0868 10.7199 17.7396C7.23416 16.2499 5 12.0844 5 8.51464ZM12 11C13.1046 11 14 10.1046 14 9C14 7.89543 13.1046 7 12 7C10.8954 7 10 7.89543 10 9C10 10.1046 10.8954 11 12 11Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">الفروع</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90': activeDropdown === 'branches'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </button>
                                <ul x-show="activeDropdown === 'branches'" x-collapse="" class="sub-menu text-gray-500" style="display: block;">
                                    <li>
                                        <a href="{{ route('super_admin.branch.index') }}" 
                                           class="{{ request()->routeIs('super_admin.branch.index') ? 'active' : '' }}">الكل</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('super_admin.branch.create') }}" 
                                        class="{{ request()->routeIs('super_admin.branch.create') ? 'active' : '' }}">إضافة</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </li>
            <li class="nav-item">
                <ul x-data="{ activeDropdown: '{{ request()->routeIs('super_admin.activity.*') ? 'activity' : '' }}' }">
                    <li class="nav-item">
                        <ul>
                            <li class="menu nav-item">
                                <button type="button" class="nav-link group" 
                                        :class="{'active': activeDropdown === 'activity'}" 
                                        @click="activeDropdown === 'activity' ? activeDropdown = null : activeDropdown = 'activity'">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5" d="M13 15.4C13 13.3258 13 12.2887 13.659 11.6444C14.318 11 15.3787 11 17.5 11C19.6213 11 20.682 11 21.341 11.6444C22 12.2887 22 13.3258 22 15.4V17.6C22 19.6742 22 20.7113 21.341 21.3556C20.682 22 19.6213 22 17.5 22C15.3787 22 14.318 22 13.659 21.3556C13 20.7113 13 19.6742 13 17.6V15.4Z" fill="currentColor"></path>
                                            <path d="M2 8.6C2 10.6742 2 11.7113 2.65901 12.3556C3.31802 13 4.37868 13 6.5 13C8.62132 13 9.68198 13 10.341 12.3556C11 11.7113 11 10.6742 11 8.6V6.4C11 4.32582 11 3.28873 10.341 2.64437C9.68198 2 8.62132 2 6.5 2C4.37868 2 3.31802 2 2.65901 2.64437C2 3.28873 2 4.32582 2 6.4V8.6Z" fill="currentColor"></path>
                                            <path d="M13 5.5C13 4.4128 13 3.8692 13.1713 3.44041C13.3996 2.86867 13.8376 2.41443 14.389 2.17761C14.8024 2 15.3266 2 16.375 2H18.625C19.6734 2 20.1976 2 20.611 2.17761C21.1624 2.41443 21.6004 2.86867 21.8287 3.44041C22 3.8692 22 4.4128 22 5.5C22 6.5872 22 7.1308 21.8287 7.55959C21.6004 8.13133 21.1624 8.58557 20.611 8.82239C20.1976 9 19.6734 9 18.625 9H16.375C15.3266 9 14.8024 9 14.389 8.82239C13.8376 8.58557 13.3996 8.13133 13.1713 7.55959C13 7.1308 13 6.5872 13 5.5Z" fill="currentColor"></path>
                                            <path opacity="0.5" d="M2 18.5C2 19.5872 2 20.1308 2.17127 20.5596C2.39963 21.1313 2.83765 21.5856 3.38896 21.8224C3.80245 22 4.32663 22 5.375 22H7.625C8.67337 22 9.19755 22 9.61104 21.8224C10.1624 21.5856 10.6004 21.1313 10.8287 20.5596C11 20.1308 11 19.5872 11 18.5C11 17.4128 11 16.8692 10.8287 16.4404C10.6004 15.8687 10.1624 15.4144 9.61104 15.1776C9.19755 15 8.67337 15 7.625 15H5.375C4.32663 15 3.80245 15 3.38896 15.1776C2.83765 15.4144 2.39963 15.8687 2.17127 16.4404C2 16.8692 2 17.4128 2 18.5Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">الانشطة</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90': activeDropdown === 'activity'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </button>
                                <ul x-show="activeDropdown === 'activity'" x-collapse="" class="sub-menu text-gray-500" style="display: block;">
                                    <li>
                                        <a href="{{ route('super_admin.activity.index') }}" 
                                           class="{{ request()->routeIs('super_admin.activity.index') ? 'active' : '' }}">الكل</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('super_admin.activity.create') }}" 
                                           class="{{ request()->routeIs('super_admin.activity.create') ? 'active' : '' }}">إضافة</a>
                                    </li>
                                  
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </li>
            <li class="nav-item">
                <ul x-data="{ activeDropdown: '{{ (request()->routeIs('super_admin.section.*') or request()->routeIs('super_admin.contribution.*') ) ? 'section' : '' }}' }">
                    <li class="nav-item">
                        <ul>
                            <li class="menu nav-item">
                                <button type="button" class="nav-link group" 
                                        :class="{'active': activeDropdown === 'section'}" 
                                        @click="activeDropdown === 'section' ? activeDropdown = null : activeDropdown = 'section'">
                                    <div class="flex items-center">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0 group-hover:!text-primary">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.73167 5.77133L5.66953 9.91436C4.3848 11.6526 3.74244 12.5217 4.09639 13.205C4.10225 13.2164 4.10829 13.2276 4.1145 13.2387C4.48945 13.9117 5.59888 13.9117 7.81775 13.9117C9.05079 13.9117 9.6673 13.9117 10.054 14.2754L10.074 14.2946L13.946 9.72466L13.926 9.70541C13.5474 9.33386 13.5474 8.74151 13.5474 7.55682V7.24712C13.5474 3.96249 13.5474 2.32018 12.6241 2.03721C11.7007 1.75425 10.711 3.09327 8.73167 5.77133Z" fill="currentColor"></path>
                                            <path opacity="0.5" d="M10.4527 16.4432L10.4527 16.7528C10.4527 20.0374 10.4527 21.6798 11.376 21.9627C12.2994 22.2457 13.2891 20.9067 15.2685 18.2286L18.3306 14.0856C19.6154 12.3474 20.2577 11.4783 19.9038 10.7949C19.8979 10.7836 19.8919 10.7724 19.8857 10.7613C19.5107 10.0883 18.4013 10.0883 16.1824 10.0883C14.9494 10.0883 14.3329 10.0883 13.9462 9.72461L10.0742 14.2946C10.4528 14.6661 10.4527 15.2585 10.4527 16.4432Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">اللجان</span>
                                    </div>
                                    <div class="rtl:rotate-180" :class="{'!rotate-90': activeDropdown === 'section'}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </button>
                                <ul x-show="activeDropdown === 'section'" x-collapse="" class="sub-menu text-gray-500" style="display: block;">
                               
                                    <li>
                                        <a href="{{ route('super_admin.section.index') }}" 
                                        class="{{ request()->routeIs('super_admin.section.index') ? 'active' : '' }}">الكل</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('super_admin.section.create') }}" 
                                        class="{{ request()->routeIs('super_admin.section.create') ? 'active' : '' }}">إضافة</a>
                                    </li>
                               
                                    <li>
                                        <a href="{{ route('super_admin.contribution.index') }}" 
                                        class="{{ request()->routeIs('super_admin.contribution.index') ? 'active' : '' }}">المشاركات</a>
                                    </li>
                                 
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </li>
            @role('owner')
            <h2 class="-mx-4 mb-1 flex items-center bg-white-light/30 px-7 py-3 font-extrabold uppercase dark:bg-dark dark:bg-opacity-[0.08]">
                <svg class="hidden h-5 w-4 flex-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>الإعدادت</span>
            </h2>
            <li class="nav-item">
                <ul x-data="{ activeDropdown: '{{ request()->routeIs('super_admin.user.*') ? 'users' : '' }}' }">
                    <li class="nav-item">
                        <ul>
                            
                            <li class="nav-item">
                                <a href="{{ route('super_admin.user.index') }}" class="{{ request()->routeIs('super_admin.user.*') ? 'active' : '' }} group">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle opacity="0.5" cx="15" cy="6" r="3" fill="currentColor"></circle>
                                            <ellipse opacity="0.5" cx="16" cy="17" rx="5" ry="3" fill="currentColor"></ellipse>
                                            <circle cx="9.00098" cy="6" r="4" fill="currentColor"></circle>
                                            <ellipse cx="9.00098" cy="17.001" rx="7" ry="4" fill="currentColor"></ellipse>
                                        </svg>
                                        <span
                                            class="text-black rtl:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">المستخدمون</span>
                                    </div>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{ route('super_admin.role.index') }}" class="{{ request()->routeIs('super_admin.role.*') ? 'active' : '' }} group">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5" d="M2 16C2 13.1716 2 11.7574 2.87868 10.8787C3.75736 10 5.17157 10 8 10H16C18.8284 10 20.2426 10 21.1213 10.8787C22 11.7574 22 13.1716 22 16C22 18.8284 22 20.2426 21.1213 21.1213C20.2426 22 18.8284 22 16 22H8C5.17157 22 3.75736 22 2.87868 21.1213C2 20.2426 2 18.8284 2 16Z" fill="currentColor"></path>
                                            <path d="M8 17C8.55228 17 9 16.5523 9 16C9 15.4477 8.55228 15 8 15C7.44772 15 7 15.4477 7 16C7 16.5523 7.44772 17 8 17Z" fill="currentColor"></path>
                                            <path d="M12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z" fill="currentColor"></path>
                                            <path d="M17 16C17 16.5523 16.5523 17 16 17C15.4477 17 15 16.5523 15 16C15 15.4477 15.4477 15 16 15C16.5523 15 17 15.4477 17 16Z" fill="currentColor"></path>
                                            <path d="M6.75 8C6.75 5.10051 9.10051 2.75 12 2.75C14.8995 2.75 17.25 5.10051 17.25 8V10.0036C17.8174 10.0089 18.3135 10.022 18.75 10.0546V8C18.75 4.27208 15.7279 1.25 12 1.25C8.27208 1.25 5.25 4.27208 5.25 8V10.0546C5.68651 10.022 6.18264 10.0089 6.75 10.0036V8Z" fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black rtl:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">الصلاحيات</span>
                                    </div>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{ route('super_admin.activity_logs.index') }}" class="{{ request()->routeIs('super_admin.activity_logs.index') ? 'active' : '' }} group">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5" d="M21 15.9983V9.99826C21 7.16983 21 5.75562 20.1213 4.87694C19.3529 4.10856 18.175 4.01211 16 4H8C5.82497 4.01211 4.64706 4.10856 3.87868 4.87694C3 5.75562 3 7.16983 3 9.99826V15.9983C3 18.8267 3 20.2409 3.87868 21.1196C4.75736 21.9983 6.17157 21.9983 9 21.9983H15C17.8284 21.9983 19.2426 21.9983 20.1213 21.1196C21 20.2409 21 18.8267 21 15.9983Z" fill="currentColor"></path>
                                            <path d="M8 3.5C8 2.67157 8.67157 2 9.5 2H14.5C15.3284 2 16 2.67157 16 3.5V4.5C16 5.32843 15.3284 6 14.5 6H9.5C8.67157 6 8 5.32843 8 4.5V3.5Z" fill="currentColor"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 9.25C12.4142 9.25 12.75 9.58579 12.75 10V12.25L15 12.25C15.4142 12.25 15.75 12.5858 15.75 13C15.75 13.4142 15.4142 13.75 15 13.75L12.75 13.75L12.75 16C12.75 16.4142 12.4142 16.75 12 16.75C11.5858 16.75 11.25 16.4142 11.25 16L11.25 13.75H9C8.58579 13.75 8.25 13.4142 8.25 13C8.25 12.5858 8.58579 12.25 9 12.25L11.25 12.25L11.25 10C11.25 9.58579 11.5858 9.25 12 9.25Z" fill="currentColor"></path>
                                        </svg>
                                        <span
                                            class="text-black rtl:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">سجل العمليات</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </li>
            @endrole
        </ul>
        
        </div>
    </nav>
</div>
