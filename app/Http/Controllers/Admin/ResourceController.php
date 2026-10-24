<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminResources;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(string $resource): View
    {
        $def = AdminResources::get($resource);
        $model = $def['model'];
        $sortable = in_array('sort_order', array_keys($def['fields']), true);

        $items = $model::query()
            ->when($sortable, fn ($q) => $q->orderBy('sort_order'))
            ->orderByDesc('id')
            ->paginate(25);

        return view('admin.resource.index', ['def' => $def, 'items' => $items]);
    }

    public function create(string $resource): View
    {
        $def = AdminResources::get($resource);

        return view('admin.resource.form', ['def' => $def, 'item' => new $def['model']]);
    }

    public function store(Request $request, string $resource): RedirectResponse
    {
        $def = AdminResources::get($resource);
        $item = new $def['model'];
        $this->fillAndSave($request, $def, $item);

        return redirect()->route('admin.resource.index', $resource)->with('status', $def['singular'].' created.');
    }

    public function edit(string $resource, int $id): View
    {
        $def = AdminResources::get($resource);

        return view('admin.resource.form', ['def' => $def, 'item' => $def['model']::findOrFail($id)]);
    }

    public function update(Request $request, string $resource, int $id): RedirectResponse
    {
        $def = AdminResources::get($resource);
        $item = $def['model']::findOrFail($id);
        $this->fillAndSave($request, $def, $item);

        return redirect()->route('admin.resource.edit', [$resource, $item->id])->with('status', 'Saved.');
    }

    public function destroy(Request $request, string $resource, int $id): RedirectResponse
    {
        abort_unless($request->user()->isAdmin(), 403);
        $def = AdminResources::get($resource);
        $def['model']::findOrFail($id)->delete();
        Cache::forget('sitemap.xml');

        return redirect()->route('admin.resource.index', $resource)->with('status', $def['singular'].' deleted.');
    }

    private function fillAndSave(Request $request, array $def, Model $item): void
    {
        $rules = [];
        foreach ($def['fields'] as $name => $field) {
            $rules[$name] = $field['rules'] ?? ['nullable'];
            if ($field['type'] === 'checkbox') {
                $rules[$name] = ['nullable', 'boolean'];
            }
        }

        $titleField = array_key_exists('title', $def['fields']) ? 'title' : (array_key_exists('name', $def['fields']) ? 'name' : null);

        if (isset($def['fields']['slug'])) {
            $table = $item->getTable();
            $rules['slug'][] = Rule::unique($table, 'slug')->ignore($item->id);
            if ($titleField && ! $request->filled('slug')) {
                $request->merge(['slug' => Str::slug((string) $request->input($titleField))]);
            }
        }

        $data = $request->validate($rules);

        foreach ($def['fields'] as $name => $field) {
            $value = $data[$name] ?? null;

            $item->{$name} = match ($field['type']) {
                'checkbox' => $request->boolean($name),
                'lines' => array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $value)))),
                'number' => $value === null ? ($name === 'sort_order' ? 0 : null) : (int) $value,
                default => $value,
            };
        }

        if ($item instanceof \App\Models\Post && $item->status === 'published' && ! $item->published_at) {
            $item->published_at = now();
        }

        if ($item instanceof \App\Models\Post && ! $item->author_id) {
            $item->author_id = $request->user()->id;
        }

        $item->save();
        Cache::forget('sitemap.xml');
    }
}
