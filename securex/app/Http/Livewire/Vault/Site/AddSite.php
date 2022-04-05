<?php

namespace App\Http\Livewire\Vault\Site;

use App\Actions\User\AddFaviconToSiteAction;
use App\Mail\Alerts\SiteLimitReached as SiteLimitReachedMail;
use App\Models\Vaults\Vault;
use App\Notifications\User\SiteLimitReached;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use TechTailor\RPG\Facade\RPG;

class AddSite extends Component
{
    use AuthorizesRequests;

    public $rpg;

    public $vault;

    public $name;

    public $link;

    public $folder;

    public $login_id;

    public $login_password;

    public $additional_info;

    public function mount(Vault $vault, $folder = null): void
    {
        $this->vault = $vault;
        $this->login_password = RPG::Preset(Auth::user()->rng_level);
        $this->folder = $folder;
    }

    public function rpg()
    {
        return $this->login_password = RPG::Preset(Auth::user()->rng_level);
    }

    public function addSite(): void
    {
        $messages = [
            'name.required' => Lang::get('alerts.site.validation.name_required'),
            'name.min' => Lang::get('alerts.site.validation.name_min'),
            'name.max' => Lang::get('alerts.site.validation.name_max'),
            'link.max' => Lang::get('alerts.site.validation.link_max'),
            'login_id.required' => Lang::get('alerts.site.validation.login_id_required'),
            'login_id.min' => Lang::get('alerts.site.validation.login_id_min'),
            'login_id.max' => Lang::get('alerts.site.validation.login_id_max'),
            'login_password.required' => Lang::get('alerts.site.validation.login_password_required'),
            'login_password.min' => Lang::get('alerts.site.validation.login_password_min'),
            'login_password.max' => Lang::get('alerts.site.validation.login_password_max'),
            'additional_info.max' => Lang::get('alerts.site.validation.additional_info_max'),
        ];

        $validatedData = $this->validate([
            'name' => 'required|min:3|max:35',
            'link' => ['nullable', 'max:200', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'login_id' => 'required|min:3|max:155',
            'login_password' => 'required|min:3|max:155',
            'additional_info' => 'max:255',
        ], $messages);

        $this->authorize('update', $this->vault);

        if ($this->folder) {
            $this->authorize('update', $this->folder);
        }

        $this->storeSite();
    }

    public function storeSite()
    {
        $user = Auth::user();

        if (substr($this->link, -1) == '/') {
            $this->link = substr($this->link, 0, -1);
        }

        $site = $this->vault->sites()->create([
            'name' => $this->name,
            'user_id' => $user->id,
            'link' => $this->link,
            'login_id' => $this->login_id,
            'login_password' => $this->login_password,
            'additional_info' => $this->additional_info,
        ]);

        if ($user->hasReachedSiteLimit()) {
            $user->notify(new SiteLimitReached());
            if (setting()->get('app_email_alerts') === 'true') {
                Mail::to($user->email)->send(new SiteLimitReachedMail($user));
            }
        }

        if ($this->folder) {
            $this->authorize('update', $this->folder);
            $this->folder->sites()->attach($site);
        }

        (new AddFaviconToSiteAction())->execute($site);

        laraflash(Lang::get('alerts.vault.site_added', ['site' => $site->name, 'vault' => $this->vault->name]), Lang::get('alerts.success'))->success();

        return redirect()->route('vault.site.show', [$this->vault, $site]);
    }

    public function render()
    {
        return view('livewire.vault.site.add-site');
    }
}
