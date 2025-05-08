<script setup lang="ts">
import { ref, reactive, computed, watch } from 'vue';
import { FormWizard, TabContent } from 'vue3-form-wizard';
import 'vue3-form-wizard/dist/style.css';

// Define props
const props = defineProps({
  volunteer: {
    type: Object,
    default: null, // Default to null for create mode
  },
  sections: {
    type: Array,
    default: () => [], // Default to empty array
  },
});

// Define data using reactive
const formData = reactive({
  id: props.volunteer?.id || null,
  name: props.volunteer?.name || '',
  phone: props.volunteer?.phone || '',
  gender: props.volunteer?.gender || null, // Use null for initial state or 1/2
  birth_date: props.volunteer?.birth_date || '',
  vol_date: props.volunteer?.vol_date || '',
  address: props.volunteer?.address || '',
  national: props.volunteer?.national || '',
  type: props.volunteer?.type || '',
  section_id: props.volunteer?.section_id || '',
  position: props.volunteer?.position || '',
  tshirt: props.volunteer?.tshirt == 1, // Convert boolean-like values
  camp_48: props.volunteer?.camp_48 == 1,
  mine_camp: props.volunteer?.mine_camp == 1,
  // File inputs will be handled differently, not via v-model directly for simplicity here
  // profile_photos: null,
  // id_card: null,
  // donation_receipts: null,
  notes: props.volunteer?.notes || '',
});

// Computed property for button text
const submitButtonText = computed(() => {
  return props.volunteer ? 'تحديث' : 'اضافة';
});

// Handle form submission
const onComplete = () => {
  console.log('Form completed and ready to submit');
  console.log('Form Data:', formData);

  // Here you would typically send the formData to your backend API
  // using something like Axios.
  // Example using Axios:
  /*
  const url = props.volunteer
    ? '/api/volunteer/' + formData.id // Adjust API endpoint
    : '/api/volunteer'; // Adjust API endpoint

  const method = props.volunteer ? 'PUT' : 'POST'; // Or POST with _method=PUT

  // Need to handle file uploads separately, potentially with FormData
  const submitFormData = new FormData();
  for (const key in formData) {
    submitFormData.append(key, formData[key]);
  }
  // Append files if they were selected - requires handling the file input change event
  // Example (assuming you have refs or state for files):
  // if (profilePhotos.value) {
  //   for (const file of profilePhotos.value) {
  //     submitFormData.append('profile_photos[]', file);
  //   }
  // }
  // if (idCard.value) {
  //   submitFormData.append('id_card', idCard.value);
  // }
  // if (donationReceipts.value) {
  //    for (const file of donationReceipts.value) {
  //     submitFormData.append('donation_receipts[]', file);
  //   }
  // }


  axios({
    method: method,
    url: url,
    data: submitFormData, // Use FormData for files
    headers: {
      'Content-Type': 'multipart/form-data', // Essential for file uploads
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // If using CSRF tokens
    }
  })
  .then(response => {
    console.log('Submission successful:', response.data);
    // Redirect or show success message
  })
  .catch(error => {
    console.error('Submission failed:', error.response.data);
    // Handle errors - display validation errors
  });
  */

  // alert('Form submitted!'); // Placeholder alert
};

// Error handling for demonstration - in a real app, this comes from backend API
// const errors = ref({});
// function hasError(field) {
//   return errors.value[field] && errors.value[field].length > 0;
// }
// function getErrorMessage(field) {
//   return errors.value[field] ? errors.value[field][0] : '';
// }

// Note: File input handling with previews is complex in Vue and is omitted here.
// You would typically use refs or handle file changes manually to store files
// and potentially generate preview URLs using URL.createObjectURL.
// Clearing files would involve setting the file input value to null and clearing previews.
// The original JavaScript snippet is a good starting point if you adapt it for Vue's lifecycle.

</script>

