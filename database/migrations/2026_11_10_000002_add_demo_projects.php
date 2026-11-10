<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function projects(): array
    {
        $p = fn ($t, $s, $cat, $ct, $sum, $prob, $sol, $f, $tech, $o) => compact('t', 's', 'cat', 'ct', 'sum', 'prob', 'sol', 'f', 'tech', 'o');

        return [
            $p('Nexora ERP — Business Suite', 'erp-business-suite', 'system', 'Manufacturing & trading companies',
                'One system for sales, purchase, inventory, production, accounts and payroll across multiple branches.',
                'Growing companies run each department on its own spreadsheet, so stock, sales and accounts never match and month-end takes days.',
                'A modular ERP where every sale, purchase and stock movement posts to accounts automatically, with branch-level permissions and live dashboards.',
                ['Sales, purchase & inventory', 'Multi-branch stock with reorder alerts', 'Accounts, VAT & financial reports', 'HR, attendance & payroll', 'Role-based access & audit log'],
                ['Laravel', 'Filament', 'PostgreSQL', 'Redis'], 10),
            $p('CareDesk — Clinic Management', 'clinic-management-system', 'system', 'Clinics, diagnostic centres & hospitals',
                'Appointments, patient records, prescriptions, lab reports and billing for multi-doctor clinics.',
                'Paper registers and phone bookings cause long queues, lost records and billing mistakes.',
                'A clinic system with token queues, digital prescriptions, lab report delivery and SMS reminders that cut waiting time.',
                ['Online & walk-in appointments', 'Token queue display', 'Patient history & e-prescriptions', 'Lab reports & pharmacy', 'Billing with SMS reminders'],
                ['Laravel', 'Livewire', 'MySQL', 'SMS gateway'], 11),
            $p('PipeLine CRM — Sales Pipeline', 'crm-sales-pipeline', 'system', 'Sales teams & agencies',
                'A visual sales pipeline with contacts, deals, tasks and revenue reports for small sales teams.',
                'Leads live in WhatsApp chats and notebooks, so follow-ups are missed and nobody knows what the pipeline is worth.',
                'A drag-and-drop pipeline that tracks every deal, reminds the owner of the next step and reports won revenue by month.',
                ['Kanban deal pipeline', 'Contacts & company records', 'Tasks, calls & email logging', 'Win-rate & revenue reports', 'Team roles'],
                ['Laravel', 'Vue.js', 'MySQL'], 12),
            $p('Billify — SaaS Invoicing Tool', 'saas-invoicing-tool', 'system', 'Freelancers & small businesses (SaaS)',
                'A multi-tenant SaaS for invoices, quotes, recurring billing and online payments with subscription plans.',
                'Small businesses chase payments by hand and lose track of who has paid.',
                'A subscription SaaS where each workspace sends branded invoices, takes card payments and sends automatic reminders.',
                ['Multi-tenant workspaces', 'Invoices, quotes & recurring billing', 'Stripe & PayPal payments', 'Automatic payment reminders', 'Subscription plans & team seats'],
                ['Laravel', 'React', 'PostgreSQL', 'Stripe'], 13),
            $p('BookEase — Online Booking System', 'online-booking-system', 'system', 'Salons, spas, clinics & consultants',
                'Online booking with staff calendars, deposits, reminders and a widget for any website.',
                'Bookings over the phone mean double bookings, no-shows and staff idle time.',
                'A 24/7 booking system with real-time availability, online deposits and SMS reminders that reduce no-shows.',
                ['Real-time staff availability', 'Online deposits', 'SMS & email reminders', 'Embeddable booking widget', 'Reviews & customer history'],
                ['Laravel', 'Alpine.js', 'MySQL', 'Stripe'], 14),
            $p('Harbor & Co. — Business Website', 'business-website', 'web', 'Service businesses & firms',
                'A fast, SEO-ready company website with portfolio, services, reviews and a quote form.',
                'Without a credible website, customers who search on Google choose a competitor.',
                'A conversion-focused site with clear services, project gallery, Google reviews and a lead form that reaches the owner instantly.',
                ['Responsive, fast-loading pages', 'Project portfolio & services', 'Quote / contact forms', 'SEO & Google Business setup', 'Easy admin panel'],
                ['Laravel', 'Tailwind CSS', 'MySQL'], 15),
            $p('The Daily Ledger — News Portal', 'news-portal', 'web', 'Online newspapers & media',
                'A high-traffic news portal with categories, breaking-news ticker, editor workflow and ad slots.',
                'Media teams need to publish fast, handle traffic spikes and earn from ads.',
                'A news CMS with roles for reporters and editors, scheduled publishing, caching for traffic spikes and ad management.',
                ['Category & tag-based news', 'Breaking news ticker', 'Reporter / editor workflow', 'Ad slot management', 'Caching & SEO for Google News'],
                ['Laravel', 'Redis', 'MySQL', 'Cloudflare'], 16),
        ];
    }

    public function up(): void
    {
        $now = now();
        foreach ($this->projects() as $x) {
            if (DB::table('projects')->where('slug', $x['s'])->exists()) {
                continue;
            }
            DB::table('projects')->insert([
                'title' => $x['t'], 'slug' => $x['s'], 'client_type' => $x['ct'], 'category' => $x['cat'], 'status' => 'demo',
                'summary' => $x['sum'], 'problem' => $x['prob'], 'solution' => $x['sol'],
                'results' => 'Demo project built by Meghbyte to show what we deliver. We can customise it for your business.',
                'features' => json_encode($x['f']), 'tech_stack' => json_encode($x['tech']),
                'is_featured' => false, 'is_published' => true, 'sort_order' => $x['o'],
                'meta_title' => $x['t'].' | Meghbyte', 'meta_description' => $x['sum'],
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('projects')->whereIn('slug', array_column($this->projects(), 's'))->delete();
    }
};
