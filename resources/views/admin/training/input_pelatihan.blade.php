@extends('base/admin_navbar')

@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Input Jadwal Misa</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css">
    </head>

    <body>
        <div class="container mx-auto mt-20">
            <h2 class="ml-4 p-6 mt-4 text-2xl font-semibold">Input Jadwal Pelatihan</h2>
        </div>

        <div class="bg-[#f6f1e3] p-6 mx-12 rounded-lg mb-8">
            <form method="POST" action="{{ route('store_training') }}" class="grid grid-cols-1 gap-4">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium">Nama Kelompok</label>
                    <select name="id" id="title" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option value="" disabled selected>Pilih Kelompok</option>
                        <option value="1">Kelompok 1</option>
                        <option value="2">Kelompok 2</option>
                        <option value="3">Kelompok 3</option>
                        <option value="4">Kelompok 4</option>
                    </select>
                </div>

                <div class="flex space-x-4">
                    <div>
                        <label for="date" class="block text-sm font-medium">Tanggal Pelatihan</label>
                        <input type="date" name="training_date" id="date"
                            class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium">Jam Pelatihan</label>
                        <input type="time" name="start_time" id="start_time"
                            class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                </div>
                <div>
                    <label for="place" class="block text-sm font-medium">Tempat</label>
                    <input type="text" name="place" id="place" class="mt-1 block w-full border-gray-300 rounded-md"
                        required>
                </div>
                <div class="flex space-x-4">
                    <div>
                        <label for="contact_person" class="block text-sm font-medium">Contact Person</label>
                        <input type="text" name="contact_person" id="contact_person"
                            class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="phone_number" class="block text-sm font-medium">No. Telepon</label>
                        <input type="text" id="phone_number" name="phone_number"
                            class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium">Catatan</label>
                    <textarea id="description" class="mt-1 block w-full border-gray-300 rounded-md h-24" oninput="readTextarea()"></textarea>
                    <input type="hidden" name="description" value="halo" id="eventDesc" required></input>
                </div>
                <div class="text-center mt-4">
                    <button type="submit"
                        class="px-8 py-2 bg-[#002366] hover:bg-[#20252f] text-white font-semibold rounded-md transition duration-300">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </body>

    <script>
        function readTextarea() {
            var text = document.getElementById("description").value;
            document.getElementById("eventDesc").value = encodeURIComponent(text);
            console.log(document.getElementById("eventDesc").value);
        }
    </script>

    </html>
