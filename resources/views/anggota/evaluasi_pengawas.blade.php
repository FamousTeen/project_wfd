@extends('base/anggota_navbar')

@section('content')
<div class="container-fluid m-12 me-0 mt-24">
  <!-- Header Section -->
  <div class="grid grid-cols-12">
    <div class="col-start-4 col-span-6 mt-6 mb-8 justify-items-center">
      <h1 class="font-bold text-4xl text-center">EVALUASI</h1>
    </div>
    <div class="col-start-11 col-span-2 text-right mr-16 mt-8">
      <h2 class="font-bold text-xl ">Hi, Shasa</h2>
      <p class="font-normal text-sm" id="currentDate"></p>
    </div>
  </div>

  <!-- Jadwal Misa Section -->
  <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-center gap-x-4 gap-y-16 mx-32 mt-5">
    <!-- Card 1 -->
    <div class="bg-[#f6f1e3] p-6 shadow-lg border border-[#002366] rounded-xl w-[300px] mx-auto resize-y">
        <div class="flex justify-end text-sm text-gray-500" onclick="openModal('modal1')">
            <a class="mr-1">detail</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
            </svg>              
        </div>
      <div class="flex justify-between items-center">
        <p class="font-bold" style="font-size: 18px">Rabu, 25-12-2024</p>
      </div>
      <div class="mt-2">
        <div class="flex mb-2">
            <span class="bg-orange-500 mt-1 h-4 w-4 rounded-full inline-block"></span>
            <div class="flex flex-col ml-2">
                <span>Misa Natal</span>
                <p class="mt-0">06.00 WIB</p>
            </div>
        </div>
      </div>
      {{-- Evaluasi --}}
      <div class="mt-6">
        <div class="flex flex-col">
          <p class="font-bold">Evaluasi: </p>
          <p class="mt-0 text-sm">none</p>
        </div>
      </div>
    </div>
    <!-- Modal 1 -->
    <div id="modal1" class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center" onclick="closeModal('modal1')">
      <div class="bg-[#D1D9D1] p-8 rounded-lg w-[700px] resize-y relative p-12" onclick="event.stopPropagation()">
          <button class="absolute top-4 right-4 text-black" onclick="closeModal('modal1')">
              &#10005;
          </button>
          <!-- Content inside the modal with two columns -->
          <div class="grid grid-cols-2 gap-4">
              <!-- Left column: Event details -->
              <div class="text-left ">
                  <div class="flex items-center justify-items">
                      <span class="bg-orange-500 h-7 w-7 rounded-full inline-block"></span>
                      <h2 class="text-2xl font-bold ml-2">Misa Natal</h2>
                  </div>
                  <div class="ms-9">
                    <p class="mt-2 text-lg">25 Desember 2024</p>
                  <p class="font-bold">06.00 WIB</p>
                  </div>
                  {{-- Evaluasi --}}
                  <div class="mt-6 ms-9">
                    <div class="flex flex-col">
                      <div class="flex flex-row justify-between items-center mr-4">
                        <p class="font-bold">Evaluasi: </p>                     
                      </div>
                      <div class="mt-2 pe-2">
                        <textarea class="w-full h-40 p-4 border border-[#002366] rounded-md focus:outline-none focus:ring-2 focus:ring-[#D2D2D2]" placeholder="Masukkan Evaluasi..."></textarea>
                        <div class="place-items-end">
                          <button class="bg-[#002366] text-white py-1 px-2 rounded-md hover:bg-[#740001] transition-all duration-300 text-sm mt-2">Upload</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              
              <!-- Right column: Task details -->
              <div class="text-left">
                  <p class="text-xl font-bold">Yang bertugas saat ini:</p>
                  <p class="mt-2"><span class="font-bold">Petugas:</span></p>
                  <div class="flex flex-row">
                      <ul class="mr-14">
                          <li>Angel</li>
                          <li>Martin</li>
                          <li>Bobby</li>
                          <li>Jonathan</li>
                      </ul>
                      <ul>
                          <li>Angel</li>
                          <li>Martin</li>
                          <li>Angel</li>
                      </ul>
                  </div>
                  <p class="mt-2"><span class="font-bold">Pengawas:</span></p>
                  <ul>
                      <li>Shasa</li>
                      <li>Bryan</li>
                  </ul>
                  <p class="mt-2"><span class="font-bold">Perkap:</span></p>
                  <ul>
                      <li>Alonso</li>
                      <li>Bryan</li>
                  </ul>
              </div>
          </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-[#C4CDC1] p-6 rounded-xl w-[300px] h-[200px] mx-auto">
        <div href="#" class="flex justify-end text-sm text-gray-500">
            <a class="mr-1">detail</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
            </svg>              
        </div>
      <div class="flex justify-between items-center">
        <p class="font-bold" style="font-size: 18px">Rabu, 25-12-2024</p>
      </div>
      <div class="mt-2">
        <div class="flex mb-2">
            <span class="bg-orange-500 mt-1 h-4 w-4 rounded-full inline-block"></span>
            <div class="flex flex-col ml-2">
                <span>Misa Natal</span>
                <p class="mt-0">10.00 WIB</p>
            </div>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-[#C4CDC1] p-6 rounded-xl w-[300px] h-[200px] mx-auto">
        <div href="#" class="flex justify-end text-sm text-gray-500">
            <a class="mr-1">detail</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
            </svg>              
        </div>
      <div class="flex justify-between items-center">
        <p class="font-bold" style="font-size: 18px">Minggu, 15-09-2024</p>
      </div>
      <div class="mt-2">
        <div class="flex mb-2">
            <span class="bg-blue-500 mt-1 h-4 w-4 rounded-full inline-block"></span>
            <div class="flex flex-col ml-2">
                <span>Misa Mingguan</span>
                <p class="mt-0">18.00 WIB</p>
            </div>
        </div>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-[#C4CDC1] p-6 rounded-xl w-[300px] h-[200px] mx-auto">
        <div href="#" class="flex justify-end text-sm text-gray-500">
            <a class="mr-1">detail</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
            </svg>              
        </div>
      <div class="flex justify-between items-center">
        <p class="font-bold" style="font-size: 18px">Minggu, 15-09-2024</p>
      </div>
      <div class="mt-2">
        <div class="flex mb-2">
            <span class="bg-blue-500 mt-1 h-4 w-4 rounded-full inline-block"></span>
            <div class="flex flex-col ml-2">
                <span>Misa Mingguan</span>
                <p class="mt-0">18.00 WIB</p>
            </div>
        </div>
      </div>
    </div>



  </div>

  @section('libraryjs')
<script>
  // Function to display the current date in the "Hi, Shasa" section
  const today = new Date();
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  document.getElementById('currentDate').innerText = today.toLocaleDateString(undefined, options);

  // Modal open function
  function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
  }

  // Modal close function
  function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
  }
</script>
@endsection