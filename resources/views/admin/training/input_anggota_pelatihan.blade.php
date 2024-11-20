@extends('base/admin_navbar')

@section('content')
@php
use Carbon\Carbon;
$accounts = App\Models\Account::all();
@endphp

<header class="mt-16 p-8">
    <div class="grid">
        <h1 class="text-2xl font-bold text-[#20252f]">Input Anggota Pelatihan</h1>

        <!-- Input Button -->
        <button id="addButton" class="px-6 py-2 bg-[#002366] hover:bg-[#20252f] text-white rounded-lg justify-self-end">+ Add</button>
    </div>
    
    {{-- <div class="flex items-center justify-center">
        <div class="w-64 h-64 bg-gray-200 border-2 border-dashed border-gray-400 flex flex-col justify-center items-center rounded-lg cursor-pointer hover:bg-gray-300 transition duration-300"
            onclick="openModal('modalJadwal')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <p class="mt-4 text-gray-600 font-semibold">Add new</p>
        </div>
    </div> --}}
</header>

{{-- @foreach ($misas as $misa) --}}
<div class="bg-[#f6f1e3] rounded-lg shadow-lg p-6 mx-16 mb-8 misa-card">
    <div class="flex justify-between">
        <!-- Schedule Card -->
        <div class="flex-1 basis-1/4">
            <div class="flex items-start space-x-4">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold">
                        Kelompok 1
                    </h2>
                </div>
            </div>
        </div>

        <!-- Task Assignment Section -->
        <div class="flex-1 basis-3/4 bg-white p-4 rounded-lg">
            <h3 class="text-[#20252f] font-semibold border-b pb-2">ANGGOTA</h3>
            <div class="grid grid-cols-2 gap-4 mt-2">
                <ul class="text-gray-600 mt-2 grid grid-flow-col grid-rows-2 gap-x-4 gap-y-1">
                    <li>Nama1</li>
                    <li>Nama1</li>
                    <li>Nama1</li>
                    <li>Nama1</li>
                    <li>Nama1</li>
                    <li>Nama1</li>
                    <li>Nama1</li>
                    <li>Nama1</li>
                    <li>Nama1</li>
                    
                </ul>
            </div>
        </div>
    </div>
    <div class="flex justify-end space-x-4 mt-4">
        <button id="editButton" class="px-6 py-2 bg-[#002366] hover:bg-[#20252f] text-white rounded-lg">Edit</button>
        <form action="#" method="post">
            <button class="px-4 py-2 bg-[#ae0001] hover:bg-[#740001] text-white rounded-lg">Delete</button>
        </form>
    </div>
</div>


