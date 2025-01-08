@extends('volunteer.layout.master')
@section('title','إدارة المتطوعين')


@section('content')
<div x-data="finance">
<ul class="flex space-x-2 rtl:space-x-reverse">
    <li>
        <a href="javascript:;" class="text-primary hover:underline">لوحة التحكم</a>
    </li>
    <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
        <span>الرئيسية</span>
    </li>
</ul>

<div class="my-6 grid grid-cols-1 gap-6  sm:grid-cols-2 xl:grid-cols-3">
    <div class="panel h-full">
        <div class="mb-5 flex items-center justify-between ">
            <h5 class="text-lg font-semibold  ">م. مشاركات مسئول</h5>
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
        <div class="my-8 text-3xl font-bold text-[#e95f2b]">
            <span>{{ $statistics['averagemasaolContribution'] }}</span>
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> مشاركة</span>
        </div>
        <div class="my-2 ">
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> شارك {{ $statistics['volunteersMasaolContribution_count'] }} من اصل {{ $statistics['volunteersMasaol_count'] }}</span>
        </div>

        <div class="flex items-center justify-between">
            
            <div class="h-5 w-full overflow-hidden rounded-full bg-dark-light p-1 shadow-3xl dark:bg-dark-light/10 dark:shadow-none">
                <div class="relative h-full w-full rounded-full bg-gradient-to-r {{$statistics['masaolContributionPercentage'] == 100 ? 'from-[#3cba92] to-[#0ba360]' : 'from-[#4361ee] to-[#805dca] ' }}  before:absolute before:inset-y-0 before:m-auto before:h-2 before:w-2 before:rounded-full before:bg-white ltr:before:right-0.5 rtl:before:left-0.5" style="width: {{ $statistics['masaolContributionPercentage'] }}%"></div>
            </div>
            <span class="ltr:ml-5 rtl:mr-5 dark:text-white-light">{{ $statistics['masaolContributionPercentage'] }}%</span>
        </div>
    </div>
    <div class="panel h-full">
        <div class="mb-5 flex items-center justify-between ">
            <h5 class="text-lg font-semibold  ">م. مشاركات مشروع مسئول</h5>
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
        <div class="my-8 text-3xl font-bold text-[#e95f2b]">
            <span>{{ $statistics['averagemashroaaMasaolContribution'] }}</span>
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> مشاركة</span>
        </div>
        <div class="my-2 ">
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> شارك {{ $statistics['volunteersMashroaaMasaolContribution_count'] }} من اصل {{ $statistics['volunteersMashroaaMasaol_count'] }}</span>
        </div>

        <div class="flex items-center justify-between">
            
            <div class="h-5 w-full overflow-hidden rounded-full bg-dark-light p-1 shadow-3xl dark:bg-dark-light/10 dark:shadow-none">
                <div class="relative h-full w-full rounded-full bg-gradient-to-r  {{$statistics['mashroaaMasaolContributionPercentage'] == 100 ? 'from-[#3cba92] to-[#0ba360]' : 'from-[#4361ee] to-[#805dca] ' }} before:absolute before:inset-y-0 before:m-auto before:h-2 before:w-2 before:rounded-full before:bg-white ltr:before:right-0.5 rtl:before:left-0.5" style="width: {{ $statistics['mashroaaMasaolContributionPercentage'] }}%"></div>
            </div>
            <span class="ltr:ml-5 rtl:mr-5 dark:text-white-light">{{ $statistics['mashroaaMasaolContributionPercentage'] }}%</span>
        </div>
    </div>
    <div class="panel h-full">
        <div class="mb-5 flex items-center justify-between ">
            <h5 class="text-lg font-bold">م. مشاركات داخل المتابعة</h5>
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
        <div class="my-8 text-3xl font-bold text-[#e95f2b]">
            <span>{{ $statistics['averagemashroaaMasaolContribution'] }}</span>
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> مشاركة</span>
        </div>
        <div class="my-2 ">
            <span class="text-sm text-black ltr:mr-1 rtl:ml-1 dark:text-white-light"> شارك {{ $statistics['volunteersMashroaaMasaolContribution_count'] }} من اصل {{ $statistics['volunteersMashroaaMasaol_count'] }}</span>
        </div>

        <div class="flex items-center justify-between">
            
            <div class="h-5 w-full overflow-hidden rounded-full bg-dark-light p-1 shadow-3xl dark:bg-dark-light/10 dark:shadow-none">
                <div class="relative h-full w-full rounded-full bg-gradient-to-r  {{$statistics['mashroaaMasaolContributionPercentage'] == 100 ? 'from-[#3cba92] to-[#0ba360]' : 'from-[#4361ee] to-[#805dca] ' }} before:absolute before:inset-y-0 before:m-auto before:h-2 before:w-2 before:rounded-full before:bg-white ltr:before:right-0.5 rtl:before:left-0.5" style="width: {{ $statistics['mashroaaMasaolContributionPercentage'] }}%"></div>
            </div>
            <span class="ltr:ml-5 rtl:mr-5 dark:text-white-light">{{ $statistics['mashroaaMasaolContributionPercentage'] }}%</span>
        </div>
    </div>
</div>


