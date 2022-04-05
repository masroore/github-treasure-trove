<?php

namespace Modules\Project\Repositories;

use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * [getUserSuggestion description].
     *
     * @param array $data [request data]
     *
     * @return mixed [Collection]
     */
    public function getUserSuggestion($data)
    {
        return $this->model::where(function ($query) use ($data): void {
            $query->where('name', 'LIKE', "%{$data['value']}%")->orWhere('email', 'LIKE', "%{$data['value']}%");
        })->get();
    }

    public function getUserIdByEmail($data)
    {
        $id = [];
        foreach ($data as $key => $value) {
            $user = $this->model->where('email', trim($value))->first();

            if ($user) {
                $id[] = $user->id;
            }
        }

        return $id;
    }

    public function update($data, $id)
    {
        $user = $this->model->find($id);

        $user->name = $data['name'];
        $user->role = $data['role'];
        $user->department = $data['department'];
        $user->about_me = $data['about_me'];
        $user->avatar = $data['image'];

        return $user->save();
    }

    public function updatePassword($password)
    {
        $user = Auth::user();
        $user->password = Hash::make($password);

        return $user->save();
    }

    public function userDeactive()
    {
        $user = Auth::user();

        DB::table('team_user')->where('user_id', $user->id)->delete();
        DB::table('project_user')->where('user_id', $user->id)->delete();

        $workspaces = DB::table('workspaces')->where('user_id', $user->id)->get();

        foreach ($workspaces as $key => $workspace) {
            DB::table('teams')->where('workspace_id', $workspace->id)->delete();
        }

        $default_workspace = $workspaces->where('default_workspace', 1)->first();

        DB::table('workspaces')->where('user_id', $user->id)->where('default_workspace', '!=', 1)->delete();

        $user->current_workspace_id = $default_workspace->id;

        return $user->save();
    }

    public function getUsersByMultipuleId($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function getUserByCurrentWorkspace($id)
    {
        return $this->model->where('current_workspace_id', $id)->get();
    }

    public function getUserByEmail($data)
    {
        return $this->model->whereIn('email', $data)->get();
    }
}
