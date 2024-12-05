@extends('base/anggota_navbar')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-center mb-6">Saldo Anda</h1>

    <div class="bg-[#f6f1e3] p-6 rounded-xl shadow-lg border border-[#002366] mb-6">
        <h2 class="text-lg font-semibold">Saldo Tersisa</h2>

        @if($saldo)
        <p class="text-4xl saldo-display">Rp {{ number_format($saldo->amount, 0, ',', '.') }}</p>
        @else
        <p class="mt-2 text-red-500 saldo-display">Anda belum memiliki saldo.</p>
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

        <form id="updateSaldoForm" onsubmit="event.preventDefault(); initiatePayment();">
            @csrf

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

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script>
    // Function to open modal
    function openModal() {
        document.getElementById('updateSaldoModal').classList.remove('hidden');
    }

    // Function to close modal
    function closeModal() {
        document.getElementById('updateSaldoModal').classList.add('hidden');
    }

    // Function to initiate payment using Midtrans Snap
    function initiatePayment() {
        const amount = document.getElementById('amount').value;

        if (!amount || amount <= 0) {
            alert('Masukkan jumlah yang valid.');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        // Call backend to generate Snap token
        fetch('/create-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    amount: parseFloat(amount),
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server Response:', data);

                if (data.snapToken) {
                    // Open Midtrans Snap payment
                    snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            console.log('Payment Success:', result);
                            alert('Payment successful!');
                            closeModal();

                            // Call backend to update transaction and saldo
                            fetch('/update-transaction-and-saldo', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                    },
                                    body: JSON.stringify({
                                        order_id: result.order_id, // Order ID from Midtrans result
                                    }),
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log('Backend Response:', data);
                                    if (data.success) {
                                        refreshSaldo(); // Update saldo display immediately
                                    } else {
                                        alert('Failed to update transaction and saldo.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('An error occurred while updating the transaction and saldo.');
                                });
                        },
                        onPending: function(result) {
                            console.log('Payment Pending:', result);
                            alert('Payment pending. Please complete your payment.');
                        },
                        onError: function(result) {
                            console.log('Payment Error:', result);
                            alert('Payment failed. Please try again.');
                        },
                    });

                } else {
                    alert('Failed to generate Snap token. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    }

    // Function to refresh saldo after successful payment
    // Function to refresh saldo after successful payment
    function refreshSaldo() {
        console.log('Refreshing saldo...'); // Add a log to check if it's being called
        fetch('/get-saldo')
            .then(response => response.json())
            .then(data => {
                if (data.saldo) {
                    document.querySelector('.saldo-display').innerHTML = `Rp ${new Intl.NumberFormat('id-ID').format(data.saldo)}`;
                } else {
                    document.querySelector('.saldo-display').innerHTML = '<p class="text-red-500">Anda belum memiliki saldo.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching saldo:', error);
            });
    }
</script>

@endsection