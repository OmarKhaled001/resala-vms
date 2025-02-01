@extends('branch.layout.master')
@section('title', 'إدارة المتطوعين')

@section('style')
<link rel="stylesheet" href="{{ asset('assets') }}/css/highlight.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/css/swiper-bundle.min.css" />
@endsection

@section('content')

    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">الاحداث </a>
        </li>
        <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
            <span>الكل</span>
        </li>
    </ul>
 {{-- <div class="flex flex-wrap mt-3 mb-5 ">
     <button href="#" class="btn btn-outline-secondary">سجل الفرع</button >
     <button type="button" class="btn btn-success mr-3">
         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
             <path opacity="0.5" d="M3 15C3 17.8284 3 19.2426 3.87868 20.1213C4.75736 21 6.17157 21 9 21H15C17.8284 21 19.2426 21 20.1213 20.1213C21 19.2426 21 17.8284 21 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
             <path d="M12 3V16M12 16L16 11.625M12 16L8 11.625" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
         </svg>
     </button>
 </div> --}}
    <div class="panel mt-5 dark:text-white-light">
        <table id="myTable" class="table-responsive myTable dark:text-white-light">
            <thead>
                <tr class="text-center">
                    <th><input type="checkbox" class="form-checkbox" /></th>
                    <th class="wd-10p border-bottom-0">#</th>
                    <th class="wd-25p border-bottom-0">التاريخ</th>
                    <th class="wd-25p border-bottom-0">اللجنة</th>
                    <th class="wd-25p border-bottom-0">المشاركة</th>
                    <th class="wd-25p border-bottom-0">الحالة</th>
                    <th class="wd-25p border-bottom-0">العدد</th>
                    <th class="wd-25p border-bottom-0">تيشرت</th>
                    <th class="wd-25p border-bottom-0">الاجرائات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td><input type="checkbox" class="form-checkbox" /></td>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $event->event_date }}</td>
                        <td class="text-center">{{ $event->section->name }}</td>
                        <td class="text-center">{{ $event->contribution->name }}</td>
                        <td class="text-center">
                            <span class="badge {{ $event->getStatusBadgeClass() }}">
                                {{ $event->getStatusLabel() }}
                            </span>
                        </td>
                        <td class="text-center">{{ $event->volunteers->count() }}</td>
                        <td class="text-center">{{ $event->tshirt_count }}</td>

                        <td class="text-center">
                            <ul class="flex items-center justify-center gap-2">
                                <li x-data="modal" >
                                    <a @click="toggle" x-tooltip="تغير الحالة">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary">
                                            <circle cx="12" cy="12" r="3" stroke="currentColor"
                                                stroke-width="1.5"></circle>
                                            <path opacity="0.5"
                                                d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z"
                                                stroke="currentColor" stroke-width="1.5"></path>
                                        </svg>
                                    </a>
                                    @include('branch.event.change-status')

                                </li>
                                <li x-data="modal">
                                    <a @click="toggle" x-tooltip="عرض" class="hover:text-info">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                            <path opacity="0.5"
                                                d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                                stroke="currentColor" stroke-width="1.5"></path>
                                            <path
                                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                                stroke="currentColor" stroke-width="1.5"></path>
                                        </svg>
                                    </a>
                                    @include('branch.event.show')
                                </li>

                                <li>
                                    <a href="javascript:;" x-tooltip="حذف">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-danger">
                                            <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round"></path>
                                            <path
                                                d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round"></path>
                                            <path opacity="0.5"
                                                d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                stroke="currentColor" stroke-width="1.5"></path>
                                        </svg>
                                    </a>
                                </li>

                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('script')
<script src="{{ asset('assets') }}/js/swiper-bundle.min.js"></script>



    <script src="{{ asset('assets') }}/js/simple-datatables.js"></script>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("modal", (initialOpenState = false) => ({
                open: initialOpenState,

                toggle() {
                    this.open = !this.open;
                },
            }));

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const myTable = document.querySelector(".myTable");

            new simpleDatatables.DataTable(myTable, {
                searchable: true, // Enable search functionality
                fixedHeight: false, // Add scrollable height
                perPage: 10, // Default rows per page
                perPageSelect: [5, 10, 20, 50], // Dropdown options for rows per page
                labels: {
                    placeholder: "بحث...", // Search input placeholder
                    perPage: "عرض {select}", // Per-page dropdown label
                    noRows: "لا توجد أحداث", // Message when no rows are available
                    info: "عرض {start} إلى {end} من أصل {rows} مدخلات", // Table info message
                },
                sortable: true, // Enable/disable column sorting
                columns: [{
                    select: 0,
                    sortable: false
                }, ],
                layout: {
                    top: "{select}{search}", // Search and per-page selector at the top
                    bottom: "{info}{pager}", // Info and pagination at the bottom
                },

            });


        });
    </script>

@endsection
<style>
    table.table-checkbox thead tr th:first-child {
        width: 1px !important;
    }
</style>
