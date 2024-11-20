<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Account;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAdminRequest;
use App\Models\Group;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = null;
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
        }

        $data = Admin::find($user->id);
        return view('admin.profile_admin', [
            'user' => $user,
            'data' => $data
        ]);
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
    public function store(StoreAdminRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    public function showListAnggota()
    {
        $list_anggota = Account::get()->where('roles', 'Anggota');
        return view('admin/list_anggota')->with('list_anggota', $list_anggota);
    }

    public function deleteAnggota($id) {
        $id = Account::find($id);
        $id->delete();
        return redirect()->route('list_anggota')->with('success', 'Data berhasil dihapus');
    }

    public function updateStatusAnggota($id) {
        $id = Account::find($id);
        if ($id->status == 1) {
            $id->update(['status' => 0]);
        } else {
            $id->update(['status' => 1]);
        }
        return json_encode($id->status);
    }

    public function storeTraining(Request $request) {
        $data = $request->all();
        $admin = Auth::guard('admin')->user();
        $formfield = Validator::make($data, [
            'id' => 'required',
            'training_date' => 'required',
            'start_time' => 'required',
            'place' => 'required',
            'contact_person' => 'required',
            'phone_number' => 'required',
            'description' => 'required',
        ]);
        
        if ($formfield->fails()) {
            return back()->withErrors($formfield)->withInput();
        }

        $training = [
            'admin_id' => $admin->id,
            'training_date' => Carbon::parse($data['training_date'] . ' ' . $data['start_time']),
            'place' => $data['place'],
            'contact_person' => $data['contact_person'],
            'phone_number' => $data['phone_number'],
            'description' => $data['description'],
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        $pelatihan = Training::create($training);
        Group::create([
            'training_id' => $pelatihan->id,
            'name' => 'Kelompok '.$pelatihan->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('input_pelatihan')->with('success', 'Training berhasil di tambahkan');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $user = Auth::guard('admin')->user();
        return view('admin.edit_profile_admin', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $data = $request->all();

        $formfield = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'birthdate' => 'required',
            'region' => 'required',
        ]);

        $validatedData = [];

        foreach ($formfield->validate() as $key => $updateData) {
            $validatedData[$key] = $updateData;
        }

        $temp = [
            'updated_data' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        $validatedData['updated_data'] = $temp['updated_data'];

        $account = Admin::find($user->id);
        $account->update($validatedData);

        return redirect()->route('profile_admin')->with('success', 'Data berhasil di update');
    }

    public function updatePP(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $data = $request->all();

        $formfield = Validator::make($data, [
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);
        $validatedData = $formfield->validate();

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = $photo->getClientOriginalName();
            $photo->move(public_path('asset'), $photo_name);
            $validatedData['photo'] = $photo_name;
        } else {
            $validatedData['photo'] = 'default.png';
        }

        $account = Admin::find($user->id);
        $account->update($validatedData);

        return redirect()->route('profile_admin')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function dashboard()
    {

        // if (Auth::guard('account')->check()) {
        $user = Auth::guard('admin')->user();

        // Fetch data specific to account user
        $dashboardData = Admin::find($user->id);

        // Pass the data to the account dashboard view
        return view('admin.dashboard_admin', [
            'user' => $user,
            'data' => $dashboardData
        ]);
        // }
    }
}
