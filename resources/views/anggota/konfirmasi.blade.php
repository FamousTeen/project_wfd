@extends('base/anggota_navbar')

@section('librarycss')
<link href="./node_modules/pagedone/src/css/pagedone.css" rel="stylesheet" />
@endsection

<!-- Colors:
                1. #740001 - merah gelap
                2. #ae0001 - merah terang
                3. #f6f1e3 - netral
                4. #002366 - biru terang
                5. #20252f - biru gelap
            -->

@section('content')
<div class="container-fluid m-12 mt-24">
  <!-- Header Section -->
  <div class="grid grid-cols-12">
    <div class="col-start-4 col-span-6 mt-6 mb-8 justify-items-center">
      <h1 class="font-bold text-4xl text-center">KONFIRMASI MISA</h1>
    </div>
    <div class="col-start-11 col-span-2 text-right mr-16 mt-8">
      <h2 class="font-bold text-xl ">Hi, Shasa</h2>
      <p class="font-normal text-sm" id="currentDate"></p>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 justify-center mx-32 mt-5 mb-4">
    @if (session()->has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      {{ session('success')}}
    </div>
    @elseif (session()->has('decline'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      {{ session('decline')}}
    </div>
    @endif

    <div class="md:col-span-3 text-left">
      <h2 class="font-semibold text-md text-gray-500">Perhatikan batas waktu konfirmasi!</h2>
    </div>
  </div>

  @php
  use App\Models\Misa_Detail;
  use Carbon\Carbon;

  $dataMisa = Misa_Detail::query()->where('account_id', $user->id)->where('confirmation', NULL)->get();


  @endphp

  <!-- Jadwal Misa Section -->
  <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-center gap-16 m-6 mt-5">
    @foreach ($dataMisa as $misa)
    <div class="bg-[#f6f1e3] p-6 shadow-lg border border-[#002366] rounded-xl w-[350px] mx-auto resize-y">
      <div class="flex flex-row items-center gap-x-6">
        <p class="text-sm text-gray-600 text-start flex-auto flex-nowrap mb-4">sisa waktu konfirmasi</p>
        <div class="flex flex-row text-sm text-gray-600 countdown">
          &nbsp;&nbsp;
          <p
            class="countdown-element hours font-bold tracking-[15.36px] max-w-[44px] text-center z-20 h-fit">
          </p>&nbsp;&nbsp;&nbsp;&nbsp;:
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <p
            class="countdown-element minutes font-bold  tracking-[15.36px] max-w-[44px] text-center z-20 h-fit">
          </p>:&nbsp;&nbsp;&nbsp;&nbsp;
          <p
            class="countdown-element seconds font-bold  tracking-[15.36px] max-w-[44px] text-center z-20 h-fit">
          </p>
        </div>
      </div>
      @php
      Carbon::setLocale('en');
      @endphp
      <!-- Javascript buat countdown -->
      <script>
        let dest = new Date("{{Carbon::parse($misa->misa->upload_datetime)->addDays(3)->translatedFormat('M j, Y H:i:s')}}").getTime();
        let x = setInterval(function() {
          let now = new Date().getTime();
          let diff = dest - now;

          // Check if the countdown has reached zero or negative
          if (diff <= 0) {
            clearInterval(x); // Stop the countdown
            return; // Exit the function
          }

          // let days = Math.floor(diff / (1000 * 60 * 60 * 24));
          let hours = Math.floor(diff / (1000 * 60 * 60));
          let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
          let seconds = Math.floor((diff % (1000 * 60)) / 1000);

          // if (days < 10) {
          //   days = `0${days}`;
          // }
          if (hours < 10) {
            hours = `0${hours}`;
          }
          if (minutes < 10) {
            minutes = `0${minutes}`;
          }
          if (seconds < 10) {
            seconds = `0${seconds}`;
          }

          // Get elements by class name

          let countdown = document.getElementsByClassName("countdown");

          if (hours < 24 && countdown) {
            for (let i = 0; i < countdown.length; i++) {
              let element = countdown[i];

              // Check if the element exists and if the class is already present
              if (element && !element.classList.contains('bg-red-700')) {
                element.classList.add('bg-red-700');
              }
              if (element && !element.classList.contains('text-white')) {
                element.classList.add('text-white');
              }
            }
          }

          let countdownElements = document.getElementsByClassName("countdown-element");

          // Loop through the elements and update their content
          for (let i = 0; i < countdownElements.length; i++) {
            let className = countdownElements[i].classList[1]; // Get the second class name
            switch (className) {
              // case "days":
              //   countdownElements[i].innerHTML = days;
              //   break;
              case "hours":
                countdownElements[i].innerHTML = hours;
                break;
              case "minutes":
                countdownElements[i].innerHTML = minutes;
                break;
              case "seconds":
                countdownElements[i].innerHTML = seconds;
                break;
              default:
                break;
            }
          }
        }, 1000);
      </script>
      @php
      Carbon::setLocale('id');
      @endphp
      <div class="flex justify-between items-center">
        <p class="font-bold" style="font-size: 18px">{{ Carbon::parse($misa->misa->activity_datetime)->translatedFormat('l, j-m-Y') }}</p>
      </div>
      <div class="mt-2">
        <div class="flex mb-2">
          <span class="bg-orange-500 mt-1 h-4 w-4 rounded-full inline-block"></span>
          <div class="flex flex-col ml-2">
            <span>{{$misa->misa->title}}</span>
            <p class="mt-0">{{Carbon::parse($misa->misa->activity_datetime)->translatedFormat('H.i')}} WIB</p>
          </div>
        </div>
      </div>
      {{-- Button Konfirmasi --}}
      <div class="mt-6">
        <div class="flex flex-row justify-center gap-6 mt-6">
          <a href="{{ route('update_konfirmasi', ['id' => $misa->id, 'answer' => 1])}}" class="flex items-center justify-center rounded-md bg-[#002366] border border-[#002366] p-2 transition-all shadow-sm hover:bg-[#00112e] hover:shadow-lg focus:bg-[#00112e] focus:shadow-none active:bg-green-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check">
              <polyline points="20 6 9 17 4 12" />
            </svg>
          </a>
          <a href="{{ route('update_konfirmasi', ['id' => $misa->id, 'answer' => 0])}}" class="flex items-center justify-center rounded-md bg-[#ae0001] border border-[#ae0001] p-2 transition-all shadow-sm hover:bg-[#740001] hover:shadow-lg focus:bg-[#740001] focus:shadow-none active:bg-red-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
              <line x1="18" y1="6" x2="6" y2="18" />
              <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  @section('libraryjs')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script>
    // Function to display the current date in the "Hi, Shasa" section
    const today = new Date();
    const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    };
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
  <script src="./node_modules/pagedone/src/js/pagedone.js"></script>
  @endsection