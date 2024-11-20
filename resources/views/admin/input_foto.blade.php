@extends('base/admin_navbar')

@section('content')
<!-- Colors:
                1. #740001 - merah gelap
                2. #ae0001 - merah terang
                3. #f6f1e3 - netral
                4. #002366 - biru terang
                5. #20252f - biru gelap
            -->

<div class="container mx-auto py-8 mt-8 mb-8">
    <div class="grid grid-cols-12">
        <div class="col-start-2 col-span-6 mt-8">
            <h2 class="font-bold text-3xl ">Input Foto Dokumentasi</h2>
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-2 p-6">
        <div class="bg-[#f6f1e3] p-4 rounded-lg shadow-md mb-6 grid grid-cols-4 gap-4 items-center">
            <div class="col-span-1">
                <button class="flex items-center bg-[#002366] hover:bg-[#20252f] text-white px-4 py-2 rounded-md font-semibold ml-12">
                    <span class="mr-2">+</span> Tambahkan Foto
                </button>
            </div>
            <div class="text-sm text-[#20252f] border border-gray-300 p-4 rounded-lg bg-white col-span-3 mr-8">
                <p class="font-semibold mb-1">Syarat & Ketentuan Foto</p>
                <ul class="list-disc ml-4">
                    <li>Ukuran Foto 800x400</li>
                    <li>Foto Landscape</li>
                    <li>Resolusi file minimum</li>
                </ul>
            </div>
        </div>

        <div class="bg-white border border-gray-300 p-4 rounded-lg">
            <table class="w-full text-center table-auto">
                <thead> 
                    <tr>
                        <th class="pb-3 border-b font-semibold w-1/4">Foto Dokumentasi</th>
                        <th class="pb-3 border-b font-semibold">Tanggal Unggah</th>
                        <th class="pb-3 border-b font-semibold">Hapus Foto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="py-4 flex items-center justify-center space-x-4"> 
                            <img src="../../../images/default.jpg" alt="Foto Dokumentasi" class="w-10 h-10 rounded">
                            <span>Christmas 2024</span>
                        </td>
                        <td class="py-4 text-center">26/12/2024</td>
                        <td class="py-4 text-center">
                            <button class="bg-[#ae0001] hover:bg-[#740001] text-white px-4 py-2 rounded-md">Delete</button>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>

@endsection
