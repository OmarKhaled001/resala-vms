@extends('volunteer.layout.master')
@section('title', 'المتطوعين')

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
            <a href="javascript:;" class="text-primary hover:underline">المتطوعين </a>
        </li>
        <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
            <span>الكل</span>
        </li>
    </ul>
    <div class="flex flex-wrap mt-3 mb-5 ">
        <a href="{{ route('volunteer.event.create') }}" class="btn btn-outline-primary ml-3">إضافة متطوع</a>
        <!-- button -->
        <div x-data="modal">
            <div class="flex items-center justify-center  ml-3">
                <button type="button" class="btn btn-outline-primary" @click="toggle">فلتر</button>
                @include('volunteer.vol.filter')

            </div>
        </div>
        {{-- <div x-data="modal">
            <div class="flex items-center justify-center  ml-3">
                <button type="button" class="btn btn-outline-success" @click="toggle"><svg
                        class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.5"
                            d="M6.22209 4.60105C6.66665 4.304 7.13344 4.04636 7.6171 3.82976C8.98898 3.21539 9.67491 2.9082 10.5875 3.4994C11.5 4.09061 11.5 5.06041 11.5 7.00001V8.50001C11.5 10.3856 11.5 11.3284 12.0858 11.9142C12.6716 12.5 13.6144 12.5 15.5 12.5H17C18.9396 12.5 19.9094 12.5 20.5006 13.4125C21.0918 14.3251 20.7846 15.011 20.1702 16.3829C19.9536 16.8666 19.696 17.3334 19.399 17.7779C18.3551 19.3402 16.8714 20.5578 15.1355 21.2769C13.3996 21.9959 11.4895 22.184 9.64665 21.8175C7.80383 21.4509 6.11109 20.5461 4.78249 19.2175C3.45389 17.8889 2.5491 16.1962 2.18254 14.3534C1.81598 12.5105 2.00412 10.6004 2.72315 8.86451C3.44218 7.12861 4.65982 5.64492 6.22209 4.60105Z"
                            fill="currentColor"></path>
                        <path
                            d="M21.446 7.06901C20.6342 5.00831 18.9917 3.36579 16.931 2.55398C15.3895 1.94669 14 3.34316 14 5.00002V9.00002C14 9.5523 14.4477 10 15 10H19C20.6569 10 22.0533 8.61055 21.446 7.06901Z"
                            fill="currentColor"></path>
                    </svg>
                </button>
            </div>
            @include('volunteer.event.charts')
        </div> --}}
        <a href="{{ route('volunteer.vol.index') }}" class="btn btn-primary ml-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5">
                <path
                    d="M12.0789 3V2.25V3ZM3.67981 11.3333H2.92981H3.67981ZM3.67981 13L3.15157 13.5324C3.44398 13.8225 3.91565 13.8225 4.20805 13.5324L3.67981 13ZM5.88787 11.8657C6.18191 11.574 6.18377 11.0991 5.89203 10.8051C5.60029 10.511 5.12542 10.5092 4.83138 10.8009L5.88787 11.8657ZM2.52824 10.8009C2.2342 10.5092 1.75933 10.511 1.46759 10.8051C1.17585 11.0991 1.17772 11.574 1.47176 11.8657L2.52824 10.8009ZM18.6156 7.39279C18.8325 7.74565 19.2944 7.85585 19.6473 7.63892C20.0001 7.42199 20.1103 6.96007 19.8934 6.60721L18.6156 7.39279ZM12.0789 2.25C7.03155 2.25 2.92981 6.3112 2.92981 11.3333H4.42981C4.42981 7.15072 7.84884 3.75 12.0789 3.75V2.25ZM2.92981 11.3333L2.92981 13H4.42981L4.42981 11.3333H2.92981ZM4.20805 13.5324L5.88787 11.8657L4.83138 10.8009L3.15157 12.4676L4.20805 13.5324ZM4.20805 12.4676L2.52824 10.8009L1.47176 11.8657L3.15157 13.5324L4.20805 12.4676ZM19.8934 6.60721C18.287 3.99427 15.3873 2.25 12.0789 2.25V3.75C14.8484 3.75 17.2727 5.20845 18.6156 7.39279L19.8934 6.60721Z"
                    fill="currentColor"></path>
                <path opacity="0.5"
                    d="M11.8825 21V21.75V21ZM20.3137 12.6667H21.0637H20.3137ZM20.3137 11L20.8409 10.4666C20.5487 10.1778 20.0786 10.1778 19.7864 10.4666L20.3137 11ZM18.1002 12.1333C17.8056 12.4244 17.8028 12.8993 18.094 13.1939C18.3852 13.4885 18.86 13.4913 19.1546 13.2001L18.1002 12.1333ZM21.4727 13.2001C21.7673 13.4913 22.2421 13.4885 22.5333 13.1939C22.8245 12.8993 22.8217 12.4244 22.5271 12.1332L21.4727 13.2001ZM5.31769 16.6061C5.10016 16.2536 4.63806 16.1442 4.28557 16.3618C3.93307 16.5793 3.82366 17.0414 4.0412 17.3939L5.31769 16.6061ZM11.8825 21.75C16.9448 21.75 21.0637 17.6915 21.0637 12.6667H19.5637C19.5637 16.8466 16.133 20.25 11.8825 20.25V21.75ZM21.0637 12.6667V11H19.5637V12.6667H21.0637ZM19.7864 10.4666L18.1002 12.1333L19.1546 13.2001L20.8409 11.5334L19.7864 10.4666ZM19.7864 11.5334L21.4727 13.2001L22.5271 12.1332L20.8409 10.4666L19.7864 11.5334ZM4.0412 17.3939C5.65381 20.007 8.56379 21.75 11.8825 21.75V20.25C9.09999 20.25 6.6656 18.7903 5.31769 16.6061L4.0412 17.3939Z"
                    fill="currentColor"></path>
            </svg>
        </a>

    </div>





    <div class="panel mt-5 dark:text-white-light">

        <table id="myTable" class="table-responsive myTable dark:text-white-light">
            <thead>
                <tr class="text-center">
                    <th class="wd-10p border-bottom-0">#</th>
                    <th class="wd-25p border-bottom-0">الاسم</th>
                    <th class="wd-25p border-bottom-0">الرقم</th>
                    <th class="wd-25p border-bottom-0">التصنيف</th>
                    <th class="wd-25p border-bottom-0">المشاركات</th>
                    <th class="wd-25p border-bottom-0">الاجرائات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($volunteers as $volunteer)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $volunteer->name }}</td>
                        <td class="text-center">{{ $volunteer->phone }}</td>
                        <td class="text-center">
                            <span class="badge {{ $volunteer->getTypeBadgeClass() }}">
                                {{ $volunteer->type  ?? 'داخل المتابعة'}}
                            </span>
                        </td>
                        <td class="text-center">{{ $volunteer->getMonthlyCountAttribute() ?? 0 }}</td>

                        <td class="text-center">
                            <ul class="flex items-center justify-center gap-2">
                                {{-- <li x-data="modal">
                                    <a href="{{ route('volunteer.event.edit',$event->id) }}" x-tooltip="تعديل" class="hover:text-info">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
                                            <path opacity="0.5" d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z" stroke="currentColor" stroke-width="1.5"></path>
                                            <path opacity="0.5" d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9" stroke="currentColor" stroke-width="1.5"></path>
                                        </svg>
                                    </a>
                                    @include('branch.event.change-status')

                                </li> --}}
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
                                </li>

                                <li>
                                    <a href="javascript:;" x-tooltip="حذف" @click="showDeleteAlert({{ $volunteer->id }})">
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('assets') }}/js/simple-datatables.js"></script>
    <script defer src="{{ asset('assets') }}/js/apexcharts.js"></script>
    <script src="{{ asset('assets') }}/js/countUp.min.js"></script>
    <script src="{{ asset('assets') }}/js/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets') }}/js/highlight.min.js"></script>
    <script src="{{ asset('assets') }}/js/flatpickr.js"></script>
    <script src="{{ asset('assets') }}/js/nice-select2.js"></script>
    <script src="{{ asset('assets') }}/js/nouislider.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr(".form-input", {
                dateFormat: "Y-m-d",
                enableTime: false,
                locale: "ar",
                maxDate: "today",
            });
            flatpickr("#commentInput", {
                allowInput: true // يسمح للمستخدم بإدخال القيم يدويًا
            });
        });
    </script>
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
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // الحصول على الإحصائيات من Laravel عبر الـ Blade
            const statistics = @json($statistics);

            // hours (إجمالي عدد الساعات أو أي إحصائية أخرى ترغب في عرضها)
            const counter1 = new countUp.CountUp("counter1", statistics.total_volunteers_count, {
                startVal: 0,
                duration: 10,
            });
            counter1.start();


            // customers (إجمالي عدد المتطوعين الفريدين)
            const counter3 = new countUp.CountUp("counter3", statistics.unique_volunteers_count, {
                startVal: 0,
                duration: 10,
            });
            counter3.start();

            // customers (إجمالي عدد المتطوعين الجدد)
            const counter4 = new countUp.CountUp("counter4", statistics.new_volunteers_count, {
                startVal: 0,
                duration: 10,
            });
            counter4.start();
        });
    </script>
    <script>
        document.addEventListener("alpine:init", () => {
            // مخطط الـ RadialBar
            Alpine.data("radialBarChart", () => ({
                init() {
                    const statistics = @json($statistics);

                    const series = [
                        statistics.pending_count,
                        statistics.conforming_count,
                        statistics.non_conforming_count,
                        statistics.rejected_count
                    ];

                    const labels = ['معلق', 'مطابق', 'غير مطابق', 'مرفوض'];

                    let isDark = this.$store.app.theme === "dark";

                    let radialBarChart = new ApexCharts(this.$refs.radialBarChart, {
                        series: series,
                        chart: {
                            height: 300,
                            type: 'radialBar',
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#4361ee', '#00ab55', '#e2a03f', '#ff4d4f'],
                        grid: {
                            borderColor: isDark ? '#191e3a' : '#e0e6ed',
                        },
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '22px',
                                    },
                                    value: {
                                        fontSize: '18px',
                                    },
                                    total: {
                                        show: true,
                                        label: 'الاجمالي',
                                        formatter: function() {
                                            return series.reduce((a, b) => a + b,
                                                0); // إجمالي الإحصائيات
                                        }
                                    }
                                }
                            }
                        },
                        labels: labels,
                        fill: {
                            opacity: 0.9
                        }
                    });

                    radialBarChart.render();

                    this.$watch('$store.app.theme', () => {
                        isDark = this.$store.app.theme === "dark";
                        radialBarChart.updateOptions({
                            grid: {
                                borderColor: isDark ? '#191e3a' : '#e0e6ed',
                            }
                        });
                    });
                }
            }));

            // مخطط الـ Donut
            Alpine.data("donutChart", () => ({
                init() {
                    const statistics = @json($statistics);

                    const series = [
                        statistics.offline_count,
                        statistics.online_count
                    ];

                    const labels = ['ميدانية', 'من المنزل'];

                    let isDark = this.$store.app.theme === "dark";

                    let donutChart = new ApexCharts(this.$refs.donutChart, {
                        series: series,
                        chart: {
                            height: 300,
                            type: 'donut',
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false
                            }
                        },
                        stroke: {
                            show: false,
                        },
                        labels: labels,
                        colors: ['#00ab55', '#2196f3'],
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                }
                            }
                        }],
                        legend: {
                            position: 'bottom',
                        },
                    });

                    donutChart.render();

                    this.$watch('$store.app.theme', () => {
                        isDark = this.$store.app.theme === "dark";
                        donutChart.updateOptions({
                            grid: {
                                borderColor: isDark ? '#191e3a' : '#e0e6ed',
                            }
                        });
                    });
                }
            }));
        });
    </script> --}}
    



@endsection
