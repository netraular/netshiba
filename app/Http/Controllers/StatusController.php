<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::all();
        return view('statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('statuses.create');
    }

    public function store(Request $request)
    {
        $status = Status::create($request->all());
        return redirect()->route('statuses.index')->with('success', 'Estado añadido correctamente');
    }

    public function edit(Status $status)
    {
        return view('statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $status->update($request->all());
        return redirect()->route('statuses.index')->with('success', 'Estado actualizado correctamente');
    }

    public function destroy(Status $status)
    {
        $status->delete();
        return redirect()->route('statuses.index')->with('success', 'Estado eliminado correctamente');
    }
}