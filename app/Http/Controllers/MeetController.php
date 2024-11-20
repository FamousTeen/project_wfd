<?php

namespace App\Http\Controllers;

use App\Models\Meet;
use App\Http\Requests\StoreMeetRequest;
use App\Http\Requests\UpdateMeetRequest;
use Carbon\Carbon;

class MeetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeetRequest $request)
    {
        // input rapat pengurus
        $request->validate([
            'namaJadwal' => 'required',
            'tanggalJadwal' => 'required|date',
            'waktuJadwal' => 'required',
            'lokasiJadwal' => 'required',
            'meetDesc' => 'required'
        ]);

        $datetime = Carbon::createFromFormat('Y-m-d H:i', $request->tanggalJadwal . ' ' . $request->waktuJadwal);
        
        Meet::create([
            'title' => $request->namaJadwal,
            'date' => $datetime->format('Y-m-d H:i:s'),
            'place' => $request->lokasiJadwal,
            'notulen' => $request->meetDesc,
            'permission' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('jadwal_pengurus')->with('success', 'Rapat pengurus berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meet $meet)
    {
        return view('admin.detail_rapat', [
            'meet' => $meet
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meet $meet)
    {
        return view('admin.edit_rapat', compact('meet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeetRequest $request, Meet $meet)
    {
        $request->validate([
            'meetNotulen' => 'required',
        ]);

        $meet->update([
            'notulen' => $request->meetNotulen
        ]);

        return redirect()->route('meets.show', compact('meet'))->with('success', 'Rapat berhasil diupdate.');
    }

    public function updatePengurus(UpdateMeetRequest $request, Meet $meet)
    {
        $request->validate([
            'namaJadwal' => 'required',
            'tanggalJadwal' => 'required|date',
            'waktuJadwal' => 'required',
            'lokasiJadwal' => 'required',
            'meetDesc' => 'required'
        ]);

        $datetime = Carbon::createFromFormat('Y-m-d H:i', $request->tanggalJadwal . ' ' . $request->waktuJadwal);
        
        Meet::where('id', $request->meet)->update([
            'title' => $request->namaJadwal,
            'date' => $datetime->format('Y-m-d H:i:s'),
            'place' => $request->lokasiJadwal,
            'notulen' => $request->meetDesc,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('jadwal_pengurus')->with('success', 'Rapat pengurus berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meet $meet)
    {
        //
    }
}
