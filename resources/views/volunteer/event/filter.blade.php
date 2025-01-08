<div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
        <div x-show="open" x-transition x-transition.duration.300
            class="panel border-0 p-0 rounded-lg overflow-hidden my-8 w-full max-w-lg">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg">تصفية البيانات</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                    x
                </button>
            </div>
            <form action="{{ route('volunteer.event.filter') }}" method="post">
                @csrf
                <div class="p-5">
                    <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
                        <div>
                            <label>من:</label>
                            <div>
                                <input class="form-input" name="event_date_from" placeholder="اختر تاريخ البداية" value="{{ old('event_date_from', request('event_date_from')) }}">
                            </div>
                        </div>
                        <div class="mt-5">
                            <label>إلى:</label>
                            <div>
                                <input class="form-input" name="event_date_to" placeholder="اختر تاريخ النهاية" value="{{ old('event_date_to', request('event_date_to')) }}">
                            </div>
                        </div>

                        <!-- فلتر باللجنة -->
                        <div class="mt-5">
                            <label>اللجنة:</label>
                            <select name="section_id" class="form-select">
                                <option value="">اختر اللجنة</option>
                                @foreach ($sections as $section)
                                <option value="{{ $section->id }}" 
                                    {{ old('section_id', request('section_id')) == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر بنوع المشاركة -->
                        <div class="mt-5">
                            <label>نوع المشاركة:</label>
                            <select name="contribution_id" class="form-select">
                                <option value="">اختر نوع المشاركة</option>
                                @foreach ($sections as $section)
                                    @foreach ($section->contributions as $contribution)
                                        <option value="{{ $contribution->id }}" 
                                            {{ old('contribution_id', request('contribution_id')) == $contribution->id ? 'selected' : '' }}>
                                            {{ $contribution->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر بالحالة -->
                        <div class="mt-5">
                            <label>الحالة:</label>
                            <select name="status" class="form-select">
                                <option value="">اختر الحالة</option>
                                <option value="pending" {{ old('status', request('status')) == 'pending' ? 'selected' : '' }}>معلقة</option>
                                <option value="conforming" {{ old('status', request('status')) == 'conforming' ? 'selected' : '' }}>مطابق</option>
                                <option value="non-conforming" {{ old('status', request('status')) == 'non-conforming' ? 'selected' : '' }}>غير مطابق</option>
                                <option value="rejected" {{ old('status', request('status')) == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end items-center mt-8">
                        <button type="button" class="btn btn-outline-danger" @click="toggle">إغلاق</button>
                        <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4" >فلتر</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>