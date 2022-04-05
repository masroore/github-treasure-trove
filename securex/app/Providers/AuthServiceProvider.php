<?php

namespace App\Providers;

use App\Models\Vaults\Folder;
use App\Models\Vaults\Site;
use App\Models\Vaults\Vault;
use App\Policies\FolderPolicy;
use App\Policies\SitePolicy;
use App\Policies\VaultPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Vault::class => VaultPolicy::class,
        Folder::class => FolderPolicy::class,
        Site::class => SitePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

    }
}
