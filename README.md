# Meghbyte — company website

Laravel website and admin panel for **Meghbyte**, a software studio from Hathazari, Chattogram (websites, mobile apps and management software).

## What's inside

**Public site:** Home, Services (+ detail pages), Work / case studies, Pricing (+ FAQ), About, Insights (blog), Contact / quote form, Privacy policy, `sitemap.xml`, `robots.txt`, branded error pages.

**Admin (`/admin`):** login, dashboard with lead counts, Leads pipeline (New → Contacted → Quoted → Won / Lost, notes, one-click WhatsApp), and editors for Services, Projects, Pricing, Insights and FAQ. No public registration.

**Security:** CSRF on every form, server-side validation, rate limiting (quote form 3 per 10 minutes and 10 per day per IP, login 5 per minute), honeypot spam trap, admin-only area with active-user + role checks, admin-only deletes, hashed passwords, explicit `$fillable` on every model (status/role never mass-assignable), Markdown rendered with raw HTML escaped and unsafe links removed, security headers (CSP, HSTS in production, X-Frame-Options, nosniff, Referrer-Policy, Permissions-Policy), HTTPS forced in production, secrets only in environment variables.

**Database:** PostgreSQL in production, SQLite locally. Tables: users, services, projects, pricing_packages, posts, quote_requests, faqs, settings (+ sessions, cache, jobs). Soft deletes on content and leads.

## Run locally

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
# set ADMIN_PASSWORD in .env first
php artisan migrate --seed
php artisan serve
```

Open http://localhost:8000 and the admin at http://localhost:8000/admin.

Run the tests with `php artisan test`.

## Deploy (Render)

`render.yaml` defines a Docker web service and a PostgreSQL database. On each deploy the container runs migrations and the (idempotent) seeder. Render generates `APP_SECRET` (used to derive `APP_KEY`) and `ADMIN_PASSWORD`; find the admin password under the service's **Environment** tab and change it after the first login.

Uploaded images are not used in v1 because Render's free disk is wiped on every deploy.

Website content (copy, services, projects, packages, articles, FAQ) was seeded from `database/seeders/content.json` and is edited from the admin afterwards.
