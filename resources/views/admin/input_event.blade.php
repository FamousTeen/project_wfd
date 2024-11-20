@extends('base/admin_navbar')

@section('content')
<!-- Colors:
                1. #740001 - merah gelap
                2. #ae0001 - merah terang
                3. #f6f1e3 - netral
                4. #002366 - biru terang
                5. #20252f - biru gelap
            -->

<div class="container mx-auto mt-20">
    <h2 class="ml-4 p-6 mt-4 text-2xl font-semibold">Input Acara Misdinar</h2>
        @if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
        role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>



<div class="max-w-full mx-auto px-16 rounded-lg">
    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Left Column: Data Acara Section -->
        <div class="bg-[#f6f1e3] p-6 rounded-lg">
            <h3 class="text-xl font-bold mb-4">Data Acara</h3>
            <form method="post" action="{{route('events.store')}}" class="grid grid-cols-1 gap-4" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium">Nama Acara</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="flex space-x-4">
                    <div>
                        <label for="date" class="block text-sm font-medium">Tanggal</label>
                        <input type="date" name="date" id="date" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium">Jam Mulai</label>
                        <input type="time" name="start_time" id="start_time" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="finished_time" class="block text-sm font-medium">Jam Selesai</label>
                        <input type="time" name="finished_time" id="finished_time" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                </div>
                <div>
                    <label for="place" class="block text-sm font-medium">Tempat</label>
                    <input type="text" name="place" id="place" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="flex space-x-4">
                    <div>
                        <label for="contact_person" class="block text-sm font-medium">Contact Person</label>
                        <input type="text" name="contact_person" id="contact_person" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="phone_number" class="block text-sm font-medium">No. Telepon</label>
                        <input type="text" id="phone_number" name="phone_number" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium">Narasi Singkat</label>
                    <textarea id="description" class="mt-1 block w-full border-gray-300 rounded-md h-24" oninput="readTextarea()"></textarea>
                    <input type="hidden" name="description" id="eventDesc" required></input>
                </div>
        </div>

        <!-- Right Column: Poster Acara and Pengurus Acara Section -->
        <div class="grid grid-cols-1 gap-2">
            <div>
                <div class="bg-[#f6f1e3] p-6 rounded-lg h-56 relative">
                    <h3 class="text-xl font-bold absolute top-4 left-6">Poster Acara</h3>
                    <div class="flex items-center justify-center h-36 mt-8">
                        <label for="file-upload-poster" class="border-2 border-dashed border-gray-400 rounded-lg p-4 text-gray-600 flex flex-col items-center justify-center cursor-pointer w-full h-full">
                            <svg id="upload-icon-poster" class="w-10 h-10 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span id="upload-text-poster">Tekan untuk unggah foto</span>
                            <input id="file-upload-poster" name="poster" type="file" class="hidden" accept=".jpg, .png, .jpeg" onchange="handleFileUploadPoster(event)" required />
                            <span id="file-name-poster" class="hidden mt-2 text-gray-800 font-semibold"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Pengurus Acara -->
            <div class="bg-[#f6f1e3] p-6 rounded-lg grid grid-cols-2 gap-4" id="">
                <div class="pengurus">
                    <label for="chief" class="block text-sm font-medium">Ketua Acara</label>
                    <select id="chief" name="chief" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option selected>Pilih Nama Ketua</option>
                        @foreach ($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}} - {{$account->region}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pengurus">
                    <label for="chief2" class="block text-sm font-medium">Wakil Ketua Acara</label>
                    <select id="chief2" name="chief2" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option selected>Pilih Nama Wakil Ketua</option>
                        @foreach ($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}} - {{$account->region}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pengurus">
                    <label for="secretary" class="block text-sm font-medium">Sekretaris 1</label>
                    <select id="secretary" name="secretary" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option selected>Pilih Nama Sekretaris</option>
                        @foreach ($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}} - {{$account->region}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pengurus">
                    <label for="secretary2" class="block text-sm font-medium">Sekretaris 2</label>
                    <select id="secretary2" name="secretary2" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option selected>Pilih Nama Sekretaris 2</option>
                        @foreach ($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}} - {{$account->region}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pengurus">
                    <label for="treasurer" class="block text-sm font-medium">Bendahara 1</label>
                    <select id="treasurer" name="treasurer" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option selected>Pilih Nama Bendahara</option>
                        @foreach ($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}} - {{$account->region}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pengurus">
                    <label for="treasurer2" class="block text-sm font-medium">Bendahara 2</label>
                    <select id="treasurer2" name="treasurer2" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option selected>Pilih Nama Bendahara 2</option>
                        @foreach ($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}} - {{$account->region}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Anggota Panitia and Rundown Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <input type="hidden" name="selectedCommittee[]" id="selectedCommitteeInput">
        <input type="hidden" name="selectedDivision[]" id="selectedDivisionInput">
        <!-- Anggota Panitia -->
        <div class="bg-[#f6f1e3] h-72 p-6 rounded-lg">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Anggota Panitia</h2>
                <button type="button" onclick="openModal()" class="bg-[#002366] hover:bg-[#20252f] text-white text-sm px-4 py-1 rounded">Tambah +</button>
            </div>

            <div class="no-scrollbar overflow-y-auto max-h-52">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b-2 border-black">
                            <th class="pb-2">Nama</th>
                            <th class="pb-2">Wilayah</th>
                            <th class="pb-2">Divisi</th>
                            <th class="pb-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-committee-content">
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Rundown Upload -->
        <div class="grid grid-cols-1 gap-2">
            <div>
                <div class="bg-[#f6f1e3] p-6 rounded-lg h-72 relative">
                    <h3 class="text-xl font-bold absolute top-4 left-6">Rundown Acara</h3>
                    <div class="flex items-center justify-center h-52 mt-8">
                        <label for="file-upload" class="border-2 border-dashed border-gray-400 rounded-lg p-4 text-gray-600 flex flex-col items-center justify-center cursor-pointer w-full h-full">
                            <svg id="upload-icon" class="w-10 h-10 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span id="upload-text">Tekan untuk unggah foto</span>
                            <input id="file-upload" name="rundown_image" type="file" class="hidden" accept=".jpg, .png, .jpeg" onchange="handleFileUpload(event)" required />
                            <span id="file-name" class="hidden mt-2 text-gray-800 font-semibold"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <!-- Akses Input Section -->
        <div class="bg-[#f6f1e3] h-72 p-6 rounded-lg">
            <input type="hidden" name="selectedAdmin[]" id="selectedAdminInput">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold">Akses Input</h2>
                <button type="button" onclick="openSearchModal()" class="bg-[#002366] hover:bg-[#20252f] text-white text-sm px-4 py-1 rounded">Tambah +</button>
            </div>
            <div class="no-scrollbar overflow-y-auto max-h-52">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b-2 border-black">
                            <th class="pb-2">Nama</th>
                            <th class="pb-2">Wilayah</th>
                            <th class="pb-2">Email</th>
                            <th class="pb-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-admin-content"></tbody>
                </table>
            </div>
        </div>


        <!-- Jadwal Rapat Input Section -->
        <div class="bg-[#f6f1e3] h-72 p-6 rounded-lg">
            <input type="hidden" name="selectedRapat[]" id="selectedRapatInput">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold">Jadwal Rapat</h2>
                <button type="button" onclick="openRapatModal()" class="bg-[#002366] hover:bg-[#20252f] text-white text-sm px-4 py-1 rounded">Tambah +</button>
            </div>
            <div class="no-scrollbar overflow-y-auto max-h-52">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b-2 border-black">
                            <th class="pb-2">Kegiatan</th>
                            <th class="pb-2">Tanggal & Waktu</th>
                            <th class="pb-2">Tempat</th>
                            <th class="pb-2"></th>
                        </tr>
                    </thead>
                    <tbody id="rapat-table-body">
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Save Button -->
        <div class="text-center col-span-2 mt-4 mb-12">
            <button type="submit" class="bg-[#002366] hover:bg-[#20252f] w-64 text-white px-6 py-3 rounded-md">Simpan</button>
        </div>
        </form>


        <!-- Panitia Modal -->
        <div id="myModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" style="z-index: 1000;">
            <div class="bg-white rounded-lg p-6 w-96">
                <h2 class="text-xl font-bold mb-4">Tambah Anggota Panitia</h2>
                <div class="mb-4 pengurus">
                    <label for="name-dropdown1" class="block text-sm font-medium">Nama</label>
                    <select id="name-dropdown1" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option selected>Pilih Nama Anggota</option>
                        @foreach ($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}} - {{$account->region}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="divisi-input" class="block text-sm font-medium">Divisi</label>
                    <input type="text" id="divisi-input" class="mt-1 block w-full border-gray-300 rounded-md">
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded mr-2">Batal</button>
                    <button type="button" onclick="addAnggota()" class="bg-[#002366] hover:bg-[#20252f] text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Search Modal -->
        <div id="searchModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" style="z-index: 1000;">
            <div class="bg-white rounded-lg p-6 w-96 h-64">
                <h2 class="text-xl font-bold mb-4">Akses Input</h2>
                <div class="mb-4">
                    <label for="name-dropdown2" class="block text-sm font-medium">Nama</label>
                    <select id="name-dropdown2" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option selected>Pilih Nama Admin</option>
                        @foreach ($admins as $admin)
                        <option value="{{$admin->id}}">{{$admin->name}} - {{$admin->region}} - {{$admin->email}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="addAdmin()" class="bg-[#002366] hover:bg-[#20252f] text-white mt-8 px-4 py-2 rounded">Tambah</button>
                    <button type="button" onclick="closeSearchModal()" class="bg-gray-300 hover:bg-gray-400 text-black mt-8 px-4 py-2 rounded ml-2">Batal</button>
                </div>
            </div>
        </div>

        <!-- Rapat Input Modal -->
        <div id="rapatModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" style="z-index: 1000;">
            <div class="bg-white rounded-lg p-6 w-96">
                <h2 class="text-xl font-bold mb-4" id="rapat-modal-title">Tambah Jadwal Rapat</h2>
                <div class="mb-4">
                    <label for="kegiatan" class="block text-sm font-medium">Kegiatan</label>
                    <input type="text" id="kegiatan" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="tanggal" class="block text-sm font-medium">Tanggal</label>
                    <input type="date" id="tanggal" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="waktu" class="block text-sm font-medium">Waktu</label>
                    <input type="time" id="waktu" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="lokasi" class="block text-sm font-medium">Lokasi</label>
                    <input type="text" id="lokasi" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium">Catatan</label>
                    <textarea id="catatan" class="mt-1 block w-full border-gray-300 rounded-md" rows="3"></textarea>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="addRapat()" class="bg-[#002366] hover:bg-[#20252f] text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" onclick="closeRapatModal()" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded ml-2">Batal</button>
                </div>
            </div>
        </div>

        <!-- Rapat Edit Modal -->
        <div id="rapatEditModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden" style="z-index: 1000;">
            <div class="bg-white rounded-lg p-6 w-96">
                <h2 class="text-xl font-bold mb-4" id="rapat-modal-title2">Edit Jadwal Rapat</h2>
                <div class="mb-4">
                    <label for="kegiatanEdit" class="block text-sm font-medium">Kegiatan</label>
                    <input type="text" id="kegiatanEdit" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="tanggalEdit" class="block text-sm font-medium">Tanggal</label>
                    <input type="date" id="tanggalEdit" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="waktuEdit" class="block text-sm font-medium">Waktu</label>
                    <input type="time" id="waktuEdit" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="lokasiEdit" class="block text-sm font-medium">Lokasi</label>
                    <input type="text" id="lokasiEdit" class="mt-1 block w-full border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="catatanEdit" class="block text-sm font-medium">Catatan</label>
                    <textarea id="catatanEdit" class="mt-1 block w-full border-gray-300 rounded-md" rows="3"></textarea>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" id="saveEditRapat" class="bg-[#002366] hover:bg-[#20252f] text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" onclick="closeRapatModal2()" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded ml-2">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('libraryjs')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        var commmitteeArray = [];
        var divisiArray = [];
        var adminArray = [];
        var rapatArray = [];

        function readTextarea() {
            const textareaValue = document.getElementById('description').value;
            document.getElementById('eventDesc').value = encodeURIComponent(textareaValue);
            console.log(document.getElementById('eventDesc').value);
        }

        document.addEventListener("DOMContentLoaded", () => {
            const selectElements = document.querySelectorAll(".pengurus select");

            selectElements.forEach(select => {
                select.addEventListener("change", () => {
                    updateOptions();
                });
            });

            function updateOptions() {
                const selectedValues = Array.from(selectElements)
                    .map(select => select.value)
                    .filter(value => !value.includes("Pilih Nama"));

                selectElements.forEach(select => {
                    Array.from(select.options).forEach(option => {
                        option.disabled = false;
                    });
                });

                // Disable options based on selected values
                selectElements.forEach(select => {
                    Array.from(select.options).forEach(option => {
                        if (selectedValues.includes(option.value) && select.value !== option.value) {
                            option.disabled = true;
                        }
                    });
                });
            }
        });


        function addAnggota() {
            var idPanitia = $('#name-dropdown1').val();
            var identitasPanitia = $('#name-dropdown1 option:selected').html();
            $('#name-dropdown1 option:selected').prop('disabled', true);
            var parts = identitasPanitia.split(" - ");
            var divisi = $('#divisi-input').val();


            var name = parts[0].trim();
            var region = parts[1].trim();

            $('#table-committee-content').html($('#table-committee-content').html() + `
                <tr id="row-${commmitteeArray.length}" class='border-b border-black'>
                    <td class='py-2'>${name}</td>
                    <td class='py-2'>${region}</td>
                    <td class='py-2'>${divisi}</td>
                    <td class='py-2'>
                        <button type="button" id="delete${commmitteeArray.length}" onclick="deleteRow(${commmitteeArray.length})" class="bg-[#ae0001] hover:bg-[#740001] text-white text-sm px-4 py-1 rounded">Delete</button>
                    </td>
                </tr>
            `);

            commmitteeArray.push(idPanitia);
            divisiArray.push(divisi);
            $('#selectedCommitteeInput').val(JSON.stringify(commmitteeArray));
            $('#selectedDivisionInput').val(JSON.stringify(divisiArray));
            console.log($('#selectedCommitteeInput').val, $('#selectedDivisionInput').val);
            $('#name-dropdown1').val('Pilih Nama Anggota')
            $('#divisi-input').val('')
            closeModal()
        }


        //button delete di list tabel anggota panitia
        function deleteRow(id) {

            var row = $(`#row-${id}`);
            row.remove();

            var selectElement = document.getElementById('name-dropdown1');
            var options = selectElement.options;

            console.log(options[0].value, commmitteeArray[id]);

            for (var i = 0; i < options.length; i++) {
                if (options[i].value == commmitteeArray[id]) {
                    options[i].disabled = false;
                    break;
                }
            }

            commmitteeArray[id] = null;
            divisiArray[id] = null;

            $('#selectedCommitteeInput').val(JSON.stringify(commmitteeArray));
            $('#selectedDivisionInput').val(JSON.stringify(divisiArray));
            console.log(commmitteeArray)
        }

        function addAdmin() {
            var idAdmin = $('#name-dropdown2').val();
            var identitasAdmin = $('#name-dropdown2 option:selected').html();
            $('#name-dropdown2 option:selected').prop('disabled', true);
            var parts = identitasAdmin.split(" - ");

            var name = parts[0].trim();
            var region = parts[1].trim();
            var email = parts[2].trim();

            $('#table-admin-content').html($('#table-admin-content').html() + `
                <tr id="row2-${adminArray.length}" class='border-b border-black'>
                    <td class='py-2'>${name}</td>
                    <td class='py-2'>${region}</td>
                    <td class='py-2'>${email}</td>
                    <td class='py-2'>
                        <button type="button" id="delete${adminArray.length}" onclick="deleteRow2(${adminArray.length})" class="bg-[#ae0001] hover:bg-[#740001] text-white text-sm px-4 py-1 rounded">Delete</button>
                    </td>
                </tr>
            `);

            adminArray.push(idAdmin);
            $('#selectedAdminInput').val(JSON.stringify(adminArray));
            $('#name-dropdown2').val('Pilih Nama admin')
            closeSearchModal()
        }


        //button delete di list tabel admin akses
        function deleteRow2(id) {

            var row = $(`#row2-${id}`);
            row.remove();

            var selectElement = document.getElementById('name-dropdown2');
            var options = selectElement.options;

            // console.log(options[0].value, adminArray[id]);

            for (var i = 0; i < options.length; i++) {
                if (options[i].value == adminArray[id]) {
                    options[i].disabled = false;
                    break;
                }
            }

            adminArray[id] = null;

            $('#selectedAdminInput').val(JSON.stringify(adminArray));
            console.log(adminArray);
        }

        // var index = 0;

        function addRapat() {
            const kegiatan = document.getElementById('kegiatan').value;
            const tanggal = document.getElementById('tanggal').value;
            const waktu = document.getElementById('waktu').value;
            const lokasi = document.getElementById('lokasi').value;
            const catatan = encodeURIComponent(document.getElementById('catatan').value);

            $('#rapat-table-body').html($('#rapat-table-body').html() + `
                <tr id="row3-${rapatArray.length}" class='border-b border-black'>
                    <td class='py-2'>${kegiatan}</td>
                    <td class='py-2'>${new Date(tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'numeric', year: 'numeric' })} ${waktu}</td>
                    <td class='py-2'>${lokasi}</td>
                    <td class='py-2 hidden'>${decodeURIComponent(catatan)}</td>
                    <td class="py-2">
                        <button type="button" id="editRapat${rapatArray.length}" onclick="editRapat(this, ${rapatArray.length})" class="bg-[#002366] hover:bg-[#20252f] text-white text-sm px-4 py-1 rounded">Edit</button>
                    </td>
                    <td class='py-2'>
                        <button type="button" id="delete${rapatArray.length}" onclick="deleteRow3(${rapatArray.length})" class="bg-[#ae0001] hover:bg-[#740001] text-white text-sm px-4 py-1 rounded">Delete</button>
                    </td>
                </tr>
            `);

            rapatArray.push([kegiatan, tanggal, waktu, lokasi, encodeURIComponent(catatan)]);
            $('#selectedRapatInput').val(JSON.stringify(rapatArray));
            console.log(rapatArray);
            closeRapatModal()
        }


        //button delete di list tabel rapat
        function deleteRow3(id) {
            var row = $(`#row3-${id}`);
            row.remove();

            rapatArray[id] = null;

            $('#selectedAdminInput').val(JSON.stringify(rapatArray));
            console.log(rapatArray);
        }


        let currentRow;

        function editRapat(button, id) {
            document.getElementById('rapatEditModal').classList.remove('hidden');

            currentRow = button.closest('tr');
            document.getElementById('kegiatanEdit').value = currentRow.cells[0].innerText;
            var dateTime = currentRow.cells[1].innerText.split(" ");

            var dateParts = dateTime[0].split('/');
            var formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;

            var timeParts = dateTime[1].split(':');
            var formattedTime = `${timeParts[0]}:${timeParts[1]}`;

            document.getElementById('tanggalEdit').value = formattedDate
            document.getElementById('waktuEdit').value = formattedTime;

            document.getElementById('lokasiEdit').value = currentRow.cells[2].innerText;
            document.getElementById('catatanEdit').value = decodeURIComponent(currentRow.cells[3].innerText);


            console.log(currentRow.cells[3].innerText)

            $('#saveEditRapat').on('click', function() {
                currentRow.cells[0].innerText = document.getElementById('kegiatanEdit').value;

                currentRow.cells[1].innerText = new Date(document.getElementById('tanggalEdit').value).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'numeric',
                    year: 'numeric'
                }) + " " + document.getElementById('waktuEdit').value;

                currentRow.cells[2].innerText = document.getElementById('lokasiEdit').value;

                currentRow.cells[3].innerText = encodeURIComponent(document.getElementById('catatanEdit').value);

                rapatArray[id] = [document.getElementById('kegiatanEdit').value, document.getElementById('tanggalEdit').value, document.getElementById('waktuEdit').value, document.getElementById('lokasiEdit').value, encodeURIComponent(document.getElementById('catatanEdit').value)];
                $('#selectedRapatInput').val(JSON.stringify(rapatArray));
                closeRapatModal2();

                console.log(rapatArray);
            });
        }

        function openModal() {
            document.getElementById('myModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('myModal').classList.add('hidden');
        }

        function openSearchModal() {
            document.getElementById('searchModal').classList.remove('hidden');
        }

        function closeSearchModal() {
            document.getElementById('searchModal').classList.add('hidden');
            document.getElementById('name-dropdown2').selectedIndex = 0;
        }

        function openRapatModal() {
            document.getElementById('rapatModal').
            classList.remove('hidden');
        }

        function closeRapatModal() {
            document.getElementById('rapatModal').classList.add('hidden');
        }

        function closeRapatModal2() {
            document.getElementById('rapatEditModal').classList.add('hidden');
        }

        // Handle file upload for Rundown Acara
        function handleFileUpload(event) {
            var fileInput = event.target;
            var fileNameSpan = document.getElementById('file-name');
            var uploadIcon = document.getElementById('upload-icon');
            var uploadText = document.getElementById('upload-text');

            // Check if file is selected
            if (fileInput.files.length > 0) {
                // Hide icon and text
                uploadIcon.style.display = 'none';
                uploadText.style.display = 'none';

                // Show file name
                var fileName = fileInput.files[0].name;
                fileNameSpan.textContent = fileName;
                fileNameSpan.style.display = 'block';
            }
        }

        // Handle file upload for Poster Acara
        function handleFileUploadPoster(event) {
            var fileInput = event.target;
            var fileNameSpan = document.getElementById('file-name-poster');
            var uploadIcon = document.getElementById('upload-icon-poster');
            var uploadText = document.getElementById('upload-text-poster');

            // Check if file is selected
            if (fileInput.files.length > 0) {
                // Hide icon and text
                uploadIcon.style.display = 'none';
                uploadText.style.display = 'none';

                // Show file name
                var fileName = fileInput.files[0].name;
                fileNameSpan.textContent = fileName;
                fileNameSpan.style.display = 'block';
            }
        }
    </script>
    @endsection