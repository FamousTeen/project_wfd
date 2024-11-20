<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Http\Requests\StoreTemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::where('status', 1)->get();
        return view('admin.khusus_pengurus.dokumen_pengurus', compact('templates'));
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
    public function store(StoreTemplateRequest $request)
    {
        $user = Auth::guard('admin')->user();

        $data = $request->all();

        $formfield = Validator::make($data, [
            'fileName' => 'required',
            'file' => 'required|file|mimes:pdf',
        ]);
        $validatedData = $formfield->validate();

        $title = pathinfo($validatedData['fileName'], PATHINFO_FILENAME);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('asset'), $file_name);
            $validatedData['file'] = $file_name;
        } else {
            $validatedData['file'] = 'dokumen.pdf';
        }

        Template::create([
            'admin_id' => $user->id,
            'title' => $title,
            'file' => $validatedData['file'], 
        ]);

        return redirect()->route('templates.index')->with('success', 'Template berhasil di upload');
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        $templates = Template::all();

        return view('admin.khusus_pengurus.dokumen_pengurus', compact(['template', 'templates']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTemplateRequest $request, Template $template)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        $template->update([
            'status' => 0
        ]);

        return redirect()->route('templates.index')->with('success', 'Template berhasil dihapus.');
    }
}
