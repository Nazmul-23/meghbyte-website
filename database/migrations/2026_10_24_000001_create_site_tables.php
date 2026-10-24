<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->string('slug')->unique();
            $table->string('icon', 16)->nullable();
            $table->string('summary', 300);
            $table->text('body')->nullable();
            $table->json('features')->nullable();
            $table->json('tech')->nullable();
            $table->json('ideal_for')->nullable();
            $table->unsignedInteger('starting_price')->nullable();
            $table->string('price_note')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true)->index();
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('client_type')->nullable();
            $table->string('category', 30)->default('web')->index();
            $table->string('status', 20)->default('live');
            $table->string('summary', 300);
            $table->text('problem')->nullable();
            $table->text('solution')->nullable();
            $table->text('results')->nullable();
            $table->json('features')->nullable();
            $table->json('tech_stack')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true)->index();
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pricing_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('group', 30)->default('websites')->index();
            $table->unsignedInteger('price');
            $table->string('price_suffix', 40)->nullable();
            $table->string('delivery', 60)->nullable();
            $table->string('description')->nullable();
            $table->json('features')->nullable();
            $table->boolean('is_highlighted')->default(false);
            $table->boolean('is_published')->default(true)->index();
            $table->integer('sort_order')->default(0);
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 300);
            $table->longText('body');
            $table->string('status', 20)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 20);
            $table->string('email', 150)->nullable();
            $table->string('business_name', 150)->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('budget', 30)->nullable();
            $table->text('message');
            $table->string('status', 20)->default('new');
            $table->text('notes')->nullable();
            $table->string('source_page')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'created_at']);
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('quote_requests');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('pricing_packages');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('services');
    }
};