<div class="panel h-full p-0 "  x-data="analytics"> 
    <div
        class="mb-5 flex items-start justify-between border-b border-[#e0e6ed] p-5 dark:border-[#1b2e4b] "
    >
        <h5 class="text-lg font-semibold">المشاركات الاسبوعية
            <span class="block text-sm font-normal text-white-dark">(بالتكرار)</span>
        </h5>

    </div>

    <div x-ref="uniqueVisitorSeries" class="overflow-hidden">
        <!-- loader -->
        <div
            class="grid min-h-[360px] place-content-center bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08]">
            <span
                class="inline-flex h-5 w-5 animate-spin rounded-full border-2 border-black !border-l-transparent dark:border-white"></span>
        </div>
    </div>
</div>
<div class="my-6 grid grid-cols-1 gap-6  sm:grid-cols-2 xl:grid-cols-2">
    <!-- RadialBar Chart -->
    <div class="mb-5 panel">
        
        <h5 class="text-lg font-semibold"> المطابقة
            <span class="block text-sm font-normal text-white-dark">(الاحداث الشهرية)</span>

        </h5>
        <div x-data="radialBarChart" x-ref="radialBarChart" class="bg-white dark:bg-black rounded-lg  p-3">

        </div>
        
    </div>

    <!-- Donut Chart -->
    <div class="mb-5 panel">
        <h5 class="text-lg font-semibold">الاحداث
            <span class="block text-sm font-normal text-white-dark">(الاحداث الشهرية)</span>
        </h5>
        <div x-data="donutChart" x-ref="donutChart" class="bg-white dark:bg-black rounded-lg  p-3">

        </div>
    </div>
</div>

 

</div>


@endsection
@section('script')
<script defer src="{{ asset('assets') }}/js/apexcharts.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('analytics', () => ({
            init() {
                isDark = this.$store.app.theme === 'dark' || this.$store.app.isDarkMode ? true : false;
                isRtl = this.$store.app.rtlClass === 'rtl' ? true : false;

                // Fetch the volunteer statistics
                this.fetchVolunteerStatistics();

                this.$watch('$store.app.theme', () => {
                    isDark = this.$store.app.theme === 'dark' || this.$store.app.isDarkMode ? true : false;
                    this.updateChart();
                });

                this.$watch('$store.app.rtlClass', () => {
                    isRtl = this.$store.app.rtlClass === 'rtl' ? true : false;
                    this.updateChart();
                });
            },
            fetchVolunteerStatistics() {
                // Make an AJAX request to fetch the data
                fetch('{{ route("volunteer.weekly.statistics") }}')
                    .then(response => response.json())
                    .then(data => {
                        this.days = data.days;
                        this.offlineVolunteers = data.offline;
                        this.onlineVolunteers = data.online;
                        this.renderChart();
                    })
                    .catch(error => {
                        console.error('Error fetching statistics:', error);
                    });
            },
            renderChart() {
                const uniqueVisitorSeriesOptions = {
                    series: [
                        {
                            name: 'مشاركات ميدانية',
                            data: this.offlineVolunteers,
                        },
                        {
                            name: 'مشلركات من المنزل',
                            data: this.onlineVolunteers,
                        },
                    ],
                    chart: {
                        height: 360,
                        type: 'bar',
                        fontFamily: 'Nunito, sans-serif',
                        toolbar: { show: false },
                    },
                    dataLabels: { enabled: false },
                    stroke: { width: 2, colors: ['transparent'] },
                    colors: ['#5c1ac3', '#ffbb44'],
                    dropShadow: {
                        enabled: true,
                        blur: 3,
                        color: '#515365',
                        opacity: 0.4,
                    },
                    plotOptions: {
                        bar: { horizontal: false, columnWidth: '55%', borderRadius: 10 },
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '14px',
                        itemMargin: { horizontal: 8, vertical: 8 },
                    },
                    grid: {
                        borderColor: isDark ? '#191e3a' : '#e0e6ed',
                        padding: { left: 20, right: 20 },
                    },
                    xaxis: {
                        categories: this.days,
                        axisBorder: {
                            show: true,
                            color: isDark ? '#3b3f5c' : '#e0e6ed',
                        },
                    },
                    yaxis: {
                        tickAmount: 6,
                        opposite: isRtl ? true : false,
                        labels: { offsetX: isRtl ? -10 : 0 },
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: isDark ? 'dark' : 'light',
                            type: 'vertical',
                            shadeIntensity: 0.3,
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 0.8,
                            stops: [0, 100],
                        },
                    },
                    tooltip: {
                        marker: { show: true },
                        y: { formatter: val => val },
                    },
                };

                // Initialize the chart
                this.uniqueVisitorSeries = new ApexCharts(this.$refs.uniqueVisitorSeries, uniqueVisitorSeriesOptions);
                this.$refs.uniqueVisitorSeries.innerHTML = '';
                this.uniqueVisitorSeries.render();
            },
            updateChart() {
                // Update chart options based on theme or language changes
                if (this.uniqueVisitorSeries) {
                    this.uniqueVisitorSeries.updateOptions({
                        grid: {
                            borderColor: isDark ? '#191e3a' : '#e0e6ed',
                        },
                        yaxis: {
                            opposite: isRtl ? true : false,
                            labels: { offsetX: isRtl ? -10 : 0 },
                        },
                    });
                }
            },
        }));
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
</script>




@endsection