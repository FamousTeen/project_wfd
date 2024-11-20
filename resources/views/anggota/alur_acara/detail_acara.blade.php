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
      <h1 class="font-bold text-4xl text-center">{{$selectedEvent->title}}</h1>
    </div>
    <div class="col-start-11 col-span-2 text-right mr-16 mt-8">
      <h2 class="font-bold text-xl ">Hi, Shasa</h2>
      <p class="font-normal text-sm" id="currentDate"></p>
    </div>
  </div>
</div>

<!-- Poster Section -->
<div class="flex justify-center mb-16">
  <php class="grid grid-cols-1 gap-16 justify-items-center">
    @php
    use Carbon\Carbon;

    Carbon::setLocale('id');
    @endphp


    <div class="bg-[#f6f1e3] p-6 shadow-lg w-auto mx-8 border border-[#002366] flex">
      <div>
        <img src="../../images/{{$selectedEvent->poster}}" alt="Poster Acara" class="mx-auto w-64" />
      </div>
      <div class="ml-8 mt-3">
        <p><span class="font-bold">Tanggal: &nbsp;</span> {{ Carbon::parse($selectedEvent->date)->translatedFormat('l, j F Y') }}</p>
        <br>
        <p><span class="font-bold">Contact Person: &nbsp;</span> {{$selectedEvent->contact_person}}&nbsp;(<i>{{$selectedEvent->phone_number}}</i>)</p>
        <br>
        <p><span class="font-bold">Description: &nbsp;</span> {{$selectedEvent->description}}</i>)</p>
        <br>
        <p><span class="font-bold">Evaluation: &nbsp;</span> {{$selectedEvent->evaluation}}</i>)</p>
      </div>
    </div>

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