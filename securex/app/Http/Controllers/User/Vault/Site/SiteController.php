<?php

namespace App\Http\Controllers\User\Vault\Site;

use App\Actions\User\AddFaviconToSiteAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiteUpdateForm;
use App\Models\Vaults\Site;
use App\Models\Vaults\Vault;
use App\Notifications\User\SiteMovedToVault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class SiteController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
    }

    /**
     * Display the site details page.
     *
     * @param model $vault
     * @param model $site
     */
    public function show(Vault $vault, Site $site)
    {
        $this->authorize('update', $vault);
        $this->authorize('update', $site);

        $fields = $site->custom_fields;

        if ($vault->password && !session()->has($vault->id . '-pass')) {
            return view('main.vaults.select.authenticate')->with(compact('vault'));
        }

        return view('main.vault.sites.show')->with(compact('vault', 'site', 'fields'));
    }

    /**
     * Page to Edit Site Details.
     *
     * @param model $vault
     * @param model $site
     */
    public function edit(Vault $vault, Site $site)
    {
        $this->authorize('update', $vault);
        $this->authorize('update', $site);

        return view('main.vault.sites.edit')->with(compact('vault', 'site'));
    }

    /**
     * Update the site.
     *
     * @param array $request
     * @param model $vault
     * @param model $site
     */
    public function update(Vault $vault, Site $site, SiteUpdateForm $request)
    {
        $this->authorize('update', $vault);
        $this->authorize('update', $site);

        $site->update($request->all());

        (new AddFaviconToSiteAction())->execute($site);

        //Code to check and add http to link if it doesnt exists.
        if ($site->link) {
            if (!preg_match('~^(?:f|ht)tps?://~i', $site->link)) {
                $site->link = 'https://' . $site->link;
            }
        }

        $site->save();

        laraflash(Lang::get('alerts.vault.site_updated', ['site' => $site->name]), Lang::get('alerts.success'))->success();

        return redirect()->route('vault.site.show', [$vault, $site]);
    }

    /**
     * Mark a Site as Favorite.
     *
     * @param model $vault
     * @param model $site
     */
    public function storeFav(Vault $vault, Site $site)
    {
        $this->authorize('update', $vault);
        $this->authorize('update', $site);

        $site->is_fav = true;
        $site->save();

        laraflash(Lang::get('alerts.vault.site_favorited', ['site' => $site->name]), Lang::get('alerts.success'))->success();

        return back();
    }

    /**
     * Unmark a Site as Favorite.
     *
     * @param model $vault
     * @param model $site
     */
    public function deleteFav(Vault $vault, Site $site)
    {
        $this->authorize('update', $vault);
        $this->authorize('update', $site);

        $site->is_fav = false;
        $site->save();

        laraflash(Lang::get('alerts.vault.site_unfavorited', ['site' => $site->name]), Lang::get('alerts.alert'))->warning();

        return back();
    }

    /**
     * Delete the Site.
     *
     * @param model $vault
     * @param model $site
     */
    public function delete(Vault $vault, Site $site)
    {
        $this->authorize('update', $vault);
        $this->authorize('update', $site);

        $site->custom_fields()->delete();

        $site->delete();

        laraflash(Lang::get('alerts.vault.site_deleted'), Lang::get('alerts.success'))->success();

        return redirect()->route('vaults.select', $vault);
    }

    /**
     * Move the Site to another vault.
     *
     * @param model $vault
     * @param model $site
     */
    public function move(Vault $vault, Site $site, Request $request)
    {
        $user = Auth::user();

        $this->authorize('update', $vault);
        $this->authorize('update', $site);

        $newVault = Vault::find($request->vault);

        $this->authorize('update', $newVault);

        if (!$site->folder->isEmpty()) {
            $folder = $site->folder[0];
            $folder->sites()->detach($site);
        }

        $site->vault()->associate($newVault);
        $site->save();

        $user->notify(new SiteMovedToVault($site, $vault, $newVault));

        laraflash(Lang::get('alerts.vault.site_moved', ['site' => $site->name, 'vault' => $newVault->name]), Lang::get('alerts.success'))->info();

        return redirect()->route('vault.site.show', [$newVault, $site]);
    }
}
