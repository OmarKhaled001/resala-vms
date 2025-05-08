<form action="{{ isset($volunteer) ? route('volunteer.vol.update', $volunteer->id) : route('volunteer.vol.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($volunteer))
        @method('PUT') @endif
    <div class="space-y-8">
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

                <div>
                    <label for="phone" class="block mb-1">رقم الهاتف</label>
                    <input type="text" id="phone" name="phone" placeholder="ادخل رقم الهاتف"
                        class="w-full form-input" value="{{ old('phone', $volunteer->phone ?? '') }}" required />
                    @error('phone')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">النوع (الجنس)</label>
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
                    <label for="vol_date" class="block mb-1">تاريخ التطوع</label>
                    <input id="vol_date" name="vol_date" type="date" class="w-full form-input"
                        value="{{ old('vol_date', $volunteer->vol_date ?? ($volunteer->volunteer_date ?? '')) }}" placeholder="ادخل تاريخ التطوع" required />
                    @error('vol_date')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block mb-1">العنوان</label>
                    <input type="text" id="address" name="address" placeholder="ادخل العنوان"
                        class="w-full form-input" value="{{ old('address', $volunteer->address ?? '') }}" />
                    @error('address')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="national" class="block mb-1">الجنسية</label>
                    <input type="text" id="national" name="national" placeholder="ادخل الجنسية"
                        class="w-full form-input" value="{{ old('national', $volunteer->national ?? '') }}" />
                    @error('national')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                 <div>
                    <label for="type" class="block mb-1">نوع العضوية/الحالة</label>
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

                <div>
                    <label for="section_id">اللجنة</label>
                    <select name="section_id" id="section_id" class="w-full form-select">
                        <option value="">اختر اللجنة</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id', $volunteer->section_id ?? '') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                        @endforeach
                    </select>
                    @error('section_id')
                        <span class="text-sm text-red-500">{{ $message }}</span>
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

                <div>
                    <label for="password" class="block mb-1">كلمة المرور</label>
                    <input type="password" id="password" name="password" placeholder="اتركها فارغة لعدم التغيير"
                        class="w-full form-input" />
                    @error('password')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-1">تأكيد كلمة المرور</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="أعد كتابة كلمة المرور"
                        class="w-full form-input" />
                </div>

            </div>

            <div class="flex flex-wrap items-center gap-6 my-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="tshirt" name="tshirt" value="1" class="form-checkbox"
                        {{ old('tshirt', $volunteer->tshirt ?? false) ? 'checked' : '' }} />
                    <span> تيشيرت</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="camp_48" name="camp_48" value="1" class="form-checkbox"
                        {{ old('camp_48', $volunteer->camp_48 ?? false) ? 'checked' : '' }} />
                    <span> كامب 48</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="mine_camp" name="mine_camp" value="1" class="form-checkbox"
                        {{ old('mine_camp', $volunteer->mine_camp ?? false) ? 'checked' : '' }} />
                    <span> الميني كامب</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1" class="form-checkbox"
                           {{ old('is_active', $volunteer->is_active ?? true) ? 'checked' : '' }} /> <span>فعال</span>
                </label>
                 @error('is_active')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                 @enderror
            </div>
        </div>

        <div class="p-6 rounded-lg shadow">
            <h3 class="pb-2 mb-6 text-lg font-semibold ">الوسائط والمرفقات</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div>
                    <label for="profile_photo" class="block mb-2">الصور الشخصية</label>
                    <input type="file" id="profile_photo" name="profile_photos[]" multiple class="filepond"
                        accept="image/jpeg, image/png" />
                    @error('profile_photos.*')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="id_card" class="block mb-2">صورة البطاقة</label>
                    <input type="file" id="id_card" name="id_card" class="filepond"
                        accept="image/jpeg, image/png" />
                    @error('id_card')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="donation_receipts" class="block mb-2">صور إيصالات التبرعات</label>
                    <input type="file" id="donation_receipts" name="donation_receipts[]" class="filepond"
                        accept="image/jpeg, image/png, application/pdf" multiple />
                    @error('donation_receipts.*')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="p-6 rounded-lg shadow">
            <h3 class="pb-2 mb-4 text-lg font-semibold ">ملاحظات إضافية</h3>
            <div>
                <label for="notes" class="block mb-2">ملاحظات</label>
                <textarea id="notes" name="notes" rows="4" class="w-full form-textarea"
                    placeholder="اكتب ملاحظات الحدث والتفاصيل الإضافية إن وجد">{{ old('notes', $volunteer->notes ?? '') }}</textarea>
                @error('notes')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <button type="submit" class="mt-6 btn btn-primary ltr:ml-4 rtl:mr-4">
        {{ isset($volunteer) ? 'تحديث' : 'اضافة' }}
    </button>

