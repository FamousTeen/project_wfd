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

    @if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50"
        role="alert">
        {{ session('success')}}
    </div>
    @endif

    <div class="my-6 rounded-xl py-6 pe-6 ps-12 flex justify-between items-start bg-[#f6f1e3]">
        <div>   
            <p class="text-md">
            {!! nl2br(e(urldecode($meet->notulen))) !!}
            </p>
        </div>
        <div>
            <a href="{{route('meets.edit', ['meet' => $meet])}}" class="text-[#20252f] hover:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 010 2.828L8.828 14l-4 1 1-4 8.586-8.586a2 2 0 012.828 0z" />
                    <path fill-rule="evenodd" d="M3 18a1 1 0 001 1h12a1 1 0 001-1V8a1 1 0 00-2 0v9H5V7H4v11z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
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
</script>
@endsection