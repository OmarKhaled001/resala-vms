@extends('super_admin.layout.master')
@section('title', 'الإدارة المركزية')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/highlight.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/swiper-bundle.min.css" />
@endsection

@section('content')

    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">الفرق </a>
        </li>
        <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
            <span>الكل</span>
        </li>
    </ul>

    <div class="flex flex-wrap items-center justify-start gap-2 mt-3 mb-5">
        <div x-data="dropdown" @click.outside="open = false" class="dropdown" style="z-index:50;" id="action-button">
            <button class="btn btn-primary dropdown-toggle" @click="toggle">إجراءات
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="inline-block h-4 w-4 ltr:ml-1 rtl:mr-1">
                    <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </svg>
            </button>
            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                class="ltr:right-0 rtl:left-0 whitespace-nowrap">
                <li x-data="modal"><a href="javascript:;" @click="toggle">استخراج </a>
                    @include('super_admin.group.export')</li>
            </ul>
        </div>
    </div>



    <div class="panel mt-5 dark:text-white-light">

        <table id="myTable" class="table-responsive myTable dark:text-white-light">
            <thead>
                <tr class="text-center">
                    <th><input type="checkbox" class="form-checkbox" id="all" /></th>
                    <th class="wd-10p text-center border-bottom-0">#</th>
                    <th class="wd-25p text-center border-bottom-0">الاسم</th>
                    <th class="wd-25p text-center border-bottom-0">الصف</th>
                    <th class="wd-25p text-center border-bottom-0"> مسئول</th>
                    <th class="wd-25p text-center border-bottom-0">مسئول مشروع</th>
                    <th class="wd-25p text-center border-bottom-0">فريق العمل</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                    @php
                        $teemCount= $group->getMasaolCount() + $group->getMashroaaMasaolCount() ;
                        $teemCountAttributeCount = $group->getMasaolCountAttributeCount() + $group->getMashroaaMasaolCountAttributeCount();
                        $percentage = ($teemCount == 0) ? 0 : round((($teemCountAttributeCount / $teemCount) * 100),2);
                    @endphp
                    <tr>
                        <td style="text-align: center;"><input value="{{ $group->id }}" type="checkbox" class="form-checkbox item" /></td>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td class="text-center hover:!text-primary  " style="text-align: center;" x-data="modal"><a href="javascript:;"
                        @click="toggle" x-tooltip="عرض">{{ $group->name }}</a></td>
                        <td style="text-align: center;">{{ $group->getClass() }}</td>
                        <td style="text-align: center;">{{ $group->getMasaolCount() ?? 0 }}</td>
                        <td style="text-align: center;">{{ $group->getMashroaaMasaolCount() ?? 0 }}</td>
                        <td style="text-align: center;">
                            <div  x-tooltip="{{ $teemCount.' / '.$teemCountAttributeCount  ?? 0 }}" class="w-full h-4 bg-[#ebedf2] dark:bg-dark/40 rounded-full">
                                <div
                                    class="bg-gradient-to-r {{$percentage == 100 ? 'from-[#3cba92] to-[#0ba360]' : 'from-[#4361ee] to-[#805dca] ' }} h-4 rounded-full  text-center text-white flex justify-between items-center px-2 text-xs"  style="width: {{ $percentage }}%">
                                    <span>{{  $percentage }}%</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'bottom-start',
                icon: 'success',
                title: '{{ session('success') }}', // رسالة النجاح من الجلسة
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
@endsection
@section('script')
    <script src="{{ asset('assets') }}/js/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets') }}/js/simple-datatables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('all');
            const itemCheckboxes = document.querySelectorAll('.item');
            const hiddenInputs = document.querySelectorAll('.group-ids');
            const exportButton = document.getElementById('action-button');
            const deleteButton = document.getElementById('delete-button');

            function updateHiddenInputs() {
                const selectedIds = Array.from(itemCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                // تحديث جميع الإدخالات المخفية بالقيم المختارة
                hiddenInputs.forEach(input => {
                    input.value = selectedIds.join(',');
                });

                // إظهار أو إخفاء الأزرار إذا تم اختيار عناصر
                if (selectedIds.length > 0) {
                    exportButton.style.display = 'block';
                    deleteButton.style.display = 'block';
                } else {
                    exportButton.style.display = 'none';
                    deleteButton.style.display = 'none';
                }
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateHiddenInputs();
                });
            }

            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateHiddenInputs);
            });

            updateHiddenInputs();
        });

    </script>

@endsection
