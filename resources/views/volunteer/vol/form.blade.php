<div class="grid grid-cols-4 gap-6 lg:grid-cols-3 mb-5">
  
      
        <div>
            <label for="name">الاسم</label>
            <input type="text" name="name" placeholder="ادخل اسم المتطوع ثلاثي" class="form-input" />
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror

        </div>
        <div>
            <label for="phone">رقم الهاتف</label>
            <input type="text" name="phone" placeholder="ادخل رقم الهاتف" class="form-input" />
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror

        </div>
        <select wire:model.live="section_id" id="section_id" name="section_id" class="form-input">
            <option value="">اختر اللجنة</option>
            @foreach ($sections as $section)
                <option value="{{ $section->id }}">{{ $section->name }}</option>
            @endforeach
        </select>



</div>