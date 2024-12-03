@extends('base/anggota_navbar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-center mb-6">Saldo Anda</h1>

    <div class="bg-[#f6f1e3] p-6 rounded-xl shadow-lg border border-[#002366] mb-6">
        <h2 class="text-lg font-semibold">Saldo Tersisa</h2>

        @if($saldo)
            <p class="text-4xl">Rp {{ number_format($saldo->amount, 0, ',', '.') }}</p>
        @else
            <p class="mt-2 text-red-500">Anda belum memiliki saldo.</p>
        @endif

        <!-- Button to trigger modal -->
        <button 
            class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-4 hover:bg-blue-800"
            onclick="openModal()">
            Update Saldo
        </button>
    </div>
</div>

<!-- Modal -->
<div id="updateSaldoModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Tambah Saldo</h2>

        <form action="{{ route('saldo.update', ['accountId' => $saldo->account_id ?? Auth::id()]) }}" method="POST">
    @csrf
    @method('PUT') <!-- Add this line to specify a PUT request -->
    <div class="mb-4">
        <label for="amount" class="block text-gray-700">Jumlah Top Up:</label>
        <input 
            type="number" 
            name="amount" 
            id="amount" 
            class="w-full border-gray-300 rounded-lg p-2 mt-1" 
            placeholder="Masukkan jumlah top-up" 
            required>
    </div>
    <div class="flex justify-end gap-2">
        <button 
            type="button" 
            class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-600"
            onclick="closeModal()">
            Batal
        </button>
        <button 
            type="submit" 
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
            Tambah Saldo
        </button>
    </div>
</form>

    </div>
</div>

<script>
    function openModal() {
        document.getElementById('updateSaldoModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('updateSaldoModal').classList.add('hidden');
    }
</script>
@endsection
