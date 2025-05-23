@extends('volunteer.layout.master')
@section('title', 'تعديل متطوع')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/nice-select2.css" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/file-upload-with-preview/dist/style.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/file-upload-with-preview.min.css" />

@endsection

@section('content')
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline"> المتطوعين</a>
            </li>
            <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
                <span>تعديل</span>
            </li>
        </ul>
        <div class="mt-3 panel">
            <div class="flex items-center justify-between mb-5">
                <h5 class="text-lg font-semibold dark:text-white-light">تعديل متطوع</h5>
                <div class="space-x-2 dark:text-white-light ">

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
