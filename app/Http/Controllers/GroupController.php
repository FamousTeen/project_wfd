<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Account;
use App\Models\GroupDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

class GroupController extends Controller
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
        // Fetch all accounts
        $accounts = Account::all();

        // Fetch IDs of existing members in the group (if any)
        $existingMemberIds = GroupDetail::pluck('account_id')->toArray();

        // Return the view with the data
        return view('add-group', [
            'accounts' => $accounts,
            'existingMemberIds' => $existingMemberIds,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Decode 'accounts' if it is a JSON string
        if (is_string($request->accounts)) {
            $request->merge([
                'accounts' => json_decode($request->accounts, true),
            ]);
        }

        // Validate
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'accounts' => 'required|array',
            'accounts.*' => 'exists:accounts,id',
        ]);

        // Create group
        $group = Group::create([
            'name' => $validatedData['group_name'],
            'training_id' => null,
        ]);

        // Attach members
        foreach ($validatedData['accounts'] as $accountId) {
            $group->groupDetails()->create(['account_id' => $accountId]);
        }

        return redirect()->route('input_anggota_pelatihan')->with('success', 'Kelompok berhasil ditambahkan');
    }



    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        // Delete related records from group_details
        $group->groupDetails()->delete();

        // Now delete the group itself
        $group->delete();

        return redirect()->route('input_anggota_pelatihan')->with('success', 'Group deleted successfully!');
    }


    public function inputAnggotaPelatihan()
    {
        // Fetch groups and their details
        $groups = Group::with('groupDetails')->get();


        return view('admin.training.input_anggota_pelatihan', compact('groups'));
    }

    public function addMember(Request $request, Group $group)
    {

        $request->validate([
            'account_id' => 'required|exists:accounts,id',
        ]);

        $groupDetail = GroupDetail::create([
            'group_id' => $group->id,
            'account_id' => $request->account_id,
        ]);

        return response()->json([
            'success' => true,
            'member' => $groupDetail,
        ]);
    }

    public function updateMembers(Request $request, $groupId)
    {
        // Validate the input
        $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:accounts,id',  // Validate that each member ID exists in the accounts table
        ]);

        // Debugging: Log incoming member_ids
        Log::info('Received member_ids:', $request->input('member_ids')); // Add this line for debugging

        // Get the group
        $group = Group::findOrFail($groupId);

        // Convert the comma-separated string back into an array (since the JavaScript now joins with commas)
        $memberIds = explode(',', $request->input('member_ids')[0]); // Assuming member_ids is an array of strings

        // Debugging: Log the converted member IDs
        Log::info('Converted member_ids:', $memberIds); // Add this line for debugging

        // Ensure all member IDs are integers
        $memberIds = array_map('intval', $memberIds);

        // Sync the group members (this will remove any members not in the new list)
        // First, delete members that are no longer in the list
        $group->groupDetails()->whereNotIn('account_id', $memberIds)->delete();

        // Debugging: Log the result after deletion
        Log::info('Group members after deletion:', $group->groupDetails()->pluck('account_id')->toArray());

        // Then, add members that are not already part of the group
        foreach ($memberIds as $accountId) {
            // Only add the member if it's not already in the group
            if (!$group->groupDetails()->where('account_id', $accountId)->exists()) {
                $group->groupDetails()->create([
                    'account_id' => $accountId,
                ]);
            }
        }

        // Debugging: Log the final group members
        Log::info('Final group members:', $group->groupDetails()->pluck('account_id')->toArray());

        return redirect()->route('input_anggota_pelatihan')->with('success', 'Group members updated successfully.');
    }


    public function getDetails($groupId)
    {
        $group = Group::find($groupId);
        if (!$group) {
            return response()->json(['error' => 'Group not found'], 404);
        }

        $groupDetails = $group->members;
        return response()->json($groupDetails);
    }
}
