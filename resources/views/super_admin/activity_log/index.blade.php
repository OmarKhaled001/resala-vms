@extends('super_admin.layout.master')
@section('title', 'الإدارة المركزية')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/highlight.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/swiper-bundle.min.css" />
@endsection

@section('content')

    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">الأدوار </a>
        </li>
        <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
            <span>الكل</span>
        </li>
    </ul>

    <div class="panel mt-5 dark:text-white-light">
        <table id="myTable" class="table-responsive myTable dark:text-white-light">
            <thead>
                <tr >
                    <th class="wd-10p text-center border-bottom-0">#</th>
                    <th class="wd-25p text-center border-bottom-0">العنوان</th>
                    <th class="wd-25p text-center border-bottom-0">النوع</th>
                    <th class="wd-25p text-center border-bottom-0">وصف</th>
                    <th class="wd-25p text-center border-bottom-0">التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="text-align: center;">{{ $activity->log_name }}</td>
                        <td style="text-align: center;">{{ $activity->event }}</td>
                        <td style="text-align: center;">{{ $activity->description }}</td>
                        <td style="text-align: center;">{{ $activity->created_at->format('Y-m-d (h:i:s A)') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
    <script>
        async function showDeleteAlert(id) {
            const url = "{{ route('super_admin.role.destroy', ['role' => ':id']) }}".replace(':id',
                id);

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
                    axios.post(url, {
                            _token: '{{ csrf_token() }}',
                        })
                        .then(response => {
                            if (response.data.success) {
                                new window.Swal('تم الحذف!', response.data.success, 'success').then(() => {
                                    location.reload();
                                });
                            } else if (response.data.error) {
                                new window.Swal('خطأ!', response.data.error, 'error');
                            }
                        })
                        .catch(error => {
                            new window.Swal('خطأ!', 'حدث خطأ أثناء الحذف.', 'error');
                        });
                }
            });
        }
    </script>


@endsection
