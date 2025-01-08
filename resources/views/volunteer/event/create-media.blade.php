@extends('volunteer.layout.master')
@section('title', 'إضافة حدث')
@section('style')

@endsection

@section('content')
    <div >
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline"> الاحداث</a>
            </li>
            <li class="before:content-['/'] rtl:before:mr-1 rtl:before:ml-1">
                <span>إضافة وسائط</span>
            </li>
        </ul>
        <div class="panel mt-3">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">إضافة وسائط للحدث</h5>
                <div class="dark:text-white-light  space-x-2 ">

                    <span class="badge badge-outline-primary">{{ auth('volunteer')->user()->branch->name }}</span>
                    <span class="badge badge-outline-primary">{{ auth('volunteer')->user()->activity->name }}</span>
                </div>

            </div>

            @if($errors->any())
                @foreach($errors->all() as $error)
                <div class="relative flex items-center rounded border border-danger bg-danger-light p-3.5 text-danger before:absolute before:top-1/2 before:-mt-2 before:inline-block before:border-b-8 before:border-r-8 before:border-t-8 before:border-b-transparent before:border-r-inherit before:border-t-transparent ltr:border-r-[64px] ltr:before:right-0 rtl:border-l-[64px] rtl:before:left-0 rtl:before:rotate-180 dark:bg-danger-dark-light">
                    <span class="absolute inset-y-0 m-auto h-6 w-6 text-white ltr:-right-11 rtl:-left-11">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6">
                            <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"></circle>
                            <path d="M12 7V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                            <circle cx="12" cy="16" r="1" fill="currentColor"></circle>
                        </svg>
                    </span>
                    <span class="ltr:pr-2 rtl:pl-2"><strong class="ltr:mr-1 rtl:ml-1">!</strong>{{ $error }}</span>
                
                </div>
                @endforeach
            
            @endif

            <form action="{{ route('volunteer.event.create.media') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <input type="hidden" name="id" value="{{ $event->id }}">
                    
                    <div>
                        <label for="ctnFile">ارفع صور الحدث</label>
                        <input id="ctnFile" type="file"name="images[]" class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary" multiple  />
                    </div>

                    <div id="preview-container" class="mt-3"></div>
                </div>
                <button id="submitButton" class="btn btn-primary mt-3" type="submit">إضافة</button>

         

            </form>

        </div>


    </div>

@endsection
@section('script')

<script>
    document.getElementById('ctnFile').addEventListener('change', function(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = ''; // تفريغ الحاوية قبل إضافة الصور الجديدة

    // عرض الصور المختارة
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            imgElement.classList.add('preview-image');
            imgElement.style.maxWidth = '250px';
            imgElement.style.marginTop = '5px';
            previewContainer.appendChild(imgElement);
        };
        reader.readAsDataURL(file);
    });


});


</script>
@endsection
