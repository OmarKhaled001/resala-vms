<div class="fixed inset-0 bg-[black]/60 dark:text-white-light z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4">
        <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden  w-full max-w-5xl my-8">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg"> احصائيات الاحداث</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle()">
                    x
                </button>
            </div>
           
            <div class="p-5" >
                
           
                @php
                    $totalevents = $events->count();
                    $conformingCount =  $events->where('status', 'conforming')->count();
                    $percentage = $totalevents > 0 ? ($conformingCount / $totalevents) * 100 : 0;
                @endphp

                <div class="mb-5 "  x-data="{ tab: 'home'}">
                    <!-- buttons -->
                    <div>
                        <ul class="flex flex-wrap mt-3 mb-5 border-b border-white-light dark:border-[#3b3f5c]">
                            <li>
                                <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 before:absolute hover:text-primary before:bottom-0 before:w-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-primary hover:before:w-full" :class="{'before:w-full text-primary' : tab === 'home'}" @click="tab='home'">
                                    الاحداث</a>
                            </li>
                            <li>
                                <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-primary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-primary hover:before:w-full" :class="{'before:w-full text-primary' : tab === 'profile'}" @click="tab='profile'">
                                    المتطوعين</a>
                            </li>
                       
                        </ul>
                    </div>
                <div x-show="tab === 'home'">
                    <div class="my-6 grid grid-cols-1 gap-6 dark:text-white-light sm:grid-cols-2 xl:grid-cols-2">
                        <!-- RadialBar Chart -->
                        <div class="mb-5">
                            <label for="chart">المطابقة</label>
                            <div x-data="radialBarChart" x-ref="radialBarChart" class="bg-white dark:bg-black rounded-lg"></div>
                            <div class="w-full h-5 bg-[#888ea8] dark:bg-dark/40 rounded-full ">
                                <div class="bg-gradient-to-r from-[#3cba92] to-[#0ba360] h-5 rounded-full text-center text-white flex justify-between items-center px-2 text-xs" style="width: {{ $percentage }}%;">
                                    <span>{{ round($percentage, 2) }}%</span>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Donut Chart -->
                        <div class="mb-5">
                            <label for="chart">الاحداث</label>
                            <div x-data="donutChart" x-ref="donutChart" class="bg-white dark:bg-black rounded-lg"></div>
                        </div>
                    </div>

                    
                </div>
                <div x-show="tab === 'profile'">
                    
                <div class="mx-auto mb-5 grid max-w-[900px] grid-cols-3 justify-items-center gap-3">
                    <div>
                        <div class="w-[70px] h-[70px] sm:w-[100px] sm:h-[100px] shadow-[1px_2px_12px_0_rgba(31,45,61,0.10)] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] flex justify-center flex-col">
                            <h1 class="text-primary text-xl sm:text-3xl text-center" id="counter1"></h1>
                        </div>
                        <h4 class="text-[#3b3f5c] text-xs sm:text-[15px] mt-4 text-center dark:text-white-dark font-semibold"> بالتكرار</h4>
                    </div>
                
                    <!-- customers -->
                    <div>
                        <div class="w-[70px] h-[70px] sm:w-[100px] sm:h-[100px] shadow-[1px_2px_12px_0_rgba(31,45,61,0.10)] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] flex justify-center flex-col">
                            <h1 class="text-primary text-xl sm:text-3xl text-center" id="counter3"></h1>
                        </div>
                        <h4 class="text-[#3b3f5c] text-xs sm:text-[15px] mt-4 text-center dark:text-white-dark font-semibold"> بدون تكرار</h4>
                    </div>
                    <!-- customers -->
                    <div>
                        <div class="w-[70px] h-[70px] sm:w-[100px] sm:h-[100px] shadow-[1px_2px_12px_0_rgba(31,45,61,0.10)] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] flex justify-center flex-col">
                            <h1 class="text-primary text-xl sm:text-3xl text-center" id="counter4"></h1>
                        </div>
                        <h4 class="text-[#3b3f5c] text-xs sm:text-[15px] mt-4 text-center dark:text-white-dark font-semibold">الجدد</h4>
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