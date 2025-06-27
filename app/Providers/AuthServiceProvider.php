<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Tambahkan model dan policy di sini
use App\Models\Product;
use App\Policies\ProductPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        // Tambahkan policy lain jika ada, misalnya:
        // Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies(); // Penting: ini wajib agar policies bisa digunakan

        // Optional: define Gate di sini jika kamu pakai Gate langsung, contoh:
        // Gate::define('edit-product', [ProductPolicy::class, 'update']);
    }
}
