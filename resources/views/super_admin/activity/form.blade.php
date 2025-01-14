<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div>
        <label for="name">الاسم</label>
        <input name="name" type="text" placeholder="ادخل اسم النشاط" class="form-input" value="{{ old('name', $activity->name ?? '') }}" autocomplete="off" />
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="username">اسم المستخدم</label>
        <input name="username" type="text" placeholder="ادخل اسم المستخدم" class="form-input" value="{{ old('username', $activity->username ?? '') }}" autocomplete="off">
        @error('username') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="email">البريد الالكتروني</label>
        <input name="email" type="email" placeholder="ادخل البريد الالكتروني" class="form-input" value="{{ old('email', $activity->email ?? '') }}" />
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4">
    <div>
        <label for="password">كلمة المرور</label>
        <input name="password" type="password" placeholder="***************" class="form-input" />
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="password_confirmation">تأكيد كلمة المرور</label>
        <input name="password_confirmation" type="password" placeholder="***************" class="form-input" />
        @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
</div>
<label class="inline-flex my-4">
    <input type="checkbox" class="form-checkbox rounded-4" id="select-all" />
    <label class="ml-5">اختر اللجان</label>
</label>
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
    @foreach ($sections as $section)
        <label class="inline-flex">
            <input name="section_id[]" value="{{ $section->id }}" type="checkbox" class="form-checkbox rounded-full item-checkbox" {{ isset($activity) && in_array($section->id, $activity->sections->pluck('id')->toArray()) ? 'checked' : '' }} />
            <span>{{ $section->name }}</span>
        </label>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('select-all');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');

        selectAllCheckbox.addEventListener('change', function () {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    });
</script>

