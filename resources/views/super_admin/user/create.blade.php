<div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4">
        <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg">إضافة  مستخدم</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="m-auto h-5 w-5">
                        <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"></circle>
                        <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('super_admin.user.store') }}" method="post">
            @csrf
            @include('super_admin.user.form')
            <div class="flex justify-end items-center p-5">
                <button type="button" class="btn btn-outline-danger" @click="toggle">غلق</button>
                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4" wire:click="addNewVolunteer" >إضافة</button>
            </div>
            </form>
        </div>


    </div>
</div>
