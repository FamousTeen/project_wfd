@extends('base/admin_navbar')

@section('content')
    <!-- Colors:
                                    1. #740001 - merah gelap
                                    2. #ae0001 - merah terang
                                    3. #f6f1e3 - netral
                                    4. #002366 - biru terang
                                    5. #20252f - biru gelap
                                -->

    <div class="container-fluid content-body mx-12 ">
        @php
            use Carbon\Carbon;
            use App\Models\Account;
            use App\Models\Meet;

            Carbon::setLocale('id');
        @endphp
        <h1 class="text-3xl">Edit Jadwal Pelatihan</h1>
        <form class="mt-6 rounded-xl py-6 pe-6 ms-5 flex bg-[#f6f1e3]" method="POST" action=""
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="grid ms-10 gap-4 grid-cols-2 w-full">
                <div>
                    <label for="group" class="mt-2">
                        Kelompok
                    </label>
                    <select id="group" name="group"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        @if ($group->name == 'Kelompok 1')
                            <option value="{{ $group->name }}" selected>{{ $group->name }}</option>
                            <option value="Kelompok 2">Kelompok 2</option>
                            <option value="Kelompok 3">Kelompok 3</option>
                            <option value="Kelompok 4">Kelompok 4</option>
                        @elseif ($group->name == 'Kelompok 2')
                            <option value="{{ $group->name }}" selected>{{ $group->name }}</option>
                            <option value="Kelompok 1">Kelompok 1</option>
                            <option value="Kelompok 3">Kelompok 3</option>
                            <option value="Kelompok 4">Kelompok 4</option>
                        @elseif ($group->name == 'Kelompok 3')
                            <option value="{{ $group->name }}" selected>{{ $group->name }}</option>
                            <option value="Kelompok 1">Kelompok 1</option>
                            <option value="Kelompok 2">Kelompok 2</option>
                            <option value="Kelompok 4">Kelompok 4</option>
                        @elseif ($group->name == 'Kelompok 4')
                            <option value="{{ $group->name }}" selected>{{ $group->name }}</option>
                            <option value="Kelompok 1">Kelompok 1</option>
                            <option value="Kelompok 2">Kelompok 2</option>
                            <option value="Kelompok 3">Kelompok 3</option>
                        @endif
                    </select>
                </div>

                <div>
                    <label for="place" class="mt-2">
                        Tempat Pelatihan
                    </label>
                    <input type="text" id="place" name="place"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ $training->place }}" required />
                </div>

                <div>
                    <label for="date" class="mt-2">
                        Tanggal Pelatihan
                    </label>
                    <input type="date" id="date" name="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required value="{{ Carbon::parse($training->training_date)->translatedFormat('Y-m-d') }}" />
                </div>

                <div>
                    <label for="time" class="mt-2">
                        Waktu Pelatihan
                    </label>
                    <input type="time" id="time" name="time"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ Carbon::parse($training->training_date)->translatedFormat('H:i') }}" required />
                </div>

                <div>
                    <label for="contact_person" class="mt-2">
                        Contact Person
                    </label>
                    <input type="text" id="contact_person" name="contact_person"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ $training->contact_person }}" required />
                </div>

                <div>
                    <label for="phone_number" class="mt-2">
                        Nomor Telepon
                    </label>
                    <input type="text" id="phone_number" name="phone_number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ $training->phone_number }}" required />
                </div>

                <div class="col-span-2">
                    <label for="notes" class="mt-2">
                        Catatan
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Tulis catatan jika diperlukan"></textarea>
                </div>

                <div class="flex col-span-2 mt-4 items-start justify-center">
                    <button type="submit"
                        class="px-8 py-2 bg-[#002366] hover:bg-[#20252f] text-white rounded-lg">Edit</button>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('libraryjs')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var ElementHeight = $("nav").height();
            var ElementPadding = parseInt($("nav").css('padding').replace("px", ""));
            var numberMargin = ((ElementHeight + (ElementPadding * 2)) / 16) + 2;
            var MarginTop = String(numberMargin) + "rem";
            console.log(MarginTop);
            $(".content-body").css("margin-top", MarginTop);
        });
    </script>
@endsection
