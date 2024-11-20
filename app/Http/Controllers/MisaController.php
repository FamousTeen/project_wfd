<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Misa;
use App\Models\Account;
use App\Models\Misa_Detail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateMisaRequest;


class MisaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = null;
        $accounts = Account::all(); // Fetch all accounts

        // Count the duties for each account by counting occurrences in misa_details
        $dutyCounts = DB::table('misa_details')
            ->select('account_id', DB::raw('count(*) as duty_count'))
            ->groupBy('account_id')
            ->get()
            ->keyBy('account_id'); // Key the result by account_id for easier access

        if (Auth::guard('admin')->check()) {
            return view('admin/input_misa', compact('accounts', 'dutyCounts'));
        } elseif (Auth::guard('account')->check()) {
            $user = Auth::guard('account')->user();
            $userData = Account::query()->where(
                'email',
                $user->email
            )->where('password', $user->password)->firstOrFail();

            $misas = Misa::with('misaDetails')->whereHas('misaDetails', function ($query) use ($userData) {
                $query->where('account_id', $userData->id);
            })->get();

            return view('anggota/jadwal', [
                'misas' => $misas,
                'data' => $userData,
                'accounts' => $accounts,
                'dutyCounts' => $dutyCounts // Pass dutyCounts to the view
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin/input_misa', compact('accounts', 'dutyCounts')); // Pass both variables to the view
    }



    public function store(Request $request)
    {
        // Debugging to inspect input data, remove once confirmed.
        // dd($request->all());

        $accounts = Account::all();
        // Decode JSON strings from the selected options
        $selectedOptions = json_decode($request->input('selectedOptions')[0], true);
        $selectedOptions2 = json_decode($request->input('selectedOptions2')[0], true);

        // Validate that decoding was successful
        if (!is_array($selectedOptions) || !is_array($selectedOptions2)) {
            return back()->withErrors(['selectedOptions' => 'Invalid format for selected options.']);
        }

        // Now you have arrays of IDs and roles
        $memberIdArray = $selectedOptions;
        $rolesArray = $selectedOptions2;

        // Validate inputs
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'activity_datetime' => 'required|date',
            'activity_time' => 'required|date_format:H:i',
            'upload_datetime' => 'nullable|date',
            'upload_time' => 'nullable|date_format:H:i',
            'deadline_datetime' => 'nullable|date',
            'customTugas' => 'array',
            'customTugas.*' => 'nullable|string|max:255',
        ]);

        // Merge activity date and time
        try {
            $activityDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->activity_datetime . ' ' . $request->activity_time);
        } catch (\Exception $e) {
            return back()->withErrors(['activity_datetime' => 'Invalid activity date or time format.']);
        }

        // Merge upload date and time, defaulting to current date/time if not provided
        $uploadDate = $request->input('upload_datetime') ?? Carbon::now()->format('Y-m-d');
        $uploadTime = $request->input('upload_time') ?? Carbon::now()->format('H:i');
        try {
            $uploadDateTime = Carbon::createFromFormat('Y-m-d H:i', "$uploadDate $uploadTime");
        } catch (\Exception $e) {
            return back()->withErrors(['upload_datetime' => 'Invalid upload date or time format.']);
        }

        // Insert into the `Misa` table
        $misa = Misa::create([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'activity_datetime' => $activityDateTime->format('Y-m-d H:i'),
            'upload_datetime' => $uploadDateTime->format('Y-m-d H:i:s'),
            'deadline_datetime' => $request->input('deadline_datetime') ?? null,
            'evaluation' => "",
            'status' => "Proses",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Store each `Misa_Detail` record
        foreach ($memberIdArray as $index => $account_id) {
            $role = $rolesArray[$index] ?? null;

            $misaDetailData = [
                'misa_id' => $misa->id,
                'account_id' => $account_id,
                'roles' => $role,
                'participation' => null,
                'confirmation' => null
            ];

            Misa_Detail::create($misaDetailData);
        }

        // Redirect with success message
        return redirect()->route('input_misa')->with('success', 'Misa created successfully.');
    }





    /**
     * Display the specified resource.
     */
    public function show(Misa $misa) {}

    /**
     * Show the form for editing the specified resource.
     */
    // Example Controller Method
    public function edit($id)
    {
        $misa = Misa::findOrFail($id); // Retrieve the misa record by its ID
        $misaDetails = Misa_Detail::where('misa_id', $misa->id)->get(); // Fetch related misa_details
        $accounts = Account::all(); // Fetch accounts for the dropdown if needed




        return view('admin.misaDetails.edit', compact('misa', 'misaDetails', 'accounts')); // Pass data to the view
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Misa $misa)

    {

        // Validate input data for misa
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'activity_datetime' => 'required|date',
            'upload_datetime' => 'required|date',
            'evaluation' => 'required|string|max:1000',
            'status' => 'required|string',
            'misa_details' => 'array', // Expect an array for misa_details
            'misa_details.*.account_id' => 'required|exists:accounts,id',
            'misa_details.*.roles' => 'required|string|max:255',
            'misa_details.*.participation' => 'nullable|boolean',
            'misa_details.*.confirmation' => 'nullable|boolean',
        ]);

        // Update the main misa record
        $misa->update([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'activity_datetime' => Carbon::parse($request->input('activity_datetime')),
            'upload_datetime' => Carbon::parse($request->input('upload_datetime')),
            'evaluation' => $request->input('evaluation'),
            'status' => $request->input('status'),
        ]);

        // Update or create misa_details
        if ($request->has('misa_details')) {
            foreach ($request->input('misa_details') as $index => $detailData) {
                Misa_Detail::updateOrCreate(
                    [
                        'misa_id' => $misa->id,
                        'account_id' => $detailData['account_id'], // Correct account_id reference
                    ],
                    [
                        'roles' => $detailData['roles'], // Correct roles reference
                        'participation' => $detailData['participation'] ?? false, // Default to false if not set
                        'confirmation' => $detailData['confirmation'] ?? false, // Default to false if not set
                    ]
                );
            }
        }

        return redirect()->route('admin.jadwal_misa', $misa->id)
            ->with('success', __('Misa and its details updated successfully.'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Misa $misa)
    {
        $misa->update([
            'active' => 0
        ]);
        return back()->with('success', 'Acara berhasil dihapus.');
    }

    public function showMisaList()
    {
        $user = null;
    
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $misas = Misa::where('active', 1)->with('misaDetails')->get();
    
            // Loop through each misa to update its status
            foreach ($misas as $misa) {
                // Count the number of members with confirmation = 0
                $pendingCount = $misa->misaDetails->where('confirmation', 0)->count();
    
                // Check if all members have confirmation = 1
                $allConfirmed = $misa->misaDetails->every(function ($detail) {
                    return $detail->confirmation == 1;
                });
    
                // Ensure deadline is parsed correctly
                $deadline = Carbon::parse($misa->deadline_datetime);
    
                // Check if deadline has passed
                $deadlinePassed = Carbon::now()->greaterThan($deadline);
    
                // Debugging output to check the current time and deadline time
                logger("Current time: " . Carbon::now());
                logger("Misa deadline: " . $deadline);
                logger("Deadline passed? " . ($deadlinePassed ? 'Yes' : 'No'));
                logger("Pending count: " . $pendingCount);
                logger("All confirmed? " . ($allConfirmed ? 'Yes' : 'No'));
    
                // Set the status based on conditions
                if ($pendingCount > 0 && $deadlinePassed) {
                    $status = "Tertunda"; // If deadline has passed and there are pending confirmations
                } elseif ($pendingCount > 0 && !$deadlinePassed) {
                    $status = "Proses"; // If still pending confirmations and deadline hasn't passed
                } elseif ($allConfirmed) {
                    $status = "Berhasil"; // If all members have confirmed, set status to 'Berhasil'
                } else {
                    $status = "Proses"; // Default status if still in progress
                }
    
                // Update the misa status in the database
                $misa->status = $status;
                $misa->save();  // Save the updated status to the database
            }
    
            return view('admin.jadwal_misa', [
                'user' => $user,
                'misas' => $misas
            ]);
        } elseif (Auth::guard('account')->check()) {
            $user = Auth::guard('account')->user();
    
            $userData = Account::query()
                ->where('email', $user->email)
                ->where('password', $user->password)
                ->firstOrFail();
    
            $misas = Misa::query()->where('active', 1)->with('misaDetails')->get();
    
            // Loop through each misa to update its status
            foreach ($misas as $misa) {
                $pendingCount = $misa->misaDetails->where('confirmation', 0)->count();
    
                $allConfirmed = $misa->misaDetails->every(function ($detail) {
                    return $detail->confirmation == 1;
                });
    
                // Ensure deadline is parsed correctly
                $deadline = Carbon::parse($misa->deadline_datetime);
    
                // Check if deadline has passed
                $deadlinePassed = Carbon::now()->greaterThan($deadline);
    
                // Set the status based on conditions
                if ($pendingCount > 0 && $deadlinePassed) {
                    $status = "Tertunda"; // If deadline has passed and there are pending confirmations
                } elseif ($pendingCount > 0 && !$deadlinePassed) {
                    $status = "Proses"; // If still pending confirmations and deadline hasn't passed
                } elseif ($allConfirmed) {
                    $status = "Berhasil"; // If all members have confirmed, set status to 'Berhasil'
                } else {
                    $status = "Proses"; // Default status if still in progress
                }
    
                $misa->status = $status;
                $misa->save(); // Update status in the database
            }
    
            return view('anggota.jadwal', [
                'misas' => $misas,
                'user' => $userData
            ]);
        }
    }
    

    public function addAnggota(Request $request, Misa $misa)
    {
        // Validate the input
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'role' => 'required|string',
        ]);

        // Determine the role, using custom task if applicable
        $role = $request->input('role') === 'custom' ? $request->input('custom_task') : $request->input('role');

        // Add the new detail to the misa
        $misa->misaDetails()->create([
            'account_id' => $request->input('account_id'),
            'roles' => $role,
            'confirmation' => 0, // default confirmation status
        ]);

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan');
    }
}
