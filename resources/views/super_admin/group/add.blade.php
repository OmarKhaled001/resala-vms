<div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-start justify-center min-h-screen px-4">
        <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                <div class="font-bold text-lg">إضافة  مدير</div>
                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="m-auto h-5 w-5">
                        <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"></circle>
                        <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    </svg>
                </button>
            </div>

            <div class="p-5">

                <div class="mb-5 " x-data="{ tab: 'home' }">
                    <!-- buttons -->
                    <div>
                        <ul class="flex flex-wrap mt-3 mb-5 border-b border-white-light dark:border-[#191e3a]">
                            <li>
                                <a href="javascript:"
                                    class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 before:absolute hover:text-primary before:bottom-0 before:w-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-primary hover:before:w-full"
                                    :class="{ 'before:w-full text-primary': tab === 'home' }" @click="tab='home'">
                                    إضافة مدير</a>
                            </li>
                            @if($group->getMangers())
                            <li>
                                <a href="javascript:"
                                    class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-primary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-primary hover:before:w-full"
                                    :class="{ 'before:w-full text-primary': tab === 'profile' }"
                                    @click="tab='profile'">
                                    المديرين</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div x-show="tab === 'home'">
                    <form action="{{ route('super_admin.group.add.admin') }}" method="post">
                        @csrf
                        <div class="p-5">
                            <div class="my-3">
                                <label for="name">اختر المتطوع</label>
                                <select id="seachable-select" name="volunteer_id" data-placeholder="اختر المتطوع">
                                    <option value="" disabled selected>اختر المتطوع</option>

                                    @foreach ($group->getVolunteersWhitOutMangers() as $volunteer)
                                        
                                    <option  value="{{ $volunteer->id }}">{{  $volunteer->name.' - '.$volunteer->phone.' - '.$volunteer->type }}</option>
                                    @endforeach
        
                                </select>
                                @error('volunteer_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
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
                        
                        <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">إضافة</button>
                    </form> 
                    </div>
                    @if($group->getMangers())
                    <div x-show="tab === 'profile'">
                        <div class="p-5">
                            <div class="flex flex-col rounded-md border border-[#e0e6ed] dark:border-[#1b2e4b]">
                                @foreach ($group->getMangers() as $volunteer)
                                <div class="flex px-4 py-2.5 hover:bg-[#eee] dark:hover:bg-[#eee]/10">
                                    <div class="ltr:mr-3 rtl:ml-3">
                                        <img src="/assets/images/profile-3.jpeg" alt="image" class="rounded-full w-12 h-12 object-cover" />
                                    </div>
                                    <div class="flex-1 font-semibold">
                                        <h6 class="mb-1 text-base">{{ $volunteer->name }}</h6>
                                        <p class="text-md">{{ $volunteer->phone }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                 
                </div>

            </div>
          
            <div class="flex justify-end items-center p-5">
                <button type="button" class="btn btn-outline-danger" @click="toggle">غلق</button>
            </div>
        </div>


    </div>
</div>