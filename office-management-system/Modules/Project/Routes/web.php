<?php

// use Modules\Project\Http\Controllers\WorkspaceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('get_sections', [\Modules\Project\Http\Controllers\Api\ApiController::class, 'getSectionByProject']);

Route::group(['middleware' => 'auth'], function (): void {
    Route::resource('workspaces', WorkspaceController::class);

    Route::get('project/create', [\Modules\Project\Http\Controllers\ProjectController::class, 'create'])->name('project.create');
    Route::post('project/create', [\Modules\Project\Http\Controllers\ProjectController::class, 'store'])->name('project.store');
    Route::get('project/{uuid}/{view?}', [\Modules\Project\Http\Controllers\ProjectController::class, 'show'])->name('project.show');

    Route::resource('project', ProjectController::class);

    Route::get('team/{id}/invite', [\Modules\Project\Http\Controllers\TeamController::class, 'inviteFormCreate'])->name('team.invite.create');
    Route::post('team/{id}/invite', [\Modules\Project\Http\Controllers\TeamController::class, 'teamInviteStore'])->name('team.invite.store');
    Route::get('team-user/{team_id}', [\Modules\Project\Http\Controllers\TeamController::class, 'teamUsers'])->name('team-user');
    Route::resource('team', TeamController::class);

    Route::get('user/team/{team}/remove', [\Modules\Project\Http\Controllers\UserController::class, 'removeTeam'])->name('user.team.remove')->middleware(['password.confirm']);

    Route::get('get-user-suggestion', [\Modules\Project\Http\Controllers\WorkspaceController::class, 'getUserSuggestion'])->name('get-user-suggestion');
    Route::get('get-user-suggestion-email', [\Modules\Project\Http\Controllers\WorkspaceController::class, 'getUserSuggestionEmail'])->name('get-user-suggestion-email');

    Route::get('get-user-suggestion-priority', [\Modules\Project\Http\Controllers\UserController::class, 'suggestUserByPriority'])->name('get-user-suggestion-priority');

    // Project

    Route::get('project-create/{teamId?}', [Modules\Project\Http\Controllers\ProjectController::class, 'create'])->name('project.create');
    Route::post('project-store', [Modules\Project\Http\Controllers\ProjectController::class, 'store'])->name('project.store');
    Route::post('project-update', [Modules\Project\Http\Controllers\ProjectController::class, 'update'])->name('project.update');
    Route::post('project-default-view', [Modules\Project\Http\Controllers\ProjectController::class, 'defaultView'])->name('project-default-view');
    Route::post('project/setFieldVisibility', [Modules\Project\Http\Controllers\ProjectController::class, 'setFieldVisibility'])->name('project.setFieldVisibility');

    Route::post('update-project-color', [Modules\Project\Http\Controllers\ProjectController::class, 'updateColor'])->name('update-project-color');
    Route::post('update-project-icon', [Modules\Project\Http\Controllers\ProjectController::class, 'updateIcon'])->name('update-project-icon');
    Route::post('update-project-favorite', [Modules\Project\Http\Controllers\ProjectController::class, 'updateFavorite'])->name('update-project-favorite');

    Route::post('field/store', [\Modules\Project\Http\Controllers\FieldController::class, 'store'])->name('field.store');
    Route::post('field/edit', [\Modules\Project\Http\Controllers\FieldController::class, 'edit'])->name('field.edit');
    Route::post('/field/delete', [\Modules\Project\Http\Controllers\FieldController::class, 'delete'])->name('field.delete');

    Route::get('project-overview', function () {
        return view('project::project.overview');
    });

    Route::post('sections', [\Modules\Project\Http\Controllers\Api\ApiController::class, 'getSectionByProject'])->name('task.getSectionByProject');
    Route::post('projects', [\Modules\Project\Http\Controllers\Api\ApiController::class, 'getProject'])->name('task.getProject');
    Route::post('sections/sortbyfield', [\Modules\Project\Http\Controllers\Api\ApiController::class, 'sortByField'])->name('task.sortByField');
    Route::post('set_sections', [\Modules\Project\Http\Controllers\Api\ApiController::class, 'setSectionOnProject'])->name('task.setSectionOnProject');
    Route::post('section/update_name', [\Modules\Project\Http\Controllers\SectionController::class, 'updateName'])->name('section.updateName');
    Route::post('section/store', [\Modules\Project\Http\Controllers\SectionController::class, 'store'])->name('section.store');
    Route::post('section/delete', [\Modules\Project\Http\Controllers\SectionController::class, 'delete'])->name('section.delete');

    Route::post('task/update_name', [\Modules\Project\Http\Controllers\TaskController::class, 'updateName'])->name('task.updateName');
    Route::post('task/update_field', [\Modules\Project\Http\Controllers\TaskController::class, 'updateField'])->name('task.updateField');
    Route::post('task/store', [\Modules\Project\Http\Controllers\TaskController::class, 'store'])->name('task.store');
    Route::post('update-task-user', [\Modules\Project\Http\Controllers\TaskController::class, 'updateTaskUser'])->name('update-task-user');
    Route::post('task-complete', [\Modules\Project\Http\Controllers\TaskController::class, 'taskComplete'])->name('task-complete');
    Route::post('task-delete', [\Modules\Project\Http\Controllers\TaskController::class, 'taskDelete'])->name('task-delete');
    Route::post('task-like', [\Modules\Project\Http\Controllers\TaskController::class, 'taskLike'])->name('task-like');
    Route::post('task-chek-like', [\Modules\Project\Http\Controllers\TaskController::class, 'checkTaskLike'])->name('task-check-like');

    Route::post('task-comment', [\Modules\Project\Http\Controllers\TaskController::class, 'taskComment'])->name('task-comment');

    Route::post('comment/pin-to-top', [\Modules\Project\Http\Controllers\TaskController::class, 'taskCommentPinToTop'])->name('comment.pin-to-top');

    Route::post('comment/delete', [\Modules\Project\Http\Controllers\TaskController::class, 'taskCommentDelete'])->name('comment.delete');

    Route::get('task/{uuid}', [\Modules\Project\Http\Controllers\TaskController::class, 'show'])->name('task.show');

    Route::post('set_tasks', [\Modules\Project\Http\Controllers\Api\ApiController::class, 'setTasksOnSection'])->name('task.setTasksOnSection');
    Route::post('set_sub_tasks', [\Modules\Project\Http\Controllers\Api\ApiController::class, 'setSubTasksOnTask'])->name('task.setSubTasksOnTask');

    Route::post('set_sections', [\Modules\Project\Http\Controllers\Api\ApiController::class, 'setSectionOnProject'])->name('task.setSectionOnProject');

    Route::get('share-project', [Modules\Project\Http\Controllers\ProjectController::class, 'shareProject'])->name('share-project');

    Route::post('project-delete', [Modules\Project\Http\Controllers\ProjectController::class, 'deleteProject'])->name('project-delete');

    Route::post('project-comment', [Modules\Project\Http\Controllers\ProjectController::class, 'comment'])->name('project-comment');

    Route::post('project-comment-edit', [Modules\Project\Http\Controllers\ProjectController::class, 'editComment'])->name('project-comment-edit');

    Route::post('project-comment-delete', [Modules\Project\Http\Controllers\ProjectController::class, 'deleteComment'])->name('project-comment-delete');

    Route::get('project-user/{project_id}', [Modules\Project\Http\Controllers\ProjectController::class, 'projectUser'])->name('project-user');
    // Remove user form project

    Route::post('remove-user-form-project', [Modules\Project\Http\Controllers\ProjectController::class, 'removeUser'])->name('remove-user-form-project');

    // update tag
    Route::post('store-tag', [Modules\Project\Http\Controllers\TagController::class, 'storeTag'])->name('store-tag');
    Route::post('remove-tag', [Modules\Project\Http\Controllers\TagController::class, 'removeTag'])->name('remove-tag');
    Route::post('get_options', [Modules\Project\Http\Controllers\OptionController::class, 'show'])->name('get_option');

    Route::post('get_auth_user', function () {
        return \Auth::user();
    });

    Route::post('api/upload', '\Modules\Project\Http\Controllers\Upload\UploadController@upload');
    Route::post('api/upload/extension', '\Modules\Project\Http\Controllers\Upload\UploadController@getAllowedExtension');
    Route::post('api/upload/image', '\Modules\Project\Http\Controllers\Upload\UploadController@uploadImage');
    Route::post('api/upload/fetch', '\Modules\Project\Http\Controllers\Upload\UploadController@fetch');
    Route::post('api/upload/{id}', '\Modules\Project\Http\Controllers\Upload\UploadController@destroy');

    Route::post('get_images', '\Modules\Project\Http\Controllers\ProjectController@getImages');
});

Route::get('/js/lang', function (): void {
    if (App::environment('local')) {
        Cache::forget('lang.js');
    }

    if (\Cache::has('locale')) {
        config(['app.locale' => \Cache::get('locale')]);
    }

    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');
        $files = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];
        foreach ($files as $file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;
        }

        $modules = Module::all();
        $module_files = [];
        foreach ($modules as $module) {
            if ($module->isEnabled()) {
                $file = glob(module_path($module->getName()) . '/Resources/lang/' . $lang . '/*.php');
                if ($file) {
                    $module_files[$module->getLowerName()] = $file;
                }
            }
        }

        foreach ($module_files as $module => $module_file) {
            foreach ($module_file as $file) {
                $name = basename($file, '.php');
                $strings[$module . '::' . $name] = require $file;
            }
        }

        return $strings;
    });
    header('Content-Type: text/javascript');
    echo 'window.i18n = ' . json_encode($strings) . ';';
    exit();
})->name('assets.lang');
