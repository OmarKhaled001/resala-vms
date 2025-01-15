@extends('super_admin.layout.master')
@section('title','الإدارة المركزية')


@section('content')
<div x-data="finance">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">الفروع</a>
        </li>
        <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
            <span>تعديل</span>
        </li>
    </ul>
</div>
<div class="panel mt-3">
    <h5 class="text-lg font-semibold dark:text-white-light">تعديل {{ $role->name }}</h5>

    <form class="mt-5" autocomplete="off" action="{{ route('super_admin.role.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $role->id }}">
        @include('super_admin.role.form')
        <button type="submit" class="btn btn-primary mt-6">تعديل</button>
    </form>

</div>

@endsection