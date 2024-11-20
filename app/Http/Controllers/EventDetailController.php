<?php

namespace App\Http\Controllers;

use App\Models\EventDetail;
use App\Http\Requests\StoreEventDetailRequest;
use App\Http\Requests\UpdateEventDetailRequest;
use Illuminate\Http\Request;

class EventDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
    public function store(StoreEventDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EventDetail $eventDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventDetail $eventDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventDetailRequest $request, EventDetail $eventDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventDetail $eventDetail)
    {
        //
    }
}