<!-- Modal Tambah Kelompok -->
<div id="addModal" class="hidden fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50">
    <div class="bg-[#f6f1e3] p-8 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-semibold mb-4">Tambah Kelompok</h3>

        <!-- Form for submitting anggota data -->
        {{-- <form id="addAnggotaForm-{{ $misa->id }}" action="{{ route('misas.addAnggota', ['misa' => $misa->id]) }}" method="POST"> --}}
            {{-- @csrf --}}

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Nama Kelompok</label>
                <input type="text"class="mt-1 p-2 w-full border border-gray-300 rounded-md" placeholder="Input Nama Kelompok">
            </div>

            <!-- Nama Dropdown -->
            <div>
                <label class="block text-sm mt-4 font-medium text-gray-700">Nama Anggota</label>
                <select class="block appearance-none w-full p-2 border border-gray-300 rounded-md bg-white">
                    <option>Nama1</option>
                    <option>Nama2</option>
                    <option>Nama3</option>
                    <option>Nama4</option>
                    <option>Nama5</option>
                </select>
                </select>
            </div>

            <button type="button" class="w-full bg-[#740001] mt-2 text-white py-2 rounded-lg hover:bg-[#20252f] transition-all duration-300">
                Tambah Anggota
            </button>

            <!-- Table to show added anggota -->
            <div class="mt-6 overflow-y-auto max-h-60">
                <h3 class="text-lg font-semibold">Daftar Anggota</h3>
                <table class="w-full mt-2 table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-1 py-1">No.</th>
                            <th class="border border-gray-300 px-6 py-1">Nama</th>
                            <th class="border border-gray-300 px-1 py-1">Wilayah</th>
                            {{-- <th class="border border-gray-300 px-4 py-1">Tugas</th> --}}
                            <th class="border border-gray-300 py-1">Action</th>
                        </tr>
                    </thead>
                    <tbody id="anggotaTableBody">
                        <!-- Table rows will be added here -->
                    </tbody>
                </table>
            </div>

            <div class="bg-[#f6f1e3] py-3 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#002366] text-base font-medium text-white hover:bg-[#20252f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Save
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" id="cancelButton" >
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kelompok Pelatihan-->
<div id="editModal" class="hidden fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50">
    <div class="bg-[#f6f1e3] p-8 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-semibold mb-4">Edit Kelompok 1</h3>

        <!-- Form for submitting anggota data -->
        {{-- <form id="addAnggotaForm-{{ $misa->id }}" action="{{ route('misas.addAnggota', ['misa' => $misa->id]) }}" method="POST"> --}}
            {{-- @csrf --}}

            {{-- <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Nama Kelompok</label>
            </div> --}}

            <!-- Nama Dropdown -->
            <div>
                <label class="block text-sm mt-4 font-medium text-gray-700">Nama Anggota</label>
                <table class="w-full mt-2 table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-1 py-1">No.</th>
                            <th class="border border-gray-300 px-6 py-1">Nama</th>
                            <th class="border border-gray-300 px-1 py-1">Wilayah</th>
                            <th class="border border-gray-300 py-1">Action</th>
                        </tr>
                    </thead>
                    <tbody id="anggotaTableBody">
                        <tbody id="anggotaTableBody">
                            <tr>
                                <td>1</td>
                                <td>Nama1</td>
                                <td>XXX</td>
                                <td class="border border-gray-300 py-1">
                                    <button type="button" class="delete-btn">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Nama2</td>
                                <td>XXX</td>
                                <td class="border border-gray-300 py-1">
                                    <button type="button" class="delete-btn">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Nama3</td>
                                <td>XXX</td>
                                <td class="border border-gray-300 py-1">
                                    <button type="button" class="delete-btn">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Nama4</td>
                                <td>XXX</td>
                                <td class="border border-gray-300 py-1">
                                    <button type="button" class="delete-btn">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </tbody>
                </table>
            </div>

            <!-- Nama Dropdown -->
            <div>
                <label class="block text-sm mt-4 font-medium text-gray-700">Nama Anggota</label>
                <select class="block appearance-none w-full p-2 border border-gray-300 rounded-md bg-white">
                    <option>Nama1</option>
                    <option>Nama2</option>
                    <option>Nama3</option>
                    <option>Nama4</option>
                    <option>Nama5</option>
                </select>
                </select>
            </div>

            <button type="button" class="w-full bg-[#740001] mt-2 text-white py-2 rounded-lg hover:bg-[#20252f] transition-all duration-300">
                Tambah Anggota
            </button>

            <div class="bg-[#f6f1e3] py-3 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#002366] text-base font-medium text-white hover:bg-[#20252f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Save
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" id="cancelButton" >
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const addButton = document.getElementById('addButton');
    const addModal = document.getElementById('addModal');
    const cancelButton = document.getElementById('cancelButton');
    const editButton = document.getElementById('editButton');
    const editModal = document.getElementById('editModal');

    // Event untuk membuka modal Add
    addButton.addEventListener('click', () => {
        addModal.classList.remove('hidden');
        addModal.classList.add('flex');
    });

    // Event untuk membuka modal Edit
    editButton.addEventListener('click', () => {
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
    });

    // Fungsi untuk menutup modal
    function closeModal() {
        addModal.classList.remove('flex');
        addModal.classList.add('hidden');
    }

    // Event listener pada tombol Cancel
    cancelButton.addEventListener('click', closeModal);

    // Menutup modal saat klik di luar area modal untuk addModal
    addModal.addEventListener('click', (e) => {
        if (e.target === addModal) {
            closeModal(); // hanya menutup addModal
        }
    });

    // Menutup modal saat klik di luar area modal untuk editModal
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            closeModal(); // hanya menutup editModal
        }
    });

    // Add delete button functionality
    row.querySelector('.delete-btn').addEventListener('click', function() {
        // Enable the previously selected option in the dropdown
        option.disabled = false;

        // Remove the row from the table
        tableBody.removeChild(row);

        // Find and remove the corresponding value in selectedOptionsArray
        const index = selectedOptionsArray.indexOf(namaSelect.value);
        if (index > -1) {
            selectedOptionsArray.splice(index, 1);
            selectedOptionsArray2.splice(index, 1); // Remove the corresponding tugas entry
        }

        // Update the hidden inputs
        selectedOptionsInput.value = JSON.stringify(selectedOptionsArray);
        selectedOptionsInput2.value = JSON.stringify(selectedOptionsArray2);

        // Update the row numbers
        updateRowNumbers();
    });
</script>
@endsection