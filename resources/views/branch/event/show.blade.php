<div class="fixed inset-0 bg-[black]/60 dark:text-white-light z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4">
        <div x-data="eventModal()" x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden  w-full max-w-5xl my-8">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg">عرض حدث - {{ $event->contribution->name }}</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle()">x</button>
            </div>

            @php
            $totalVolunteers = $event->volunteers->count();
            $tshirtCount = $event->volunteers->where('pivot.tshirt', 1)->count();
            $percentage = $totalVolunteers > 0 ? ($tshirtCount / $totalVolunteers) * 100 : 0;

            // تمرير روابط الصور للجاڤاسكريبت
            $imageUrls = $event->getMedia('images')->map(fn($media) => $media->getUrl());
            @endphp

            <script>
                function eventModal() {
                    return {
                        open: true
                        , tab: 'home'
                        , items: @json($imageUrls)
                        , toggle() {
                            this.open = !this.open;
                        }
                    }
                }

            </script>

            <div class="p-5">
                <div class="mb-5 flex justify-between">
                    <span class="badge {{$event->getStatusBadgeClass()}} py-1.5 dark:{{$event->getStatusBadgeClass()}}dark:text-white">{{ $event->getStatusLabel() }}</span>

                </div>

                <div class="mb-5">
                    <ul class="flex flex-wrap mt-3 mb-5 border-b border-white-light dark:border-[#191e3a]">
                        <li>
                            <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center relative hover:text-secondary" :class="{'text-secondary': tab === 'home'}" @click="tab='home'">المتطوعين</a>
                        </li>
                        <li>
                            <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center relative hover:text-secondary" :class="{'text-secondary': tab === 'profile'}" @click="tab='profile'">الوسائط</a>
                        </li>
                        {{-- @if ($event->reason) --}}
                        <li>
                            <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center relative hover:text-secondary" :class="{'text-secondary': tab === 'contact'}" @click="tab='contact'">المطابقة</a>
                        </li>
                        @endif
                    </ul>
                </div>

                <div x-show="tab === 'home'">
                    <div class="w-full h-5 bg-[#ebedf2] dark:bg-dark/40 rounded-full">
                        <div class="bg-gradient-to-r from-[#3cba92] to-[#0ba360] h-5 rounded-full text-center text-white flex justify-between items-center px-2 text-xs" style="width: {{ $percentage }}%;">
                            <span>نسبة التيشرتات</span>
                            <span>{{ round($percentage, 2) }}%</span>
                        </div>
                    </div>

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
                                        <svg width="24" height="24" fill="none" class="h-5 w-5 text-success" xmlns="http://www.w3.org/2000/svg">
                                            <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                            <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
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
                    <div class="swiper max-w-3xl mx-auto mb-5 slider1">
                        <div class="swiper-wrapper">
                            <template x-for="item in items" :key="item">
                                <div class="swiper-slide">
                                    <img :src="item" class="w-full max-h-80 object-cover" alt="event image" />
                                </div>
                            </template>
                        </div>
                        <!-- Navigation buttons and pagination would go here if needed -->
                    </div>
                </div>

                @if ($event->reason)
                <div x-show="tab === 'contact'">
                    @livewire('index-events', ['event' => $event])
                </div>
                @endif

                <div class="flex justify-end items-center mt-8">
                    <button type="button" class="btn btn-outline-danger" @click="open = false">غلق</button>
                </div>
            </div>
        </div>
    </div>
</div>
