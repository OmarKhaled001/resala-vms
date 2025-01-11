<div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
        <div x-show="open" x-transition x-transition.duration.300
            class="panel border-0 p-0 rounded-lg overflow-hidden my-8 w-full max-w-lg">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg">إرفاق البيانات</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                    x
                </button>
            </div>
            <form action="{{ route('super_admin.activity.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="p-5">
                    <div>
                        <label>قم برفع ملف البيانات يكون مطابق النموذج المطلوب <br>
                            يمكنك تحميله من <a class="underline text-success" href="{{ route('super_admin.activity.sheet') }}">هنا</a>
                        </label>
                        <input type="file" name="file" class="rtl:file-ml-5 form-input p-0 file:border-0 file:bg-primary/90 file:px-4 file:py-2 file:font-semibold file:text-white file:hover:bg-primary ltr:file:mr-5 mt-5">
                    </div>
                    <div class="flex justify-start items-center mt-8">
                        <button type="button" class="btn btn-outline-danger" @click="toggle">غلق</button>
                        <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">رفع</button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
