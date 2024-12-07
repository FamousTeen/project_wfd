@extends('base/admin_navbar')

@section('content')
<div class="container-fluid mt-24">
    <div class="grid grid-cols-12">
        <div class="col-start-4 col-span-6 mt-6 mb-8">
            <h1 class="font-bold text-4xl text-center">Saldo Admin</h1>
        </div>
    </div>

    <div class="overflow-x-auto mb-8">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Amount</th>
                    <th class="border border-gray-300 px-4 py-2">Date</th>
                    <th class="border border-gray-300 px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saldos as $item)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $item->account->name }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">{{ number_format($item->amount, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <button 
                            class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600"
                            onclick="openEditModal({{ $item->id }}, {{ $item->amount }})">
                            Edit Amount
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="editSaldo" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/3">
        <h3 class="text-lg font-semibold mb-4">Edit Saldo Amount</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" id="editAmount" name="amount" 
                    class="block w-full p-2 border border-gray-300 rounded-md"
                    required>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" 
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" 
                    onclick="closeEditModal()">Cancel</button>
                <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, amount) {
        console.log(id, amount);
        const modal = document.getElementById('editSaldo');
        const form = document.getElementById('editForm');
        const editAmount = document.getElementById('editAmount');

        // Update modal fields
        editAmount.value = amount;

        // Update form action dynamically
        form.action = `/update-saldo/${id}`;

        // Show the modal
        console.log(modal.classList);
        modal.classList.remove('hidden');
        console.log(modal.classList);
    }

    function closeEditModal() {
        const modal = document.getElementById('editSaldo');
        modal.classList.add('hidden');
    }
</script>
@endsection