<template>
  <form-wizard color="#4361ee" class="circle" @on-complete="onComplete">

    <tab-content title="المعلومات الشخصية">
      <div class="p-6 rounded-lg shadow">
        <h3 class="pb-2 mb-6 text-lg font-semibold ">المعلومات الشخصية</h3>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

          <div>
            <label for="name" class="block mb-1">الاسم<span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" v-model="formData.name" placeholder="ادخل اسم المتطوع ثلاثي"
              class="w-full form-input" required />
            </div>

          <div>
            <label for="phone" class="block mb-1">رقم الهاتف<span class="text-danger">*</span></label>
            <input type="text" id="phone" name="phone" v-model="formData.phone" placeholder="ادخل رقم الهاتف"
              class="w-full form-input" required />
            </div>

          <div>
            <label class="block mb-1">النوع (الجنس)<span class="text-danger">*</span></label>
            <div class="flex items-center gap-4">
              <label class="flex items-center gap-2">
                <input type="radio" name="gender" value="1" v-model="formData.gender" class="form-radio text-info" required />
                <span>ذكر</span>
              </label>
              <label class="flex items-center gap-2">
                <input type="radio" name="gender" value="2" v-model="formData.gender" class="form-radio text-danger" required />
                <span>أنثى</span>
              </label>
            </div>
            </div>

          <div>
            <label for="birth_date" class="block mb-1">تاريخ الميلاد<span class="text-danger">*</span></label>
            <input id="birth_date" name="birth_date" type="date" v-model="formData.birth_date" class="w-full form-input"
              placeholder="ادخل تاريخ الميلاد" required />
            </div>

          <div>
            <label for="vol_date" class="block mb-1">تاريخ التطوع<span class="text-danger">*</span></label>
            <input id="vol_date" name="vol_date" type="date" v-model="formData.vol_date" class="w-full form-input"
              placeholder="ادخل تاريخ التطوع" required />
            </div>

          <div>
            <label for="address" class="block mb-1">العنوان</label>
            <input type="text" id="address" name="address" v-model="formData.address" placeholder="ادخل العنوان"
              class="w-full form-input" />
            </div>

          <div>
            <label for="national" class="block mb-1">الرقم القومي</label>
            <input type="text" id="national" name="national" v-model="formData.national" placeholder="ادخل الرقم القومي"
              class="w-full form-input" />
            </div>

          {{-- The 'Type' field is conditional --}}
          <div v-if="props.volunteer">
            <label for="type" class="block mb-1">الاعمدة</label>
            <select name="type" id="type" v-model="formData.type" class="w-full form-select">
              <option value="مسئول">مسئول</option>
              <option value="مشروع مسئول">مشروع مسئول</option>
              <option value="مسئول مستقيل">مسئول مستقيل</option>
              <option value="مشروع مسئول مستقيل">مشروع مسئول مستقيل</option>
              <option value="داخل المتابعة">داخل المتابعة</option>
              <option value="خارج المتابعة">خارج المتابعة</option>
            </select>
            </div>
          {{-- End conditional 'Type' field --}}


          <div>
            <label for="section_id">اللجنة</label>
            <select name="section_id" id="section_id" v-model="formData.section_id" class="w-full form-select">
            <option value="">اختر اللجنة</option>
            @foreach ($sections as $section)
                <option value="{{ $section->id }}" {{ old('section_id', $volunteer->section_id ?? '') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
            @endforeach
            </select>
            </div>

          <div>
            <label for="position" class="block mb-1">المنصب</label>
            <select name="position" id="position" v-model="formData.position" class="w-full form-select">
              <option value="">اختار المنصب</option>
              <option value="مدير">مدير</option>
              <option value="نائب مدير">نائب مدير</option>
              <option value="عضو">عضو</option>
            </select>
            </div>

        </div>

        <div class="flex flex-wrap items-center gap-6 my-4">
          <label class="flex items-center gap-2">
            <input type="checkbox" id="tshirt" name="tshirt" value="1" v-model="formData.tshirt" class="form-checkbox" />
            <span> تيشيرت</span>
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" id="camp_48" name="camp_48" value="1" v-model="formData.camp_48" class="form-checkbox" />
            <span> كامب 48</span>
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" id="mine_camp" name="mine_camp" value="1" v-model="formData.mine_camp" class="form-checkbox" />
            <span> الميني كامب</span>
          </label>

        </div>
      </div>
    </tab-content>

    <tab-content title="الوسائط والمرفقات">
      <div class="p-6 rounded-lg shadow">
        <h3 class="pb-2 mb-6 text-lg font-semibold ">الوسائط والمرفقات</h3>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
          <div>
            <label for="profile_photos" class="block mb-2">الصور الشخصية</label>
            <input type="file" id="profile_photos" name="profile_photos[]" multiple
              class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              accept="image/jpeg, image/png"
              />
            </div>
          <div>
            <label for="id_card" class="block mb-2">صورة البطاقة</label>
            <input type="file" id="id_card" name="id_card"
              class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              accept="image/jpeg, image/png" />
            </div>
          <div>
            <label for="donation_receipts" class="block mb-2">صور إيصالات التبرعات</label>
            <input type="file" id="donation_receipts" name="donation_receipts[]" multiple
              class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              accept="image/jpeg, image/png, application/pdf" />
            </div>
        </div>
      </div>
    </tab-content>

    <tab-content title="ملاحظات إضافية">
      <div class="p-6 rounded-lg shadow">
        <h3 class="pb-2 mb-4 text-lg font-semibold ">ملاحظات إضافية</h3>
        <div>
          <label for="notes" class="block mb-2">ملاحظات</label>
          <textarea id="notes" name="notes" v-model="formData.notes" rows="4" class="w-full form-textarea"
            placeholder="اكتب ملاحظات الحدث والتفاصيل الإضافية إن وجد"></textarea>
          </div>
      </div>
    </tab-content>

    <input type="hidden" name="id" v-if="formData.id" :value="formData.id">

     <template #finish-button>
       <button class="btn btn-primary ltr:ml-4 rtl:mr-4">
         {{ submitButtonText }}
       </button>
     </template>

  </form-wizard>
</template>

<style scoped>
/* Add any component-specific styles here if needed */
/* Keep your existing form-input, form-radio, form-checkbox, form-select, form-textarea styles */
/* Ensure vue3-form-wizard styles are imported globally or in your main app file */
</style>