@extends('super_admin.layout.master')
@section('title','الإدارة المركزية')


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
</div>
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
    <div class="panel h-full p-0">
        <div class="absolute flex w-full items-center justify-between p-5">
            <div class="relative">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-success-light text-success dark:bg-success dark:text-success-light">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                        <circle cx="12" cy="6" r="4" stroke="currentColor" stroke-width="1.5"></circle>
                        <path opacity="0.5" d="M18 9C19.6569 9 21 7.88071 21 6.5C21 5.11929 19.6569 4 18 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                        <path opacity="0.5" d="M6 9C4.34315 9 3 7.88071 3 6.5C3 5.11929 4.34315 4 6 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                        <ellipse cx="12" cy="17" rx="6" ry="4" stroke="currentColor" stroke-width="1.5"></ellipse>
                        <path opacity="0.5" d="M20 19C21.7542 18.6153 23 17.6411 23 16.5C23 15.3589 21.7542 14.3847 20 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                        <path opacity="0.5" d="M4 19C2.24575 18.6153 1 17.6411 1 16.5C1 15.3589 2.24575 14.3847 4 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    </svg>
                </div>
            </div>
            <h5 class="text-2xl font-semibold ltr:text-right rtl:text-left dark:text-white-light">
                {{ $statistics['new_volunteers_count'] }}
                <span class="block text-sm font-normal">عدد الجدد الشهري</span>
            </h5>
        </div>
        <div x-ref="totalOrders" class="overflow-hidden rounded-lg bg-transparent" style="min-height: 150px;"><div id="apexcharts3ftvnujm" class="apexcharts-canvas apexcharts3ftvnujm apexcharts-theme-light" style="width: 331px; height: 210px;"><svg id="SvgjsSvg1265" width="331" height="290" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1267" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 125)"><defs id="SvgjsDefs1266"><clipPath id="gridRectMask3ftvnujm"><rect id="SvgjsRect1272" width="337" height="167" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask3ftvnujm"></clipPath><clipPath id="nonForecastMask3ftvnujm"></clipPath><clipPath id="gridRectMarkerMask3ftvnujm"><rect id="SvgjsRect1273" width="335" height="169" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient1278" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1279" stop-opacity="0.3" stop-color="rgba(0,171,85,0.3)" offset="1"></stop><stop id="SvgjsStop1280" stop-opacity="0.05" stop-color="rgba(255,255,255,0.05)" offset="1"></stop><stop id="SvgjsStop1281" stop-opacity="0.05" stop-color="rgba(255,255,255,0.05)" offset="1"></stop></linearGradient></defs><line id="SvgjsLine1271" x1="293.72222222222223" y1="0" x2="293.72222222222223" y2="165" stroke="#b6b6b6" stroke-dasharray="3" stroke-linecap="butt" class="apexcharts-xcrosshairs" x="293.72222222222223" y="0" width="1" height="165" fill="#b1b9c4" filter="none" fill-opacity="0.9" stroke-width="1"></line><g id="SvgjsG1284" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1285" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1297" class="apexcharts-grid"><g id="SvgjsG1298" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1300" x1="0" y1="0" x2="331" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1301" x1="0" y1="16.5" x2="331" y2="16.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1302" x1="0" y1="33" x2="331" y2="33" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1303" x1="0" y1="49.5" x2="331" y2="49.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1304" x1="0" y1="66" x2="331" y2="66" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1305" x1="0" y1="82.5" x2="331" y2="82.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1306" x1="0" y1="99" x2="331" y2="99" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1307" x1="0" y1="115.5" x2="331" y2="115.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1308" x1="0" y1="132" x2="331" y2="132" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1309" x1="0" y1="148.5" x2="331" y2="148.5" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine1310" x1="0" y1="165" x2="331" y2="165" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG1299" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1312" x1="0" y1="165" x2="331" y2="165" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine1311" x1="0" y1="1" x2="0" y2="165" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG1274" class="apexcharts-area-series apexcharts-plot-series"><g id="SvgjsG1275" class="apexcharts-series" seriesName="Sales" data:longestSeries="true" rel="1" data:realIndex="0"><path id="SvgjsPath1282" d="M0 165L0 88C12.872222222222222 88 23.90555555555556 55 36.77777777777778 55C49.65 55 60.68333333333334 66 73.55555555555556 66C86.42777777777778 66 97.46111111111112 22 110.33333333333334 22C123.20555555555556 22 134.23888888888888 60.5 147.11111111111111 60.5C159.98333333333335 60.5 171.01666666666665 0 183.88888888888889 0C196.76111111111112 0 207.79444444444445 60.5 220.66666666666669 60.5C233.5388888888889 60.5 244.57222222222225 22 257.44444444444446 22C270.31666666666666 22 281.35 66 294.22222222222223 66C307.09444444444443 66 318.1277777777778 55 331 55C331 55 331 55 331 165M331 55C331 55 331 55 331 55 " fill="url(#SvgjsLinearGradient1278)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask3ftvnujm)" pathTo="M 0 165L 0 88C 12.872222222222222 88 23.90555555555556 55 36.77777777777778 55C 49.65 55 60.68333333333334 66 73.55555555555556 66C 86.42777777777778 66 97.46111111111112 22 110.33333333333334 22C 123.20555555555556 22 134.23888888888888 60.5 147.11111111111111 60.5C 159.98333333333335 60.5 171.01666666666665 0 183.88888888888889 0C 196.76111111111112 0 207.79444444444445 60.5 220.66666666666669 60.5C 233.5388888888889 60.5 244.57222222222225 22 257.44444444444446 22C 270.31666666666666 22 281.35 66 294.22222222222223 66C 307.09444444444443 66 318.1277777777778 55 331 55C 331 55 331 55 331 165M 331 55z" pathFrom="M -1 165L -1 165L 36.77777777777778 165L 73.55555555555556 165L 110.33333333333334 165L 147.11111111111111 165L 183.88888888888889 165L 220.66666666666669 165L 257.44444444444446 165L 294.22222222222223 165L 331 165"></path><path id="SvgjsPath1283" d="M0 88C12.872222222222222 88 23.90555555555556 55 36.77777777777778 55C49.65 55 60.68333333333334 66 73.55555555555556 66C86.42777777777778 66 97.46111111111112 22 110.33333333333334 22C123.20555555555556 22 134.23888888888888 60.5 147.11111111111111 60.5C159.98333333333335 60.5 171.01666666666665 0 183.88888888888889 0C196.76111111111112 0 207.79444444444445 60.5 220.66666666666669 60.5C233.5388888888889 60.5 244.57222222222225 22 257.44444444444446 22C270.31666666666666 22 281.35 66 294.22222222222223 66C307.09444444444443 66 318.1277777777778 55 331 55C331 55 331 55 331 55 " fill="none" fill-opacity="1" stroke="#00ab55" stroke-opacity="1" stroke-linecap="butt" stroke-width="2" stroke-dasharray="0" class="apexcharts-area" index="0" clip-path="url(#gridRectMask3ftvnujm)" pathTo="M 0 88C 12.872222222222222 88 23.90555555555556 55 36.77777777777778 55C 49.65 55 60.68333333333334 66 73.55555555555556 66C 86.42777777777778 66 97.46111111111112 22 110.33333333333334 22C 123.20555555555556 22 134.23888888888888 60.5 147.11111111111111 60.5C 159.98333333333335 60.5 171.01666666666665 0 183.88888888888889 0C 196.76111111111112 0 207.79444444444445 60.5 220.66666666666669 60.5C 233.5388888888889 60.5 244.57222222222225 22 257.44444444444446 22C 270.31666666666666 22 281.35 66 294.22222222222223 66C 307.09444444444443 66 318.1277777777778 55 331 55" pathFrom="M -1 165L -1 165L 36.77777777777778 165L 73.55555555555556 165L 110.33333333333334 165L 147.11111111111111 165L 183.88888888888889 165L 220.66666666666669 165L 257.44444444444446 165L 294.22222222222223 165L 331 165"></path><g id="SvgjsG1276" class="apexcharts-series-markers-wrap" data:realIndex="0"><g class="apexcharts-series-markers"><circle id="SvgjsCircle1318" r="0" cx="294.22222222222223" cy="66" class="apexcharts-marker w27s0nx5m no-pointer-events" stroke="#ffffff" fill="#00ab55" fill-opacity="1" stroke-width="2" stroke-opacity="0.9" default-marker-size="0"></circle></g></g></g><g id="SvgjsG1277" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1313" x1="0" y1="0" x2="331" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1314" x1="0" y1="0" x2="331" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1315" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1316" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1317" class="apexcharts-point-annotations"></g></g><rect id="SvgjsRect1270" width="0" height="0" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fefefe"></rect><g id="SvgjsG1296" class="apexcharts-yaxis" rel="0" transform="translate(-18, 0)"></g><g id="SvgjsG1268" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 145px;"></div><div class="apexcharts-tooltip apexcharts-theme-light" style="left: 190.582px; top: 69px;"><div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(0, 171, 85);"></span><div class="apexcharts-tooltip-text" style="font-family: Nunito, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-y-label">Sales: </span><span class="apexcharts-tooltip-text-y-value">36</span></div><div class="apexcharts-tooltip-goals-group"><span class="apexcharts-tooltip-text-goals-label"></span><span class="apexcharts-tooltip-text-goals-value"></span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
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
                fetch('{{ route("super_admin.weekly.statistics") }}')
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