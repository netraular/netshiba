<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Link;
use App\Models\Status;
use Illuminate\Http\Request;
use Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['versions', 'tags', 'links' => function ($query) {
            $query->orderBy('order')->orderBy('id');
        }])->get();

        // Filtrar enlaces ocultos si el usuario no está autenticado
        if (!Auth::check()) {
            $projects->each(function ($project) {
                $project->links = $project->links->filter(function ($link) {
                    return $link->hidden == 0;
                });
            });
        }

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
        $statuses = Status::all();
    
        return view('projects.create', compact('categories', 'tags', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'complexity' => 'required|integer|min:1|max:10',
        ]);

        $projectData = $request->except('links', 'tags', 'logo', 'background', 'link_icons', 'link_names', 'link_hiddens', 'link_orders');

        if ($request->hasFile('logo')) {
            $projectData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('background')) {
            $projectData['background'] = $request->file('background')->store('backgrounds', 'public');
        }

        $project = Project::create($projectData);

        if ($request->has('links')) {
            foreach ($request->links as $index => $link) {
                if (!empty($link)) {
                    $project->links()->create([
                        'url' => $link,
                        'icon' => $request->link_icons[$index] ?? '',
                        'name' => $request->link_names[$index] ?? '',
                        'hidden' => isset($request->link_hiddens[$index]) ? 1 : 0,
                        'order' => $index + 1, // Guardar el orden basado en el índice
                    ]);
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
        $tags = Tag::all();
        $statuses = Status::all();
        return view('projects.edit', compact('project', 'categories', 'tags', 'statuses'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'complexity' => 'required|integer|min:1|max:10',
        ]);

        $projectData = $request->except('links', 'tags', 'logo', 'background', 'link_icons', 'link_names', 'link_hiddens', 'link_orders', 'link_ids', 'link_delete');

        if ($request->hasFile('logo')) {
            $projectData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('background')) {
            $projectData['background'] = $request->file('background')->store('backgrounds', 'public');
        }

        $project->update($projectData);

        // Update links
        if ($request->has('links')) {
            $linkIds = $request->link_ids ?? [];
            $linksToDelete = $project->links->pluck('id')->diff($linkIds);

            foreach ($linksToDelete as $linkId) {
                Link::where('id', $linkId)->delete();
            }

            foreach ($request->links as $index => $link) {
                if (!empty($link)) {
                    $linkId = $request->link_ids[$index] ?? null;
                    $linkDelete = $request->link_delete[$index] ?? 'false';

                    if ($linkDelete === 'true') {
                        if ($linkId) {
                            Link::where('id', $linkId)->delete();
                        }
                    } else {
                        $linkData = [
                            'url' => $link,
                            'icon' => $request->link_icons[$index] ?? '',
                            'name' => $request->link_names[$index] ?? '',
                            'hidden' => isset($request->link_hiddens[$index]) ? 1 : 0,
                            'order' => $index + 1, // Guardar el orden basado en el índice
                        ];

                        if ($linkId) {
                            Link::where('id', $linkId)->update($linkData);
                        } else {
                            $project->links()->create($linkData);
                        }
                    }
                }
            }
        } else {
            // Si no se envían enlaces, eliminar todos los enlaces del proyecto
            $project->links()->delete();
        }

        // Update tags
        $project->tags()->sync([]);
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
    public function destroy(Project $project)
    {
        // Eliminar enlaces relacionados
        $project->links()->delete();

        // Eliminar etiquetas relacionadas
        $project->tags()->detach();

        // Eliminar el proyecto
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado correctamente');
    }
}