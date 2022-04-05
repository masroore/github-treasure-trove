<?php

namespace Modules\Attendance\Http\Controllers;

use App\Traits\ImageStore;
use App\Traits\Notification;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Attendance\Repositories\EventRepositoryInterface;
use Modules\RolePermission\Repositories\RoleRepositoryInterface;

class EventController extends Controller
{
    use ImageStore;
    use Notification;

    protected $eventRepository;

    protected $roleRepository;

    public function __construct(EventRepositoryInterface $eventRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        try {
            $events = $this->eventRepository->all();
            $roles = $this->roleRepository->normalRoles();

            return view('attendance::events.index', compact('events', 'roles'));
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function create(): void
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'from_date' => 'required',
        ]);

        try {
            if (!empty($request->image)) {
                $this->saveAvatar($request->image);
            }
            $event = $this->eventRepository->create($request->except('_token'));
            $user_id = null;
            $role_id = $request->for_whom;
            $subject = $request->title;
            $class = $event;
            $data = $request->description ?? 'A Event Has been Created';
            $url = route('events.index');
            $this->sendNotification($class, null, $subject, null, null, $data, $user_id, $role_id, $url);
            Toastr::success(trans('event.Event Has Been Created Successfully'));

            return back();
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function show($id)
    {
        return view('attendance::show');
    }

    public function edit($id)
    {
        try {
            $events = $this->eventRepository->all();
            $editData = $this->eventRepository->find($id);
            $roles = $this->roleRepository->normalRoles();

            return view('attendance::events.index', compact('events', 'editData', 'roles'));
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'from_date' => 'required',
        ]);

        try {
            $event = $this->eventRepository->update($request->except('_token'), $id);

            Toastr::success(trans('event.Event Has Been Updated Successfully'));

            return redirect()->route('events.index');
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->eventRepository->delete($id);
            Toastr::success(trans('event.Event Has Been Deleted Successfully'));

            return back();
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'));

            return back();
        }
    }
}
