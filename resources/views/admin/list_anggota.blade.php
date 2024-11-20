@extends('base/admin_navbar')

@section('content')
    <!-- Colors:
                                                1. #740001 - merah gelap
                                                2. #ae0001 - merah terang
                                                3. #f6f1e3 - netral
                                                4. #002366 - biru terang
                                                5. #20252f - biru gelap
                                            -->

    <?php use App\Models\Misa_Detail; ?>
    <div class="container mx-auto p-20 mt-8 mb-8 flex flex-col items-center">
        <div class="grid grid-cols-12">
            <div class="col-start-4 col-span-6 mt-8">
                <h2 class="font-bold text-3xl text-center">Anggota Misdinar</h2>
            </div>
        </div>

        <div class="flex flex-col w-full place-items-center">
            {{-- Search --}}
            <div class="flex w-full justify-between sm:w-[600px] md:w-[750px] lg:w-[1150px] mt-10">
                <div class="flex flex-row justify-items mt-5text-gray-500">
                    <div class="mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>

                    <form class="sm:w-[300px] md:w-[300px] lg:w-[300px]">
                        <div class="flex items-center border-b border-grey-500 py-2">
                            <input
                                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                                type="text" placeholder="search" aria-label="Full name">
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel --}}
            <div
                class="relative overflow-x-auto shadow-md sm:rounded-md sm:w-[600px] md:w-[750px] lg:w-[1150px] mt-10 content-center">
                <table class="min-w-full text-sm text-left rtl:text-right text-black" style="table-layout: auto;">
                    <thead class="text-md text-black uppercase bg-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Address
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Birthdate
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Region
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Bertugas
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_anggota as $l)
                            <tr class="odd:bg-white even:bg-gray-100 border-b hover:odd:bg-gray-200 hover:even:bg-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                                    {{ $l->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $l->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $l->address }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $l->birth_place_date }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $l->region }}
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                    $count = Misa_Detail::get()
                                        ->where('account_id', $l->id)
                                        ->count();
                                    ?>
                                    {{ $count }}
                                </td>
                                @if ($l->status == 0)
                                    <td class="px-6 py-4" id="statusCell">
                                        Inactive
                                    </td>
                                @else
                                    <td class="px-6 py-4" id="statusCell">
                                        Active
                                    </td>
                                @endif
                                <td class="px-6 py-4">
                                    <div class="flex flex-row gap-2">
                                        <button
                                            class="bg-[#002366] text-white py-1 px-2 rounded-md hover:bg-[#20252f] transition-all duration-300 text-sm mt-2"
                                            onclick="openModal('modal{{ $l->id }}')">Edit</button>
                                        <form action="{{ route('delete_anggota', $l->id) }}" method="GET">
                                            @csrf
                                            <button
                                                class="bg-[#ae0001] text-white py-1 px-2 rounded-md hover:bg-[#740001] transition-all duration-300 text-sm mt-2">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            {{-- Modal 1 --}}
                            <div id="modal{{ $l->id }}"
                                class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center"
                                onclick="closeModal('modal{{ $l->id }}')">
                                <div class="bg-[#f6f1e3] p-8 rounded-lg w-[500px] h-[400px] relative p-12"
                                    onclick="event.stopPropagation()">
                                    <button class="absolute top-4 right-4 text-black"
                                        onclick="closeModal('modal{{ $l->id }}')">
                                        &#10005;
                                    </button>
                                    <div class="text-left px-10">
                                        <div class="flex flex-col">
                                            <p class="font-bold text-xl">Nama: </p>
                                            <p class="font-semibold">{{ $l->name }}</p>
                                        </div>
                                        <div class="flex flex-col mt-5">
                                            <p class="font-bold text-xl">Email: </p>
                                            <p class="font-semibold">{{ $l->email }}</p>
                                        </div>
                                        <div class="flex flex-col mt-5">
                                            <p class="font-bold text-xl">Region: </p>
                                            <p class="font-semibold">{{ $l->region }}</p>
                                        </div>
                                        <div class="flex flex-col mt-5">
                                            <p class="font-bold text-xl">Bertugas: </p>
                                            <p class="font-semibold">{{ $count }}</p>
                                        </div>
                                        <div class="flex flex-col mt-5">
                                            <p class="font-bold text-xl">Status: </p>
                                            <div class="flex flex-row m">
                                                @if ($l->status == 0)
                                                    <p id="statusLabel">Inactive</p>
                                                    <label class="inline-flex items-center cursor-pointer ms-5">
                                                        <input type="checkbox" name="status" class="sr-only peer"
                                                            id="statusToggle" onchange="update('{{ $l->id }}')">
                                                        <div
                                                            class="relative w-14 h-7 bg-[#740001] peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#002366] dark:peer-focus:ring-[#002366] rounded-full peer dark:bg-[#740001] peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-[#002366] duration-700">
                                                        </div>
                                                    </label>
                                                @else
                                                    <p id="statusLabel">Active</p>
                                                    <label class="inline-flex items-center cursor-pointer ms-5">
                                                        <input type="checkbox" name="status" class="sr-only peer"
                                                            id="statusToggle" onchange="update('{{ $l->id }}')" checked>
                                                        <div
                                                            class="relative w-14 h-7 bg-[#740001] peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#002366] dark:peer-focus:ring-[#002366] rounded-full peer dark:bg-[#740001] peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-[#002366] duration-700">
                                                        </div>
                                                    </label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function update(id) {
            var url = '{{ url('') }}/update_status_anggota/' + id;
            $.ajax({
                url: url,
                success: function(result) {
                    if (result == 0) {
                        document.getElementById('statusLabel').innerHTML = "Inactive";
                        document.getElementById('statusCell').innerHTML = "Inactive";
                    } else {
                        document.getElementById('statusLabel').innerHTML = "Active";
                        document.getElementById('statusCell').innerHTML = "Active";
                    }
                }
            });
        }

        // Modal open function
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        // Modal close function
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
@endsection
