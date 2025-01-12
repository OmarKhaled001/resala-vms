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

    <div class="flex flex-wrap items-center justify-start gap-2 mt-3 mb-5">
        <div x-data="modal">
            <button class="btn btn-outline-primary" @click="toggle">إستيراد</button>
            @include('super_admin.activity.import')
        </div>
        <div x-data="dropdown" @click.outside="open = false" class="dropdown" id="action-button">
            <button class="btn btn-primary dropdown-toggle" @click="toggle">إجراءات
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="inline-block h-4 w-4 ltr:ml-1 rtl:mr-1">
                    <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </svg>
            </button>
            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                class="ltr:right-0 rtl:left-0 whitespace-nowrap">
                <li><a href="javascript:;" id="delete-button" class="text-danger" onclick="confirmDelete()">حذف</a></li>
                <li x-data="modal"><a href="javascript:;" @click="toggle" class="z-50">استخراج تقرير</a>
                    @include('super_admin.activity.export')</li>
            </ul>
        </div>
        <form id="delete-form" action="{{ route('super_admin.activity.bulk.delete') }}" method="post">
            @csrf
            <input type="hidden" name="activity_ids" class="activity-ids" value="" />
        </form>
    </div>



    <div class="panel mt-5 dark:text-white-light">

        <table id="myTable" class="table-responsive myTable dark:text-white-light">
            <thead>
                <tr class="text-center">
                    <th><input type="checkbox" class="form-checkbox" id="all" /></th>
                    <th class="wd-10p border-bottom-0">#</th>
                    <th class="wd-25p border-bottom-0">الاسم</th>
                    <th class="wd-25p border-bottom-0">عدد اللجان</th>
                    <th class="wd-25p border-bottom-0"> مسئول</th>
                    <th class="wd-25p border-bottom-0">مسئول مشروع</th>
                    <th class="wd-25p border-bottom-0">فريق العمل</th>
                    <th class="wd-25p border-bottom-0">إجرائات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                @php
                    $teemCount= $activity->getMasaolCount() + $activity->getMashroaaMasaolCount() ;
                    $teemCountAttributeCount = $activity->getMasaolCountAttributeCount() + $activity->getMashroaaMasaolCountAttributeCount();
                    $percentage = ($teemCount == 0) ? 0 : round((($teemCountAttributeCount / $teemCount) * 100),2);
                    @endphp
                    <tr>
                        <td><input value="{{ $activity->id }}" type="checkbox" class="form-checkbox item" /></td>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center hover:!text-primary  " x-data="modal"><a href="javascript:;"
                        @click="toggle" x-tooltip="عرض">{{ $activity->name }}</a></td>
                        <td class="text-center">{{ $activity->sections->count() ?? 0 }}</td>
                        <td class="text-center">{{ $activity->getMasaolCount() ?? 0 }}</td>
                        <td class="text-center">{{ $activity->getMashroaaMasaolCount() ?? 0 }}</td>
                        <td class="text-center">
                            <div  x-tooltip="{{ $teemCount.' / '.$teemCountAttributeCount  ?? 0 }}" class="w-full h-4 bg-[#ebedf2] dark:bg-dark/40 rounded-full">
                                <div
                                    class="bg-gradient-to-r {{$percentage == 100 ? 'from-[#3cba92] to-[#0ba360]' : 'from-[#4361ee] to-[#805dca] ' }} h-4 rounded-full  text-center text-white flex justify-between items-center px-2 text-xs"  style="width: {{ $percentage }}%">
                                    <span>{{  $percentage }}%</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <ul class="flex items-center justify-center gap-2">
                                <li x-data="modal">
                                    <a href="{{ route('super_admin.activity.edit', $activity->id) }}" x-tooltip="تعديل"
                                        class="hover:text-info">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
                                            <path opacity="0.5"
                                                d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path
                                                d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                                stroke="currentColor" stroke-width="1.5"></path>
                                            <path opacity="0.5"
                                                d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                                stroke="currentColor" stroke-width="1.5"></path>
                                        </svg>
                                    </a>

                                </li>
                                <li>
                                    <a href="javascript:;" x-tooltip="حذف" @click="showDeleteAlert({{ $activity->id }})">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-danger">
                                            <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round"></path>
                                            <path
                                                d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5"
                                                d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                stroke="currentColor" stroke-width="1.5"></path>
                                        </svg>
                                    </a>
                                    <form id="delete-form-{{ $activity->id }}" action="{{ route('super_admin.activity.delete', ['activity' => $activity->id]) }}" method="post" style="display: none;"> @csrf </form>
                                </li>
                            </ul>
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
            const hiddenInputs = document.querySelectorAll('.activity-ids');
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

        function confirmDelete() {
            const selectedIds = document.querySelector('.activity-ids').value;

            if (selectedIds.length > 0) {
                new window.Swal({
                    icon: 'warning',
                    title: 'هل أنت متأكد؟',
                    text: "لن تتمكن من التراجع عن هذا الإجراء!",
                    showCancelButton: true,
                    confirmButtonText: 'نعم، احذف!',
                    cancelButtonText: 'إلغاء',
                    padding: '2em',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // إرسال النموذج
                        document.getElementById('delete-form').submit();
                    }
                });
            } else {
                alert('يرجى اختيار الأنشطة التي تريد حذفها.');
            }
        }
    </script>
    <script>
        async function showDeleteAlert(id) {
            const formId = `delete-form-${id}`;

            new window.Swal({
                icon: 'warning',
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من التراجع عن هذا الإجراء!",
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف!',
                cancelButtonText: 'إلغاء',
                padding: '2em',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

    </script>
@endsection
