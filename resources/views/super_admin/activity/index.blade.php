@extends('super_admin.layout.master')
@section('title', 'الإدارة المركزية')

@section('style')
<link rel="stylesheet" href="{{ asset('assets') }}/css/highlight.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/css/swiper-bundle.min.css" />
@endsection

@section('content')

    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">الانشطة </a>
        </li>
        <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
            <span>الكل</span>
        </li>
    </ul>
 <div class="flex flex-wrap mt-3 mb-5 ">
     <button href="#" class="btn btn-outline-secondary">إضافة</button >
    
 </div>
    <div class="panel mt-5 dark:text-white-light">

    <table id="myTable" class="table-responsive myTable dark:text-white-light">
        <thead>
            <tr class="text-center">
                <th class="wd-10p border-bottom-0">#</th>
                <th class="wd-25p border-bottom-0">الاسم</th>
                <th class="wd-25p border-bottom-0">فريق العمل</th>
                <th class="wd-25p border-bottom-0">عدد مسئول</th>
                <th class="wd-25p border-bottom-0">م.م مسئول</th>
                <th class="wd-25p border-bottom-0">عدد مشروع</th>
                <th class="wd-25p border-bottom-0">م.م مشروع</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center hover:!text-primary " x-data="modal"><a href="javascript:;" @click="toggle" x-tooltip="عرض">{{ $activity->name }}</a></td>
                    <td class="text-center">
                        <div class="w-full h-4 bg-[#ebedf2] dark:bg-dark/40 rounded-full">
                            <div class="bg-gradient-to-r from-[#3cba92] to-[#0ba360] h-4 rounded-full w-8/12 text-center text-white flex justify-between items-center px-2 text-xs"><span>{{ ($activity->getMasaolCount() + $activity->getMashroaaMasaolCount()) ?? 0 }}</span><span>90%</span></div>
                        </div>
                        
                    </td>
                    <td class="text-center">{{ $activity->getMasaolCount() ?? 0 }}</td>
                    <td class="text-center">{{ $activity->getMasaolCountAttribute() ?? 0 }}</td>
                    <td class="text-center">{{ $activity->getMashroaaMasaolCount() ?? 0 }}</td>
                    <td class="text-center">{{ $activity->getMashroaaMasaolCountAttribute() ?? 0 }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    @if(session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'bottom-start',
                icon: 'success',
                title: '{{ session("success") }}', // رسالة النجاح من الجلسة
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
@endsection
@section('script')
<script src="{{ asset('assets') }}/js/swiper-bundle.min.js"></script>

    <script>
        const swiper1 = new Swiper(".slider1", {
            navigation: {
                nextEl: '.swiper-button-next-ex1',
                prevEl: '.swiper-button-prev-ex1',
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
        </script>

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
