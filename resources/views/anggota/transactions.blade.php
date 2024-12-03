@extends('base/anggota_navbar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-center mb-6">Riwayat Transaksi</h1>

    <div class="bg-[#f6f1e3] p-6 rounded-xl shadow-lg border border-[#002366]">
        @if($transactions->isEmpty())
            <p class="text-center text-gray-500">Tidak ada transaksi.</p>
        @else
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Tipe</th>
                        <th class="border p-2">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td class="border p-2">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            <td class="border p-2">{{ ucfirst($transaction->type) }}</td>
                            <td class="border p-2">
                                {{ $transaction->type == 'credit' ? '+' : '-' }}
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection