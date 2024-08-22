<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

use App\Models\Category;
class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::where('status', '!=', 'Idea')
            ->with('category', 'tags', 'links')
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $project = Project::create($request->all());
        return redirect()->route('projects.show', $project);
    }

    public function edit(Project $project)
    {
        $categories = Category::all();
        return view('projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $project->update($request->all());
        return redirect()->route('projects.show', $project);
    }
}