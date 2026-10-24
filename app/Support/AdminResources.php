<?php

namespace App\Support;

use App\Models\Faq;
use App\Models\Post;
use App\Models\PricingPackage;
use App\Models\Project;
use App\Models\Service;

/**
 * Field definitions for the simple admin CRUD screens.
 * Field types: text, textarea, markdown, lines (array, one item per line), number,
 * checkbox, select, datetime.
 */
class AdminResources
{
    public static function all(): array
    {
        return [
            'services' => [
                'label' => 'Services',
                'singular' => 'Service',
                'model' => Service::class,
                'columns' => ['title' => 'Title', 'is_published' => 'Published', 'sort_order' => 'Order'],
                'public_route' => 'services.show',
                'fields' => [
                    'title' => ['type' => 'text', 'label' => 'Title', 'rules' => ['required', 'string', 'max:150']],
                    'title_bn' => ['type' => 'text', 'label' => 'Title (Bangla)', 'rules' => ['nullable', 'string', 'max:150']],
                    'slug' => ['type' => 'text', 'label' => 'Slug', 'help' => 'Leave empty to create from the title.', 'rules' => ['nullable', 'alpha_dash', 'max:150']],
                    'icon' => ['type' => 'text', 'label' => 'Icon (emoji)', 'rules' => ['nullable', 'string', 'max:16']],
                    'summary' => ['type' => 'textarea', 'label' => 'Summary', 'rules' => ['required', 'string', 'max:300']],
                    'body' => ['type' => 'markdown', 'label' => 'Description (Markdown)', 'rules' => ['nullable', 'string', 'max:20000']],
                    'features' => ['type' => 'lines', 'label' => 'Features (one per line)', 'rules' => ['nullable', 'string', 'max:5000']],
                    'tech' => ['type' => 'lines', 'label' => 'Technology (one per line)', 'rules' => ['nullable', 'string', 'max:2000']],
                    'ideal_for' => ['type' => 'lines', 'label' => 'Ideal for (one per line)', 'rules' => ['nullable', 'string', 'max:2000']],
                    'price_note' => ['type' => 'text', 'label' => 'Price note', 'rules' => ['nullable', 'string', 'max:190']],
                    'sort_order' => ['type' => 'number', 'label' => 'Sort order', 'rules' => ['nullable', 'integer', 'min:0', 'max:1000']],
                    'is_featured' => ['type' => 'checkbox', 'label' => 'Featured'],
                    'is_published' => ['type' => 'checkbox', 'label' => 'Published'],
                    'meta_title' => ['type' => 'text', 'label' => 'SEO title', 'rules' => ['nullable', 'string', 'max:70']],
                    'meta_description' => ['type' => 'text', 'label' => 'SEO description', 'rules' => ['nullable', 'string', 'max:160']],
                ],
            ],
            'projects' => [
                'label' => 'Projects',
                'singular' => 'Project',
                'model' => Project::class,
                'columns' => ['title' => 'Title', 'status' => 'Status', 'is_published' => 'Published'],
                'public_route' => 'work.show',
                'fields' => [
                    'title' => ['type' => 'text', 'label' => 'Title', 'rules' => ['required', 'string', 'max:150']],
                    'slug' => ['type' => 'text', 'label' => 'Slug', 'help' => 'Leave empty to create from the title.', 'rules' => ['nullable', 'alpha_dash', 'max:150']],
                    'client_type' => ['type' => 'text', 'label' => 'Client / type', 'rules' => ['nullable', 'string', 'max:150']],
                    'category' => ['type' => 'select', 'label' => 'Category', 'options' => Project::CATEGORIES, 'rules' => ['required', 'in:'.implode(',', array_keys(Project::CATEGORIES))]],
                    'status' => ['type' => 'select', 'label' => 'Status', 'options' => Project::STATUSES, 'rules' => ['required', 'in:'.implode(',', array_keys(Project::STATUSES))]],
                    'summary' => ['type' => 'textarea', 'label' => 'Summary', 'rules' => ['required', 'string', 'max:300']],
                    'problem' => ['type' => 'textarea', 'label' => 'Problem', 'rules' => ['nullable', 'string', 'max:3000']],
                    'solution' => ['type' => 'textarea', 'label' => 'Solution', 'rules' => ['nullable', 'string', 'max:3000']],
                    'results' => ['type' => 'textarea', 'label' => 'Result', 'rules' => ['nullable', 'string', 'max:3000']],
                    'features' => ['type' => 'lines', 'label' => 'Key features (one per line)', 'rules' => ['nullable', 'string', 'max:5000']],
                    'tech_stack' => ['type' => 'lines', 'label' => 'Tech stack (one per line)', 'rules' => ['nullable', 'string', 'max:2000']],
                    'url' => ['type' => 'text', 'label' => 'Live URL', 'rules' => ['nullable', 'url:https,http', 'max:255']],
                    'sort_order' => ['type' => 'number', 'label' => 'Sort order', 'rules' => ['nullable', 'integer', 'min:0', 'max:1000']],
                    'is_featured' => ['type' => 'checkbox', 'label' => 'Featured'],
                    'is_published' => ['type' => 'checkbox', 'label' => 'Published'],
                    'meta_title' => ['type' => 'text', 'label' => 'SEO title', 'rules' => ['nullable', 'string', 'max:70']],
                    'meta_description' => ['type' => 'text', 'label' => 'SEO description', 'rules' => ['nullable', 'string', 'max:160']],
                ],
            ],
            'packages' => [
                'label' => 'Pricing',
                'singular' => 'Package',
                'model' => PricingPackage::class,
                'columns' => ['name' => 'Name', 'price' => 'Price (BDT)', 'is_published' => 'Published', 'sort_order' => 'Order'],
                'public_route' => null,
                'fields' => [
                    'name' => ['type' => 'text', 'label' => 'Name', 'rules' => ['required', 'string', 'max:150']],
                    'slug' => ['type' => 'text', 'label' => 'Slug', 'help' => 'Leave empty to create from the name.', 'rules' => ['nullable', 'alpha_dash', 'max:150']],
                    'group' => ['type' => 'select', 'label' => 'Group', 'options' => PricingPackage::GROUPS, 'rules' => ['required', 'in:'.implode(',', array_keys(PricingPackage::GROUPS))]],
                    'price' => ['type' => 'number', 'label' => 'Price (BDT, whole number)', 'rules' => ['required', 'integer', 'min:0', 'max:100000000']],
                    'price_suffix' => ['type' => 'text', 'label' => 'Price suffix (e.g. /month)', 'rules' => ['nullable', 'string', 'max:40']],
                    'delivery' => ['type' => 'text', 'label' => 'Delivery time', 'rules' => ['nullable', 'string', 'max:60']],
                    'description' => ['type' => 'text', 'label' => 'Short description', 'rules' => ['nullable', 'string', 'max:190']],
                    'features' => ['type' => 'lines', 'label' => 'Features (one per line)', 'rules' => ['nullable', 'string', 'max:3000']],
                    'sort_order' => ['type' => 'number', 'label' => 'Sort order', 'rules' => ['nullable', 'integer', 'min:0', 'max:1000']],
                    'is_highlighted' => ['type' => 'checkbox', 'label' => 'Highlight as most popular'],
                    'is_published' => ['type' => 'checkbox', 'label' => 'Published'],
                ],
            ],
            'posts' => [
                'label' => 'Insights',
                'singular' => 'Post',
                'model' => Post::class,
                'columns' => ['title' => 'Title', 'status' => 'Status', 'published_at' => 'Published at'],
                'public_route' => 'insights.show',
                'fields' => [
                    'title' => ['type' => 'text', 'label' => 'Title', 'rules' => ['required', 'string', 'max:190']],
                    'slug' => ['type' => 'text', 'label' => 'Slug', 'help' => 'Leave empty to create from the title.', 'rules' => ['nullable', 'alpha_dash', 'max:190']],
                    'excerpt' => ['type' => 'textarea', 'label' => 'Excerpt', 'rules' => ['required', 'string', 'max:300']],
                    'body' => ['type' => 'markdown', 'label' => 'Body (Markdown — HTML is not allowed)', 'rules' => ['required', 'string', 'max:60000']],
                    'status' => ['type' => 'select', 'label' => 'Status', 'options' => ['draft' => 'Draft', 'published' => 'Published'], 'rules' => ['required', 'in:draft,published']],
                    'published_at' => ['type' => 'datetime', 'label' => 'Publish date', 'help' => 'Empty = now when published.', 'rules' => ['nullable', 'date']],
                    'meta_title' => ['type' => 'text', 'label' => 'SEO title', 'rules' => ['nullable', 'string', 'max:70']],
                    'meta_description' => ['type' => 'text', 'label' => 'SEO description', 'rules' => ['nullable', 'string', 'max:160']],
                ],
            ],
            'faqs' => [
                'label' => 'FAQ',
                'singular' => 'FAQ',
                'model' => Faq::class,
                'columns' => ['question' => 'Question', 'is_published' => 'Published', 'sort_order' => 'Order'],
                'public_route' => null,
                'fields' => [
                    'question' => ['type' => 'text', 'label' => 'Question', 'rules' => ['required', 'string', 'max:190']],
                    'answer' => ['type' => 'textarea', 'label' => 'Answer', 'rules' => ['required', 'string', 'max:2000']],
                    'sort_order' => ['type' => 'number', 'label' => 'Sort order', 'rules' => ['nullable', 'integer', 'min:0', 'max:1000']],
                    'is_published' => ['type' => 'checkbox', 'label' => 'Published'],
                ],
            ],
        ];
    }

    public static function get(string $key): array
    {
        $all = static::all();
        abort_unless(isset($all[$key]), 404);

        return $all[$key] + ['key' => $key];
    }
}
