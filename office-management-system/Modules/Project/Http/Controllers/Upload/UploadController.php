<?php

namespace Modules\Project\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Str;
use Modules\Project\Entities\Task;
use Modules\Project\Entities\TaskComment;
use Modules\Project\Entities\Upload\Upload;
use Storage;

class UploadController extends Controller
{
    protected $upload;

    /**
     * Instantiate a new controller instance.
     */
    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    protected $module = 'upload';

    public function getAllowedExtension()
    {
        $upload_variables = getVar('upload');

        return isset($upload_variables[request('module')]['allowed_file_extensions']) ? $upload_variables[request('module')]['allowed_file_extensions'] : ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'JPG'];
    }

    /**
     * Used to upload Files.
     *
     * @post("/api/upload")
     *
     * @param ({
     * @Parameter("module", type="string", required="true", description="Name of module"),
     * @Parameter("token", type="string", required="true", description="Upload Token from Form"),
     * @Parameter("file", type="file", required="true", description="File to be uploaded"),
     * })
     *
     * @return Response
     */
    public function upload()
    {
        $module = request('module');
        $token = request('token') ?? randomString(32);
        $upload_variables = getVar('upload');
        $module_upload_variables = $upload_variables[$module] ?? [];

        $auth_required = $module_upload_variables['auth_required'] ?? 1;
        $max_file_size = $module_upload_variables['max_file_size'] ?? 10000;
        $allowed_file_extensions = $module_upload_variables['allowed_file_extensions'] ?? ['jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $max_no_of_files = $module_upload_variables['max_no_of_files'] ?? 5;

        if ($this->upload->whereUploadToken(request('token'))->where('module', '!=', $module)->count()) {
            return $this->error(['message' => trans('project::general.invalid_action')]);
        }

        $user = Auth::user();

        if ($auth_required && !isset($user)) {
            return $this->error(['message' => trans('project::upload.authentication_require_before_upload')]);
        }

        $size = request()->file('file')->getSize();

        if ($size > $max_file_size * 1024 * 1024) {
            return $this->error(['message' => trans('project::upload.file_size_exceeds')]);
        }

        $extension = request()->file('file')->extension();
        $memetye = request()->file('file')->getMimeType();

        if (!in_array($extension, $allowed_file_extensions)) {
            return $this->error(['message' => trans('project::upload.invalid_extension', ['extension' => $extension])]);
        }

        $existing_upload = $this->upload->filterByModule($module)->filterByUploadToken($token)->filterByIsTempDelete(0)->count();

        if ($existing_upload >= $max_no_of_files) {
            return $this->error(['message' => trans('project::upload.max_file_limit_crossed', ['number' => $max_no_of_files])]);
        }
        $file = Storage::disk('public')->putFile($module, request()->file('file'));

        if (!file_exists('public/uploads/' . $module)) {
            mkdir('public/uploads/' . $module, 0777, true);
        }
        $f = request()->file('file');
        $fileName = $f->getClientOriginalName() . time() . '.' . $f->getClientOriginalExtension();
        $f->move('public/uploads/' . $module . '/', $fileName);
        $image_url = asset('public/uploads/' . $module . '/' . $fileName);

        $upload = $this->upload;
        $upload->module = $module;
        $upload->module_id = request('module_id') ?: null;
        $upload->upload_token = $token;
        $upload->user_filename = $f->getClientOriginalName();
        $upload->filename = $image_url;
        $upload->file_type = $memetye;
        $upload->uuid = Str::uuid();
        $upload->user_id = isset($user) ? $user->id : null;
        $upload->status = 1;
        $upload->save();

        if ($module == 'task') {
            $task = Task::find(request('module_id'));

            $task_comment = new TaskComment();
            $task_comment->event = 'attached';
            $task_comment->task_id = request('module_id');
            $task_comment->table_type = 'Modules\Project\Entities\Upload\Upload';
            $task_comment->new_id = $upload->id;
            $task_comment->created_by = isset($user) ? $user->id : null;
            $task_comment->save();

            activity()
                ->performedOn($task)
                ->causedBy($user)
                ->withProperties(['image' => $file])
                ->log('attached');
        }

        return $this->success(['message' => trans('project::upload.file_uploaded'), 'upload' => $upload]);
    }

    /**
     * Used to fetch Uploaded Files.
     *
     * @post("/api/upload")
     *
     * @param ({
     * @Parameter("module", type="string", required="true", description="Name of module"),
     * @Parameter("module_id", type="integer", required="true", description="Id of Module"),
     * })
     *
     * @return Response
     */
    public function fetch()
    {
        $this->upload->filterByModule(request('module'))->filterByModuleId(request('module_id'))->update(['is_temp_delete' => 0]);

        return $this->ok($this->upload->filterByModule(request('module'))->filterByModuleId(request('module_id'))->filterByStatus(1)->get());
    }

    /**
     * Used to upload Image in Summernote.
     *
     * @post("/api/upload/image")
     *
     * @param ({
     * @Parameter("file", type="file", required="true", description="Image file to be uploaded"),
     * })
     *
     * @return Response
     */
    public function uploadImage()
    {
        request()->validate([
            'file' => [
                'required',
                'image',
                'mimes:jpeg,bmp,png,svg,gif',
            ],
        ], [], [
            'file' => 'File',
        ]);
        if (!file_exists('public/uploads/editor-image')) {
            mkdir('public/uploads/editor-image', 0777, true);
        }

        $f = request()->file('file');
        $fileName = $f->getClientOriginalName() . time() . '.' . $f->getClientOriginalExtension();
        $f->move('public/uploads/editor-image/', $fileName);
        $image_url = asset('public/uploads/editor-image/' . $fileName);

        return $this->success(compact('image_url'));
    }

    /**
     * Used to delete Upload File.
     *
     * @post("/api/upload/{id}")
     *
     * @param ({
     * @Parameter("id", type="integer", required="true", description="Id of Uploaded File"),
     * @Parameter("token", type="string", required="true", description="Upload Token from Form"),
     * @Parameter("module_id", type="integer", required="optional", description="Id of Module"),
     * })
     *
     * @return Response
     */
    public function destroy($id)
    {
        $upload = $this->upload->find($id);

        if (!$upload || $upload->upload_token != request('token')) {
            return $this->error(['message' => 'Invalid action!']);
        }

        if (request('module_id') && $upload->status) {
            $this->upload->filterById($id)->update(['is_temp_delete' => 1]);
        } else {
            Storage::delete($upload->filename);
            $this->upload->filterById($id)->delete();
        }

        return $this->success(['message' => trans('project::upload.file_deleted')]);
    }
}
