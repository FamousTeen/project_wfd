<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Announcement;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Account;
use App\Models\AnnouncementDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();
        $announcements = Announcement::get()->where('type', 0)->where('status', 1);
        return view('admin.post_pengumuman', [
            'announcements' => $announcements,
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncementRequest $request)
    {
        $request->validate([
            'eventDesc' => 'required'
        ]);


        $created_announcement = Announcement::create([
            'admin_id' => Auth::guard('admin')->user()->id,
            'upload_time' => Carbon::now()->format('Y-m-d H:i:s'),
            'description' => $request->eventDesc,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $account_count = Account::where('status', 1)->count();

        for ($i = 1; $i <= $account_count; $i++) {
            // if ((Account::where('id', $i)->firstOrFail()->roles) == "Anggota") {
            AnnouncementDetail::create([
                'announcement_id' => $created_announcement->id,
                'account_id' => $i
            ]);
            // }
        }

        return redirect()->route('announcements.create')->with('success2', 'Announcement berhasil dibuat dan disebarkan ke seluruh anggota dan pengurus.');
    }

    /**
     * Display the specified resource.
     */
    public function showForPengurus(Announcement $announcement)
    {
        $user = Auth::guard('admin')->user();
        $announcement = Announcement::get()->where('type', 1)->where('status', 1);
        return view('admin.khusus_pengurus.pengumuman_pengurus', compact('announcement', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function post_pengumuman_pengurus(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $data = $request->all();
        $formField = Validator::make($data, [
            'description' => 'required|string'
        ]);
        $validated_data = $formField->validate();
        $data = [
            'admin_id' => $admin->id,
            'upload_time' => Carbon::now()->format('Y-m-d H:i:s'),
            'description' => $validated_data['description'],
            'type' => 1
        ];

        Announcement::create($data);
        return redirect()->route('pengumuman_pengurus')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function update_pengumuman_pengurus(Request $request, $id)
    {
        $data = $request->all();
        $formField = Validator::make($data, [
            'description' => 'required|string'
        ]);
        $validated_data = $formField->validate();
        $data = [
            'upload_time' => Carbon::now()->format('Y-m-d H:i:s'),
            'description' => $validated_data['description']
        ];

        $ann = Announcement::find($id);
        $ann->update($data);
        return redirect()->route('pengumuman_pengurus')->with('success', 'Pengumuman berhasil diupdate.');
    }

    public function delete_pengumuman_pengurus($id)
    {
        $ann = Announcement::find($id);
        $data = [
            'status' => 0
        ];
        $ann->update($data);
        return redirect()->route('pengumuman_pengurus')->with('success', 'Pengumuman berhasil didelete.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $request->validate([
            'eventDesc' => 'required'
        ]);

        $announcement->update([
            'description' => $request->eventDesc,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('announcements.create')->with('success', 'Announcement berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $isUpdated = $announcement->update([
            'status' => 0,
        ]);

        return redirect()->route('announcements.create')->with('success', 'Announcement berhasil dihapus.');
    }
}
