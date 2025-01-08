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


@endsection