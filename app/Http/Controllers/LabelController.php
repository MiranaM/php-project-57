<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function __construct()
    {
        // Гости видят только список (index)
        $this->middleware('auth')->except(['index']);
    }

    // GET /labels
    public function index()
    {
        $labels = Label::all();
        return view('labels.index', compact('labels'));
    }

    // GET /labels/create
    public function create()
    {
        return view('labels.create');
    }

    // POST /labels
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:labels,name',
            'description' => 'nullable|string',
        ]);

        Label::create($data);

        flash(__('Метка успешно создана'))->success();
        return redirect()->route('labels.index');
    }

    // GET /labels/{label}/edit
    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    // PATCH /labels/{label}
    public function update(Request $request, Label $label)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:labels,name,' . $label->id,
            'description' => 'nullable|string',
        ]);

        $label->update($data);

        flash(__('Метка успешно обновлена'))->success();
        return redirect()->route('labels.index');
    }

    // DELETE /labels/{label}
    public function destroy(Label $label)
    {
        $label->delete();

        flash(__('Метка успешно удалена'))->success();
        return redirect()->route('labels.index');
    }
}