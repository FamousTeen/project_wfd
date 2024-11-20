@extends('base/admin_navbar')

@section('content')
<!-- Colors:
                1. #740001 - merah gelap
                2. #ae0001 - merah terang
                3. #f6f1e3 - netral
                4. #002366 - biru terang
                5. #20252f - biru gelap
            -->

<div class="container mx-auto py-8 mt-8">
    <div class="p-6 mb-8 bg-[#f6f1e3] border border-[#002366] shadow-lg">
        <h2 class="ml-4 mt-4 text-2xl font-semibold mb-2">Dokumen Khusus Pengurus</h2>
        <div class="flex flex-col items-center justify-center space-x-4 mt-8 mx-8 md:flex-row">
            <!-- Add File Button -->
            <button onclick="openUploadModal()" class="bg-[#002366] hover:bg-[#20252f] text-white px-4 py-2 rounded-lg flex flex items-center justify-center w-15 h-20">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambahkan File
            </button>
            <span>atau</span>
            <!-- Drag and Drop Area -->
            <div id="dropArea" class="w-full h-40 border-dashed border-2 border-gray-300 rounded flex items-center justify-center p-4 cursor-pointer" ondrop="handleFileDrop(event)" ondragover="event.preventDefault()">
                <div class="text-center flex flex-col items-center"> <!-- Added flex-col for vertical alignment -->
                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#5f6368">
                        <path d="m446.67-467.33-53.34 53q-9.66 9.66-23.23 9.66t-23.43-10q-9.67-9.66-9.67-23.66t9.67-23.67l110-110.67q10-10 23.33-10 13.33 0 23.33 10L614-462q9.67 9.67 9.83 23.17.17 13.5-9.83 23.5-9.67 9.66-23.5 9.83-13.83.17-23.83-9.5l-53.34-52.33v240.66h234q44 0 75-31t31-75q0-44-31-75t-75-31h-62v-82.66q0-87-59.83-149.17-59.83-62.17-146.83-62.17-87 0-147.17 62.17-60.17 62.17-60.17 149.17H252q-60.67 0-103 42.66Q106.67-436 106.67-374q0 60.67 42.95 104t103.71 43.33h93.34q14.16 0 23.75 9.62 9.58 9.62 9.58 23.83 0 14.22-9.58 23.72-9.59 9.5-23.75 9.5h-93.34q-87.66 0-150.5-62.33Q40-284.67 40-372.33q0-78 48.67-138 48.66-60 126-73.67 21.66-95.33 96-155.33 74.33-60 170.66-60 114.34 0 192.5 81.5Q752-636.33 752-521.33v16q71 1.33 119.5 50.83T920-332.67q0 71-50.83 121.84Q818.33-160 747.33-160h-234q-27 0-46.83-19.83-19.83-19.84-19.83-46.84v-240.66ZM480-446.67Z" />
                    </svg>
                    <p class="text-gray-600 mt-2">unggah file disini</p>
                </div>
            </div>

        </div>
    </div>

    @if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
        role="alert">
        {{ session('success')}}
    </div>
    @endif

    <div class="grid grid-cols-12">
        <div class="col-start-4 col-span-6 mb-8 justify-items-center">
            <h4 class="font-bold text-2xl text-center">Dokumen-Dokumen</h4>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 w-full max-w-3xl mx-auto p-8">
        @php
        $index = 0;
        @endphp
        @foreach ($templates as $template)
        <button onclick="openPreview('template{{$index++}}')" type="button" class="bg-[#f6f1e3] text-[#20252f] hover:bg-[#20252f] hover:text-white px-4 py-2 rounded shadow">Template {{$template->title}}</button>
        @endforeach
    </div>

    @for ($i = 0; $i < count($templates); $i++)
        <div class="mt-12 hidden" id="template{{$i}}">
        <div class="flex justify-between mb-3">
            <h1 class="font-bold text-2xl">Template {{$templates[$i]->title}}</h1>
            <form action="{{route('templates.destroy', ['template' => $templates[$i]])}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="bg-[#ae0001] hover:bg-[#740001] text-white text-sm px-4 py-1 rounded">Delete</button>
            </form>
        </div>
        <iframe id="templatePDF" class="w-full h-[1200px]" src="{{asset('asset/' . $templates[$i]->file)}}" frameborder="0"></iframe>
</div>
@endfor

<!-- Modal Background
                <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden"> -->
<!-- Modal Content -->
<!-- <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center"> -->
<!-- <h2 class="text-xl font-semibold mb-4">Konfirmasi Unduh File</h2> -->
<!-- <p class="text-gray-700 mb-6">Apakah Anda ingin mengunduh file ini?</p>
                        <div class="flex justify-center space-x-4"> -->
<!-- <button onclick="confirmDownload()" class="bg-[#002366] text-white px-4 py-2 rounded hover:bg-[#20252f]">Iya</button> -->
<!-- <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-800">Tidak</button> -->
<!-- </div>
                    </div> -->
<!-- </div> -->



<!-- File Upload Modal -->
<div id="uploadModal" class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center" onclick="closeUploadModal()">
    <div class="bg-white p-6 rounded-lg w-96" onclick="event.stopPropagation()">
        <h2 class="text-xl font-bold mb-4">Upload File</h2>
        <form id="fileUploadForm" action="{{route('templates.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="fileName" class="block text-sm font-medium text-gray-700 mb-1">Nama File:</label>
            <input type="text" name="fileName" id="fileName" class="w-full border border-gray-300 rounded p-2 mb-4" placeholder="Masukkan nama file">

            <label class="block text-sm font-medium text-gray-700 mb-1">File:</label>
            <span class="sr-only">Choose File</span>
            <input type="file" id="fileInput"
                class="block w-full text-sm rounded-lg text-gray-700 file:mr-4 file:py-2 file:px-4
                             file:rounded-lg file:border-0
                             file:text-sm file:font-semibold
                             file:bg-[#002366] file:text-white
                             hover:file:bg-[#20252f]"
                name="file" accept=".pdf" onchange="displayFileName()" />
            </label>
            <div class="mt-6 text-right">
                <button type="button" class="bg-gray-600 hover:bg-gray-800 text-white px-4 py-2 rounded mr-2" onclick="closeUploadModal()">Cancel</button>
                <button type="submit" class="bg-[#002366] hover:bg-[#20252f] text-white px-4 py-2 rounded">Upload</button>
            </div>
        </form>
    </div>
</div>
</div>

@endsection

@section('libraryjs')
<script>
    var previewArray = [];

    function openUploadModal() {
        document.getElementById('uploadModal').classList.remove('hidden');
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
    }

    function handleFileDrop(event) {
        event.preventDefault();
        openUploadModal();

        const file = event.dataTransfer.files[0];
        document.getElementById('fileInput').files = event.dataTransfer.files;
        document.getElementById('fileName').value = file.name;
    }

    function displayFileName() {
        const fileInput = document.getElementById('fileInput');
        document.getElementById('fileName').value = fileInput.files[0].name;
    }

    function uploadFile() {
        const fileName = document.getElementById('fileName').value;
        const fileInput = document.getElementById('fileInput').files[0];

        if (fileName && fileInput) {
            alert(`File "${fileName}" uploaded successfully.`);
            closeUploadModal();
        } else {
            alert('Please provide a file name and select a file.');
        }
    }
    let downloadUrl = '';

    function showModal(url) {
        downloadUrl = url;
        document.getElementById('modal').classList.remove('hidden');
    }

    // function confirmDownload() {
    //     if (downloadUrl) {
    //         window.location.href = downloadUrl;
    //     }
    //     closeModal();
    // }

    function openPreview(templateID) {
        document.getElementById(templateID).classList.remove('hidden');
        if (!(previewArray[0] == null)) {
            document.getElementById(previewArray[0]).classList.add('hidden');
            previewArray = [];
        }
        previewArray.push(templateID);
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        downloadUrl = '';
    }
</script>
@endsection