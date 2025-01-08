<div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4">
        <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg">تغير الحالة - {{ $event->id }}</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle()">
                    x
                </button>
            </div>
            <div class="p-5">
                <form :action="`{{ url('branch/event/change/') }}/{{ $event->id }}`" method="post">
                    @csrf
                    <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
                        <div>
                            <label>الحالة</label>
                            <select class="form-select text-white-dark" name="status">
                                <option {{$event->status == 'pending' ? 'selected' : '' }} value="pending">معلق</option>
                                <option {{$event->status == 'conforming' ? 'selected' : '' }} value="conforming">مطابق</option>
                                <option {{$event->status == 'non-conforming' ? 'selected' : '' }} value="non-conforming">غير مطابق</option>
                                <option {{$event->status == 'rejected' ? 'selected' : '' }} value="rejected">مرفوض</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label>السبب</label>
                            <textarea id="ctnTextarea" name="reason" rows="3" class="form-textarea" placeholder="اكتب سبب تغير الحالة إن وجد">{{ $event->reason ?? null }}</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end items-center mt-8">
                        <button type="button" class="btn btn-outline-danger" @click="open = false">غلق</button>
                        <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">تغير</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>