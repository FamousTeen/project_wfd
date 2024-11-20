@extends('base/admin_navbar')

@section('content')
@php
use Carbon\Carbon;
$accounts = App\Models\Account::all();
@endphp

<header class="mt-16 p-8">
    <h1 class="text-2xl font-semibold text-[#20252f]">JADWAL MISA</h1>
    <div class="flex space-x-4 mt-4 ml-8">
        <!-- Status Filter Buttons -->
        <button class="px-4 py-2 rounded-lg bg-[#740001] text-white status-filter-button" data-status="all">Semua</button>
        <button class="px-4 py-2 bg-[#f6f1e3] rounded-lg hover:bg-[#740001] hover:text-white status-filter-button" data-status="Proses">Proses</button>
        <button class="px-4 py-2 bg-[#f6f1e3] rounded-lg hover:bg-[#740001] hover:text-white status-filter-button" data-status="Tertunda">Tertunda</button>
        <button class="px-4 py-2 bg-[#f6f1e3] rounded-lg hover:bg-[#740001] hover:text-white status-filter-button" data-status="Berhasil">Berhasil</button>
    </div>
</header>

@foreach ($misas as $misa)
<div class="bg-[#f6f1e3] rounded-lg shadow-lg p-6 mx-16 mb-8 misa-card" data-status="{{ $misa->status }}">
    <div class="flex justify-between">
        <!-- Schedule Card -->
        <div class="flex-1">
            <div class="flex items-start space-x-4">
                <div class="text-2xl">
                    <span class="bg-orange-500 h-5 w-5 rounded-full inline-block"></span>
                </div>
                <div class="flex-1">
                    <h2 class="text-lg font-semibold">
                        {{ Carbon::parse($misa->activity_datetime)->translatedFormat('j, F Y') }}
                    </h2>
                    <p class="text-gray-600">{{$misa->title}}</p>
                    <p class="text-gray-600">{{ Carbon::parse($misa->activity_datetime)->translatedFormat('H:i') }} WIB</p>
                    <p class="mt-2 flex items-center">
                        Status:
                        <span class="text-black ml-2">
                            @if ($misa->status == 'Proses')
                            <span class="text-green-500">{{$misa->status}} ✔</span> <!-- Green check for 'Proses' -->
                            @elseif ($misa->status == 'Tertunda')
                            <span class="text-yellow-500">{{$misa->status}} ✖</span> <!-- Yellow 'X' for 'Tertunda' -->
                            @elseif ($misa->status == 'Berhasil')
                            <span class="text-blue-500">{{$misa->status}} ✔</span> <!-- Blue check for 'Berhasil' -->
                            @else
                            <span class="text-gray-500">{{$misa->status}} ✖</span> <!-- Gray 'X' for any other status -->
                            @endif
                        </span>
                    </p>

                    <p class="text-gray-500 text-sm">
                        Berakhir pada: {{ Carbon::parse($misa->deadline_datetime)->translatedFormat('l, j-m-Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Task Assignment Section -->
        <div class="w-1/2 bg-white p-4 rounded-lg">
            <h3 class="text-[#20252f] font-semibold border-b pb-2">PETUGAS - PETUGAS</h3>
            <div class="grid grid-cols-2 gap-4 mt-2">
                @php
                $roles = $misa->misaDetails->pluck('roles')->unique();
                @endphp

                @foreach ($roles as $role)
                <div>
                    <h4 class="text-[#20252f] font-semibold">{{ $role }}</h4>
                    <ul class="text-gray-600">
                        @foreach ($misa->misaDetails->where('roles', $role) as $detail)
                        <li class="flex items-center">
                            <span class="mr-2 w-6">
                                @if ($detail->confirmation == 1) ✔
                                @elseif ($detail->confirmation == 0) ✖
                                @endif
                            </span>
                            {{ $detail->account->name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="flex justify-end space-x-4 mt-4">
        <button onclick="openEditModal('{{ $misa->id }}')" class="px-6 py-2 bg-[#002366] hover:bg-[#20252f] text-white rounded-lg">Edit</button>
        <form action="{{ route('misas.destroy', ['misa' => $misa]) }}" method="post">
            @csrf
            @method('delete')
            <button class="px-4 py-2 bg-[#ae0001] hover:bg-[#740001] text-white rounded-lg">Delete</button>
        </form>
    </div>
</div>


<!-- Anggota Section Modal for each misa -->
<div id="anggotaSection-{{ $misa->id }}" class="hidden fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h3 class="text-[#740001] font-semibold mb-4">Ubah Anggota</h3>

        <!-- Form for submitting anggota data -->
        <form id="addAnggotaForm-{{ $misa->id }}" action="{{ route('misas.addAnggota', ['misa' => $misa->id]) }}" method="POST">
            @csrf

            <!-- Nama Dropdown -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Anggota</label>

                @php
                // Get account IDs already in misaDetails
                $assignedAccountIds = $misa->misaDetails->pluck('account_id')->all();
                $unassignedAccounts = $accounts->whereNotIn('id', $assignedAccountIds); // Filtered list of unassigned accounts
                @endphp

                <select id="namaAnggota-{{ $misa->id }}" name="account_id" class="block appearance-none w-full p-2 border border-gray-300 rounded-md bg-white" @if($unassignedAccounts->isEmpty()) disabled @endif>
                    @if ($unassignedAccounts->isNotEmpty())
                    @foreach ($unassignedAccounts as $account)
                    <option value="{{ $account->id }}">{{ $account->name }} - {{ $account->region }} - {{ $account->tugas_count }} tugas</option>
                    @endforeach
                    @else
                    <option value="" disabled selected>No available members to assign</option>
                    @endif
                </select>
            </div>

            <!-- Tugas Selection -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Tugas</label>
                <select id="tugasAnggota-{{ $misa->id }}" name="role" class="block appearance-none w-full p-2 border border-gray-300 rounded-md bg-white">
                    <option value="Petugas">Petugas</option>
                    <option value="Pengawas">Pengawas</option>
                    <option value="Perlengkapan">Perlengkapan</option>
                    <option value="custom">Custom (Isi Manual)</option>
                </select>
            </div>



            <!-- Custom Task Input -->
            <div id="customTaskInput-{{ $misa->id }}" class="hidden mt-2">
                <label class="block text-sm font-medium text-gray-700">Tugas Custom</label>
                <input type="text" id="customTask-{{ $misa->id }}" name="custom_task" class="block w-full p-2 border border-gray-300 rounded-md" placeholder="Masukkan tugas...">
            </div>
        </form>

        <!-- Dynamic Role Column Section -->
        <div class="w-1/2 bg-white p-4 rounded-lg">
            <h3 class="text-[#20252f] font-semibold border-b pb-2">PETUGAS - PETUGAS</h3>
            <div class="grid grid-cols-2 gap-4 mt-2">
                @php
                $roles = $misa->misaDetails->pluck('roles')->unique();
                @endphp

                @foreach ($roles as $role)
                <div>
                    <h4 class="text-[#20252f] font-semibold">{{ $role }}</h4>
                    <ul class="text-gray-600">
                        @foreach ($misa->misaDetails->where('roles', $role) as $detail)
                        <li class="flex items-center">
                            <span class="mr-2 w-6">
                                @if ($detail->confirmation == 1)
                                ✔
                                @elseif ($detail->confirmation == 0)
                                ✖
                                @endif
                            </span>
                            {{ $detail->account->name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Action Buttons -->
        <div class="mt-4 flex justify-end space-x-4">
            <button class="px-6 py-2 bg-[#002366] hover:bg-[#20252f] text-white rounded-lg" onclick="closeAnggotaSection('{{ $misa->id }}')">Tutup</button>
            <button class="px-6 py-2 bg-[#ae0001] hover:bg-[#740001] text-white rounded-lg" onclick="addAnggota('{{ $misa->id }}')">Simpan</button>
        </div>
    </div>
</div>

@endforeach

<script>
    const headerButtons = document.querySelectorAll(".header-button");

    headerButtons.forEach(button => {
        button.addEventListener("click", () => {
            headerButtons.forEach(btn => {
                btn.classList.remove("bg-[#740001]", "text-white");
                btn.classList.add("bg-[#f6f1e3]");
            });

            button.classList.add("bg-[#740001]", "text-white");
            button.classList.remove("bg-[#f6f1e3]");
        });
    });

    function openEditModal(misaId) {
        document.getElementById("anggotaSection-" + misaId).classList.remove("hidden");
    }

    function closeAnggotaSection(misaId) {
        document.getElementById("anggotaSection-" + misaId).classList.add("hidden");
    }

    function addAnggota(misaId) {
        const selectedTugas = document.getElementById("tugasAnggota-" + misaId).value;
        const customTaskInput = document.getElementById("customTaskInput-" + misaId);
        const customTask = document.getElementById("customTask-" + misaId).value;

        // Set the custom task field only if custom task is chosen
        if (selectedTugas === "custom") {
            customTaskInput.querySelector("input").value = customTask;
        } else {
            customTaskInput.querySelector("input").value = ""; // Clear custom task input if another role is chosen
        }

        // Submit the form
        document.getElementById("addAnggotaForm-" + misaId).submit();
        closeAnggotaSection(misaId);
    }

    document.querySelectorAll(".status-filter-button").forEach(button => {
        button.addEventListener("click", function() {
            const selectedStatus = this.getAttribute("data-status"); // Get the status to filter
            const misaCards = document.querySelectorAll(".misa-card"); // Get all misa cards

            // Toggle the button styles (active vs non-active)
            document.querySelectorAll(".status-filter-button").forEach(btn => {
                btn.classList.remove("bg-[#740001]", "text-white");
                btn.classList.add("bg-[#f6f1e3]");
            });

            this.classList.add("bg-[#740001]", "text-white");
            this.classList.remove("bg-[#f6f1e3]");

            misaCards.forEach(card => {
                const cardStatus = card.getAttribute("data-status"); // Get the status of the misa

                // If the selected status is 'all', show all cards
                if (selectedStatus === "all" || cardStatus === selectedStatus) {
                    card.classList.remove("hidden");
                } else {
                    card.classList.add("hidden");
                }
            });
        });
    });


    document.getElementById("tugasAnggota").addEventListener("change", function() {
        if (this.value === "custom") {
            document.getElementById("customTaskInput").classList.remove("hidden");
        } else {
            document.getElementById("customTaskInput").classList.add("hidden");
        }
    });
</script>

@endsection