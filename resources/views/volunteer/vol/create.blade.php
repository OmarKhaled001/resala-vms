@extends('volunteer.layout.master')
@section('title', 'إضافة متطوع')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/nice-select2.css" />
    <link
    rel="stylesheet"
    type="text/css"
    href="https://unpkg.com/file-upload-with-preview/dist/style.css"
  />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/file-upload-with-preview.min.css" />

@endsection

@section('content')
    <div >
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline"> المتطوعين</a>
            </li>
            <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
                <span>إضافة</span>
            </li>
        </ul>
        <div class="panel mt-3">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">إضافة متطوع</h5>
                <div class="dark:text-white-light  space-x-2 ">

                    <span class="badge badge-outline-primary">{{ auth('volunteer')->user()->branch->name }}</span>
                    <span class="badge badge-outline-primary">{{ auth('volunteer')->user()->activity->name }}</span>
                </div>

            </div>
            <div class="mb-5">
                
                    
                @include('volunteer.vol.form')
        
            </div>

        </div>


    </div>
    <script src="https://unpkg.com/file-upload-with-preview/dist/index.js"></script>

@endsection
@section('script')
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script>
    FilePond.create(document.querySelector('.filepond'));
</script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/css/highlight.min.css" />
    <script src="{{ asset('assets') }}/js/highlight.min.js"></script>
    <script src="{{ asset('assets') }}/js/flatpickr.js"></script>
    <script src="{{ asset('assets') }}/js/nice-select2.js"></script>
    <script src="{{ asset('assets') }}/js/nouislider.min.js"></script>

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
@endsection