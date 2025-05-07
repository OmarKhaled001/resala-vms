<form action="{{ isset($volunteer) ? route('volunteer.vol.update', $volunteer->id) : route('volunteer.vol.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    <div class="space-y-8">
        <!-- Personal Information Section -->
        <div class="p-6 rounded-lg shadow">
            <h3 class="pb-2 mb-6 text-lg font-semibold ">المعلومات الشخصية</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                <div>
                    <label for="name" class="block mb-1">الاسم</label>
                    <input type="text" id="name" name="name" placeholder="ادخل اسم المتطوع ثلاثي"
                        class="w-full form-input" value="{{ old('name', $volunteer->name ?? '') }}" required />
                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>


                <!-- Contact & Dates Group -->
                <div>
                    <label for="phone" class="block mb-1">رقم الهاتف</label>
                    <input type="text" id="phone" name="phone" placeholder="ادخل رقم الهاتف"
                        class="w-full form-input" value="{{ old('phone', $volunteer->phone ?? '') }}" required />
                    @error('phone')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1">النوع</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="gender" value="1" class="form-radio text-info"
                                {{ old('gender', $volunteer->gender ?? '') == 1 ? 'checked' : '' }} required />
                            <span>ذكر</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="gender" value="2" class="form-radio text-danger"
                                {{ old('gender', $volunteer->gender ?? '') == 2 ? 'checked' : '' }} required />
                            <span>أنثى</span>
                        </label>
                    </div>
                    @error('gender')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="birth_date" class="block mb-1">تاريخ الميلاد</label>
                    <input id="birth_date" name="birth_date" type="date" class="w-full form-input"
                        value="{{ old('birth_date', $volunteer->birth_date ?? '') }}" placeholder="ادخل تاريخ الميلاد"
                        required />
                    @error('birth_date')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="volunteer_date" class="block mb-1">تاريخ التطوع</label>
                    <input id="volunteer_date" name="volunteer_date" type="date" class="w-full form-input"
                        value="{{ old('volunteer_date', $volunteer->volunteer_date ?? '') }}"
                        placeholder="ادخل تاريخ التطوع" required />
                    @error('volunteer_date')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Role & Status Group -->


                <div>
                    <label for="type" class="block mb-1">النوع</label>
                    <select name="type" id="type" class="w-full form-select">
                        <option value="مسئول" {{ old('type', $volunteer->type ?? '') == 'مسئول' ? 'selected' : '' }}>
                            مسئول</option>
                        <option value="مشروع مسئول"
                            {{ old('type', $volunteer->type ?? '') == 'مشروع مسئول' ? 'selected' : '' }}>مشروع مسئول
                        </option>
                        <option value="مسئول مستقيل"
                            {{ old('type', $volunteer->type ?? '') == 'مسئول مستقيل' ? 'selected' : '' }}>مسئول مستقيل
                        </option>
                        <option value="مشروع مسئول مستقيل"
                            {{ old('type', $volunteer->type ?? '') == 'مشروع مسئول مستقيل' ? 'selected' : '' }}>مشروع
                            مسئول مستقيل</option>
                        <option value="داخل المتابعة"
                            {{ old('type', $volunteer->type ?? '') == 'داخل المتابعة' ? 'selected' : '' }}>داخل
                            المتابعة</option>
                        <option value="خارج المتابعة"
                            {{ old('type', $volunteer->type ?? '') == 'خارج المتابعة' ? 'selected' : '' }}>خارج
                            المتابعة</option>
                    </select>
                    @error('type')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Section (Committee) -->
                <div>
                    <label for="section_id">اللجنة</label>
                    <select name="section_id" id="section_id" class="form-select">
                        <option value="">اختر اللجنة</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                    @error('section_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>


                <div>
                    <label for="position" class="block mb-1">المنصب</label>
                    <select name="position" id="position" class="w-full form-select">
                        <option value="مدير"
                            {{ old('position', $volunteer->position ?? '') == 'مدير' ? 'selected' : '' }}>مدير</option>
                        <option value="نائب مدير"
                            {{ old('position', $volunteer->position ?? '') == 'نائب مدير' ? 'selected' : '' }}>نائب
                            مدير</option>
                        <option value="عضو"
                            {{ old('position', $volunteer->position ?? '') == 'عضو' ? 'selected' : '' }}>عضو</option>
                    </select>
                    @error('position')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Additional Info Group -->


            <div class="flex flex-wrap gap-6 my-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="tshirt" name="tshirt" class="form-checkbox"
                        {{ old('tshirt', $volunteer->tshirt ?? false) ? 'checked' : '' }} />
                    <span> تيشيرت</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="camp_48" name="camp_48" class="form-checkbox"
                        {{ old('camp_48', $volunteer->camp_48 ?? false) ? 'checked' : '' }} />
                    <span> كامب 48</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="mine_camp" name="mine_camp" class="form-checkbox"
                        {{ old('mine_camp', $volunteer->mine_camp ?? false) ? 'checked' : '' }} />
                    <span> الميني كامب</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Media Section -->
    <div class="p-6 rounded-lg shadow">
        <h3 class="pb-2 mb-6 text-lg font-semibold ">الوسائط والمرفقات</h3>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
                <label for="profile_photo" class="block mb-2">الصور الشخصية</label>
                <input type="file" id="profile_photo" name="profile_photos[]" multiple class="filepond"
                    accept="image/jpeg, image/png" />
            </div>
            <div>
                <label for="id_card" class="block mb-2">صورة البطاقة</label>
                <input type="file" id="id_card" name="id_card" class="filepond"
                    accept="image/jpeg, image/png" />
            </div>
            <div>
                <label for="donation_receipts" class="block mb-2">صور إيصالات التبرعات</label>
                <input type="file" id="donation_receipts" name="donation_receipts[]" class="filepond"
                    accept="image/jpeg, image/png, application/pdf" multiple />
            </div>
        </div>
    </div>

    <!-- Notes Section -->
    <div class="p-6 rounded-lg shadow">
        <h3 class="pb-2 mb-4 text-lg font-semibold ">ملاحظات إضافية</h3>
        <div>
            <label for="notes" class="block mb-2">ملاحظات</label>
            <textarea id="notes" name="notes" rows="4" class="w-full form-textarea"
                placeholder="اكتب ملاحظات الحدث والتفاصيل الإضافية إن وجد">{{ old('notes', $volunteer->notes ?? '') }}</textarea>
        </div>
    </div>
    </div>
    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">اضافة</button>

</form>
<!-- Filepond Scripts -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script>
    FilePond.create(document.getElementById('profile_photo'));
    FilePond.create(document.getElementById('id_card'));
    FilePond.create(document.getElementById('donation_receipts'));
</script>
