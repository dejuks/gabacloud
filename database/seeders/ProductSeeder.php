<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // ── Web Templates ──────────────────────────────
            [
                'category' => 'Web Templates',
                'items' => [
                    [
                        'title'       => 'Modern SaaS Landing Page',
                        'description' => 'A clean, conversion-optimized landing page template for SaaS products. Includes hero section, pricing table, testimonials, and FAQ. Built with HTML, CSS, and vanilla JS.',
                        'price'       => 499.00,
                        'type'        => 'template',
                        'preview_url' => 'https://example.com/preview/saas-landing',
                    ],
                    [
                        'title'       => 'Portfolio Pro Template',
                        'description' => 'Stunning personal portfolio template for developers and designers. Features dark/light mode, smooth animations, project showcase, and contact form.',
                        'price'       => 349.00,
                        'type'        => 'template',
                        'preview_url' => 'https://example.com/preview/portfolio-pro',
                    ],
                    [
                        'title'       => 'E-Commerce Storefront UI',
                        'description' => 'Complete e-commerce frontend template with product listings, cart, checkout flow, and user dashboard. Responsive and pixel-perfect design.',
                        'price'       => 799.00,
                        'type'        => 'template',
                        'preview_url' => null,
                    ],
                ],
            ],

            // ── Laravel Scripts ─────────────────────────────
            [
                'category' => 'Laravel Scripts',
                'items' => [
                    [
                        'title'       => 'Laravel Multi-Tenant SaaS Boilerplate',
                        'description' => 'Full-featured multi-tenant Laravel starter kit. Includes subscription billing, team management, role permissions, and API support. Save weeks of development time.',
                        'price'       => 1999.00,
                        'type'        => 'software',
                        'preview_url' => 'https://example.com/preview/laravel-saas',
                    ],
                    [
                        'title'       => 'Laravel REST API Starter',
                        'description' => 'Production-ready Laravel REST API boilerplate with JWT authentication, rate limiting, API versioning, comprehensive error handling, and Swagger docs.',
                        'price'       => 899.00,
                        'type'        => 'software',
                        'preview_url' => null,
                    ],
                    [
                        'title'       => 'Laravel Invoice & Billing System',
                        'description' => 'Complete invoicing system built on Laravel. Create, send, and track invoices. Supports multiple currencies, PDF export, and payment tracking.',
                        'price'       => 1499.00,
                        'type'        => 'software',
                        'preview_url' => 'https://example.com/preview/invoice-system',
                    ],
                ],
            ],

            // ── Mobile Apps ─────────────────────────────────
            [
                'category' => 'Mobile Apps',
                'items' => [
                    [
                        'title'       => 'Flutter Food Delivery App UI Kit',
                        'description' => 'Beautiful Flutter UI kit for food delivery apps. Includes 30+ screens: onboarding, home, restaurant listing, order tracking, cart, and profile. Well-structured code.',
                        'price'       => 1299.00,
                        'type'        => 'template',
                        'preview_url' => 'https://example.com/preview/flutter-food',
                    ],
                    [
                        'title'       => 'React Native E-Commerce Starter',
                        'description' => 'Complete React Native e-commerce app with Redux state management, product catalog, cart, checkout, push notifications, and Stripe payment integration.',
                        'price'       => 1799.00,
                        'type'        => 'software',
                        'preview_url' => null,
                    ],
                ],
            ],

            // ── WordPress Themes ────────────────────────────
            [
                'category' => 'WordPress Themes',
                'items' => [
                    [
                        'title'       => 'Nexus — Business WordPress Theme',
                        'description' => 'Premium multipurpose WordPress theme for businesses and agencies. Includes 15 homepage demos, Elementor support, WooCommerce ready, and one-click import.',
                        'price'       => 649.00,
                        'type'        => 'template',
                        'preview_url' => 'https://example.com/preview/nexus-theme',
                    ],
                    [
                        'title'       => 'BlogMaster Pro Theme',
                        'description' => 'SEO-optimized WordPress theme designed for bloggers and content creators. Features fast loading, schema markup, newsletter integration, and beautiful typography.',
                        'price'       => 449.00,
                        'type'        => 'template',
                        'preview_url' => 'https://example.com/preview/blogmaster',
                    ],
                ],
            ],

            // ── Plugins ─────────────────────────────────────
            [
                'category' => 'Plugins',
                'items' => [
                    [
                        'title'       => 'Advanced SEO Analyzer Plugin',
                        'description' => 'Powerful WordPress SEO plugin with real-time content analysis, keyword tracking, XML sitemap generation, schema markup, and Google Search Console integration.',
                        'price'       => 549.00,
                        'type'        => 'plugin',
                        'preview_url' => null,
                    ],
                    [
                        'title'       => 'WP Chapa Payment Gateway',
                        'description' => 'Integrate Chapa payment gateway into your WooCommerce store. Supports ETB currency, mobile money, bank transfers, and provides instant payment notifications.',
                        'price'       => 699.00,
                        'type'        => 'plugin',
                        'preview_url' => 'https://example.com/preview/chapa-gateway',
                    ],
                    [
                        'title'       => 'Smart Popup & Lead Capture Plugin',
                        'description' => 'Conversion-focused popup builder for WordPress. Features exit-intent detection, scroll triggers, A/B testing, Mailchimp integration, and detailed analytics.',
                        'price'       => 399.00,
                        'type'        => 'plugin',
                        'preview_url' => null,
                    ],
                ],
            ],
        ];

        foreach ($products as $group) {
            $category = Category::where('name', $group['category'])->first();

            if (!$category) continue;

            foreach ($group['items'] as $item) {
                $slug = Str::slug($item['title']) . '-' . Str::lower(Str::random(5));

                Product::create([
                    'category_id' => $category->id,
                    'title'       => $item['title'],
                    'slug'        => $slug,
                    'description' => $item['description'],
                    'price'       => $item['price'],
                    'type'        => $item['type'],
                    'thumbnail'   => null,
                    'file_path'   => 'products/files/placeholder.zip',
                    'preview_url' => $item['preview_url'],
                    'is_active'   => true,
                    'downloads'   => rand(0, 250),
                ]);
            }
        }

        $this->command->info('✅ ' . Product::count() . ' products seeded across ' . Category::count() . ' categories.');
    }
}