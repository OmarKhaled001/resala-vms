<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div>
        <label for="name">الاسم</label>
        <input name="name" type="text" placeholder="ادخل اسم اللجنة" class="form-input" value="{{ old('name', $branch->name ?? '') }}" autocomplete="off" />
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="username">اسم المستخدم</label>
        <input name="username" type="text" placeholder="ادخل اسم المستخدم" class="form-input" value="{{ old('username', $branch->username ?? '') }}" autocomplete="off" />
        @error('username') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="email">البريد الالكتروني</label>
        <input name="email" type="email" placeholder="ادخل البريد الالكتروني" class="form-input" value="{{ old('email', $branch->email ?? '') }}" autocomplete="off" />
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
    <span class="ml-5">اختر الانشطة</span>
</label>

<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
    @foreach ($activities as $activity)
        <label class="inline-flex">
            <input name="activity_id[]" value="{{ $activity->id }}" type="checkbox" class="form-checkbox rounded-full item-checkbox" {{ isset($branch) && in_array($activity->id, $branch->activities->pluck('id')->toArray()) ? 'checked' : '' }} />
            <span>{{ $activity->name }}</span>
        </label>
    @endforeach
</div>
