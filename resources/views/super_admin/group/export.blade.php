<div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'" >
    <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
        <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden my-8 w-full max-w-5xl">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg">استخراج تقرير</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                    x
                </button>
            </div>
            <form action="{{ route('super_admin.group.export') }}" method="POST">
            @csrf
            <input type="hidden" name="ids" class="group-ids" value="" />
            <div class="p-5">
                <label class="inline-flex my-4">
                    
                    <h5 class="mb-4 text-xl font-semibold text-[#3b3f5c] dark:text-white-light"><input type="checkbox" class="form-checkbox rounded-4 ml-2"  id="select-all" />حدد بيانات التقرير </h5>

                </label>
                <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <label class="inline-flex">
                                <input name="columns[]" value="name" type="checkbox"  class="form-checkbox rounded-full item-checkbox "  checked />
                                <span>اسم الفريق</span>
                            </label>
                            <label class="inline-flex">
                                <input name="columns[]" value="team_count" type="checkbox" class="form-checkbox rounded-full item-checkbox" checked />
                                <span>عدد فريق العمل</span>
                            </label>
                            <label class="inline-flex">
                                <input name="columns[]" value="masaol_count" type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                                <span>عدد مسئول</span>
                            </label>
                            <label class="inline-flex">
                                <input name="columns[]" value="mashroaa_count" type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                                <span>عدد مشروع مسئول</span>
                            </label>
                            <label class="inline-flex">
                                <input name="columns[]" value="team_countAttribute_count" type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                                <span>فريق شارك</span>
                            </label>
                            <label class="inline-flex">
                                <input name="columns[]" value="masaol_countAttribute_count" type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                                <span>مسئول شارك</span>
                            </label>
                            <label class="inline-flex">
                                <input name="columns[]" value="mashroaa_countAttribute_count" type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                                <span>مشروع مسئول شارك</span>
                            </label>
                          
                            <label class="inline-flex">
                                <input name="columns[]" value="masaol_countAttribute" type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                                <span>متوسط مشاركات مسئول </span>
                            </label>
                            <label class="inline-flex">
                                <input name="columns[]" value="mashroaa_countAttribute" type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                                <span>متوسط مشاركات مشروع مسئول </span>
                            </label>
                            <label class="inline-flex">
                                <input name="columns[]" value="new_count" type="checkbox" class="form-checkbox rounded-full item-checkbox"  />
                                <span>الجدد</span>
                            </label>
                           
                    </div>
                </div>
                <div class="flex justify-end items-center mt-8">
                    <button type="button" class="btn btn-outline-danger" @click="toggle">غلق</button>
                    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle" >إستخراج</button>
                </div>
            </form>
            </div>
        </div>
    </div>
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