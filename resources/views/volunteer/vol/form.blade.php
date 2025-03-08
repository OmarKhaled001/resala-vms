<div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-5">
    <div>
        <label for="name">الاسم</label>
        <input type="text" name="name" placeholder="ادخل اسم المتطوع ثلاثي" class="form-input" />
        @error('name')
        <span class="text-danger">{{ $message }}</span>
        @enderror

    </div>
    <div>
        <label for="phone">رقم الهاتف</label>
        <input type="text" name="phone" placeholder="ادخل رقم الهاتف" class="form-input" />
        @error('phone')
        <span class="text-danger">{{ $message }}</span>
        @enderror
        
    </div>
    <div>
        <label for="phone">النوع</label>

        <div class="d-flex  my-3">
            <label class="inline-flex ml-3">
                <input type="radio" name="default_text_color" class="form-radio text-info peer" value="1"/>
                <span class="peer-checked:text-info">ذكر</span>
            </label>
            <label class="inline-flex">
                <input type="radio" name="default_text_color" class="form-radio text-danger peer" value="2"/>
                <span class="peer-checked:text-danger">انثي</span>
            </label>
        </div>
        @error('gender') <span class="text-danger">{{ $message }}</span> @enderror

    </div>
    <div>
        <label for="volunteer_date">تاريخ التطوع</label>
        <input id="date-input-modal" class="form-input" placeholder="ادخل  تاريخ التطوع"/>
        @error('vol_date') <span class="text-danger">{{ $message }}</span> @enderror

    </div>
    
    <div>
        <label for="birth_date">تاريخ الميلاد</label>
        <input id="date-input-modal" class="form-input" placeholder="ادخل  تاريخ الميلاد" />
        @error('birth_date') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div>
        <label for="ctnTextarea">صورة الحدث</label>

       </div>
    <div>
        <label for="ctnTextarea">ملاحظات</label>
        <textarea id="ctnTextarea" rows="3" class="form-textarea"
            placeholder="اكتب ملاحظات الحدث والتفاصل الاضافية ان وجد " name="notes"></textarea>
    </div>
</div>
