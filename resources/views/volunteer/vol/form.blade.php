<form action="{{ isset($volunteer) ? route('volunteer.vol.update', $volunteer->id) : route('volunteer.vol.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
        @if(isset($volunteer))

        @method('PUT')

    @endif
    <div class="space-y-8">
        <div class="p-6 rounded-lg shadow">
            <h3 class="pb-2 mb-6 text-lg font-semibold ">المعلومات الشخصية</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                <div>
                    <label for="name" class="block mb-1">الاسم<span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" placeholder="ادخل اسم المتطوع ثلاثي"
                        class="w-full form-input" value="{{ old('name', $volunteer->name ?? '') }}" required />
                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block mb-1">رقم الهاتف<span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone" placeholder="ادخل رقم الهاتف"
                        class="w-full form-input" value="{{ old('phone', $volunteer->phone ?? '') }}" required />
                    @error('phone')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">النوع (الجنس)<span class="text-red-500">*</span></label>
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
                    <label for="birth_date" class="block mb-1">تاريخ الميلاد<span class="text-red-500">*</span></label>
                    <input id="birth_date" name="birth_date" type="date" class="w-full form-input"
                        value="{{ old('birth_date', $volunteer->birth_date ?? '') }}" placeholder="ادخل تاريخ الميلاد"
                        required />
                    @error('birth_date')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="vol_date" class="block mb-1">تاريخ التطوع<span class="text-red-500">*</span></label>
                    <input id="vol_date" name="vol_date" type="date" class="w-full form-input"
                        value="{{ old('vol_date', $volunteer->vol_date ?? ($volunteer->volunteer_date ?? '')) }}"
                        placeholder="ادخل تاريخ التطوع" required />
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
                    <label for="national" class="block mb-1">الرقم القومي</label>
                    <input type="text" id="national" name="national" placeholder="ادخل الجنسية"
                        class="w-full form-input" value="{{ old('national', $volunteer->national ?? '') }}" />
                    @error('national')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- The 'Type' field is now conditional --}}
                @if(isset($volunteer))
                <div>
                    <label for="type" class="block mb-1">الاعمدة</label>
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
                @endif
                {{-- End conditional 'Type' field --}}


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
                           {{ old('is_active', $volunteer->is_active ?? true) ? 'checked' : '' }} />
                    <span>فعال</span>
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
                    <label for="profile_photos" class="block mb-2">الصور الشخصية</label>
                    <input type="file" id="profile_photos" name="profile_photos[]" multiple class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            accept="image/jpeg, image/png" />
                    <div id="profile_photos_preview_container" class="mt-2 flex flex-wrap gap-2"></div>
                    <button type="button" id="clear_profile_photos" class="mt-2 text-sm text-red-600 hover:text-red-800" style="display:none;">مسح الصور الشخصية المحددة</button>
                    @error('profile_photos.*')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="id_card" class="block mb-2">صورة البطاقة</label>
                    <input type="file" id="id_card" name="id_card" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            accept="image/jpeg, image/png" />
                    <div id="id_card_preview_container" class="mt-2"></div>
                    <button type="button" id="clear_id_card" class="mt-2 text-sm text-red-600 hover:text-red-800" style="display:none;">مسح صورة البطاقة المحددة</button>
                    @error('id_card')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="donation_receipts" class="block mb-2">صور إيصالات التبرعات</label>
                    <input type="file" id="donation_receipts" name="donation_receipts[]" multiple class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            accept="image/jpeg, image/png, application/pdf" />
                    <div id="donation_receipts_preview_container" class="mt-2 flex flex-wrap gap-2"></div>
                    <button type="button" id="clear_donation_receipts" class="mt-2 text-sm text-red-600 hover:text-red-800" style="display:none;">مسح الإيصالات المحددة</button>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    function setupFileInput(inputId, previewContainerId, clearButtonId, isMultiple) {
        const fileInput = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewContainerId);
        const clearButton = document.getElementById(clearButtonId);

        if (!fileInput || !previewContainer || !clearButton) {
            // console.warn(`Initialization failed: One or more elements not found for input ID ${inputId}. Ensure IDs in HTML match those in JavaScript.`);
            return;
        }

        fileInput.addEventListener('change', function(event) {
            // Clear previous previews explicitly by removing child elements
            while (previewContainer.firstChild) {
                // Revoke object URL if the child was an image using it
                const imgElement = previewContainer.firstChild.querySelector('img');
                if (imgElement && imgElement.src.startsWith('blob:')) {
                    URL.revokeObjectURL(imgElement.src);
                }
                previewContainer.removeChild(previewContainer.firstChild);
            }

            const files = event.target.files;

            if (files.length === 0) {
                clearButton.style.display = 'none';
                return;
            }

            clearButton.style.display = 'inline-block';

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const filePreviewWrapper = document.createElement('div');
                filePreviewWrapper.className = 'inline-flex flex-col items-center p-2 border rounded-md shadow-sm max-w-[120px]'; // Added max-width for consistency

                let objectURL = null;

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    objectURL = URL.createObjectURL(file);
                    img.src = objectURL;
                    img.className = 'h-24 w-24 object-contain rounded-md'; // Changed to object-contain
                    // img.onload = () => URL.revokeObjectURL(objectURL); // Revoke on load can be problematic if element is removed before load
                    filePreviewWrapper.appendChild(img);
                } else if (file.type === 'application/pdf') {
                    const pdfIconContainer = document.createElement('div');
                    pdfIconContainer.className = 'h-24 w-24 flex items-center justify-center bg-gray-100 rounded-md text-gray-500';
                    pdfIconContainer.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V8.414a1 1 0 00-.293-.707l-4.586-4.586A1 1 0 0011.586 2H4zm7 6a1 1 0 011-1h.01a1 1 0 110 2H12a1 1 0 01-1-1zM9 9a1 1 0 00-1 1v4a1 1 0 102 0V10a1 1 0 00-1-1z" clip-rule="evenodd" /></svg><span class="mt-1 text-xs">PDF</span>';
                    filePreviewWrapper.appendChild(pdfIconContainer);
                } else {
                    const genericPreview = document.createElement('div');
                    genericPreview.className = 'h-24 w-24 flex flex-col items-center justify-center bg-gray-100 rounded-md text-gray-500 text-sm p-1';
                    genericPreview.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg><span>ملف</span>';
                    filePreviewWrapper.appendChild(genericPreview);
                }

                const fileName = document.createElement('p');
                fileName.textContent = file.name.length > 15 ? file.name.substring(0, 12) + '...' : file.name;
                fileName.className = 'text-xs mt-1 text-center break-all'; // break-all for long names
                filePreviewWrapper.appendChild(fileName);

                // Store the objectURL with the element for later cleanup if it's an image
                if (objectURL) {
                    filePreviewWrapper.dataset.objectURL = objectURL;
                }

                previewContainer.appendChild(filePreviewWrapper);

                if (!isMultiple) break;
            }
        });

        clearButton.addEventListener('click', function() {
            fileInput.value = null;
            // Clear previews and revoke URLs
            while (previewContainer.firstChild) {
                const wrapper = previewContainer.firstChild;
                if (wrapper.dataset && wrapper.dataset.objectURL) {
                    URL.revokeObjectURL(wrapper.dataset.objectURL);
                }
                previewContainer.removeChild(wrapper);
            }
            clearButton.style.display = 'none';
        });
    }

    // Initialize for each file input
    setupFileInput('profile_photos', 'profile_photos_preview_container', 'clear_profile_photos', true);
    setupFileInput('id_card', 'id_card_preview_container', 'clear_id_card', false);
    setupFileInput('donation_receipts', 'donation_receipts_preview_container', 'clear_donation_receipts', true);
});
</script>