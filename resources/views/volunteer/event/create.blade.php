@extends('volunteer.layout.master')
@section('title', 'إضافة حدث')
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
                <a href="javascript:;" class="text-primary hover:underline"> الاحداث</a>
            </li>
            <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
                <span>إضافة</span>
            </li>
        </ul>
        <div class="panel mt-3">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">إضافة حدث</h5>
                <div class="dark:text-white-light  space-x-2 ">

                    <span class="badge badge-outline-primary">{{ auth('volunteer')->user()->branch->name }}</span>
                    <span class="badge badge-outline-primary">{{ auth('volunteer')->user()->activity->name }}</span>
                </div>

            </div>
            <div class="mb-5">
                
                    
                
                <livewire:index-volunteer />  
        
            </div>

        </div>


    </div>
    <script src="https://unpkg.com/file-upload-with-preview/dist/index.js"></script>

@endsection
