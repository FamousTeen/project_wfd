@extends('base/admin_navbar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Misa Detail</h1>

    <form action="{{ route('misaDetails.update', ['misaDetail' => $misaDetail->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="account_id" class="block text-sm font-medium">Anggota</label>
            <select name="account_id" id="account_id" class="block w-full mt-1">
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" {{ $misaDetail->account_id == $account->id ? 'selected' : '' }}>
                        {{ $account->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="roles" class="block text-sm font-medium">Role</label>
            <input type="text" name="roles" id="roles" value="{{ $misaDetail->roles }}" class="block w-full mt-1">
        </div>

        <div class="mb-4">
            <label for="participation" class="block text-sm font-medium">Participation</label>
            <input type="checkbox" name="participation" id="participation" value="1" {{ $misaDetail->participation ? 'checked' : '' }}>
        </div>

        <div class="mb-4">
            <label for="confirmation" class="block text-sm font-medium">Confirmation</label>
            <input type="checkbox" name="confirmation" id="confirmation" value="1" {{ $misaDetail->confirmation ? 'checked' : '' }}>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
    </form>
</div>
@endsection
