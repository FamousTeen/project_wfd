@extends('base.main_navbar')

@section('content')

<!-- Colors:
                            1. #740001 - merah gelap
                            2. #ae0001 - merah terang
                            3. #f6f1e3 - netral
                            4. #002366 - biru terang
                            5. #20252f - biru gelap
                        -->

@php
use Carbon\Carbon;
use App\Models\Misa;
use App\Models\Documentation;
$documentations = Documentation::where('status', 1)->get();

Carbon::setLocale('id');
$all_misas = Misa::all();
$misas = $all_misas->whereBetween('activity_datetime', [
Carbon::now()->startOfWeek(),
Carbon::now()->endOfWeek(),
])->sortBy('activity_datetime');
@endphp

<!-- dokumentasi -->
<div class="bg-blue-500 text-white h-[89%] flex items-center justify-center" id="documentation">
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden md:h-full">
            @foreach ($documentations as $documentation)
            <!-- Item 1 -->
            <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                <img src="{{asset('images/' . $documentation->foto)}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 object-cover top-1/2 left-1/2" alt="...">
            </div>
            @endforeach
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
            <!-- <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button> -->
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
</div>
</div>

<!-- jadwal misa -->
<section class="bg-[#002366] h-screen p-8" id="jadwal-misa">
    <h2 class="text-3xl font-extrabold mb-4 text-center my-8 text-white">Jadwal Misa</h2>
    <div class="max-w-4xl mx-auto">
        @foreach ($misas as $misa)
        <!-- Card 1 -->
        <div class="my-8 bg-[#f6f1e3] text-[#20252f] rounded-xl shadow-lg p-4">
            <h3 class="ml-12 text-xl font-semibold mb-2">{{ $misa->title }}</h3>
            <hr class="border-[#ae0001] mb-4">
            <div class="flex ml-12 space-x-32">
                <div>
                    <div>
                        <p>{{ Carbon::parse($misa->activity_datetime)->translatedFormat('l, j F Y') }}</p>
                    </div>
                    <div>
                        <p>{{ Carbon::parse($misa->activity_datetime)->translatedFormat('H.i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
</section>

<section class="bg-[#f6f1e3] py-16" id="section3">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-center text-[#20252f] mb-8">7 PILAR</h2>

        <!-- Flexbox for the 7 cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-6">
            <div class="bg-[#740001] p-6 rounded-lg shadow-lg text-center flex items-center justify-center">
                <h4 class="text-xl font-semibold text-[#FFFFFF]">Menjaga ketertiban sakristi</h4>
            </div>

            <div class="bg-[#740001] p-6 rounded-lg shadow-lg text-center flex items-center justify-center">
                <h4 class="text-xl font-semibold text-[#FFFFFF]">Peka kepada lingkungan sekitar</h4>
            </div>

            <div class="bg-[#740001] p-6 rounded-lg shadow-lg text-center flex items-center justify-center">
                <h4 class="text-xl font-semibold text-[#FFFFFF]">5S : Senyum, Sapa, Salam, Sopan, Santun</h4>
            </div>

            <div class="bg-[#740001] p-6 rounded-lg shadow-lg text-center flex items-center justify-center">
                <h4 class="text-xl font-semibold text-[#FFFFFF]">Jaga kebersihan sarana & prasarana yang digunakan oleh
                    misdinar</h4>
            </div>

            <div class="bg-[#740001] p-6 rounded-lg shadow-lg text-center flex items-center justify-center">
                <h4 class="text-xl font-semibold text-[#FFFFFF]">Menuju integritas dalam melayani sesama</h4>
            </div>

            <div class="bg-[#740001] p-6 rounded-lg shadow-lg text-center flex items-center justify-center">
                <h4 class="text-xl font-semibold text-[#FFFFFF]">Kerja cepat tanggap tepat</h4>
            </div>

            <div class="bg-[#740001] p-6 rounded-lg shadow-lg text-center flex items-center justify-center">
                <h4 class="text-xl font-semibold text-[#FFFFFF]">Terbuka, Komunikasi, Kompak, Inisiatif, Peka</h4>
            </div>
        </div>
    </div>
</section>



<!-- acara yang diadakan -->
<section class="bg-[#002366] pt-16 px-8 text-center" id="section4">
    <h2 class="text-3xl font-extrabold text-center text-white mb-8">ACARA YANG DIADAKAN</h2>

    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        @php
        use App\Models\Event;
        $events = Event::where('status', 1)->get();
        @endphp
        <div class="relative h-56 overflow-hidden md:h-full">
            @foreach ($events as $index => $event)
            <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                <div class="bg-[#002366] flex justify-center items-center space-x-4">
                    <!-- Poster Section (Center) -->
                    <div class="bg-gray-200 p-6 shadow-lg">
                        <div class="mb-4">
                            <img src="/images/{{$event->poster }}" alt="Poster Acara" class="mx-auto w-64" />
                        </div>
                        <p class="text-center text-sm mt-2">{{ Carbon::parse($event->date)->translatedFormat('j F Y') }}
                        </p>
                    </div>

                    <!-- Event Details Section (Right) -->
                    <div class=" p-6 text-left max-w-lg self-start">
                        <h2 class="text-[#f6f1e3] text-3xl font-semibold mb-4">{{ $event->title }}</h2>
                        <p class="text-white text-sm">
                            {!! nl2br(e(urldecode($event->description))) !!}
                        </p>
                        <p class="text-white text-sm mt-4">Contact Person: {{ $event->contact_person }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-24 left-1/2 space-x-3 rtl:space-x-reverse">
            @foreach ($events as $index => $event)
            <button type="button" class="w-3 h-3 rounded-full" aria-current="{{$index == 0 ? true : false}}" aria-label="Slide {{$index+1}}" data-carousel-slide-to="{{$index}}"></button>
            @endforeach
        </div>
        <!-- Slider controls -->
        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
</section>

</div>
</div>

<!-- kolekte -->
<section class="bg-[#f6f1e3] py-16 text-center" id="section5">

    <h2 class="text-3xl font-bold text-[#20252f] mb-8">PERSEMBAHAN KASIH / KOLEKTE</h2>

    <div class="container mx-auto px-4 flex items-center justify-center space-x-4 ml-24">
        <!-- QR Code Section (Left) -->
        <div class="w-[300px] flex-shrink-0">
            <img src="../../images/QRIS_MISDINAR_RK.png" alt="QR Code" class="w-64 h-full object-cover rounded-lg">
        </div>

        <!-- Description Section (Right) -->
        <div class="w-[450px] text-left self-start mt-4">
            <p class="font-bold text-[#ae0001] text-xl">
                Dapat melalui Transfer
            </p><br>
            <p class="font-bold text-black">
                No. Rek BCA a/n
                <br><br>
                Clarissa Aurelia Gunawan
            </p><br>
            <p class="text-[#ae0001] text-xl">6751119108</p>
        </div>
    </div>
</section>


<!-- follow us -->
<section class="bg-[#002366] py-16 p-8 text-center" id="section6">
    <div class="flex justify-center items-center space-x-16  mr-16">
        <h1 class="text-[#f6f1e3] text-3xl font-bold mb-6">FOLLOW US ON</h1>\

        <!-- Instagram Card -->
        <div class="bg-[#f6f1e3] p-6 rounded-xl shadow-lg w-48 h-60">
            <a href="https://www.instagram.com/misdinar_rk?igsh=Nnh5bmF1MGZmNnJj">
                <h2 class="text-pink-600 text-2xl font-semibold mb-4">Instagram</h2>
                <img src="../../images/logoIG.png" alt="Instagram Logo" class="mx-auto w-64 mb-2">
                <p class="text-black font-semibold">@misdinar_rk
                </p>
            </a>
        </div>

        <!-- TIKTOK Card -->
        <div class="bg-[#f6f1e3] p-6 rounded-xl shadow-lg w-48 h-60">
            <a href="https://www.tiktok.com/@misdinar_rk/">
                <h2 class="text-gray-800 text-2xl font-semibold mb-4">Tiktok</h2>
                <img src="../../images/logoTiktok.png" alt="YouTube Logo" class="mx-auto w-48 mb-6">
                <p class="text-black font-semibold">@misdinar_rk</p>
            </a>
        </div>
</section>

@section('libraryjs')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var ElementHeight = $("nav").height();
        var ElementPadding = parseInt($("nav").css('padding').replace("px", ""));
        var numberMargin = ((ElementHeight + (ElementPadding * 2)) / 26.5) + 2;
        var MarginTop = String(numberMargin) + "rem";
        console.log(MarginTop);
        $("#documentation").css("margin-top", MarginTop);
        console.log($("#documentation").css("margin-top"));
    });

    console.log($('.halo-0').attr('class'));
</script>
@endsection