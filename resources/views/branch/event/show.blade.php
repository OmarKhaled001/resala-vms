<div class="fixed inset-0 bg-[black]/60 dark:text-white-light z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4">
        <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden  w-full max-w-5xl my-8">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg"> عرض حدث - {{ $event->contribution->name }}</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle()">
                    x
                </button>
            </div>
            @php
            $totalVolunteers = $event->volunteers->count();
            $tshirtCount = $event->volunteers->where('pivot.tshirt', 1)->count();
            $percentage = $totalVolunteers > 0 ? ($tshirtCount / $totalVolunteers) * 100 : 0;
            @endphp
            <div class="p-5" >
                <div class="mb-5 flex justify-between">
                    <h6 class="text-base font-semibold text-[#0e1726] dark:text-white-light">Placed Order</h6>
                    <span class="badge {{$event->getStatusBadgeClass()}} py-1.5 dark:bg-primary dark:text-white">{{ $event->getStatusLabel() }}</span>
                </div>
                <div class="mb-5 "  x-data="{ tab: 'home'}">
                    <!-- buttons -->
                    <div>
                        <ul class="flex flex-wrap mt-3 mb-5 border-b border-white-light dark:border-[#191e3a]">
                            <li>
                                <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 before:absolute hover:text-secondary before:bottom-0 before:w-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full" :class="{'before:w-full text-secondary' : tab === 'home'}" @click="tab='home'">
                                    المتطوعين</a>
                            </li>
                            <li>
                                <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full" :class="{'before:w-full text-secondary' : tab === 'profile'}" @click="tab='profile'">
                                    الوسائط</a>
                            </li>
                            <li>
                                <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full" :class="{'before:w-full text-secondary' : tab === 'contact'}" @click="tab='contact'">
                                    المطابقة</a>
                            </li>
                        </ul>
                    </div>
                <div x-show="tab === 'home'">
                    <div class="w-full h-5 bg-[#ebedf2] dark:bg-dark/40 rounded-full">
                        <div class="bg-gradient-to-r from-[#3cba92] to-[#0ba360] h-5 rounded-full text-center text-white flex justify-between items-center px-2 text-xs" style="width: {{ $percentage }}%;">
                            <span>نسبة التيشرتات</span>
                            <span>{{ round($percentage, 2) }}%</span>
                        </div>
                    </div>

                    <!-- Volunteers Table -->
                    <div class="table-responsive my-3">
                        <table class="dark:text-white-light">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>أسم المتطوع</th>
                                    <th>رقم الهاتف</th>
                                    <th>تيشرت</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event->volunteers as $volunteer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $volunteer->name }}</td>
                                        <td>{{ $volunteer->phone }}</td>
                                        <td>
                                            @if ($volunteer->pivot->tshirt)
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success">
                                                    <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"></circle>
                                                    <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div x-show="tab === 'profile'">
                    <div class="p-5" >
                        <div class="swiper max-w-3xl mx-auto mb-5 slider1" id="slider1">
                            <div class="swiper-wrapper">
                                <template x-for="item in items">
                                    <div class="swiper-slide">
                                        <img :src="`/{{ asset('assets') }}/images/${item}`" class="w-full max-h-80 object-cover" alt="image" />
                                    </div>
                                </template>
                            </div>
                            <a href="javascript:;" class="swiper-button-prev-ex1 grid place-content-center ltr:left-2 rtl:right-2 p-1 transition text-primary hover:text-white border border-primary  hover:border-primary hover:bg-primary rounded-full absolute z-[999] top-1/2 -translate-y-1/2">
                                <svg> ... </svg>
                            </a>
                            <a href="javascript:;" class="swiper-button-next-ex1 grid place-content-center ltr:right-2 rtl:left-2 p-1 transition text-primary hover:text-white border border-primary  hover:border-primary hover:bg-primary rounded-full absolute z-[999] top-1/2 -translate-y-1/2">
                                <svg> ... </svg>
                            </a>
                            <div class="swiper-pagination"></div>
                        </div>
                        
                        <!-- script -->
              
                    </div>
                </div>
                <div x-show="tab === 'contact'">
                    <div class="flex">
                        <div class="ltr:mr-4 rtl:ml-4">
                            <img src="{{ Avatar::create(auth('branch')->user()->email)->toBase64() }}" alt="image" class="w-14 h-14 rounded" />
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-lg mb-2 text-primary">{{auth('branch')->user()->email }}</h4>
                            <p class="media-text mb-5">{{ $event->reason ?? 'تم تسجيل عدد متطوعين 5 وظاهر 6' }}</p>
                            <div class="flex">
                                <div class="ltr:mr-4 rtl:ml-4">
                                    <img src="/assets/images/profile-5.jpeg" alt="image" class="w-14 h-14 rounded" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-lg mb-2 text-primary">Heading</h4>
                                    <p class="media-text"> Fusce condimentum cursus mauris et ornare. Mauris fermentum mi id sollicitudin viverra. Aenean dignissim sed ante eget dapibus. Sed dapibus nulla elementum, rutrum neque eu, gravida neque. </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                    
                </div>   
                    
                <div class="flex justify-end items-center mt-8">
                    <button type="button" class="btn btn-outline-danger" @click="open = false">غلق</button>
                </div>
            </div>
        </div>
    </div>
</div>