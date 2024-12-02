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
</header>

@foreach ($groups as $group)
<div class="bg-[#f6f1e3] rounded-lg shadow-lg p-6 mx-16 mb-8 misa-card">
    <div class="flex justify-between">
        <!-- Group Name -->
        <div class="flex-1 basis-1/4">
            <div class="flex items-start space-x-4">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold">{{ $group->name }}</h2>
                </div>
            </div>
        </div>

        <!-- Members List -->
        <div class="flex-1 basis-3/4 bg-white p-4 rounded-lg">
            <h3 class="text-[#20252f] font-semibold border-b pb-2">ANGGOTA</h3>
            <div class="grid grid-cols-2 gap-4 mt-2">
                <ul class="text-gray-600 mt-2 grid grid-flow-col grid-rows-2 gap-x-4 gap-y-1">
                    @foreach ($group->groupDetails as $groupDetail)
                    <li>{{ $groupDetail->account->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4 mt-4">
        <button
            id="editButton{{ $group->id }}"
            class="edit-button px-6 py-2 bg-[#002366] hover:bg-[#20252f] text-white rounded-lg"
            data-members='@json($group->groupDetails->map(fn($detail) => ["name" => $detail->account->name, "wilayah" => $detail->account->region, "account_id" => $detail->account->id]))'>
            Edit
        </button>
        <form id="editForm{{ $group->id }}" action="{{ route('groups.updateMembers', $group->id) }}" method="POST" style="display: none;">
            @csrf
            @method('PUT')

            <!-- Dropdown for Members -->
            <label class="block text-sm font-medium text-gray-700">Nama Anggota</label>
            <select class="block appearance-none w-full p-2 border border-gray-300 rounded-md bg-white" name="member_ids[]" multiple>
                @foreach ($accounts as $account)
                @if (! $group->groupDetails->contains('account_id', $account->id))
                <option value="{{ $account->id }}">{{ $account->name }}</option>
                @endif
                @endforeach
            </select>

            <!-- Save Button -->
            <div class="flex items-center justify-between mt-4">
                <button type="submit" class="px-4 py-2 bg-[#ae0001] hover:bg-[#740001] text-white rounded-lg">Save</button>
            </div>
        </form>

        <form action="{{ route('groups.destroy', $group->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="group_id" value="{{ $group->id }}">
            <button type="submit" class="px-4 py-2 bg-[#ae0001] hover:bg-[#740001] text-white rounded-lg">Delete</button>
        </form>
    </div>
</div>

<!-- Modal Tambah Kelompok -->
<div id="addModal" class="hidden fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50">
    <div class="bg-[#f6f1e3] p-8 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-semibold mb-4">Tambah Kelompok Baru</h3>

        <!-- Form for submitting new group data -->
        <form id="addGroupForm" action="{{ route('groups.store') }}" method="POST">
            @csrf

            <!-- Group Name -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Nama Kelompok</label>
                <input type="text" name="group_name" id="group_name" class="mt-1 p-2 w-full border border-gray-300 rounded-md"
                    placeholder="Input Nama Kelompok" required>
            </div>

            <!-- Anggota Dropdown -->
            <div>
                <label class="block text-sm mt-4 font-medium text-gray-700">Nama Anggota</label>
                <select id="memberDropdown" class="block appearance-none w-full p-2 border border-gray-300 rounded-md bg-white">
                    @foreach($accounts as $account)
                    @php
                    $isInGroup = $groups->some(fn($group) => $group->groupDetails->contains('account_id', $account->id));
                    @endphp
                    @if (! $isInGroup)
                    <option value="{{ $account->id }}" data-name="{{ $account->name }}" data-region="{{ $account->region }}">
                        {{ $account->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>

            <!-- Add Member Button -->
            <button type="button" id="addMemberButton"
                class="w-full bg-[#740001] mt-2 text-white py-2 rounded-lg hover:bg-[#20252f] transition-all duration-300">
                Tambah Anggota
            </button>

            <!-- Table for Showing Added Members -->
            <div class="mt-6 overflow-y-auto max-h-60">
                <h3 class="text-lg font-semibold">Daftar Anggota</h3>
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
                        <!-- Dynamically populated rows -->
                    </tbody>
                </table>
            </div>

            <!-- Submit and Cancel Buttons -->
            <div class="bg-[#f6f1e3] py-3 sm:flex sm:flex-row-reverse">
                <button type="submit"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#002366] text-base font-medium text-white hover:bg-[#20252f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Simpan
                </button>
                <button type="button" id="cancelButton"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>


<div id="editModal{{ $group->id }}" class="hidden fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50">
    <div class="bg-[#f6f1e3] p-8 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-semibold mb-4">Edit {{ $group->name }}</h3>

        <!-- Form to update group members -->
        <form id="updateForm{{ $group->id }}" action="{{ route('groups.updateMembers', $group->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full mt-2 table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-1 py-1">No.</th>
                        <th class="border border-gray-300 px-6 py-1">Nama</th>
                        <th class="border border-gray-300 px-1 py-1">Wilayah</th>
                        <th class="border border-gray-300 py-1">Action</th>
                    </tr>
                </thead>
                <tbody id="anggotaTableBody{{ $group->id }}">
                    <!-- Existing Members -->
                    @foreach ($group->groupDetails as $index => $detail)
                    <tr>
                        <td class="border border-gray-300 px-1 py-1">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-6 py-1">{{ $detail->account->name }}</td>
                        <td class="border border-gray-300 px-1 py-1">{{ $detail->account->region }}</td>
                        <td class="border border-gray-300 py-1">
                            <button type="button" class="remove-member-btn text-red-600" data-account-id="{{ $detail->account->id }}" data-group-id="{{ $group->id }}">
                                Remove
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Add Member Dropdown -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Tambah Anggota</label>
                <select class="block appearance-none w-full p-2 border border-gray-300 rounded-md bg-white" id="addMemberSelect{{ $group->id }}">
                    @foreach($accounts as $account)
                    @php
                    $isInGroup = $groups->some(fn($group) => $group->groupDetails->contains('account_id', $account->id));
                    @endphp
                    @if (! $isInGroup)
                    <option value="{{ $account->id }}" data-name="{{ $account->name }}" data-region="{{ $account->region }}">
                        {{ $account->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>

            <button type="button" class="w-full bg-[#740001] mt-2 text-white py-2 rounded-lg hover:bg-[#20252f] transition-all duration-300" id="addMemberButton{{ $group->id }}">
                Tambah Anggota
            </button>

            <!-- Save and Cancel Buttons -->
            <div class="bg-[#f6f1e3] py-3 sm:flex sm:flex-row-reverse mt-4">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#002366] text-base font-medium text-white hover:bg-[#20252f] focus:outline-none sm:w-auto sm:text-sm">
                    Save
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm" id="cancelButton{{ $group->id }}" onclick="closeModal('editModal{{ $group->id }}')">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>



@endforeach

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to open a modal
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.remove("hidden");
        }

        // Function to close a modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.add("hidden");
        }

        // Handle Add button click to open the Add Group modal
        document.getElementById("addButton")?.addEventListener("click", () => {
            openModal("addModal");
        });

        // Handle cancel for the Add modal
        document.getElementById("cancelButton")?.addEventListener("click", () => {
            closeModal("addModal");
        });

        // Handle Edit buttons to open the corresponding Edit modal
        document.querySelectorAll(".edit-button").forEach((button) => {
            button.addEventListener("click", (event) => {
                const groupId = event.target.id.replace("editButton", "");
                openModal(`editModal${groupId}`);
            });
        });

        // Handle Cancel buttons inside each Edit modal
        document.querySelectorAll("[id^=cancelButton]").forEach((button) => {
            button.addEventListener("click", (event) => {
                const groupId = event.target.id.replace("cancelButton", "");
                closeModal(`editModal${groupId}`);
            });
        });

        // Close modal when clicking outside the modal
        document.addEventListener("click", (event) => {
            const modals = document.querySelectorAll(".modal");
            modals.forEach((modal) => {
                if (modal && !modal.contains(event.target)) {
                    modal.classList.add("hidden");
                }
            });
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const addMemberButton = document.getElementById('addMemberButton');
        const memberDropdown = document.getElementById('memberDropdown');
        const anggotaTableBody = document.getElementById('anggotaTableBody');
        const addGroupForm = document.getElementById('addGroupForm');

        // Maintain a list of selected accounts
        let selectedAccounts = [];

        // Add member on button click
        addMemberButton.addEventListener('click', () => {
            const selectedOption = memberDropdown.options[memberDropdown.selectedIndex];

            if (!selectedOption || !selectedOption.value) {
                alert('Pilih anggota terlebih dahulu.');
                return;
            }

            const accountId = selectedOption.value;
            const accountName = selectedOption.getAttribute('data-name');
            const accountRegion = selectedOption.getAttribute('data-region');

            // Check if the account is already in the selectedAccounts list
            if (selectedAccounts.includes(accountId)) {
                alert('Anggota sudah ditambahkan.');
                return;
            }

            // Add account to the selectedAccounts list
            selectedAccounts.push(accountId);

            // Add the account to the table
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="border border-gray-300 px-1 py-1">${selectedAccounts.length}</td>
                <td class="border border-gray-300 px-6 py-1">${accountName}</td>
                <td class="border border-gray-300 px-1 py-1">${accountRegion}</td>
                <td class="border border-gray-300 py-1">
                    <button type="button" class="remove-member-btn text-red-600" data-account-id="${accountId}">
                        Remove
                    </button>
                </td>
            `;
            anggotaTableBody.appendChild(newRow);

            // Remove the added account from the dropdown
            memberDropdown.remove(memberDropdown.selectedIndex);
        });

        // Remove member from the table
        anggotaTableBody.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-member-btn')) {
                const button = event.target;
                const accountId = button.getAttribute('data-account-id');

                // Remove the account from the selectedAccounts list
                selectedAccounts = selectedAccounts.filter((id) => id !== accountId);

                // Add the account back to the dropdown
                const option = document.createElement('option');
                option.value = accountId;
                option.textContent = button.closest('tr').children[1].textContent;
                memberDropdown.appendChild(option);

                // Remove the row from the table
                button.closest('tr').remove();
            }
        });

        // Modify the form submission to include the selected accounts
        addGroupForm.addEventListener('submit', (event) => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'accounts';
            hiddenInput.value = JSON.stringify(selectedAccounts);
            addGroupForm.appendChild(hiddenInput);
        });
    });



    document.querySelectorAll("[id^=editModal]").forEach((modal) => {
        const groupId = modal.id.replace("editModal", "");
        const addMemberButton = document.getElementById(`addMemberButton${groupId}`);
        const memberDropdown = document.getElementById(`addMemberSelect${groupId}`);
        const anggotaTableBody = document.getElementById(`anggotaTableBody${groupId}`);
        const accountsInput = document.createElement("input");

        let selectedAccounts = []; // Scoped to each modal

        // Hidden input to hold account IDs
        accountsInput.type = "hidden";
        accountsInput.name = "member_ids[]";
        modal.querySelector("form").appendChild(accountsInput);

        // Fetch the group details for this specific groupId
        const groupDetails = @json($groups);
        const group = groupDetails.find(group => group.id == groupId);
        const existingMembers = group.group_details;

        // Initialize selectedAccounts with existing group members
        existingMembers.forEach(member => {
            selectedAccounts.push(member.account_id);
        });

        // Update hidden input field with existing member IDs
        accountsInput.value = selectedAccounts.join(',');

        // Update dropdown based on existing members (exclude existing members)
        function updateDropdown() {
            // Filter out the accounts that are already in group_details
            Array.from(memberDropdown.options).forEach(option => {
                if (selectedAccounts.includes(parseInt(option.value))) {
                    option.disabled = true; // Disable options already added
                } else {
                    option.disabled = false;
                }
            });
        }

        // Call the function to update the dropdown options when the modal is opened
        updateDropdown();

        // Handle adding new members
        addMemberButton.addEventListener("click", function() {
            const selectedOption = memberDropdown.options[memberDropdown.selectedIndex];
            const accountId = parseInt(selectedOption.value); // Ensure integer value
            const accountName = selectedOption.innerText;

            if (!selectedAccounts.includes(accountId)) {
                selectedAccounts.push(accountId);
                accountsInput.value = selectedAccounts.join(',');

                const newRow = document.createElement("tr");
                newRow.innerHTML = `
                <td class="border border-gray-300 px-1 py-1">${anggotaTableBody.rows.length + 1}</td>
                <td class="border border-gray-300 px-6 py-1">${accountName}</td>
                <td class="border border-gray-300 px-1 py-1">${selectedOption.dataset.region}</td>
                <td class="border border-gray-300 py-1">
                    <button type="button" class="remove-member-btn text-red-600" data-account-id="${accountId}" data-group-id="${groupId}">
                        Remove
                    </button>
                </td>
            `;
                anggotaTableBody.appendChild(newRow);
                selectedOption.remove();
                updateDropdown();
            } else {
                alert("Member already added.");
            }
        });

        // Handle member removal
        modal.addEventListener("click", function(event) {
            if (event.target && event.target.classList.contains("remove-member-btn")) {
                const accountId = event.target.getAttribute("data-account-id");
                const row = event.target.closest('tr');
                removeMemberFromGroup(groupId, accountId, row, memberDropdown, selectedAccounts, accountsInput);
            }
        });

        function removeMemberFromGroup(groupId, accountId, row, dropdown, selectedAccountsRef, accountsInputRef) {
            // Remove the account from the selectedAccounts array
            const updatedAccounts = selectedAccountsRef.filter(id => id !== parseInt(accountId));
            selectedAccountsRef.length = 0; // Clear the array
            updatedAccounts.forEach(id => selectedAccountsRef.push(id)); // Update the array reference

            // Update the hidden input value
            accountsInputRef.value = selectedAccountsRef.join(',');

            // Remove the row from the table
            row.remove();

            // Re-enable the removed account in the dropdown
            const accountName = row.cells[1].innerText;
            const accountRegion = row.cells[2].innerText;
            const option = document.createElement('option');
            option.value = accountId;
            option.setAttribute('data-region', accountRegion);
            option.textContent = accountName;
            dropdown.appendChild(option);

            // Update dropdown to reflect changes
            updateDropdown();
        }

        
    });
</script>
@endsection