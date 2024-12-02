<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Account;
use App\Models\Training;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTrainingRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = null;
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $trainings = Training::where('status', 1)->get();

            return view('admin.training.daftar_pelatihan', [
                'user' => $user,
                'trainings' => $trainings
            ]);

        } elseif (Auth::guard('account')->check()) {
            $user = Auth::guard('account')->user();

            // Fetch data for the dashboard
            $userData = Account::query()->where(
                'email',
                $user->email
            )->where('password', $user->password)->firstOrFail();

            $events = Training::query()->where('status', 1)->get();
            return view('anggota/alur_acara/acara', [
                'events' => $events,
                'user' => $userData
            ]);
        }
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
    public function store(StoreTrainingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Training $training)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($training, $g)
    {
        $trainings = Training::find($training);
        $groups = Group::find($g);

        return view('admin.training.edit_pelatihan')->with('training', $trainings)->with('group', $groups);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $g, $training)
    {
        $data = $request->all();
        $formfield = Validator::make($data, [
            'group' => 'required',
            'place' => 'required',
            'date' => 'required',
            'time' => 'required',
            'contact_person' => 'required',
            'phone_number' => 'required',
            'description' => 'required',
        ]);

        if ($formfield->fails()) {
            return redirect()->back()->withErrors($formfield)->withInput();
        }

        $trainings = Training::find($training);
        $training_data = [
            'place' => $data['place'],
            'training_date' => Carbon::parse($data['date'] . ' ' . $data['time']),
            'contact_person' => $data['contact_person'],
            'phone_number' => $data['phone_number'],
            'description' => $data['description'],
        ];
        $trainings->update($training_data);

        $group = Group::find($g);
        $group_data = [
            'name' => $data['group']
        ];
        $group->update($group_data);

        return redirect()->route('trainings.index')->with('success', 'Pelatihan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training)
    {
        $training->update([
            'status' => 0
        ]);

        return redirect()->route('trainings.index')->with('success', 'Pelatihan berhasil dihapus.');
    }
}
