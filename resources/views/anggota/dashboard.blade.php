@php
use App\Models\Misa;
use App\Models\Training;
@endphp

@extends('base/anggota_navbar')

@section('content')
<!-- Colors:
                1. #740001 - merah gelap
                2. #ae0001 - merah terang
                3. #f6f1e3 - netral
                4. #002366 - biru terang
                5. #20252f - biru gelap
            -->
<div class="container-fluid m-12 mt-24">
    <!-- Header Section -->
    <div class="grid grid-cols-12">
        <div class="col-start-4 col-span-6 mt-6 mb-8 justify-items-center">
            <h1 class="font-bold text-4xl text-center">DASHBOARD</h1>
        </div>
        <div class="col-start-11 col-span-2 text-right mr-16 mt-8">
            <h2 class="font-bold text-xl ">Hi, {{ $data->name }}</h2>
            <p class="font-normal text-sm" id="currentDate"></p>
        </div>
    </div>

    <!-- Main Layout: Left and Right Sides -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-8 mt-6">

        <!-- Left Side: Tugas, Panitia, and Pengumuman -->
        <div>
            <!-- Tugas and Panitia Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12 ml-12 ">
                <div
                    class="bg-[#f6f1e3] p-6 rounded-xl flex justify-between gap-x-3 md:gap-x-12 border border-[#002366]">
                    <div>
                        <p class="font-semibold w-fit text-lg">Tugas</p>
                        <p class="w-fit text-md">
                            {{ Training::where('status', 1)->whereHas('trainingDetails', function ($query) use ($data) {
        $query->where('account_id', $data->id);})
    ->count() + Misa::where('active', 1)->whereHas('misaDetails', function ($query) use ($data) {
        $query->where('account_id', $data->id);})
    ->count()}}
                        </p>
                    </div>
                    <img class="w-[50px] h-[50px]" src="{{ asset('asset/task_complete.png') }}" alt="Task Icon">
                </div>
                <div
                    class="bg-[#f6f1e3] p-6 rounded-xl flex justify-between gap-x-3 md:gap-x-12 border border-[#002366]">
                    <div>
                        <p class="font-semibold w-fit text-lg">Panitia</p>
                        <p class="w-fit text-md">{{ $data->eventDetails->where('account_id', $data->id)->count() }}</p>
                    </div>
                    <img class="w-[50px] h-[50px]" src="{{ asset('asset/people.png') }}" alt="People Icon">
                </div>
            </div>

            <!-- Pengumuman Section -->
            <h2 class="font-bold text-xl mb-4 ml-12">Pengumuman</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 ml-12">

                <?php

                use Carbon\Carbon;

                $announcement_details = $data->announcementDetails->where('account_id', $data->id);

                Carbon::setLocale('id');
                ?>

                @foreach ($announcement_details as $announcement_detail)
                <!-- Announcement Card 1 -->
                <div class="bg-[#f6f1e3] p-8 rounded-xl shadow-lg border border-[#002366]">
                    <p class="font-semibold mb-4">
                        {{ Carbon::parse($announcement_detail->announcement->upload_time)->translatedFormat('l, j F Y') }}
                    </p>
                    <p class="text-sm">
                    {!! nl2br(e(urldecode($announcement_detail->announcement->description))) !!}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Side: Calendar Section -->
        <div class>
            <div class="grid justify-items-center mb-6">
                <h1 class="font-bold text-xl">CALENDAR</h1>
            </div>
            <div class="flex items-center justify-center">
                <div class="lg:w-7/12 md:w-9/12 sm:w-10/12 mx-auto p-4 ps-0">
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <!-- Calendar Header -->
                        <div class="flex items-center justify-between px-6 py-3 bg-[#f6f1e3]">
                            <button id="prevMonth" class="text-[#20252f]">Previous</button>
                            <h2 id="currentMonth" class="text-[#20252f] text-lg md:text-xl"></h2>
                            <button id="nextMonth" class="text-[#20252f]">Next</button>
                        </div>

                        <!-- Calendar Days Grid -->
                        <div class="grid grid-cols-7 gap-2 p-4 text-center text-sm md:text-base" id="calendar">
                            <!-- Calendar Days Go Here -->
                        </div>

                    </div>
                </div>
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

    // Function to generate the calendar for a specific month and year
    function generateCalendar(year, month) {
        const calendarElement = document.getElementById('calendar');
        const currentMonthElement = document.getElementById('currentMonth');

        // Create a date object for the first day of the specified month
        const firstDayOfMonth = new Date(year, month, 1);
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Clear the calendar
        calendarElement.innerHTML = '';

        // Set the current month text
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'October', 'November', 'December'
        ];
        currentMonthElement.innerText = `${monthNames[month]} ${year}`;

        // Calculate the day of the week for the first day of the month (0 - Sunday, 1 - Monday, ..., 6 - Saturday)
        const firstDayOfWeek = firstDayOfMonth.getDay();

        // Create headers for the days of the week
        const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        daysOfWeek.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center font-semibold';
            dayElement.innerText = day;
            calendarElement.appendChild(dayElement);
        });

        // Create empty boxes for days before the first day of the month
        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyDayElement = document.createElement('div');
            calendarElement.appendChild(emptyDayElement);
        }

        // Create boxes for each day of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center py-2 border cursor-pointer';
            dayElement.innerText = day;

            // Check if this date is the current date
            const currentDate = new Date();
            if (year === currentDate.getFullYear() && month === currentDate.getMonth() && day === currentDate
                .getDate()) {
                dayElement.classList.add('bg-[#f6f1e3]', 'text-[#20252f]'); // Add classes for the indicator
            }

            calendarElement.appendChild(dayElement);
        }
    }

    // Initialize the calendar with the current month and year
    const currentDate = new Date();
    let currentYear = currentDate.getFullYear();
    let currentMonth = currentDate.getMonth();
    generateCalendar(currentYear, currentMonth);

    // Event listeners for previous and next month buttons
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentYear, currentMonth);
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentYear, currentMonth);
    });
</script>
@endsection