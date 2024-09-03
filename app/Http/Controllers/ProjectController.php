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
        $projects = Project::with('versions', 'tags', 'links')->get();
        return view('projects.index', compact('projects'));
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
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'complexity' => 'required|integer|min:1|max:10',
        ]);

        $projectData = $request->except('links', 'tags', 'logo', 'background');

        if ($request->hasFile('logo')) {
            $projectData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('background')) {
            $projectData['background'] = $request->file('background')->store('backgrounds', 'public');
        }

        $project = Project::create($projectData);

        if ($request->has('links')) {
            foreach ($request->links as $link) {
                if (!empty($link)) {
                    $project->links()->create(['url' => $link]);
                }
            }
        }

        if ($request->has('tags')) {
            foreach ($request->tags as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $project->tags()->attach($tag);
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