<div class="p-5">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
        <div class="my-3">
            <label for="name">الاسم</label>
            <input type="text" name="name" placeholder="ادخل اسم"
                class="form-input"  value="{{ old('name', $user->name ?? '') }}" required />
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="my-3">
            <label for="name">اختر الصلاحية</label>
                <select name="role_id" id="ctnSelect1" class="form-select text-white-dark" >
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        
                    @endforeach
                </select>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="my-3">
            <label for="username">اسم المستخدم</label>
            <input type="text" name="username" placeholder="ادخل اسم  المستخدم"
                class="form-input"  value="{{ old('username', $user->username ?? '') }}" required />
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="my-3">
            <label for="email">البريد الالكتروني</label>
            <input type="email" name="email" placeholder="ادخل  البريد الالكتروني"
                class="form-input"  value="{{ old('email', $user->email ?? '') }}" required />
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="my-3">
            <label for="password">كلمة المرور</label>
            <input name="password" type="password" placeholder="***************" class="form-input" />
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="my-3">
            <label for="password_confirmation">تأكيد كلمة المرور</label>
            <input name="password_confirmation" type="password" placeholder="***************" class="form-input" />
            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
