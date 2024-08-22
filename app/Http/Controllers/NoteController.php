<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Project;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $note = $project->notes()->create($request->all());
        return redirect()->route('projects.show', $project);
    }

    public function create(Project $project)
    {
        return view('notes.create', compact('project'));
    }

    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }
}