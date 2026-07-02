<?php
namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        // ── Blog Categories ──────────────────────────────────────
        $categories = [
            'Tutorials',
            'Laravel Tips',
            'Business & SaaS',
            'Web Development',
            'Announcements',
        ];

        foreach ($categories as $name) {
            BlogCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        $tutorials   = BlogCategory::where('slug', 'tutorials')->first();
        $laravel     = BlogCategory::where('slug', 'laravel-tips')->first();
        $business    = BlogCategory::where('slug', 'business-saas')->first();
        $webdev      = BlogCategory::where('slug', 'web-development')->first();
        $announce    = BlogCategory::where('slug', 'announcements')->first();

        // ── Blog Posts ───────────────────────────────────────────
        $posts = [
            [
                'category'  => $tutorials,
                'title'     => 'How to Build a School Management System with Laravel',
                'excerpt'   => 'A step-by-step guide to building a full-featured school management system using Laravel 11, covering student management, attendance, fees, and more.',
                'content'   => '<h2>Introduction</h2><p>School management systems are one of the highest-selling software categories on marketplaces like CodeCanyon. In this guide, we will walk through building a complete system using Laravel.</p><h2>What We Will Build</h2><ul><li>Multi-role authentication (Admin, Teacher, Student, Parent)</li><li>Student registration and class management</li><li>Attendance tracking with percentage reports</li><li>Fee management with online payment</li><li>Exam results and report card generation</li></ul><h2>Prerequisites</h2><p>You need PHP 8.2+, Composer, and a basic understanding of Laravel. Let\'s get started!</p><h2>Step 1: Setup Laravel</h2><p>Run the following command to create a new Laravel project:</p><p><strong>composer create-project laravel/laravel school-system</strong></p><h2>Step 2: Design the Database</h2><p>Start with the core tables: users, students, classes, sections, subjects, attendance, fees, and exams. Each table should have clear relationships.</p><h2>Conclusion</h2><p>Building a school management system is a great way to earn passive income on software marketplaces. With the right features and documentation, it can become a top-selling product.</p>',
            ],
            [
                'category'  => $laravel,
                'title'     => 'Top 10 Laravel Tips Every Developer Should Know in 2025',
                'excerpt'   => 'Boost your Laravel productivity with these 10 practical tips covering Eloquent, routing, performance optimization, and more.',
                'content'   => '<h2>1. Use Eloquent Scopes for Clean Queries</h2><p>Instead of repeating query conditions, define reusable scopes on your models.</p><p><strong>public function scopePublished($q) { return $q->where(\'status\', \'published\'); }</strong></p><h2>2. Leverage Route Model Binding</h2><p>Laravel automatically resolves Eloquent models from route parameters. Use <strong>getRouteKeyName()</strong> to bind by slug instead of ID.</p><h2>3. Use Config Caching in Production</h2><p>Always run <strong>php artisan config:cache</strong> and <strong>php artisan route:cache</strong> before deploying to production for maximum performance.</p><h2>4. Queue Time-Consuming Tasks</h2><p>Never run emails, PDF generation, or API calls synchronously. Push them to a queue with Laravel Jobs.</p><h2>5. Use Lazy Collections for Large Datasets</h2><p>When processing thousands of records, use <strong>LazyCollection</strong> to avoid memory issues.</p><h2>6. Validate Early, Fail Fast</h2><p>Always use Form Requests for validation. Keep your controllers thin and your validation logic reusable.</p><h2>7. Use Str and Arr Helpers</h2><p>Laravel\'s <strong>Str</strong> and <strong>Arr</strong> helper classes are packed with useful methods that save you from writing repetitive string and array manipulation code.</p><h2>8. Optimize Eager Loading</h2><p>Avoid the N+1 query problem by always using <strong>with()</strong> when accessing relationships in loops.</p><h2>9. Write Tests</h2><p>Even basic feature tests give you confidence when deploying. Laravel\'s testing tools make it easy to write fast, reliable tests.</p><h2>10. Use Laravel Telescope in Development</h2><p>Telescope gives you an incredible insight into requests, queries, jobs, and exceptions during development.</p>',
            ],
            [
                'category'  => $business,
                'title'     => 'How to Sell Your Laravel Scripts on CodeCanyon — Complete Guide',
                'excerpt'   => 'Everything you need to know about submitting, pricing, and marketing your PHP/Laravel scripts on CodeCanyon to maximize downloads and revenue.',
                'content'   => '<h2>Why CodeCanyon?</h2><p>CodeCanyon is the world\'s largest marketplace for scripts and code. With millions of buyers, it offers unmatched exposure for your Laravel products.</p><h2>What Sells Best</h2><p>Based on download numbers, these categories consistently perform well:</p><ul><li>School Management Systems</li><li>Hospital and Clinic Management</li><li>POS and Inventory Systems</li><li>HR and Payroll Software</li><li>Real Estate Management</li></ul><h2>Preparing Your Script for Submission</h2><p>Before submitting, make sure your code is clean, well-documented, and follows PSR-12 standards. Include a detailed README, an installation guide, and a changelog.</p><h2>Pricing Strategy</h2><p>Research competitor pricing. Most Laravel management systems sell between $25 and $69. Start at the lower end to build reviews, then increase the price as your rating grows.</p><h2>Getting Reviews</h2><p>Reviews are the #1 factor in CodeCanyon rankings. Provide excellent support and follow up with buyers to encourage honest reviews.</p><h2>Marketing Outside CodeCanyon</h2><p>Share your product on developer communities, YouTube tutorials, and social media. Building an audience outside the marketplace protects your income from algorithm changes.</p>',
            ],
            [
                'category'  => $webdev,
                'title'     => 'Building Secure Payment Integration with Chapa in Laravel',
                'excerpt'   => 'Learn how to integrate Chapa — Ethiopia\'s leading payment gateway — into your Laravel application for secure, reliable online payments.',
                'content'   => '<h2>What is Chapa?</h2><p>Chapa is Ethiopia\'s most popular payment gateway, supporting mobile money, bank transfers, and card payments. It is the go-to solution for Ethiopian developers building e-commerce and SaaS products.</p><h2>Getting Your API Keys</h2><p>Sign up at dashboard.chapa.co and navigate to API Keys to get your secret key. Use test keys during development.</p><h2>Initializing a Payment</h2><p>To start a payment, send a POST request to the Chapa initialize endpoint with the amount, currency, customer details, and callback URLs.</p><h2>Handling the Callback</h2><p>Chapa sends a webhook to your callback URL when a payment completes. Always verify the transaction server-side using the verify endpoint before fulfilling orders.</p><h2>Security Best Practices</h2><ul><li>Never trust client-side payment confirmation</li><li>Always verify payments server-side</li><li>Store your secret key only in .env</li><li>Log all payment responses for auditing</li></ul><h2>Testing</h2><p>Use Chapa\'s test credentials and test card numbers to simulate payments before going live. Always test both success and failure scenarios.</p>',
            ],
            [
                'category'  => $announce,
                'title'     => 'Welcome to Our Software Marketplace — What We Offer',
                'excerpt'   => 'Introducing our digital marketplace for premium Laravel scripts, templates, and software products. Learn what makes us different and what to expect.',
                'content'   => '<h2>Welcome!</h2><p>We are excited to launch our software marketplace — a platform dedicated to premium, production-ready Laravel scripts, templates, and digital products built by experienced developers.</p><h2>What We Sell</h2><ul><li><strong>Laravel Scripts</strong> — Full applications like school systems, clinic management, POS, and more</li><li><strong>Web Templates</strong> — Beautiful, responsive frontend templates</li><li><strong>Plugins</strong> — Drop-in modules to extend your existing applications</li><li><strong>Other Tools</strong> — Utilities, boilerplates, and starter kits</li></ul><h2>Why Buy From Us?</h2><ul><li>All products are thoroughly tested before listing</li><li>Detailed documentation included with every purchase</li><li>Free updates for the lifetime of the product</li><li>Responsive support from the original developers</li><li>Secure payment via Chapa with instant download</li></ul><h2>For Ethiopian Developers</h2><p>We are proud to offer a local alternative to international marketplaces. All prices are in ETB and payments are processed through Chapa, making it easy for Ethiopian buyers and sellers.</p><h2>Get Started</h2><p>Browse our products, read our blog for tutorials and tips, and join our growing community of developers building great software for the Ethiopian market and beyond.</p>',
            ],
            [
                'category'  => $tutorials,
                'title'     => 'Complete Guide to Laravel Multi-Role Authentication from Scratch',
                'excerpt'   => 'Build a custom multi-role authentication system in Laravel without any packages — covering admin, customer, and other roles with middleware protection.',
                'content'   => '<h2>Why Build Auth from Scratch?</h2><p>While packages like Breeze and Jetstream are convenient, building authentication from scratch gives you full control over the logic, design, and behavior — and it is a great learning exercise.</p><h2>Database Design</h2><p>Add a <strong>role</strong> column to your users table with values like admin, customer, or editor. Use an enum for type safety.</p><h2>Custom Login Logic</h2><p>Use <strong>Auth::attempt()</strong> to authenticate users, then check their role to redirect them to the appropriate dashboard.</p><h2>Middleware</h2><p>Create a custom <strong>AdminMiddleware</strong> that checks if the authenticated user has the admin role. Register it in <strong>bootstrap/app.php</strong> and apply it to your admin routes.</p><h2>Role-Based Views</h2><p>Use <strong>@if(auth()->user()->isAdmin())</strong> in Blade templates to conditionally show admin-only UI elements like the admin panel link.</p><h2>Security Tips</h2><ul><li>Always hash passwords with <strong>Hash::make()</strong></li><li>Regenerate the session after login to prevent session fixation</li><li>Use CSRF protection on all forms</li><li>Validate all inputs server-side</li></ul>',
            ],
            [
                'category'  => $webdev,
                'title'     => 'How to Deploy Your Laravel Application to a VPS — Step by Step',
                'excerpt'   => 'A complete guide to deploying a Laravel application on a Ubuntu VPS with Nginx, MySQL, SSL, and proper file permissions.',
                'content'   => '<h2>Prerequisites</h2><p>You need a VPS running Ubuntu 22.04, a domain name pointed at your server, and SSH access.</p><h2>Step 1: Install Dependencies</h2><p>Install PHP 8.2, Nginx, MySQL, and Composer on your server. Use the apt package manager and follow the official installation guides for each.</p><h2>Step 2: Clone Your Repository</h2><p>Clone your Laravel project into <strong>/var/www/your-app</strong> and set the correct file permissions for the storage and bootstrap/cache directories.</p><h2>Step 3: Configure Environment</h2><p>Copy <strong>.env.example</strong> to <strong>.env</strong>, fill in your production database credentials, set <strong>APP_ENV=production</strong> and <strong>APP_DEBUG=false</strong>.</p><h2>Step 4: Configure Nginx</h2><p>Create an Nginx server block pointing to your Laravel public directory. Set the root to <strong>/var/www/your-app/public</strong>.</p><h2>Step 5: SSL with Let\'s Encrypt</h2><p>Use Certbot to generate a free SSL certificate. Run <strong>certbot --nginx -d yourdomain.com</strong> and follow the prompts.</p><h2>Step 6: Production Optimization</h2><p>Run <strong>php artisan optimize</strong> to cache config, routes, and views. Set up a cron job for Laravel\'s task scheduler.</p>',
            ],
            [
                'category'  => $laravel,
                'title'     => 'Mastering Laravel Eloquent Relationships — With Real Examples',
                'excerpt'   => 'A practical deep-dive into Laravel Eloquent relationships: hasOne, hasMany, belongsTo, belongsToMany, and polymorphic relations with real-world use cases.',
                'content'   => '<h2>Why Relationships Matter</h2><p>Eloquent relationships are the backbone of any Laravel application. Understanding them deeply will make you write cleaner, faster, and more maintainable code.</p><h2>hasOne and belongsTo</h2><p>Use <strong>hasOne</strong> when a model owns exactly one of another model. For example, a User hasOne Profile. The inverse is <strong>belongsTo</strong> — Profile belongsTo User.</p><h2>hasMany</h2><p>A User hasMany Orders. This is the most common relationship. Always eager load with <strong>with(\'orders\')</strong> to avoid N+1 queries.</p><h2>belongsToMany — Pivot Tables</h2><p>Use this for many-to-many relationships, like Products and Categories. Laravel manages the pivot table automatically.</p><h2>hasManyThrough</h2><p>Access distant relationships through an intermediate model. For example, a Country has many Posts through Users.</p><h2>Polymorphic Relations</h2><p>When multiple models share a relationship with another model — for example, both Products and Blog Posts can have Comments — use polymorphic relations with <strong>morphMany</strong> and <strong>morphTo</strong>.</p><h2>Performance Tips</h2><ul><li>Always eager load relationships used in loops</li><li>Use <strong>withCount()</strong> instead of loading full relationships just to count</li><li>Use <strong>select()</strong> to limit columns when loading related models</li></ul>',
            ],
        ];

        foreach ($posts as $index => $post) {
            $title = $post['title'];
            $slug  = Str::slug($title) . '-' . Str::random(4);

            Blog::create([
                'user_id'          => $admin->id,
                'blog_category_id' => $post['category']?->id,
                'title'            => $title,
                'slug'             => $slug,
                'excerpt'          => $post['excerpt'],
                'content'          => $post['content'],
                'thumbnail'        => null,
                'status'           => 'published',
                'views'            => rand(50, 1500),
                'published_at'     => now()->subDays(count($posts) - $index),
            ]);
        }

        $this->command->info('✅ ' . Blog::count() . ' blog posts seeded across ' . BlogCategory::count() . ' categories.');
    }
}