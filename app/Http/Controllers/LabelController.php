<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        $labels = Label::all();
        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        return view('labels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:labels|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Это обязательное поле',
            'name.unique' => 'Метка с таким именем уже существует'
        ]);

        Label::create($validated);
        flash('Метка успешно создана')->success();
        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        $validated = $request->validate([
            'name' => 'required|unique:labels,name,' . $label->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $label->update($validated);
        flash('Метка успешно изменена')->success();
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash('Не удалось удалить метку')->error();
            return redirect()->route('labels.index');
        }

        $label->delete();
        flash('Метка успешно удалена')->success();
        return redirect()->route('labels.index');
    }
}
