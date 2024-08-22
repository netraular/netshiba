<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Tag;
class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('projects.tags', 'projects.links')->get();
        return view('projects.index', compact('categories'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $statuses = ['En proceso', 'Terminado', 'Idea'];
    
        return view('projects.create', compact('categories', 'tags', 'statuses'));
    }

    public function store(Request $request)
    {
        $project = Project::create($request->except('links'));
    
        if ($request->has('links')) {
            foreach ($request->links as $link) {
                if (!empty($link)) {
                    $project->links()->create(['url' => $link]);
                }
            }
        }
    
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