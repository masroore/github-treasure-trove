<?php

namespace App\Http\Controllers\User\Vault\Folder;

use App\Http\Controllers\Controller;
use App\Models\Vaults\Folder;
use App\Models\Vaults\Site;
use App\Models\Vaults\Vault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class FolderController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
    }

    /**
     * Display the Folder Page with all the Sites.
     *
     * @param model $vault
     * @param model $folder
     */
    public function show(Vault $vault, Folder $folder)
    {
        $this->authorize('update', $vault);
        $this->authorize('update', $folder);

        $sites = $folder->sites;

        return view('main.vault.folders.show')->with(compact('vault', 'sites', 'folder'));
    }

    /**
     * Adding an existing site to a folder.
     *
     * @param model $vault
     * $param model $account
     */
    public function addToFolder(Vault $vault, Site $site, Request $request)
    {
        $messages = [
            'folder.required' => Lang::get('alerts.vault.validation.invalid'),
        ];

        $this->validate($request, [
            'folder' => 'required',
        ], $messages);

        $folder = Folder::find($request->folder);

        if (!$folder) {
            laraflash(Lang::get('alerts.vault.folder_doesnt_exists'), Lang::get('alerts.warning'))->danger();

            return back();
        }

        $this->authorize('update', $vault);
        $this->authorize('update', $folder);
        $this->authorize('update', $site);

        $folder->sites()->attach($site);

        laraflash(Lang::get('alerts.vault.folder_added_site', ['site' => $site->name, 'folder' => $folder->name]), Lang::get('alerts.success'))->info();

        return back();
    }

    /**
     * Remove a site from a folder.
     *
     * @param model $vault
     * $param model $site
     */
    public function removeFromFolder(Vault $vault, Site $site)
    {
        $this->authorize('update', $vault);
        $this->authorize('update', $site);

        $folder = $site->folder[0];

        $folder->sites()->detach($site);

        laraflash(Lang::get('alerts.vault.folder_removed_site', ['site' => $site->name, 'folder' => $folder->name]), Lang::get('alerts.success'))->info();

        return back();
    }
}
