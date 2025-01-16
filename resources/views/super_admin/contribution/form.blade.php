<div class="p-5">
    <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
        <div class="my-3">
            <label for="name">الاسم</label>
            <input type="text" name="name" placeholder="ادخل اسم  المشاركة"
                class="form-input"  value="{{ old('name', $contribution->name ?? '') }}" required  />
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class=" my-3 ">
            <label for="value">النوع</label>
            <div class="d-flex  my-3">
                <label class="inline-flex ml-3">
                    <input type="radio" name="value" class="form-radio text-success peer" value="1"
                    {{ isset($contribution) ? ($contribution->value == 1 ? 'checked' : ''  ) : '' }} />
                    <span class="peer-checked:text-success">ميدانة</span>
                </label>
                <label class="inline-flex">
                    <input type="radio" name="value" class="form-radio text-info peer" value="2"
                        {{ isset($contribution) ? ($contribution->value == 2 ? 'checked' : ''  ) : '' }} />
                    <span class="peer-checked:text-info">من المنزل</span>
                </label>
            </div>
            @error('value')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
        <div class="my-3">
            <label for="description">الوصف</label>
       
                <textarea name="description"class="form-input" rows="3" placeholder="ادخل وصف المشاركة"> {{ old('description', $contribution->description ?? '') }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
        <div class="my-3">
            <label for="description">الحالة</label>
            <label class="w-12 h-6 relative">
                <input 
                type="checkbox" 
                name="is_active" 
                class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" 
                id="custom_switch_checkbox2" 
                value="1" 
                {{ isset($contribution) ? ($contribution->is_active ? 'checked' : '') : 'checked' }} 
            />
            <span for="custom_switch_checkbox2" class="outline_checkbox bg-icon border-2 border-[#ebedf2] dark:border-white-dark block h-full rounded-full before:absolute before:left-1 before:bg-[#ebedf2] dark:before:bg-white-dark before:bottom-1 before:w-4 before:h-4 before:rounded-full before:bg-[url('../images/close.svg')] before:bg-no-repeat before:bg-center peer-checked:before:left-7 peer-checked:before:bg-[url('../images/checked.svg')] peer-checked:border-primary peer-checked:before:bg-primary before:transition-all before:duration-300"></span>
            </label>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
    </div>
</div>
