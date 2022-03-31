<?php

namespace App;

use App\Models\Back\Users\UserDetail;
use Bouncer;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use HasRolesAndAbilities;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function details()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    /**
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'user_name'  => 'required',
            'user_email' => 'required',
        ]);

        $this->setRequest($request);

        return $this;
    }

    /**
     * @return $this
     */
    public function validateCustomerRequest(Request $request)
    {
        $request->validate([
            'fname'    => 'required',
            'lname'    => 'required',
            'address'  => 'required',
            'zip'      => 'required',
            'city'     => 'required',
            'email'    => 'required',
            'username' => 'required',
        ]);

        $this->setRequest($request);

        return $this;
    }

    /**
     * @return bool
     */
    public function storeData()
    {
        $role = $this->request->user_role ?? 'customer';

        $stored = $this->insertGetId([
            'name'       => $this->request->user_name,
            'email'      => $this->request->user_email,
            'password'   => isset($this->request->user_password) ? bcrypt($this->request->user_password) : '',
            'role'       => $role,
            'status'     => (isset($this->request->user_status) && 'on' == $this->request->user_status) ? 1 : 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user = self::find($stored);
        $this->setRole($user, $role);

        if ($stored) {
            $uid = UserDetail::storeData($this->request, $stored);

            return UserDetail::find($uid);
        }

        return false;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function updateData($id)
    {
        $user = self::find($id);
        $password = '' != $user->password ? $user->password : Hash::make('slkt2020');
        $role = $this->request->user_role ?? 'customer';

        if ('' == !$this->request->user_password) {
            $password = Hash::make($this->request->user_password);
        }

        $updated = $this->where('id', $id)->update([
            'name'       => $this->request->user_name,
            'email'      => $this->request->user_email,
            'password'   => $password,
            'role'       => $role,
            'status'     => (isset($this->request->user_status) && 'on' == $this->request->user_status) ? 1 : 0,
            'updated_at' => Carbon::now(),
        ]);

        $user = self::find($id);
        $this->setRole($user, $role);

        if ($updated) {
            UserDetail::updateData($this->request, $id);

            return UserDetail::where('user_id', $id)->first();
        }

        return false;
    }

    /**
     * @param $id
     */
    public function resolveAvatar($id)
    {
        $data = json_decode($this->request->user_image);

        $path = $id . '/' . time() . '_' . $data->output->name;
        $img = Image::make($data->output->image)->encode(str_replace('image/', '', $data->output->type));

        Storage::disk('user')->put($path, $img);

        $user = UserDetail::where('user_id', $id)->first();

        if ($user->avatar && 'media/images/avatar.jpg' != $user->avatar) {
            $delete_path = str_replace(config('filesystems.disks.user.url'), '', $user->avatar);

            Storage::disk('user')->delete($delete_path);
        }

        return $user->update([
            'avatar' => config('filesystems.disks.user.url') . $path,
        ]);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function updateCustomerData($id)
    {
        $updated = $this->where('id', $id)->update([
            'name'       => $this->request->username,
            'email'      => $this->request->email,
            'updated_at' => Carbon::now(),
        ]);

        if ($updated) {
            UserDetail::updateCustomerData($this->request, $id);

            return true;
        }

        return false;
    }

    /**
     * @param $blog
     * @param $path
     */
    public function updateImagePath($user_id, $path)
    {
        return UserDetail::where('user_id', $user_id)->update([
            'avatar' => $path,
        ]);
    }

    /**
     * @param $user
     * @param $role
     */
    public function setRole($user, $role)
    {
        return Bouncer::assign($role)->to($user);
    }

    /**
     * Set Model request variable.
     *
     * @param $request
     */
    private function setRequest($request)
    {
        $this->request = $request;
    }
}
