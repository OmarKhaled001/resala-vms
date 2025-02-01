<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
  <div>
      <label for="display_name">الاسم</label>
      <input name="display_name" type="text" placeholder=" ادخل اسم الدور مثل : 'محرر' " class="form-input" value="{{ old('display_name', $role->display_name ?? '') }}" autocomplete="off" required/>
      @error('display_name') <span class="text-danger">{{ $message }}</span> @enderror
  </div>
  <div>
      <label for="name">الرمز</label>
      <input name="name" type="text" placeholder="ادخل رمز الدور مثل : 'editor'" class="form-input" value="{{ old('name', $role->name ?? '') }}" autocomplete="off" />
      @error('name') <span class="text-danger">{{ $message }}</span> @enderror
  </div>
</div>

<div class="my-3">
  <label for="description">الوصف</label>
  <textarea name="description" class="form-input" rows="3" placeholder="ادخل وصف المشاركة">{{ old('description', $contribution->description ?? '') }}</textarea>
  @error('description') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<label class="inline-flex my-4">
  <input type="checkbox" class="form-checkbox rounded-4" id="select-all" />
  <span class="ml-5">اختر كل الصلاحيات</span>
</label>

<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
  @foreach (config('roles.super_admin') as $roleKey => $data)
      <div class="w-full max-w-[19rem] rounded border border-[#e0e6ed] bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
          <div class="px-6 py-7">
              <h5 class="mb-4 text-md font-semibold text-[#3b3f5c] dark:text-white-light">
                  <input type="checkbox" class="form-checkbox rounded-4 select-role" data-role="{{ $roleKey }}" />
                  {{ $data['title'] }}
              </h5>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  @foreach ($data['permissions'] as $permission => $translation)
                      <p class="text-white-dark text-md">
                          <input
                              name="permissions[]"
                              value="{{ $permission . '-' . $roleKey }}"
                              type="checkbox"
                              class="form-checkbox rounded-full item-checkbox item-{{ $roleKey }}"
                              {{ isset($role) ? ($role->hasPermission($permission . '-' . $roleKey) ? 'checked'  : '') : '' }}
                          />
                          <span>{{ $translation }}</span>
                      </p>
                  @endforeach
              </div>
          </div>
      </div>
  @endforeach
</div>


<script>
  const selectAllCheckbox = document.getElementById('select-all');
  const roleCheckboxes = document.querySelectorAll('.select-role');
  const itemCheckboxes = document.querySelectorAll('.item-checkbox');

  selectAllCheckbox.addEventListener('change', function () {
      const isChecked = selectAllCheckbox.checked;
      roleCheckboxes.forEach(roleCheckbox => (roleCheckbox.checked = isChecked));
      itemCheckboxes.forEach(itemCheckbox => (itemCheckbox.checked = isChecked));
  });

  roleCheckboxes.forEach(roleCheckbox => {
      roleCheckbox.addEventListener('change', function () {
          const role = roleCheckbox.dataset.role;
          const relatedItems = document.querySelectorAll(`.item-${role}`);
          relatedItems.forEach(item => (item.checked = roleCheckbox.checked));
          checkSelectAll();
      });
  });

  itemCheckboxes.forEach(itemCheckbox => {
      itemCheckbox.addEventListener('change', function () {
          checkSelectAll();
      });
  });

  function checkSelectAll() {
    const totalCheckboxes = itemCheckboxes.length;
    const roleCheckboxes = document.querySelectorAll('.select-role').length;
    const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked').length;
    const allChecked = (totalCheckboxes + roleCheckboxes) > 0 && (totalCheckboxes === checkedCheckboxes);
    
    selectAllCheckbox.checked = allChecked;
}



  document.addEventListener('DOMContentLoaded', function () {
      checkSelectAll();
  });
</script>
