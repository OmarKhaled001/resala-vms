<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div>
        <label for="name">الاسم</label>
        <input name="name" type="text" placeholder="ادخل اسم اللجنة" class="form-input" value="{{ old('name', $section->name ?? '') }}" autocomplete="off" required />
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="username">اسم المستخدم</label>
        <input name="username" type="text" placeholder="ادخل اسم المستخدم" class="form-input" value="{{ old('username', $section->username ?? '') }}" autocomplete="off" required/>
        @error('username') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="email">البريد الالكتروني</label>
        <input name="email" type="email" placeholder="ادخل البريد الالكتروني" class="form-input" value="{{ old('email', $section->email ?? '') }}" autocomplete="off" required/>
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

<div class="my-4">
    <label for="description">الوصف</label>
    <textarea name="description" class="form-input" rows="3" placeholder="ادخل وصف اللجنة">{{ old('description', $section->description ?? '') }}</textarea>
    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<label class="inline-flex my-4">
    <input type="checkbox" class="form-checkbox rounded-4" id="select-all" />
    <span class="ml-5">اختر المشاركات</span>
</label>

<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
    @foreach ($contributions as $contribution)
        <label class="inline-flex">
            <input name="contribution_id[]" value="{{ $contribution->id }}" type="checkbox" class="form-checkbox rounded-full item-checkbox" {{ isset($section) && in_array($contribution->id, $section->contributions->pluck('id')->toArray()) ? 'checked' : '' }} />
            <span>{{ $contribution->name }}</span>
        </label>
    @endforeach
</div>
