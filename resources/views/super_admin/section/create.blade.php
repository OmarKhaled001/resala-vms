@extends('super_admin.layout.master')
@section('title','الإدارة المركزية')


@section('content')
<div x-data="finance">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">الانشطة</a>
        </li>
        <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
            <span>إضافة</span>
        </li>
    </ul>
</div>
<div class="panel mt-3">
    <h5 class="text-lg font-semibold dark:text-white-light">إضافة نشاط</h5>

    <form class="mt-5" autocomplete="off" action="{{ route('super_admin.section.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div >

                <label for="name">الاسم</label>
                <input name="name" type="text" placeholder="ادخل اسم النشاط" class="form-input" autocomplete="off" />
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
          
            <div>
                <label for="email">البريد الالكتروني</label>
                <input name="email" type="email" placeholder="ادخل البريد الالكتروني" class="form-input" />
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4">
            <div >
                <label for="password">كلمة المرور</label>
                <input name="password" type="password" placeholder="***************" class="form-input" />
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div >
                <label for="password">تاكيد كلمة المرور</label>
                <input name="password_confirmation" type="password" placeholder="***************" class="form-input" />
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

        </div>
        <label class="inline-flex my-4">
            <input type="checkbox" class="form-checkbox rounded-4"  id="select-all" />
            <label class="ml-5">اختار اللجان</label>
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">

            <label class="inline-flex">
                <input type="checkbox" class="form-checkbox rounded-full item-checkbox" checked />
                <span>Primary</span>
            </label>
            <label class="inline-flex">
                <input type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                <span>Primary</span>
            </label>
            <label class="inline-flex">
                <input type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                <span>Primary</span>
            </label>
            <label class="inline-flex">
                <input type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                <span>Primary</span>
            </label>
            <label class="inline-flex">
                <input type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                <span>Primary</span>
            </label>
            <label class="inline-flex">
                <input type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                <span>Primary</span>
            </label>
        </div>
        <button type="submit" class="btn btn-primary mt-6">إضافة</button>
    </form>

</div>

<script>
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');

    selectAllCheckbox.addEventListener('change', function () {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
</script>
@endsection