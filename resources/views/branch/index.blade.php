@extends('branch.layout.master')
@section('title', 'إحصائيات الأحداث')

@section('style')
<link rel="stylesheet" href="{{ asset('assets') }}/css/highlight.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/css/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/highlight.min.css" />
<script defer src="{{ asset('assets') }}/js/popper.min.js"></script>
<script defer src="{{ asset('assets') }}/js/tippy-bundle.umd.min.js"></script>
<script defer src="{{ asset('assets') }}/js/sweetalert.min.js"></script>
@endsection

@section('content')

<ul class="flex space-x-2 rtl:space-x-reverse">
    <li>
        <a href="javascript:;" class="text-primary hover:underline">لوحة التحكم</a>
    </li>
    <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
        <span>إحصائيات الأحداث</span>
    </li>
</ul>

<div class="my-6 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
    <div class="panel h-full">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold">إجمالي الأحداث الشهرية</h5>
            <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                <a href="javascript:;" @click="toggle">
                    <svg class="h-5 w-5 text-black/70 hover:!text-primary dark:text-white/70" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                        <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                        <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                    </svg>
                </a>
                <ul x-show="open" x-transition="" x-transition.duration.300ms="" class="ltr:right-0 rtl:left-0" style="display: none;">
                    <li><a href="javascript:;" @click="toggle">عرض</a></li>
                </ul>
            </div>
        </div>
        <div class="my-8 text-3xl font-bold text-[#4361ee]"> {{-- Changed color to blue for total --}}
            <span>{{ $statistics['monthlyEvents'] }}</span>
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> حدث</span> {{-- Added "حدث" (event) --}}
        </div>
        <div class="my-2 ">
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> مجموع الأحداث في هذا الشهر</span> {{-- Descriptive text --}}
        </div>

        <div class="flex items-center justify-between">
            <div class="h-5 w-full overflow-hidden rounded-full bg-dark-light p-1 shadow-3xl dark:bg-dark-light/10 dark:shadow-none">
                {{-- Assuming a progress bar for total events would show 100% relative to a monthly goal or simply fill --}}
                <div class="relative h-full w-full rounded-full bg-gradient-to-r from-[#4361ee] to-[#805dca] before:absolute before:inset-y-0 before:m-auto before:h-2 before:w-2 before:rounded-full before:bg-white ltr:before:right-0.5 rtl:before:left-0.5" style="width: 100%;"></div>
            </div>
            <span class="ltr:ml-5 rtl:mr-5 dark:text-white-light">100%</span> {{-- Assuming total events is always 100% of itself --}}
        </div>
    </div>

    <div class="panel h-full">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold">الأحداث المعلقة</h5>
            <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                <a href="javascript:;" @click="toggle">
                    <svg class="h-5 w-5 text-black/70 hover:!text-primary dark:text-white/70" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                        <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                        <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                    </svg>
                </a>
                <ul x-show="open" x-transition="" x-transition.duration.300ms="" class="ltr:right-0 rtl:left-0" style="display: none;">
                    <li><a href="javascript:;" @click="toggle">عرض</a></li>
                </ul>
            </div>
        </div>
        <div class="my-8 text-3xl font-bold text-[#e95f2b]"> {{-- Kept orange for pending --}}
            <span>{{ $statistics['pendingEvents'] }}</span>
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> حدث</span>
        </div>
        <div class="my-2 ">
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> من إجمالي {{ $statistics['monthlyEvents'] }} حدث</span> {{-- Descriptive text --}}
        </div>

        <div class="flex items-center justify-between">
            <div class="h-5 w-full overflow-hidden rounded-full bg-dark-light p-1 shadow-3xl dark:bg-dark-light/10 dark:shadow-none">
                @php
                $pendingPercentage = ($statistics['monthlyEvents'] > 0) ? round(($statistics['pendingEvents'] / $statistics['monthlyEvents']) * 100) : 0;
                @endphp
                <div class="relative h-full w-full rounded-full bg-gradient-to-r from-[#e95f2b] to-[#c2421f] before:absolute before:inset-y-0 before:m-auto before:h-2 before:w-2 before:rounded-full before:bg-white ltr:before:right-0.5 rtl:before:left-0.5" style="width: {{ $pendingPercentage }}%;"></div>
            </div>
            <span class="ltr:ml-5 rtl:mr-5 dark:text-white-light">{{ $pendingPercentage }}%</span>
        </div>
    </div>

    <div class="panel h-full">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold">الأحداث المطابقة</h5>
            <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                <a href="javascript:;" @click="toggle">
                    <svg class="h-5 w-5 text-black/70 hover:!text-primary dark:text-white/70" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                        <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                        <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                    </svg>
                </a>
                <ul x-show="open" x-transition="" x-transition.duration.300ms="" class="ltr:right-0 rtl:left-0" style="display: none;">
                    <li><a href="javascript:;" @click="toggle">عرض</a></li>
                </ul>
            </div>
        </div>
        <div class="my-8 text-3xl font-bold text-[#3cba92]"> {{-- Changed color to green for conforming --}}
            <span>{{ $statistics['conformingEvents'] }}</span>
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> حدث</span>
        </div>
        <div class="my-2 ">
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> من إجمالي {{ $statistics['monthlyEvents'] }} حدث</span>
        </div>

        <div class="flex items-center justify-between">
            <div class="h-5 w-full overflow-hidden rounded-full bg-dark-light p-1 shadow-3xl dark:bg-dark-light/10 dark:shadow-none">
                @php
                $conformingPercentage = ($statistics['monthlyEvents'] > 0) ? round(($statistics['conformingEvents'] / $statistics['monthlyEvents']) * 100) : 0;
                @endphp
                <div class="relative h-full w-full rounded-full bg-gradient-to-r {{ $conformingPercentage == 100 ? 'from-[#3cba92] to-[#0ba360]' : 'from-[#4361ee] to-[#805dca]' }} before:absolute before:inset-y-0 before:m-auto before:h-2 before:w-2 before:rounded-full before:bg-white ltr:before:right-0.5 rtl:before:left-0.5" style="width: {{ $conformingPercentage }}%;"></div>
            </div>
            <span class="ltr:ml-5 rtl:mr-5 dark:text-white-light">{{ $conformingPercentage }}%</span>
        </div>
    </div>
</div>

@endsection
