<?php

namespace Vanguard\Http\Controllers\Web\Profile;

use Vanguard\Events\User\UpdatedProfileDetails;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\User\UpdateProfileDetailsRequest;
use Vanguard\Repositories\User\UserRepository;

/**
 * Class DetailsController.
 */
class DetailsController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * DetailsController constructor.
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Update profile details.
     *
     * @return mixed
     */
    public function update(UpdateProfileDetailsRequest $request)
    {
        $this->users->update(auth()->id(), $request->except('role_id', 'status'));

        event(new UpdatedProfileDetails());

        return redirect()->back()
            ->withSuccess(__('Profile updated successfully.'));
    }
}