</form>
<link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script>
    // Register the plugins
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateType,
        FilePondPluginFileValidateSize
    );

    // Set default options for all FilePond instances
    FilePond.setOptions({
        labelIdle: `اسحب وأفلت ملفاتك أو <span class="filepond--label-action">تصفح</span>`,
        labelInvalidField: 'الحقل يحتوي على ملفات غير صالحة',
        labelFileWaitingForSize: 'في انتظار الحجم',
        labelFileSizeNotAvailable: 'الحجم غير متوفر',
        labelFileLoading: 'جار التحميل',
        labelFileLoadError: 'خطأ أثناء التحميل',
        labelFileProcessing: 'جار الرفع',
        labelFileProcessingComplete: 'اكتمل الرفع',
        labelFileProcessingAborted: 'تم إلغاء الرفع',
        labelFileProcessingError: 'خطأ أثناء الرفع',
        labelFileProcessingRevertError: 'خطأ أثناء الإعادة',
        labelFileRemoveError: 'خطأ أثناء الإزالة',
        labelTapToCancel: 'اضغط للإلغاء',
        labelTapToRetry: 'اضغط لإعادة المحاولة',
        labelTapToUndo: 'اضغط للتراجع',
        labelButtonRemoveItem: 'إزالة',
        labelButtonAbortItemLoad: 'إلغاء',
        labelButtonRetryItemLoad: 'إعادة المحاولة',
        labelButtonAbortItemProcessing: 'إلغاء',
        labelButtonUndoItemProcessing: 'تراجع',
        labelButtonRetryItemProcessing: 'إعادة المحاولة',
        labelButtonProcessItem: 'رفع',
        maxFileSize: '10MB', // Default max file size (matches validation rule 10240KB)
        acceptedFileTypes: ['image/jpeg', 'image/png', 'application/pdf'], // Default accepted types
    });

    // Initialize FilePond for profile photo
    const profilePhotoPond = FilePond.create(document.getElementById('profile_photo'), {
        acceptedFileTypes: ['image/jpeg', 'image/png'],
        labelFileTypeNotAllowed: 'نوع الملف غير صالح',
        fileValidateTypeLabelExpectedTypes: 'توقع {allButLastType} أو {lastType}',
        maxFileSize: '10MB',
        labelMaxFileSizeExceeded: 'الملف كبير جدًا',
        labelMaxFileSize: 'الحد الأقصى لحجم الملف هو {filesize}',
    });

    // Initialize FilePond for ID card
    const idCardPond = FilePond.create(document.getElementById('id_card'), {
        acceptedFileTypes: ['image/jpeg', 'image/png'],
        labelFileTypeNotAllowed: 'نوع الملف غير صالح',
        fileValidateTypeLabelExpectedTypes: 'توقع {allButLastType} أو {lastType}',
        maxFileSize: '10MB',
        labelMaxFileSizeExceeded: 'الملف كبير جدًا',
        labelMaxFileSize: 'الحد الأقصى لحجم الملف هو {filesize}',
    });

    // Initialize FilePond for donation receipts
    const donationReceiptsPond = FilePond.create(document.getElementById('donation_receipts'), {
        acceptedFileTypes: ['image/jpeg', 'image/png', 'application/pdf'],
        labelFileTypeNotAllowed: 'نوع الملف غير صالح',
        fileValidateTypeLabelExpectedTypes: 'توقع {allButLastType}, {lastType} أو PDF',
        maxFileSize: '10MB',
        labelMaxFileSizeExceeded: 'الملف كبير جدًا',
        labelMaxFileSize: 'الحد الأقصى لحجم الملف هو {filesize}',
    });

</script>