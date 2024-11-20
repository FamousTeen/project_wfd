@extends('base/anggota_navbar')

@section('content')

<!-- Colors: 
        1. #740001 - merah gelap 
        2. #ae0001 - merah terang 
        3. #f6f1e3 - netral 
        4. #002366 - biru terang 
        5. #20252f - biru gelap 
    -->
<div class="container-fluid m-12 me-0 mt-24">
  <!-- Header Section -->
  <div class="grid grid-cols-12">
    <div class="col-start-4 col-span-6 mt-6 mb-8 justify-items-center">
      <h1 class="font-bold text-4xl text-center">ACARA</h1>
    </div>
    <div class="col-start-11 col-span-2 text-right mr-16 mt-8">
      <h2 class="font-bold text-xl ">Hi, Shasa</h2>
      <p class="font-normal text-sm" id="currentDate"></p>
    </div>
  </div>
</div>

<!-- Poster Section -->
<div class="flex justify-center mb-16">
  <php class="grid grid-cols-1 md:grid-cols-3 gap-16 justify-items-center">
    @php
    use Carbon\Carbon;

    Carbon::setLocale('id');
    @endphp

    @if (isset($events))
    <!-- Poster-poster -->
    @foreach ($events as $event)
    <a href="{{ route('events.show', ['event' => $event])}}">
      <div class="bg-[#f6f1e3] p-6 shadow-lg w-auto mx-8 border border-[#002366]">
        <img src="{{asset('images/'.$event->poster)}}" alt="Poster Acara" class="mx-auto w-64" />
        <p class="text-center text-sm mt-2">{{ Carbon::parse($event->date)->translatedFormat('l, j F Y') }}</p>
      </div>
    </a>

    @endforeach
    <!-- Poster 1 -->

    @else
    <h1 class="col-span-3 ms-8">NO EVENT</h1>
    @endif

</div>
</div>

@endsection

@section('libraryjs')
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
</script>
@endsection