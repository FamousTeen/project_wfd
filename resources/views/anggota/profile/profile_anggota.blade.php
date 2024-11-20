@extends('base/anggota_navbar')

@section('content')
    <!-- Colors:
                                1. #740001 - merah gelap
                                2. #ae0001 - merah terang
                                3. #f6f1e3 - netral
                                4. #002366 - biru terang
                                5. #20252f - biru gelap
                            -->

    <div class="flex justify-center items-center min-h-screen bg-gray-100 mt-6">
        <div class="bg-[#f6f1e3] rounded-lg p-8 shadow-lg w-full max-w-4xl">
            <h2 class="text-center text-4xl font-bold text-[#20252f] mb-8">PROFILE</h2>
            <div class="flex">
                <!-- Profile Image Section -->
                <div class="relative w-1/3 p-4 ml-8">
                    <div class="bg-gray-300 rounded-lg h-48 w- -bottom-3 flex justify-center items-center">
                        <!-- Placeholder for profile image -->
                        <img src="asset/{{ $user->photo }}" class="rounded-lg" alt="">
                    </div>
                </div>

                <!-- Profile Information Section -->
                <div class="w-2/3 p-4">
                    <div class="grid grid-cols-2 ml-8 gap-y-8">
                        <div class="text-gray-600 font-semibold">Nama Panggilan</div>
                        <div class="text-gray-700">{{ $user->name }}</div>
                        <div class="text-gray-600 font-semibold">Email</div>
                        <div class="text-gray-700">{{ $user->email }}</div>
                        <div class="text-gray-600 font-semibold">Alamat</div>
                        <div class="text-gray-700">{{ $user->address }}</div>
                        <div class="text-gray-600 font-semibold">Tempat, Tanggal Lahir</div>
                        <div class="text-gray-700">{{ $user->birth_place_date }}</div>
                        <div class="text-gray-600 font-semibold">Wilayah</div>
                        <div class="text-gray-700">{{ $user->region }}</div>
                    </div>
                </div>
            </div>
            <!-- Edit My Profile Button -->
            <div class="flex justify-center mt-8">
                <a href="{{ route('edit_profile_anggota') }}"><button
                        class="bg-[#002366] text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-[#20252f] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                        Edit My Profile
                    </button></a>
            </div>
        </div>
    </div>
@endsection
