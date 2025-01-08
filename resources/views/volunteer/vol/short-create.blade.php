<!-- modal -->
<div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4">
        <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg">إضافة متطوع جديد</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="m-auto h-5 w-5">
                        <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"></circle>
                        <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    </svg>
                </button>
            </div>
            <div class="p-5">
                <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
                    <div class="my-3">
                        <label for="name">الاسم</label>
                        <input type="text" wire:model.defer="newVolunteer.name" placeholder="ادخل اسم المتطوع ثلاثي" class="form-input" />
                        @error('newVolunteer.name') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                    <div class="my-3">
                        <label for="phone">رقم الهاتف</label>
                        <input type="text" wire:model.defer="newVolunteer.phone" placeholder="ادخل رقم الهاتف" class="form-input" />
                        @error('newVolunteer.phone') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                    <div class=" my-3 ">
                        <label for="phone">النوع</label>

                        <div class="d-flex  my-3">
                            <label class="inline-flex ml-3">
                                <input type="radio" name="default_text_color" class="form-radio text-info peer" value="1" wire:model.defer="newVolunteer.gender"/>
                                <span class="peer-checked:text-info">ذكر</span>
                            </label>
                            <label class="inline-flex">
                                <input type="radio" name="default_text_color" class="form-radio text-danger peer" value="2" wire:model.defer="newVolunteer.gender"/>
                                <span class="peer-checked:text-danger">انثي</span>
                            </label>
                        </div>
                        @error('newVolunteer.gender') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                    <div class="my-3">
                        <label for="volunteer_date">تاريخ التطوع</label>
                        <input id="date-input-modal"  wire:model.defer="newVolunteer.vol_date" class="form-input" placeholder="ادخل  تاريخ التطوع"/>
                        @error('newVolunteer.vol_date') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                    
                    <div class="my-3">
                        <label for="birth_date">تاريخ الميلاد</label>
                        <input id="date-input-modal"  wire:model.defer="newVolunteer.birth_date" class="form-input" placeholder="ادخل  تاريخ الميلاد" />
                        @error('newVolunteer.birth_date') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                </div>
                <div class="flex justify-end items-center mt-8">
                    <button type="button" class="btn btn-outline-danger" @click="toggle">غلق</button>
                    <button type="button" class="btn btn-primary ltr:ml-4 rtl:mr-4" wire:click="addNewVolunteer" >إضافة</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("modal", (initialOpenState = false) => ({
            open: initialOpenState,

            toggle() {
                this.open = !this.open;
            },
        }));
    });
</script>