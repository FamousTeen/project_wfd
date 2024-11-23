@extends('base/anggota_navbar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-center mb-6">Saldo Anda</h1>

    <div class="bg-[#f6f1e3] p-6 rounded-xl shadow-lg border border-[#002366]">
        <h2 class="text-lg font-semibold">Saldo Tersisa</h2>

        @if($saldo)
            <p class="mt-2 text-xl">Rp {{ number_format($saldo->amount, 0, ',', '.') }}</p>
        @else
            <p class="mt-2 text-red-500">Anda belum memiliki saldo.</p>
        @endif
    </div>
</div>
@endsection
