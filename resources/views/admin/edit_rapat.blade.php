@extends('base/admin_navbar')

<style>
    .input-no-bg:focus {
        background-color: transparent !important;
    }
</style>

@section('content')
<!-- Colors:
                1. #740001 - merah gelap
                2. #ae0001 - merah terang
                3. #f6f1e3 - netral
                4. #002366 - biru terang
                5. #20252f - biru gelap
            -->

<div class="container-fluid content-body mx-12">
    @php
    use Carbon\Carbon;
    use App\Models\Account;

    Carbon::setLocale('id');
    @endphp
    <div>
        <h1 class="text-3xl">Notulen {{$meet->title}}</h1>
        <p>{{ Carbon::parse($meet->date)->translatedFormat('l, d/m/Y') }}</p>
    </div>

    <form action="{{route('meets.update', ['meet' => $meet])}}" method="post" class="my-6 rounded-xl pb-6 pe-6 ps-12 bg-[#f6f1e3]">
        @csrf
        @method('put')
        <div class="w-full">
            <textarea id="meetNotulen" class="mt-4 w-full h-32 border border-gray-300 rounded p-2" placeholder="Masukkan pengumuman" " oninput="readTextarea()">{!! urldecode($meet->notulen) !!}</textarea>
            <input type="hidden" name="meetNotulen" id="meetNotulen1"></input>
        </div>
        <div class=" flex col-span-2 mt-4 items-start justify-center">
                <button type="submit" class="text-white bg-[#002366] hover:bg-[#20252f] font-medium rounded-lg text-sm px-12 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900">Edit</button>
            </div>
    </form>
</div>
@endsection

@php
// Fetch all accounts and store them in a variable
$accounts = Account::with('eventDetails')->get();

@endphp

@section('libraryjs')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var ElementHeight = $("nav").height();
        var ElementPadding = parseInt($("nav").css('padding').replace("px", ""));
        var numberMargin = ((ElementHeight + (ElementPadding * 2)) / 16) + 2;
        var MarginTop = String(numberMargin) + "rem";
        console.log(MarginTop);
        $(".content-body").css("margin-top", MarginTop);
    });

    function readTextarea() {
                    const textareaValue = document.getElementById(`meetNotulen`).value;
                    document.getElementById(`meetNotulen1`).value = encodeURIComponent(textareaValue);
                    console.log(document.getElementById(`meetNotulen1`).value);
                }
</script>
@endsection