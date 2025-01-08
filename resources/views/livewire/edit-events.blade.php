<div>
 
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-5">
        <div class="mb-2">
            <div x-data="form">
                <input class="form-input" type="text" id="date-input" placeholder="اختر التاريخ"  wire:model="event_date">
            </div>
        </div>
        <div class="mb-2">
            <select wire:model.live="section_id" id="section_id" name="section_id"  value="{{ $section_id }}" class="form-input">
                <option value="">اختر اللجنة</option>
                @foreach ($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="mb-2"> 
            <select wire:model="contribution_id" id="contribution_id" name="contribution_id"  value="{{ $contribution_id }}" class="form-input">
                <option value="">اختر المشاركة</option>
                @foreach ($contributions as $contribution)
                    <option value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                @endforeach
            </select>
        </div>

    </div>

    <!-- حقل البحث عن المتطوعين -->
    <div x-data="modal" class="mb-5">

        @include('volunteer.vol.short-create')

        <div class="relative">
            <input type="text"  wire:model.live="searchTerm" placeholder=" ....ابحث عن المتطوع" class="form-input shadow-[0_0_4px_2px_rgb(31_45_61_/_10%)] bg-white rounded-full h-11 placeholder:tracking-wider" x-model="search" />
            <button @click="toggle" type="button" class="btn btn-primary  absolute ltr:right-1 rtl:left-1 inset-y-0 m-auto rounded-full w-9 h-9 p-0 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </button>
        </div>
    </div>

    <!-- قائمة المتطوعين التي تظهر بناءً على نص البحث -->
    @if ($volunteers)

        <div class="p-3 border border-white-dark/20 rounded-lg space-y-2 overflow-x-auto w-full block">
            @foreach ($volunteers as $volunteer)
                <div class="bg-white dark:bg-[#1b2e4b] rounded-xl shadow-[0_0_4px_2px_rgb(31_45_61_/_10%)] p-3 row
                        text-gray font-semibold  hover:text-primary transition-all duration-300 hover:scale-[1.01]"
                    wire:click="selectVolunteer({{ $volunteer->id }})">
                    <div >{{ $volunteer->name }} ( {{ $volunteer->phone }} ) <br>
                        <p class="{{ ($volunteer->type == 'مسئول' || $volunteer->type == 'مشروع مسئول') ? 'text-success' : 'text-primary' }}">
                            ({{ $volunteer->type ?? 'غير معرف' }})
                        </p>
                        
                    </div>
         
                </div>
            @endforeach
        </div>
    @endif
    <div class="my-2">
        

    </div>

    @if ($selectedVolunteers)
        
    <!-- جدول المتطوعين المختارين -->
    <h4>العدد :  {{ count($selectedVolunteers) }}</h4>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>تيشرت</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($selectedVolunteers as $id => $volunteer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $volunteer['name'] }}</td>
                        <td><input type="checkbox" class="form-checkbox text-success peer" value="1" wire:model="selectedVolunteersShirts.{{ $id }}.tshirt"/></td>
                        <td>
                            <a href="javascript:;" wire:click="removeVolunteer({{ $id }})">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-danger">
                                    <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6" stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif



    <div class="my-2">
        <label for="ctnTextarea">ملاحظات</label>
        <textarea id="ctnTextarea" rows="3" class="form-textarea"
            placeholder="اكتب ملاحظات الحدث والتفاصل الاضافية ان وجد " wire:model="notes"></textarea>
    </div>



    <div class="flex space-x-2 !mt-6">

        <button  wire:click="createEvent('volunteer.event.index')" class="btn btn-primary ml-3">إضافة </button>
        <button  wire:click="createEvent('volunteer.event.create.media')" class="btn btn-primary ">إضافة وسائط </button>
    </div>
    @section('script')
 
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <link rel="stylesheet" href="{{ asset('assets') }}/css/highlight.min.css" />
        <script src="{{ asset('assets') }}/js/highlight.min.js"></script>
        <script src="{{ asset('assets') }}/js/flatpickr.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>
        <script src="{{ asset('assets') }}/js/nice-select2.js"></script>
        <script src="{{ asset('assets') }}/js/nouislider.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                flatpickr("#date-input", {
                    dateFormat: "Y-m-d",
                    enableTime: false,
                    locale: "ar",
                    placeholder: "اختر التاريخ",
                    minDate: new Date().fp_incr(-7),
                    maxDate: "today",
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                flatpickr("#date-input-modal", {
                    dateFormat: "Y-m-d",
                    enableTime: false,
                    locale: "ar",
                    maxDate: "today",
                });
            });
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                new TomSelect("#volunteer_id", {
                    create: false, // منع إضافة عناصر جديدة
                    plugins: ['remove_button'], // إضافة زر الحذف للعناصر المختارة
                    valueField: 'id', // القيمة المخزنة في الحقل
                    labelField: 'name', // النص الظاهر
                    searchField: ['name', 'phone'], // الحقول التي سيتم البحث فيها
                    maxItems: null, // السماح باختيار عدد غير محدود من العناصر
                    load: function(query, callback) {
                        // طلب AJAX لجلب البيانات بناءً على البحث
                        fetch(`/volunteer/search?search_term=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                callback(data.map(volunteer => ({
                                    id: volunteer.id,
                                    name: `${volunteer.name} (${volunteer.type || 'No type'}) (${volunteer.phone || 'No Phone'})`,
                                })));
                            })
                            .catch(() => {
                                callback(); // في حالة حدوث خطأ
                            });
                    },
                    maxOptions: 1000, // الحد الأقصى للعناصر المعروضة في القائمة
                    placeholder: "اختار متطوعين الحدث...", // النص الافتراضي
                    render: {
                        option: function(data, escape) {
                            return `<div class="custom-option">${escape(data.name)}</div>`;
                        },
                        item: function(data, escape) {
                            return `<div class="custom-item">${escape(data.name)} </div>  `;
                        }
                    },
                });
            });
        </script>
       
    @endsection

</div>
