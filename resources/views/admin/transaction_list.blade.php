@extends('base.admin_navbar') <!-- Assuming this is your admin layout -->

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Semua Riwayat Transaksi</h1>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">No</th>
                <th class="border border-gray-300 px-4 py-2">Nama Akun</th>
                <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                <th class="border border-gray-300 px-4 py-2">Tipe</th>
                <th class="border border-gray-300 px-4 py-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $transaction)
            <tr class="text-center">
                <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $transaction->account->name ?? 'N/A' }}</td>
                <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ ucfirst($transaction->type) }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="border border-gray-300 px-4 py-2 text-center text-red-500">
                    Tidak ada transaksi yang ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $transactions->links() }} <!-- Pagination Links -->
    </div>
</div>
@endsection