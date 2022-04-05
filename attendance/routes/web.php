<?php

use App\Http\Livewire\School\SchoolBranch;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|loaded
| Here is where you can register web routes for your application. These
| routes are  by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->Route('login');
});

Auth::routes();

Route::get('/home', [
    'uses' => 'WebController@index',
    'as' => 'home',
]);

Route::get('/loadmenu', [
    'uses' => 'WebController@menu',
    'as' => 'menu',
]);

Route::get('/about-us', [
    'uses' => 'WebController@about',
    'as' => 'about',
]);

Route::get('/student', [
    'uses' => 'WebController@student',
    'as' => 'student-login',
]);

Route::post('/student/login', [
    'uses' => 'WebController@student_login',
    'as' => 'student-login-check',
]);

Route::get('/online-payment', [
    'uses' => 'WebController@student_online_login',
    'as' => 'student-onlinepay-login',
]);

Route::post('/online-payment-login', [
    'uses' => 'WebController@student_onlinepay_login',
    'as' => 'student-onlinepay-logins',
]);

Route::get('/lecturer', [
    'uses' => 'WebController@lecturer',
    'as' => 'lecturer-login',
]);

Route::post('/lecturer/login', [
    'uses' => 'WebController@lecturer_login',
    'as' => 'lecturer-login-check',
]);

Route::group(['prefix' => 'Admission'], function (): void {
    Route::get('/purchse-OSN-Code', [
        'uses' => 'AdmissionController@index',
        'as' => 'onscode',
    ]);

    Route::post('/osn-purchase', [
        'uses' => 'AdmissionController@purchase_osn',
        'as' => 'purchase-osn-code',
    ]);

    Route::get('/osn-payment', [
        'uses' => 'AdmissionController@osn_payment',
        'as' => 'osn-payment',
    ]);

    Route::get('/osn-code-generate', [
        'uses' => 'AdmissionController@osn_code_gen',
        'as' => 'osn-code-generate',
    ]);

    Route::get('/online-admission', [
        'uses' => 'AdmissionController@online_admission',
        'as' => 'online-admission-login',
    ]);

    Route::post('/login-online-admission', [
        'uses' => 'AdmissionController@admission_loign',
        'as' => 'admission-login',
    ]);
});

Route::group(
    ['prefix' => 'Admission', 'middleware' => 'sessionavailable'],
    function (): void {
        Route::get('/online-admission-personal-information', [
            'uses' => 'AdmissionController@admission_personal_info',
            'as' => 'admission-personal-info',
        ]);

        Route::post('/save-online-personal-info', [
            'uses' => 'AdmissionController@save_per_info',
            'as' => 'save-personal-info',
        ]);

        Route::get('/online-admission-personal-results', [
            'uses' => 'AdmissionController@admission_personal_results',
            'as' => 'admission-personal-results',
        ]);

        Route::post('/save-results', [
            'uses' => 'AdmissionController@save_results',
            'as' => 'save-result',
        ]);

        Route::post('/save-results2', [
            'uses' => 'AdmissionController@save_results2',
            'as' => 'save-result2',
        ]);

        Route::post('/save-results3', [
            'uses' => 'AdmissionController@save_results3',
            'as' => 'save-result3',
        ]);

        Route::get('/online-admission-personal-school-attended', [
            'uses' => 'AdmissionController@admission_personal_school',
            'as' => 'admission-personal-school',
        ]);

        Route::post('/save-online-admission-personal-school-attended', [
            'uses' => 'AdmissionController@admission_personal_school_save',
            'as' => 'admission-personal-school-save',
        ]);

        Route::get('/online-admission-personal-app-information', [
            'uses' => 'AdmissionController@admission_app_info',
            'as' => 'admission-app-info',
        ]);

        Route::post('/save-admission-personal-app-information', [
            'uses' => 'AdmissionController@admission_app_info_save',
            'as' => 'admission-app-info-save',
        ]);

        Route::get('/online-admission-personal-guidian-information', [
            'uses' => 'AdmissionController@admission_guidian_info',
            'as' => 'admission-guidian-info',
        ]);

        Route::post('/save-guidian-information', [
            'uses' => 'AdmissionController@admission_guid_save',
            'as' => 'admission-app-gurd-save',
        ]);

        Route::get('/online-admission-personal-supporting-documents', [
            'uses' => 'AdmissionController@admission_sup_doc',
            'as' => 'admission-sup-doc',
        ]);

        Route::post('/online-admission-personal-supporting-documents-save', [
            'uses' => 'AdmissionController@admission_sup_doc_save',
            'as' => 'submit-sup-doc',
        ]);

        Route::post('/doc-delete/{id}', [
            'uses' => 'AdmissionController@admission_sup_doc_delete',
            'as' => 'doc-delete',
        ]);

        Route::get('/online-admission-personal-upload-profile-image', [
            'uses' => 'AdmissionController@admission_profile_image',
            'as' => 'admission-prof-img',
        ]);

        Route::post('/submit-profile-image', [
            'uses' => 'AdmissionController@admission_submit_img',
            'as' => 'profile-img-submit',
        ]);

        Route::post('/submit-application-now/{id}', [
            'uses' => 'AdmissionController@submit_appliaction',
            'as' => 'sub-application-now',
        ]);
    }
);

Route::get('/logout-user', [
    'uses' => 'AdmissionController@user_logout',
    'as' => 'admission-logout',
]);

Route::get('/admission-complete', [
    'uses' => 'AdmissionController@adm_complete',
    'as' => 'admission-completed',
]);

Route::get('/admission-complete-print', [
    'uses' => 'AdmissionController@adm_complete_print',
    'as' => 'admission-completed-print',
]);

Route::group(['prefix' => 'Branches',  'middleware' => 'auth'], function (): void {

    // Route::get('/create-new-branch', SchoolBranch::class)->name('school-branch');
});

Route::group(['prefix' => 'Acadmic-Calendar',  'middleware' => 'auth'], function (): void {
    Route::get('/create-event', [
        'uses' => 'AcademicCalandarController@create_event',
        'middleware' => 'can:view Create Event',
        'as' => 'create-event',
    ]);

    Route::post('/create-event/save', [
        'uses' => 'AcademicCalandarController@create_event_save',
        'middleware' => 'can:create Create Event',
        'as' => 'create-event-save',
    ]);

    Route::get('/create-event/edit/{id}', [
        'uses' => 'AcademicCalandarController@create_event_edit',
        'middleware' => 'can:edit Create Event',
        'as' => 'create-event-edit',
    ]);

    Route::get('/create-event/delete/{id}', [
        'uses' => 'AcademicCalandarController@create_event_delete',
        'middleware' => 'can:delete Create Event',
        'as' => 'create-event-delete',
    ]);

    Route::get('/create-event/fetch-events', [
        'uses' => 'AcademicCalandarController@fetch_events',
        'as' => 'fetch-events',
    ]);

    Route::get('/create-event/all', [
        'uses' => 'AcademicCalandarController@create_event_all',
        'middleware' => 'can:view All Event',
        'as' => 'create-event-all',
    ]);
});

Route::group(['prefix' => 'LatestAdmission',  'middleware' => 'auth'], function (): void {
    Route::get('/all-admissions-submitted', [
        'uses' => 'AppSubmittedController@index',
        'middleware' => 'can:view Online Admissions',
        'as' => 'admissions-home',
    ]);

    Route::get('/all-get-admission-all', [
        'uses' => 'AppSubmittedController@admission_all',
        'as' => 'admissions-all',
    ]);

    Route::post('/admission-update-programme', [
        'uses' => 'AppSubmittedController@admission_update_program',
        'as' => 'admissions-update-programme',
    ]);

    Route::get('/approve/admission/view-modal', [
        'uses' => 'AppSubmittedController@admission_modal_show',
        'as' => 'admissions-modal-show',
    ]);

    Route::post('/approve/admission', [
        'uses' => 'AppSubmittedController@admission_approve_admission',
        'middleware' => 'can:create Online Admissions',
        'as' => 'admissions-approve-admission',
    ]);

    Route::get('/admission-all-view/{id}', [
        'uses' => 'AppSubmittedController@admission_view',
        'middleware' => 'can:view Online Admissions',
        'as' => 'admissions-all-view',
    ]);

    Route::get('/all-get-admission-all-level-100', [
        'uses' => 'AppSubmittedController@admission_all_level100',
        'middleware' => 'can:view Level 100',
        'as' => 'admissions-home-level-100',
    ]);

    Route::get('/all-get-admission-all-level1', [
        'uses' => 'AppSubmittedController@admission_all_level1',
        'as' => 'admissions-all-level1',
    ]);

    Route::get('/all-get-admission-all-level-100-approved', [
        'uses' => 'AppSubmittedController@admission_all_level100_app',
        'middleware' => 'can:view Level 100',
        'as' => 'admissions-home-level-100-app',
    ]);

    Route::get('/all-get-admission-all-level1-approved', [
        'uses' => 'AppSubmittedController@admission_all_level1_app',
        'as' => 'admissions-all-level1-app',
    ]);

    Route::get('/all-get-admission-all-level-200', [
        'uses' => 'AppSubmittedController@admission_all_level200',
        'middleware' => 'can:view Level 200',
        'as' => 'admissions-home-level-200',
    ]);

    Route::get('/all-get-admission-all-level2', [
        'uses' => 'AppSubmittedController@admission_all_level2',
        'as' => 'admissions-all-level2',
    ]);

    Route::get('/all-get-admission-all-level-200-approved', [
        'uses' => 'AppSubmittedController@admission_all_level200_app',
        'middleware' => 'can:view Level 200',
        'as' => 'admissions-home-level-200-app',
    ]);

    Route::get('/all-get-admission-all-level2-approved', [
        'uses' => 'AppSubmittedController@admission_all_level2_app',
        'as' => 'admissions-all-level2-app',
    ]);

    Route::get('/all-get-admission-all-level-300', [
        'uses' => 'AppSubmittedController@admission_all_level300',
        'middleware' => 'can:view Level 300',
        'as' => 'admissions-home-level-300',
    ]);

    Route::get('/all-get-admission-all-level3', [
        'uses' => 'AppSubmittedController@admission_all_level3',
        'as' => 'admissions-all-level3',
    ]);

    Route::get('/all-get-admission-all-level-300-approved', [
        'uses' => 'AppSubmittedController@admission_all_level300_app',
        'middleware' => 'can:view Level 300',
        'as' => 'admissions-home-level-300-app',
    ]);

    Route::get('/all-get-admission-all-level3-approved', [
        'uses' => 'AppSubmittedController@admission_all_level3_app',
        'as' => 'admissions-all-level3-app',
    ]);

    //confirm student Admission
    Route::get('/student-admission-confirm-doc', [
        'uses' => 'AppSubmittedController@admission_confirm_message',
        'middleware' => 'can:view Admission Doc',
        'as' => 'admissions-confirm-message',
    ]);

    Route::post('/student-admission-delete/{id}', [
        'uses' => 'AppSubmittedController@admission_confirm_delete',
        'middleware' => 'can:delete Admission Doc',
        'as' => 'admissions-confirm-delete',
    ]);

    Route::post('/student-admission-confirm-doc-save', [
        'uses' => 'AppSubmittedController@admission_confirm_doc',
        'middleware' => 'can:create Admission Doc',
        'as' => 'admissions-confirm-doc',
    ]);

    Route::get('/student-admission-confirm', [
        'uses' => 'AppSubmittedController@admission_confirm',
        'middleware' => 'can:view Confirm Admissions',
        'as' => 'admissions-confirm',
    ]);

    Route::get('/all-student-gain-admission-confirm', [
        'uses' => 'AppSubmittedController@admission_confirm_students',
        'middleware' => 'can:view Confirm Admissions',
        'as' => 'admissions-all-confirm',
    ]);

    Route::post('/all-student-gain-admission-confirm-now', [
        'uses' => 'AppSubmittedController@admission_confirm_students_now',
        'middleware' => 'can:create Confirm Admissions',
        'as' => 'admissions-all-confirm-now',
    ]);

    Route::post('/admission-revert-now', [
        'uses' => 'AppSubmittedController@admission_revert_students_now',
        'middleware' => 'can:create Confirm Admissions',
        'as' => 'admissions-all-revert-now',
    ]);

    Route::get('/student-admission-confirm-appointment-letter/{num}', [
        'uses' => 'AppSubmittedController@admission_confirm_letter',
        'middleware' => 'can:create Confirm Admissions',
        'as' => 'admissions-confirm-letter',
    ]);

    //confirmed admission
    Route::get('/student-admission-confirm-all', [
        'uses' => 'AppSubmittedController@admission_confirm_all',
        'middleware' => 'can:view All Confirmed Admission',
        'as' => 'admissions-confirm-all',
    ]);

    Route::get('/student-admission-confirm-all-data', [
        'uses' => 'AppSubmittedController@admission_confirm_all_data',
        'as' => 'admissions-confirm-all-data',
    ]);

    //confirmed admission
    Route::get('/student-admission-unconfirm-all', [
        'uses' => 'AppSubmittedController@admission_unconfirm_all',
        'middleware' => 'can:view Revert Admission',
        'as' => 'admissions-unconfirm-all',
    ]);

    Route::get('/student-admission-unconfirm-all-data', [
        'uses' => 'AppSubmittedController@admission_unconfirm_all_data',
        'as' => 'admissions-unconfirm-all-data',
    ]);

    //add student / register new student

    Route::get('/registerStudent', [
        'uses' => 'AdmissionController@newStudent',
        'middleware' => 'can:view Add Student',
        'as' => 'add-students',
    ]);

    Route::post('/registerStudent/add-details', [
        'uses' => 'AdmissionController@newStudent_register',
        'middleware' => 'can:create Add Student',
        'as' => 'add-students-save',
    ]);
});

Route::group(['prefix' => 'OSMS',  'middleware' => 'auth'], function (): void {
    Route::get('/dashboard', [
        'uses' => 'DashboardController@index',
        'as' => 'dashboard',
    ]);
});

Route::group(['prefix' => 'AcademicYear',  'middleware' => 'auth'], function (): void {
    Route::get('/add-academic-year-osms', [
        'uses' => 'AcademicController@create',
        'middleware' => 'can:view Add Academic Year',
        'as' => 'add-academic-year',
    ]);

    Route::post('/add-academic-update-staus', [
        'uses' => 'AcademicController@updatestatus',
        'middleware' => 'can:edit Add Academic Year',
        'as' => 'academic-year-update-status',
    ]);

    Route::get('/add-academic-year-edit/{id}', [
        'uses' => 'AcademicController@edit',
        'middleware' => 'can:edit Add Academic Year',
        'as' => 'academic-year-edit',
    ]);

    Route::post('/add-academic-update-year', [
        'uses' => 'AcademicController@update',
        'middleware' => 'can:edit Add Academic Year',
        'as' => 'academic-year-update-year',
    ]);
});

Route::group(['prefix' => 'Allstudents',  'middleware' => 'auth'], function (): void {
    Route::get('/all-students-information', [
        'uses' => 'StudentsController@allstudents',
        'middleware' => 'can:view All Students',
        'as' => 'all-students',
    ]);

    Route::get('/all-students-information-date', [
        'uses' => 'StudentsController@allstudents_data',
        'as' => 'all-students-data',
    ]);

    Route::get('/all-students-informationl1', [
        'uses' => 'StudentsController@allstudentsl1',
        'middleware' => 'can:view Student Info Level 100',
        'as' => 'all-studentsl1',
    ]);

    Route::get('/all-students-information-datel1', [
        'uses' => 'StudentsController@allstudents_datal1',
        'as' => 'all-students-datal1',
    ]);

    Route::get('/all-students-informationl2', [
        'uses' => 'StudentsController@allstudentsl2',
        'middleware' => 'can:view Student Info Level 200',
        'as' => 'all-studentsl2',
    ]);

    Route::get('/all-students-information-datel2', [
        'uses' => 'StudentsController@allstudents_datal2',
        'as' => 'all-students-datal2',
    ]);

    Route::get('/all-students-informationl3', [
        'uses' => 'StudentsController@allstudentsl3',
        'middleware' => 'can:view Student Info Level 300',
        'as' => 'all-studentsl3',
    ]);

    Route::get('/all-students-information-datel3', [
        'uses' => 'StudentsController@allstudents_datal3',
        'as' => 'all-students-datal3',
    ]);

    Route::get('/all-students-informationl4', [
        'uses' => 'StudentsController@allstudentsl4',
        'middleware' => 'can:view Student Info Level 400',
        'as' => 'all-studentsl4',
    ]);

    Route::get('/all-students-information-datel4', [
        'uses' => 'StudentsController@allstudents_datal4',
        'as' => 'all-students-datal4',
    ]);

    Route::get('/all-students-informationl/graduated', [
        'uses' => 'StudentsController@allstudents_graduated',
        'middleware' => 'can:view Graduated Students',
        'as' => 'all-students-graduated',
    ]);

    Route::get('/all-students-informationl/graduated-data', [
        'uses' => 'StudentsController@allstudents_graduated_data',
        'as' => 'all-students-graduated-data',
    ]);

    Route::get('/student-information-view/{id}', [
        'uses' => 'StudentsController@studentinfo_view',
        'middleware' => 'can:view All Students',
        'as' => 'students-info-view',
    ]);

    Route::get('/student-profile-view', [
        'uses' => 'StudentsController@studentinfo_profileview',
        'as' => 'students-profile-info-view',
    ]);

    Route::get('/student-assigment/view', [
        'uses' => 'StudentsController@student_assignments',
        'as' => 'students-assignment-views',
    ]);

    Route::get('/student-assigment/view/{id}', [
        'uses' => 'StudentsController@student_assignment_view',
        'as' => 'students-assignment-view',
    ]);

    Route::post('/student-assigment/submit', [
        'uses' => 'StudentsController@student_assignment_submit',
        'as' => 'students-assignment-submit',
    ]);
});

Route::group(['prefix' => 'Programmes',  'middleware' => 'auth'], function (): void {
    Route::get('/addprogramme', [
        'uses' => 'ProgrammeController@index',
        'middleware' => 'can:view Add Programme',
        'as' => 'add-programme',
    ]);

    Route::get('/addprogramme-edit/{id}', [
        'uses' => 'ProgrammeController@editprogramme',
        'middleware' => 'can:edit Add Programme',
        'as' => 'edit-programme',
    ]);

    Route::post('/addprogramme-update', [
        'uses' => 'ProgrammeController@update',
        'middleware' => 'can:create Add Programme',
        'as' => 'update-programme',
    ]);

    Route::get('/addFaculty', [
        'uses' => 'ProgrammeController@faculty',
        'middleware' => 'can:view Add Faculty',
        'as' => 'add-faculty',
    ]);

    Route::post('/addFaculty/save', [
        'uses' => 'ProgrammeController@faculty_save',
        'middleware' => 'can:create Add Faculty',
        'as' => 'add-faculty-save',
    ]);

    Route::get('/delete/faculty/{id}', [
        'uses' => 'ProgrammeController@faculty_delete',
        'middleware' => 'can:delete Add Faculty',
        'as' => 'add-faculty-delete',
    ]);
});

Route::group(['prefix' => 'CourseManagement',  'middleware' => 'auth'], function (): void {
    Route::get('/programmme/code/register/degree', [
        'uses' => 'CourseController@pro_degree',
        'middleware' => 'can:view Add Course Degree Level 100',
        'as' => 'add-course-degreel1',
    ]);

    Route::get('/programmme/code/register/degree/edit/{id}', [
        'uses' => 'CourseController@pro_degree_update1',
        'middleware' => 'can:edit Add Course Degree Level 100',
        'as' => 'add-course-degreel1-edit',
    ]);

    Route::post('/programmme/code/update/100', [
        'uses' => 'CourseController@pro_degree_update1_save',
        'middleware' => 'can:create Add Course Degree Level 100',
        'as' => 'add-course-degreel1-save',
    ]);

    //level 200
    Route::get('/programmme/code/register/degree/200', [
        'uses' => 'CourseController@pro_degree_200',
        'middleware' => 'can:view Add Course Degree Level 200',
        'as' => 'add-course-degreel2',
    ]);

    Route::get('/programmme/code/register/degree2/edit/{id}', [
        'uses' => 'CourseController@pro_degree_update2',
        'middleware' => 'can:edit Add Course Degree Level 200',
        'as' => 'add-course-degreel2-edit',
    ]);

    Route::post('/programmme/code/200', [
        'uses' => 'CourseController@pro_degree_update2_save',
        'middleware' => 'can:create Add Course Degree Level 200',
        'as' => 'add-course-degreel2-save',
    ]);

    //300
    Route::get('/programmme/code/register/degree/300', [
        'uses' => 'CourseController@pro_degree_300',
        'middleware' => 'can:view Add Course Degree Level 300',
        'as' => 'add-course-degreel3',
    ]);

    Route::get('/programmme/code/register/degree3/edit/{id}', [
        'uses' => 'CourseController@pro_degree_update3',
        'middleware' => 'can:edit Add Course Degree Level 300',
        'as' => 'add-course-degreel3-edit',
    ]);

    Route::post('/programmme/code/300', [
        'uses' => 'CourseController@pro_degree_update3_save',
        'middleware' => 'can:create Add Course Degree Level 300',
        'as' => 'add-course-degreel3-save',
    ]);

    //400
    Route::get('/programmme/code/register/degree/400', [
        'uses' => 'CourseController@pro_degree_400',
        'middleware' => 'can:view Add Course Degree Level 400',
        'as' => 'add-course-degreel4',
    ]);

    Route::get('/programmme/code/register/degree4/edit/{id}', [
        'uses' => 'CourseController@pro_degree_update4',
        'middleware' => 'can:edit Add Course Degree Level 400',
        'as' => 'add-course-degreel4-edit',
    ]);

    Route::post('/programmme/code/400', [
        'uses' => 'CourseController@pro_degree_update4_save',
        'middleware' => 'can:create Add Course Degree Level 400',
        'as' => 'add-course-degreel4-save',
    ]);

    //diploma courses

    //level 100
    Route::get('/programmme/code/register/diploma/100', [
        'uses' => 'CourseController@pro_diploma',
        'middleware' => 'can:view Add Course Diploma Level 100',
        'as' => 'add-course-diploma1',
    ]);

    Route::get('/programmme/code/register/diploma/100/edit/{id}', [
        'uses' => 'CourseController@pro_diploma_update1',
        'middleware' => 'can:edit Add Course Diploma Level 100',
        'as' => 'add-course-diploma1-edit',
    ]);

    Route::post('/programmme/code/edit/100', [
        'uses' => 'CourseController@pro_diploma_update1_save',
        'middleware' => 'can:create Add Course Diploma Level 100',
        'as' => 'add-course-diploma1-save',
    ]);

    // level 200
    Route::get('/programmme/code/register/diploma/200', [
        'uses' => 'CourseController@pro_diploma2',
        'middleware' => 'can:view Add Course Diploma Level 200',
        'as' => 'add-course-diploma2',
    ]);

    Route::get('/programmme/code/register/diploma/200/edit/{id}', [
        'uses' => 'CourseController@pro_diploma_update2',
        'middleware' => 'can:edit Add Course Diploma Level 200',
        'as' => 'add-course-diploma2-edit',
    ]);

    Route::post('/programmme/code/edit/200', [
        'uses' => 'CourseController@pro_diploma_update2_save',
        'middleware' => 'can:create Add Course Diploma Level 200',
        'as' => 'add-course-diploma2-save',
    ]);

    //programme course Assignment

    //level 100 first Semester for BPRM
    Route::get('/programmme/course/assignment/first/semsester/{code}', [
        'uses' => 'CourseController@firstsemster_bprm',
        'middleware' => 'can:view Programs and Courses',
        'as' => 'add-course-programme-BPRM-first',
    ]);

    Route::post('/programmme/course/assignment/first/semsester/{code}/save', [
        'uses' => 'CourseController@firstsemster_bprm_save',
        'middleware' => 'can:create Programs and Courses',
        'as' => 'add-course-programme-BPRM-first-save',
    ]);

    Route::post('/programmme/course/delete/first/semsester/BPRM/{id}', [
        'uses' => 'CourseController@firstsemster_bprm_delete',
        'middleware' => 'can:delete Programs and Courses',
        'as' => 'course-remove-first-BPRM',
    ]);

    //level 100 Second Semester for BPRM
    Route::get('/programmme/course/assignment/second/semsester/{code}', [
        'uses' => 'CourseController@secondsemster_bprm',
        'middleware' => 'can:view Programs and Courses',
        'as' => 'add-course-programme-BPRM-second',
    ]);

    Route::post('/programmme/course/assignment/second/semsester/{code}/save', [
        'uses' => 'CourseController@secondsemster_bprm_save',
        'middleware' => 'can:create Programs and Courses',
        'as' => 'add-course-programme-BPRM-second-save',
    ]);

    Route::post('/programmme/course/delete/second/semsester/BPRM/{id}', [
        'uses' => 'CourseController@secondsemster_bprm_delete',
        'middleware' => 'can:delete Programs and Courses',
        'as' => 'course-remove-second-BPRM',
    ]);

    //level 200 first Semester for BPRM
    Route::get('/programmme/course/assignment/first/semsester/{code}/l200', [
        'uses' => 'CourseController@firstsemster_bprml2',
        'middleware' => 'can:view Programs and Courses',
        'as' => 'add-course-programme-BPRM-first-l2',
    ]);

    Route::post('/programmme/course/assignment/first/semsester/{code}/save/200', [
        'uses' => 'CourseController@firstsemster_bprm_savel2',
        'middleware' => 'can:create Programs and Courses',
        'as' => 'add-course-programme-BPRM-first-save-l2',
    ]);

    Route::post('/programmme/course/delete/first/semsester/BPRM/200/{id}', [
        'uses' => 'CourseController@firstsemster_bprm_deletel2',
        'middleware' => 'can:delete Programs and Courses',
        'as' => 'course-remove-first-BPRM-l2',
    ]);

    //level 200 second semester
    Route::get('/programmme/course/assignment/second/semsester/{code}/l200', [
        'uses' => 'CourseController@secondsemster_bprml2',
        'middleware' => 'can:view Programs and Courses',
        'as' => 'add-course-programme-BPRM-second-l2',
    ]);

    Route::post('/programmme/course/assignment/second/semsester/{code}/save/200', [
        'uses' => 'CourseController@secondsemster_bprm_savel2',
        'middleware' => 'can:create Programs and Courses',
        'as' => 'add-course-programme-BPRM-second-save-l2',
    ]);

    Route::post('/programmme/course/delete/firsecondst/semsester/BPRM/200/{id}', [
        'uses' => 'CourseController@secondsemster_bprm_deletel2',
        'middleware' => 'can:delete Programs and Courses',
        'as' => 'course-remove-second-BPRM-l2',
    ]);

    //level 300 first Semester for BPRM
    Route::get('/programmme/course/assignment/first/semsester/{code}/l300', [
        'uses' => 'CourseController@firstsemster_bprml3',
        'middleware' => 'can:view Programs and Courses',
        'as' => 'add-course-programme-BPRM-first-l3',
    ]);

    Route::post('/programmme/course/assignment/first/semsester/{code}/save/300', [
        'uses' => 'CourseController@firstsemster_bprm_savel3',
        'middleware' => 'can:create Programs and Courses',
        'as' => 'add-course-programme-BPRM-first-save-l3',
    ]);

    Route::post('/programmme/course/delete/first/semsester/BPRM/300/{id}', [
        'uses' => 'CourseController@firstsemster_bprm_deletel3',
        'middleware' => 'can:delete Programs and Courses',
        'as' => 'course-remove-first-BPRM-l3',
    ]);

    //level 300 second semester
    Route::get('/programmme/course/assignment/second/semsester/{code}/l300', [
        'uses' => 'CourseController@secondsemster_bprml3',
        'middleware' => 'can:view Programs and Courses',
        'as' => 'add-course-programme-BPRM-second-l3',
    ]);

    Route::post('/programmme/course/assignment/second/semsester/{code}/save/300', [
        'uses' => 'CourseController@secondsemster_bprm_savel3',
        'middleware' => 'can:create Programs and Courses',
        'as' => 'add-course-programme-BPRM-second-save-l3',
    ]);

    Route::post('/programmme/course/delete/firsecondst/semsester/BPRM/l300/{id}', [
        'uses' => 'CourseController@secondsemster_bprm_deletel3',
        'middleware' => 'can:delete Programs and Courses',
        'as' => 'course-remove-second-BPRM-l3',
    ]);

    //level 400 first Semester for BPRM
    Route::get('/programmme/course/assignment/first/semsester/{code}/l400', [
        'uses' => 'CourseController@firstsemster_bprml4',
        'middleware' => 'can:view Programs and Courses',
        'as' => 'add-course-programme-BPRM-first-l4',
    ]);

    Route::post('/programmme/course/assignment/first/semsester/{code}/save/400', [
        'uses' => 'CourseController@firstsemster_bprm_savel4',
        'middleware' => 'can:create Programs and Courses',
        'as' => 'add-course-programme-BPRM-first-save-l4',
    ]);

    Route::post('/programmme/course/delete/first/semsester/BPRM/400/{id}', [
        'uses' => 'CourseController@firstsemster_bprm_deletel4',
        'middleware' => 'can:delete Programs and Courses',
        'as' => 'course-remove-first-BPRM-l4',
    ]);

    //level 300 second semester
    Route::get('/programmme/course/assignment/second/semsester/{code}/l400', [
        'uses' => 'CourseController@secondsemster_bprml4',
        'middleware' => 'can:view Programs and Courses',
        'as' => 'add-course-programme-BPRM-second-l4',
    ]);

    Route::post('/programmme/course/assignment/second/semsester/{code}/save/400', [
        'uses' => 'CourseController@secondsemster_bprm_savel4',
        'middleware' => 'can:create Programs and Courses',
        'as' => 'add-course-programme-BPRM-second-save-l4',
    ]);

    Route::post('/programmme/course/delete/firsecondst/semsester/BPRM/300/{id}', [
        'uses' => 'CourseController@secondsemster_bprm_deletel4',
        'middleware' => 'can:delete Programs and Courses',
        'as' => 'course-remove-second-BPRM-l4',
    ]);

    //all Degree Courses
    //level 300 second semester
    Route::get('/programmme/course/all/degree/courses/registered', [
        'uses' => 'CourseController@alldegreecourse',
        'middleware' => 'can:view All Degree Courses',
        'as' => 'all-degree-course-registered-view',
    ]);

    Route::get('/programmme/course/all/diploma/courses/registered', [
        'uses' => 'CourseController@alldiplomacourse',
        'middleware' => 'can:view All Diploma Courses',
        'as' => 'all-diploma-course-registered-view',
    ]);

    Route::post('/programmme/course/delete/course/regsitered/{id}', [
        'uses' => 'CourseController@delcourse',
        'middleware' => 'can:delete All Degree Courses',
        'as' => 'all-deg-dip-delete',
    ]);

    //asign course to lecturers
    Route::get('/list-of-lecturers', [
        'uses' => 'CourseController@lecturer_list',
        'as' => 'lecturer-list',
    ]);

    //asign course to lecturers
    Route::get('/assign-course-to-lecturers/{id}', [
        'uses' => 'CourseController@assign_course_lecturer',
        'as' => 'assign-course-lecturer',
    ]);
});

Route::group(['prefix' => 'Booking',  'middleware' => 'auth'], function (): void {
    Route::get('/new-appointment-booking', [
        'uses' => 'BookingController@create',
        'as' => 'new-booking',
    ]);

    Route::post('/new-booking-create', [
        'uses' => 'BookingController@store',
        'as' => 'book-now',
    ]);

    Route::get('/all-booking', [
        'uses' => 'BookingController@index',
        'as' => 'all-booking',
    ]);

    Route::get('/Edit-booking/{id}', [
        'uses' => 'BookingController@edit',
        'as' => 'edit-booking',
    ]);

    Route::post('/Update-booking', [
        'uses' => 'BookingController@update',
        'as' => 'Update-booking',
    ]);

    Route::post('/delete-booking/{id}', [
        'uses' => 'BookingController@destroy',
        'as' => 'delete-booking',
    ]);
});

//Roles and Permssions Configuration

Route::group(['prefix' => 'UserManagement',  'middleware' => 'auth'], function (): void {
    Route::get('/adduserRole', [
        'uses' => 'UserRoleController@addrole',
        'as' => 'add-user-role',
    ]);

    Route::post('/adduserRole/save/user/role', [
        'uses' => 'UserRoleController@addrole_save',
        'as' => 'user-role-save',
    ]);

    Route::get('/deleteuserRole/{id}', [
        'uses' => 'UserRoleController@deleterole',
        'as' => 'delete-user-role',
    ]);

    Route::post('/adduserRole/save/user/permission', [
        'uses' => 'UserRoleController@addpermission_save',
        'as' => 'user-permission-save',
    ]);

    Route::post('/adduserRole/edit/role/{id}', [
        'uses' => 'UserRoleController@edit_role_per',
        'as' => 'edit-role-perm',
    ]);

    Route::post('/adduserRole/edit/roles/update', [
        'uses' => 'UserRoleController@edit_role_save',
        'as' => 'edit-role-update',
    ]);

    Route::post('/adduserRole/edit/permsission/update', [
        'uses' => 'UserRoleController@edit_per_save',
        'as' => 'edit-perm-update',
    ]);

    Route::get('/adduserRole/assign/role/permission/{id}', [
        'uses' => 'UserRoleController@assignrole_to_permission',
        'as' => 'assingn-role-to-permission',
    ]);

    Route::post('/adduserRole/assign/role/permission/save', [
        'uses' => 'UserRoleController@assignrole_to_permission_save',
        'as' => 'assingn-role-to-permission-save',
    ]);

    Route::post('/adduserRole/assign/role/edit/permission/{id}', [
        'uses' => 'UserRoleController@edit_permission',
        'as' => 'edit-role-assign-to-permission',
    ]);

    //user and their roles

    Route::get('/users/roles/display/rolesandUsers', [
        'uses' => 'UserRoleController@user_roles_display',
        'as' => 'users-roles-display',
    ]);

    //forcelogout
    Route::get('/users/force/logout', [
        'uses' => 'UserRoleController@user_force_logout',
        'as' => 'logout-user-force',
    ]);

    Route::post('/users/force/logout/{id}', [
        'uses' => 'UserRoleController@user_force_logout_update',
        'as' => 'logout-user-force-update',
    ]);

    Route::post('/users/force/logout/{id}/enableuser', [
        'uses' => 'UserRoleController@user_force_logout_enable',
        'as' => 'logout-user-force-enable',
    ]);

    Route::get('/set-locale/{lang}', [
        'uses' => 'UserRoleController@user_set_locale',
        'as' => 'setLocale',
    ]);
});

//Lock Screen User

Route::get('/users/confirm-password-user', [
    'uses' => 'UserRoleController@lockscreen',
    'as' => 'passconfirm',
]);

Route::get('/users/confirm-password/lms', [
    'uses' => 'UserRoleController@lmslockscreen',
    'as' => 'lmspassconfirm',
]);

Route::group(['prefix' => 'Notifications',  'middleware' => 'auth'], function (): void {
    Route::post('/markallasRead', [
        'uses' => 'NotificationController@markallasread',
        'as' => 'mark-all-as-read',
    ]);

    Route::post('/DeleteAllNotifications', [
        'uses' => 'NotificationController@DeleteAllNotifications',
        'as' => 'delete-all-notification',
    ]);
});

Route::group(['prefix' => 'CourseRegistration',  'middleware' => 'auth'], function (): void {
    Route::get('/student/register/course', [
        'uses' => 'CouserRegController@register_course_user',
        'as' => 'student-reg-course',
    ]);

    Route::post('/student/register/course/now/{prog}/{code}/{currentlevel}/{semester}/{academicyear}', [
        'uses' => 'CouserRegController@register_course_user_now',
        'as' => 'student-reg-course-now',
    ]);

    Route::get('/student/print/course/registration/{prog}/{currentlevel}/{semester}/{academicyear}', [
        'uses' => 'CouserRegController@print_course_user',
        'as' => 'student-print-course',
    ]);

    Route::get('/student/results/', [
        'uses' => 'CouserRegController@results_display',
        'as' => 'student-results',
    ]);
});

Route::group(['prefix' => 'Lecturer',  'middleware' => 'auth'], function (): void {
    Route::get('/register', [
        'uses' => 'LecturerController@register_lecturer',
        'as' => 'lecturer-reg-lecturer',
    ]);

    Route::post('/register/save', [
        'uses' => 'LecturerController@register_lecturer_save',
        'as' => 'lecturer-reg-lecturer-save',
    ]);

    Route::get('/all', [
        'uses' => 'LecturerController@all_lecturer',
        'as' => 'lecturer-all',
    ]);

    Route::get('/edit/lecturer/{id}', [
        'uses' => 'LecturerController@edit_lecturer',
        'as' => 'edit-lecturer',
    ]);

    Route::post('/edit/update/lecturer', [
        'uses' => 'LecturerController@register_lecturer_update',
        'as' => 'update-lecturer-info',
    ]);

    Route::get('/students/results', [
        'uses' => 'LecturerController@lecturer_enter_results',
        'as' => 'lecturer-student-results',
    ]);

    Route::post('/students/results/get/fullname', [
        'uses' => 'LecturerController@lecturer_get_fullname',
        'as' => 'lecturer-student-fullname',
    ]);

    Route::post('/students/results/save', [
        'uses' => 'LecturerController@lecturer_save_results',
        'as' => 'lecturer-student-results-save',
    ]);

    //reenter student results
    Route::get('/students/results/reEnter', [
        'uses' => 'LecturerController@lecturer_enter_results_reenter',
        'as' => 'lecturer-student-results-reenter',
    ]);

    //resave
    Route::post('/students/results/resave', [
        'uses' => 'LecturerController@lecturer_resave_results',
        'as' => 'lecturer-student-results-resave',
    ]);

    //online assignment
    Route::get('/students/assignment', [
        'uses' => 'LecturerController@lecturer_post_assignment',
        'as' => 'lecturer-student-assignment',
    ]);

    Route::post('/students/assignment/post', [
        'uses' => 'LecturerController@lecturer_assignment_save',
        'as' => 'lecturer-student-assignment-post',
    ]);

    Route::get('/students/assignment/view', [
        'uses' => 'LecturerController@lecturer_assignment_view',
        'as' => 'lecturer-student-assignment-view',
    ]);

    Route::get('/students/assignment/edit/{id}', [
        'uses' => 'LecturerController@lecturer_assignment_edit',
        'as' => 'lecturer-student-assignment-edit',
    ]);

    Route::post('/students/assignment/post/update', [
        'uses' => 'LecturerController@lecturer_assignment_update',
        'as' => 'lecturer-student-assignment-update',
    ]);

    Route::get('/students/assignment/post/delete/{id}', [
        'uses' => 'LecturerController@lecturer_assignment_delete',
        'as' => 'lecturer-student-assignment-delete',
    ]);

    Route::get('/students/assignment/submiited/{id}', [
        'uses' => 'LecturerController@lecturer_assignment_submiited',
        'as' => 'lecturer-student-assignment-submiited',
    ]);

    Route::post('/lecturer/assign-course', [
        'uses' => 'LecturerController@lecturer_assign_course',
        'as' => 'lecturer-assign-course',
    ]);

    Route::post('/lecturer/remove-assign-course', [
        'uses' => 'LecturerController@lecturer_remove_assign_course',
        'as' => 'lecturer-remove-assign-course',
    ]);
});

Route::group(['prefix' => 'Polls',  'middleware' => 'auth'], function (): void {
    Route::get('/add-polls', [
        'uses' => 'PollsController@add_pols',
        'as' => 'add-polls',
    ]);

    Route::post('/add-polls/save', [
        'uses' => 'PollsController@save_polls',
        'as' => 'save-polls',
    ]);

    Route::post('/polls-confirm-status', [
        'uses' => 'PollsController@status_confirm',
        'as' => 'confirm-polls',
    ]);

    Route::post('/polls-confirm-vote-start', [
        'uses' => 'PollsController@vote_confirm',
        'as' => 'start-vote-polls',
    ]);

    Route::get('/edit-polls/{id}', [
        'uses' => 'PollsController@edit_pols',
        'as' => 'edit-polls',
    ]);

    Route::post('/update-polls/savepoll', [
        'uses' => 'PollsController@update_pols',
        'as' => 'update-polls',
    ]);

    Route::get('/manage-candidates', [
        'uses' => 'PollsController@manage_polls',
        'as' => 'manage-candidates',
    ]);

    Route::post('/save/positions', [
        'uses' => 'PollsController@save_position',
        'as' => 'save-position',
    ]);

    Route::get('/manage-candidates/edit/{id}', [
        'uses' => 'PollsController@edit_positions',
        'as' => 'edit-position',
    ]);

    Route::post('/update/position', [
        'uses' => 'PollsController@update_position',
        'as' => 'update-position',
    ]);

    Route::get('/user/manage-candidates/', [
        'uses' => 'PollsController@add_candidates',
        'as' => 'add-candidates',
    ]);

    Route::post('/add/candidate', [
        'uses' => 'PollsController@save_candidate',
        'as' => 'add-candidates-save',
    ]);

    Route::get('/edit/candidates/info/{id}', [
        'uses' => 'PollsController@edit_candidates',
        'as' => 'edit-candidates',
    ]);

    Route::post('/update/cnadidate/info', [
        'uses' => 'PollsController@update_candidate_info',
        'as' => 'update-candidate-info',
    ]);

    Route::get('/vote', [
        'uses' => 'PollsController@start_vote',
        'as' => 'start-vote',
    ]);

    Route::post('/vote', [
        'uses' => 'PollsController@start_votes',
        'as' => 'start-votes',
    ]);

    Route::get('/start/vote/', [
        'uses' => 'PollsController@start_vote_now',
        'as' => 'start-vote-now',
    ]);

    Route::post('/start/vote/nextvote', [
        'uses' => 'PollsController@vote_next',
        'as' => 'vote-next',
    ]);

    Route::post('/start/vote/previousvote', [
        'uses' => 'PollsController@vote_previous',
        'as' => 'vote-previous',
    ]);

    Route::post('/submit/user/vote', [
        'uses' => 'PollsController@vote_save',
        'as' => 'vote-save',
    ]);

    Route::get('/results', [
        'uses' => 'PollsController@result_polls',
        'as' => 'poll-results',
    ]);

    Route::get('/results-others', [
        'uses' => 'PollsController@result_polls_others',
        'as' => 'result_polls_others',
    ]);

    Route::post('/get/results/all', [
        'uses' => 'PollsController@get_results',
        'as' => 'gets-results-polls',
    ]);

    Route::get('/release-polls', [
        'uses' => 'PollsController@release_polls',
        'as' => 'release_polls',
    ]);

    Route::get('/release-polls/now', [
        'uses' => 'PollsController@release_polls_now',
        'as' => 'release_polls_now',
    ]);

    Route::get('/unrelease-polls', [
        'uses' => 'PollsController@unrelease_polls',
        'as' => 'unrelease_polls',
    ]);
});

Route::group(['prefix' => 'OnlineExamination',  'middleware' => 'auth'], function (): void {
    Route::get('/addExams', [
        'uses' => 'ExaminationController@add_exams',
        'as' => 'add-exams',
    ]);

    Route::get('/ExamsView', [
        'uses' => 'ExaminationController@all_exams',
        'as' => 'all-exams',
    ]);

    Route::post('/examination/save', [
        'uses' => 'ExaminationController@save_exams',
        'as' => 'save-exams',
    ]);

    Route::get('/addExams/edit/{id}', [
        'uses' => 'ExaminationController@edit_exams',
        'as' => 'edit-exams',
    ]);

    Route::post('/addExams/update', [
        'uses' => 'ExaminationController@update_exams',
        'as' => 'update-exams',
    ]);

    Route::get('/addQuestion/{id}', [
        'uses' => 'ExaminationController@add_questions',
        'as' => 'add-questions',
    ]);

    Route::get('/addQuestion/more/{quanty}/{examid}', [
        'uses' => 'ExaminationController@more_questions',
        'as' => 'more-questions',
    ]);

    Route::post('/exams/questions/save/{totalquestions}', [
        'uses' => 'ExaminationController@save_questions',
        'as' => 'save-questions',
    ]);

    Route::get('/view/exams/uploaded', [
        'uses' => 'ExaminationController@view_exams',
        'as' => 'view-exams',
    ]);

    Route::get('/student/examinations', [
        'uses' => 'ExaminationController@start_exams',
        'as' => 'start-exmas',
    ]);

    Route::get('/student/examinations/start/{id}', [
        'uses' => 'ExaminationController@start_exams_now',
        'as' => 'start-exmas-now',
    ]);

    Route::get('/student/examinations/fetch/{studentname}/{examid}/{examtotal}/{mins}', [
        'uses' => 'ExaminationController@student_exams_start',
        'as' => 'student_exams_start',
    ]);

    Route::post('/student/exmaination/submit', [
        'uses' => 'ExaminationController@submit_exams',
        'as' => 'submit-exams',
    ]);

    Route::get('/student/examinations/viewscore/{id}', [
        'uses' => 'ExaminationController@view_exams_score',
        'as' => 'start-exmas-score',
    ]);

    Route::get('/lecturer/examinations/view/{id}', [
        'uses' => 'ExaminationController@lect_exam_view',
        'as' => 'lecturer-exam-view',
    ]);

    Route::get('/Student/Retry/Examination/{id}', [
        'uses' => 'ExaminationController@retry_exam_results',
        'as' => 'student-exam-retry-result',
    ]);

    Route::get('/lecturer/questions/edit/{id}', [
        'uses' => 'ExaminationController@lect_question_edit',
        'as' => 'lecturer-question-edit',
    ]);

    Route::post('/lecturer/update/questions/{totalquestions}', [
        'uses' => 'ExaminationController@update_questions',
        'as' => 'update-questions',
    ]);
});

//Lecture Hall Add

Route::group(['prefix' => 'LectureHall',  'middleware' => 'auth'], function (): void {
    Route::get('/add-view', [
        'uses' => 'LectureHall@add_view_lecture_hall',
        'as' => 'add-view-lecture-hall',
    ]);

    Route::post('/add-view/save', [
        'uses' => 'LectureHall@add_view_lecture_hall_save',
        'as' => 'add-view-lecture-hall-save',
    ]);

    Route::get('/edit/hall/{id}', [
        'uses' => 'LectureHall@edit_hall',
        'as' => 'edit-hall',
    ]);

    Route::post('/add-view/update/{id}', [
        'uses' => 'LectureHall@update_lect_hall',
        'as' => 'update-lec-hall',
    ]);

    Route::get('/delete/hall/{id}', [
        'uses' => 'LectureHall@delete_hall',
        'as' => 'delete-hall',
    ]);
});

//Timetable Management

Route::group(['prefix' => 'Timetable',  'middleware' => 'auth'], function (): void {
    Route::get('/add-timetable', [
        'uses' => 'TimetableController@add_timetable',
        'as' => 'add-timetable',
    ]);

    Route::post('/get-courses', [
        'uses' => 'TimetableController@getcources',
        'as' => 'courses-timetable',
    ]);

    Route::post('/get-courses-by-level', [
        'uses' => 'TimetableController@getcources_bylevel',
        'as' => 'courses-timetable-bylevel',
    ]);

    Route::post('/get-total-students', [
        'uses' => 'TimetableController@gettotal_students',
        'as' => 'total-students-by-cousre',
    ]);

    Route::get('/get-lectures', [
        'uses' => 'TimetableController@get_lectures',
        'as' => 'getall-lecturers',
    ]);

    Route::get('/sub-number', [
        'uses' => 'TimetableController@sub_number',
        'as' => 'substr-number',
    ]);

    Route::get('/check-lecturer', [
        'uses' => 'TimetableController@check_lecturer',
        'as' => 'check-lecturer',
    ]);

    Route::post('/save-information', [
        'uses' => 'TimetableController@save_timetable',
        'as' => 'save-timetable-save',
    ]);

    Route::get('/genearte-timetable', [
        'uses' => 'TimetableController@generate_timetable',
        'as' => 'generate-timetable',
    ]);

    Route::post('/timetable-genarate-view', [
        'uses' => 'TimetableController@gentimetable_view',
        'as' => 'timetable-gen-view',
    ]);

    Route::get('/timetable-genarate-view/pdf/', [
        'uses' => 'TimetableController@gentimetable_pdf',
        'as' => 'timetable-gen-pdf',
    ]);

    Route::get('/upload-timetable', [
        'uses' => 'TimetableController@upload_timetable',
        'as' => 'upload-timetable',
    ]);

    Route::post('/save-timetable', [
        'uses' => 'TimetableController@save_generated_timetable',
        'as' => 'save-timetable',
    ]);

    Route::get('/delete/timetable/{id}', [
        'uses' => 'TimetableController@delete_timetable',
        'as' => 'delete-timetable',
    ]);

    Route::get('/edit/timetable/{id}', [
        'uses' => 'TimetableController@edit_timetable',
        'as' => 'edit-timetable',
    ]);

    Route::post('/updatetime/uploaded', [
        'uses' => 'TimetableController@update_timetable',
        'as' => 'update-timetable',
    ]);

    Route::get('/student/lecture/grouping', [
        'uses' => 'TimetableController@grp_student_timetable',
        'as' => 'group-student-timetable',
    ]);

    Route::get('/student/lecture/hall-capacity', [
        'uses' => 'TimetableController@grp_hall_capacity',
        'as' => 'grp-hall-capacity',
    ]);

    Route::post('/student/group-dispatch', [
        'uses' => 'TimetableController@group_dispatch',
        'as' => 'group-dispatch',
    ]);

    Route::get('/student/view-group', [
        'uses' => 'TimetableController@view_grouping',
        'as' => 'view-grouping',
    ]);

    Route::get('/student/show-grouping/{year}/{semester}/{level}/{coursecode}/{session}/{progcode}/', [
        'uses' => 'TimetableController@show_grouping',
        'as' => 'show-grouping',
    ]);

    Route::get('/get-student-in-group', [
        'uses' => 'TimetableController@student_in_grps',
        'as' => 'student-in-grps',
    ]);

    Route::get('/student/timetable/view', [
        'uses' => 'TimetableController@student_timetable',
        'as' => 'student-timetable',
    ]);

    Route::get('/lecturer/timetable/view', [
        'uses' => 'TimetableController@gen_timetable_lecturer',
        'as' => 'gen_timetable_lecturer',
    ]);

    Route::post('/lecturer/timetable/view', [
        'uses' => 'TimetableController@lecturer_timetable',
        'as' => 'lecturer_timetable',
    ]);
});

Route::group(['prefix' => 'LiveClasses',  'middleware' => 'auth'], function (): void {
    Route::get('/createMeeting', [
        'uses' => 'ZoomController@index',
        'as' => 'create-meeting',
    ]);

    Route::post('/save-meeting', [
        'uses' => 'ZoomController@save_meeting',
        'as' => 'save-meeting',
    ]);

    Route::get('/getmeetinginfo', [
        'uses' => 'ZoomController@all_meeting',
        'as' => 'all-meeting',
    ]);

    Route::post('/del-meeting', [
        'uses' => 'ZoomController@del_meeting',
        'as' => 'del-meeting',
    ]);

    Route::get('/student/join-meeting', [
        'uses' => 'ZoomController@join_meeting',
        'as' => 'join-meeting',
    ]);

    Route::get('/getmeetinginfo/student', [
        'uses' => 'ZoomController@student_all_meeting',
        'as' => 'student-all-meeting',
    ]);

    Route::get('/Staffmeeting/schedule', [
        'uses' => 'ZoomController@staff_meeting',
        'as' => 'create-staff-meeting',
    ]);

    Route::get('/Staffmeeting', [
        'uses' => 'ZoomController@all_staff_meetings',
        'as' => 'show-staff-meeting',
    ]);

    Route::post('/lecmeeting/save', [
        'uses' => 'ZoomController@staff_meeting_save',
        'as' => 'staff-meeting-save',
    ]);

    Route::get('/allStaffcmeeting', [
        'uses' => 'ZoomController@all_staff_meeting',
        'as' => 'all-staff-meeting',
    ]);

    Route::post('/del-meeting-staff', [
        'uses' => 'ZoomController@del_meeting_staff',
        'as' => 'del-meeting-staff',
    ]);
});

Route::group(['prefix' => 'Log',  'middleware' => 'auth'], function (): void {
    Route::get('/systemLogs', [
        'uses' => 'LogController@viewlogs',
        'as' => 'view-system-logs',
    ]);
});

Route::group(['prefix' => 'Promote/Student',  'middleware' => 'auth'], function (): void {
    Route::get('/all', [
        'uses' => 'StudentPromotionController@promotestudent',
        'middleware' => 'can:view Promote Student',
        'as' => 'promote-student',
    ]);

    Route::get('/all-graduating-to-graduated', [
        'uses' => 'StudentPromotionController@gradtatingtograduated',
        'middleware' => 'can:view Graduation List',
        'as' => 'graduating-to-graduated',
    ]);

    Route::get('/all-400-to-graduating', [
        'uses' => 'StudentPromotionController@l400tograduating',
        'middleware' => 'can:view Promote Student',
        'as' => '400-to-graduating',
    ]);

    Route::get('/all-300-to-400', [
        'uses' => 'StudentPromotionController@l300to400',
        'middleware' => 'can:view Promote Student',
        'as' => '300-to-400',
    ]);

    Route::get('/all-200-to-300', [
        'uses' => 'StudentPromotionController@l200to300',
        'middleware' => 'can:view Promote Student',
        'as' => '200-to-300',
    ]);

    Route::get('/all-100-to-200', [
        'uses' => 'StudentPromotionController@l100to200',
        'middleware' => 'can:view Promote Student',
        'as' => '100-to-200',
    ]);

    // Graduating List
    Route::get('/graduating-List', [
        'uses' => 'StudentPromotionController@graduating_list',
        'middleware' => 'can:view Graduation List',
        'as' => 'graduating_list',
    ]);

    Route::post('/graduating-List/students', [
        'uses' => 'StudentPromotionController@graduating_list_script',
        'middleware' => 'can:create Graduation List',
        'as' => 'graduating_list_script',
    ]);

    Route::get('/fetch/graduating-List/{level}/{prog}/{session}/{academicyear}/{type}/', [
        'uses' => 'StudentPromotionController@fetch_graduatng_list',
        'as' => 'fetch_graduatng_list',
    ]);
});

Route::group(['prefix' => 'Student-Punishment',  'middleware' => 'auth'], function (): void {
    Route::get('/addfine', [
        'uses' => 'StudentfineController@addfine',
        'middleware' => 'can:view Add Fine',
        'as' => 'add-fine',
    ]);

    Route::post('/savefine', [
        'uses' => 'StudentfineController@savefine',
        'middleware' => 'can:create Add Fine',
        'as' => 'savefine',
    ]);

    Route::get('/deletefine/{id}', [
        'uses' => 'StudentfineController@deletefine',
        'middleware' => 'can:delete Add Fine',
        'as' => 'deletefine',
    ]);

    Route::get('/finestudent', [
        'uses' => 'StudentfineController@fine_student',
        'middleware' => 'can:view Fine Student',
        'as' => 'fine-student',
    ]);

    Route::post('/savefinestudent', [
        'uses' => 'StudentfineController@savefine_student',
        'middleware' => 'can:create Fine Student',
        'as' => 'savefine_student',
    ]);

    Route::get('/editfinestudent/{id}', [
        'uses' => 'StudentfineController@editfinestudent',
        'middleware' => 'can:edit Fine Student',
        'as' => 'editfinestudent',
    ]);

    Route::post('/updatefinestudent', [
        'uses' => 'StudentfineController@updatefinestudent',
        'middleware' => 'can:create Fine Student',
        'as' => 'updatefinestudent',
    ]);

    Route::get('/revertfinestudent/{id}', [
        'uses' => 'StudentfineController@revertfinestudent',
        'middleware' => 'can:edit Fine Student',
        'as' => 'revertfinestudent',
    ]);

    Route::get('/cancel-student-results', [
        'uses' => 'StudentfineController@cancel_student_results',
        'as' => 'cancel-student-results',
    ]);

    // Route::get('/editfinestudent/{id}', [
    //     'uses' => 'StudentfineController@editfinestudent',
    //     'as' => 'editfinestudent'
    // ]);

    Route::get('/student-dismissal', [
        'uses' => 'StudentfineController@dismiss_student',
        'middleware' => 'can:view Dismiss Student',
        'as' => 'dismiss_student',
    ]);

    Route::post('/save-dismissal', [
        'uses' => 'StudentfineController@save_dismiss_student',
        'middleware' => 'can:create Dismiss Student',
        'as' => 'save_dismiss_student',
    ]);

    Route::get('/student-dismissal-revert/{id}', [
        'uses' => 'StudentfineController@dismiss_revert',
        'middleware' => 'can:edit Dismiss Student',
        'as' => 'dismiss_revert',
    ]);

    Route::get('/student-undo-revert/{id}', [
        'uses' => 'StudentfineController@undo_revert',
        'middleware' => 'can:edit Dismiss Student',
        'as' => 'undo_revert',
    ]);

    Route::get('/student-rasticate', [
        'uses' => 'StudentfineController@rasticate_student',
        'middleware' => 'can:view Rusticate Student',
        'as' => 'rasticate_student',
    ]);

    Route::post('/student-rasticate-save', [
        'uses' => 'StudentfineController@rasticate_save',
        'middleware' => 'can:create Rusticate Student',
        'as' => 'rasticate_save',
    ]);

    Route::get('/student-rasticate/revert/{id}', [
        'uses' => 'StudentfineController@rasticate_revert',
        'middleware' => 'can:edit Rusticate Student',
        'as' => 'rasticate_revert',
    ]);

    Route::get('/student-rasticate-undo/revert/{id}', [
        'uses' => 'StudentfineController@rasticate_undo_revert',
        'middleware' => 'can:edit Rusticate Student',
        'as' => 'rasticate_undo_revert',
    ]);

    Route::get('/student-deferal', [
        'uses' => 'StudentfineController@deferal_student',
        'middleware' => 'can:view Defer Student',
        'as' => 'deferal_student',
    ]);

    Route::post('/student-deferal-save', [
        'uses' => 'StudentfineController@deferal_save',
        'middleware' => 'can:create Defer Student',
        'as' => 'deferal_save',
    ]);

    Route::get('/student-deferal/revert/{id}', [
        'uses' => 'StudentfineController@deferal_revert',
        'middleware' => 'can:edit Defer Student',
        'as' => 'deferal_revert',
    ]);

    Route::get('/student-deferal-undo/revert/{id}', [
        'uses' => 'StudentfineController@deferal_undo_revert',
        'middleware' => 'can:edit Defer Student',
        'as' => 'deferal_undo_revert',
    ]);
});

Route::group(['prefix' => 'Front-Desk',  'middleware' => 'auth'], function (): void {
    Route::get('/record-enquiry', [
        'uses' => 'FrontDeskController@addenquiry',
        'middleware' => 'can:view Admission Enquiry',
        'as' => 'add-enquiry',
    ]);

    Route::post('/save-enquiry', [
        'uses' => 'FrontDeskController@saveenquiry',
        'middleware' => 'can:create Admission Enquiry',
        'as' => 'save-enquiry',
    ]);

    Route::get('/edit-enquiry/{id}', [
        'uses' => 'FrontDeskController@editenquiry',
        'middleware' => 'can:edit Admission Enquiry',
        'as' => 'edit-enquiry',
    ]);

    Route::get('/delete-enquiry/{id}', [
        'uses' => 'FrontDeskController@deleteenquiry',
        'middleware' => 'can:delete Admission Enquiry',
        'as' => 'delete-enquiry',
    ]);

    // Visitors Script

    Route::get('/add-visitor', [
        'uses' => 'FrontDeskController@addvisitor',
        'middleware' => 'can:view Visitors Book',
        'as' => 'add-visitor',
    ]);

    Route::post('/save-visitor', [
        'uses' => 'FrontDeskController@savevisitor',
        'middleware' => 'can:create Visitors Book',
        'as' => 'save-visitor',
    ]);

    Route::get('/edit-visitor/{id}', [
        'uses' => 'FrontDeskController@editvisitor',
        'middleware' => 'can:edit Visitors Book',
        'as' => 'edit-visitor',
    ]);

    Route::get('/add-visitor/{id}', [
        'uses' => 'FrontDeskController@deletevisitor',
        'middleware' => 'can:delete Visitors Book',
        'as' => 'delete-visitor',
    ]);

    // Call Log

    Route::get('/add-call', [
        'uses' => 'FrontDeskController@addcall',
        'middleware' => 'can:view Phone call log',
        'as' => 'add-call',
    ]);

    Route::post('/save-call', [
        'uses' => 'FrontDeskController@savecall',
        'middleware' => 'can:create Phone call log',
        'as' => 'save-call',
    ]);

    Route::get('/edit-call/{id}', [
        'uses' => 'FrontDeskController@editcall',
        'middleware' => 'can:edit Phone call log',
        'as' => 'edit-call',
    ]);

    Route::get('/delete-call/{id}', [
        'uses' => 'FrontDeskController@deletecall',
        'middleware' => 'can:delete Phone call log',
        'as' => 'delete-call',
    ]);

    // Postal Dispatch

    Route::get('/add-postal-dispatch', [
        'uses' => 'FrontDeskController@addpostalDispatch',
        'middleware' => 'can:view Postal Dispatch',
        'as' => 'add-postal-dispatch',
    ]);

    Route::post('/save-postal-dispatch', [
        'uses' => 'FrontDeskController@savepostalDispatch',
        'middleware' => 'can:create Postal Dispatch',
        'as' => 'save-postal-dispatch',
    ]);

    Route::get('/edit-postal-dispatch/{id}', [
        'uses' => 'FrontDeskController@editpostalDispatch',
        'middleware' => 'can:edit Postal Dispatch',
        'as' => 'edit-postal-dispatch',
    ]);

    Route::get('/delete-postal-dispatch/{id}', [
        'uses' => 'FrontDeskController@deletepostalDispatch',
        'middleware' => 'can:delete Postal Dispatch',
        'as' => 'delete-postal-dispatch',
    ]);

    // Postal Receive

    Route::get('/add-postal-receive', [
        'uses' => 'FrontDeskController@addpostalreceive',
        'middleware' => 'can:view Postal receive',
        'as' => 'add-postal-receive',
    ]);

    Route::post('/save-postal-receive', [
        'uses' => 'FrontDeskController@savepostalreceive',
        'middleware' => 'can:create Postal receive',
        'as' => 'save-postal-receive',
    ]);

    Route::get('/edit-postal-receive/{id}', [
        'uses' => 'FrontDeskController@editpostalreceive',
        'middleware' => 'can:edit Postal receive',
        'as' => 'edit-postal-receive',
    ]);

    Route::get('/delete-postal-receive/{id}', [
        'uses' => 'FrontDeskController@deletepostalreceive',
        'middleware' => 'can:delete Postal receive',
        'as' => 'delete-postal-receive',
    ]);

    // Postal Receive
});

// Accounts Management

Route::group(['prefix' => 'Accounts',  'middleware' => 'auth'], function (): void {
    Route::get('/add-mandatory-fees', [
        'uses' => 'AccountController@create',
        'as' => 'add-mandatory-fees',
    ]);

    Route::post('/save-mandatory-fees', [
        'uses' => 'AccountController@store',
        'as' => 'save-mandatory-fees',
    ]);

    Route::get('/edit-mandatory-fees/{id}', [
        'uses' => 'AccountController@editmandatory',
        'as' => 'edit-mandatory-fees',
    ]);

    Route::get('/delete-mandatory-fees/{id}', [
        'uses' => 'AccountController@deletemandatory',
        'as' => 'delete-mandatory-fees',
    ]);

    // Other Services Fees

    Route::get('/add-other-services-fees', [
        'uses' => 'AccountController@add_other_services',
        'as' => 'add_other_services',
    ]);

    Route::post('/save-other-services-fees', [
        'uses' => 'AccountController@save_other_services',
        'as' => 'save_other_services',
    ]);

    Route::get('/edit-other-services-fees/{id}', [
        'uses' => 'AccountController@edit_other_services',
        'as' => 'edit_other_services',
    ]);

    Route::get('/delete-other-services-fees/{id}', [
        'uses' => 'AccountController@delete_other_services',
        'as' => 'delete_other_services',
    ]);

    // Fees Master

    Route::get('/add_fees_master', [
        'uses' => 'AccountController@add_fees_master',
        'as' => 'add_fees_master',
    ]);

    Route::get('/view_fees_master/level100', [
        'uses' => 'AccountController@view_fees_level100',
        'as' => 'view_fees_level100',
    ]);

    Route::get('/view_fees_master/level200', [
        'uses' => 'AccountController@view_fees_level200',
        'as' => 'view_fees_level200',
    ]);

    Route::get('/view_fees_master/level300', [
        'uses' => 'AccountController@view_fees_level300',
        'as' => 'view_fees_level300',
    ]);

    Route::get('/view_fees_master/level400', [
        'uses' => 'AccountController@view_fees_level400',
        'as' => 'view_fees_level400',
    ]);

    Route::post('/save_fees_master/mandatory', [
        'uses' => 'AccountController@save_fees_master_man',
        'as' => 'save_fees_master_man',
    ]);

    Route::post('/save_fees_master/otherservices', [
        'uses' => 'AccountController@save_fees_master_otherservice',
        'as' => 'save_fees_master_otherservice',
    ]);

    Route::get('/delete_fees_master/{id}', [
        'uses' => 'AccountController@delete_fees_master',
        'as' => 'delete_fees_master',
    ]);

    Route::get('/edit_fees_master/{id}', [
        'uses' => 'AccountController@edit_fees_master',
        'as' => 'edit_fees_master',
    ]);

    Route::post('/update_fees_master/{id}', [
        'uses' => 'AccountController@update_fees_master',
        'as' => 'update_fees_master',
    ]);

    Route::get('/dispatch-fees', [
        'uses' => 'AccountController@dispatch_fees',
        'as' => 'dispatch_fees',
    ]);

    Route::get('/dispatch-fees/now', [
        'uses' => 'AccountController@dispatch_fees_now',
        'as' => 'dispatch_fees_now',
    ]);

    // Student Script

    Route::get('/search-student', [
        'uses' => 'AccountController@search_student',
        'as' => 'search_student',
    ]);

    Route::post('/search-student/check', [
        'uses' => 'AccountController@search_student_check',
        'as' => 'search_student_check',
    ]);

    Route::get('/search-student/information/{id}', [
        'uses' => 'AccountController@search_student_information',
        'as' => 'search_student_information',
    ]);

    Route::get('/search-student/studentfess/{indexnumber}', [
        'uses' => 'AccountController@view_student_fees',
        'as' => 'view_student_fees',
    ]);

    Route::get('/search-student/payfees/{indexnumber}', [
        'uses' => 'AccountController@pay_students_fes',
        'as' => 'pay_students_fes',
    ]);

    Route::get('/studentinfo/fees/{id}', [
        'uses' => 'AccountController@getstudentfees_view',
        'as' => 'getstudentfees_view',
    ]);

    Route::post('/studentinfo/removefees', [
        'uses' => 'AccountController@remove_fee',
        'as' => 'remove_fee',
    ]);

    Route::post('/studentinfo/editfee', [
        'uses' => 'AccountController@edit_fee',
        'as' => 'edit_fee',
    ]);

    Route::get('/studentinfo/payfees/{id}', [
        'uses' => 'AccountController@paystudentfees_view',
        'as' => 'paystudentfees_view',
    ]);

    Route::post('/debit-student/wallet/information', [
        'uses' => 'AccountController@debit_wallet',
        'as' => 'debit-wallet',
    ]);

    Route::get('/alltransactions', [
        'uses' => 'AccountController@all_transactions',
        'as' => 'all_transactions',
    ]);

    Route::get('/gettransactions', [
        'uses' => 'AccountController@get_transactions',
        'as' => 'get_transactions',
    ]);

    Route::get('/gettransactions/{start}/{end}', [
        'uses' => 'AccountController@get_transactions_bydate',
        'as' => 'get_transactions_bydate',
    ]);

    Route::post('/gettransactions/revert-transaction', [
        'uses' => 'AccountController@revert_transactions',
        'as' => 'revert_transactions',
    ]);

    Route::get('/makepayment/cash', [
        'uses' => 'AccountController@makepayment',
        'as' => 'makepayment',
    ]);

    // Student Online Payment

    Route::get('/pay-mandatory-fees-student', [
        'uses' => 'AccountController@pay_mandatory_fees',
        'as' => 'pay_mandatory_fees',
    ]);

    Route::post('/pay-mandatory-fee-student', [
        'uses' => 'AccountController@pay_mandatory_student',
        'as' => 'pay_mandatory_student',
    ]);

    Route::get('/other-services-student', [
        'uses' => 'AccountController@other_services_fees',
        'as' => 'other_services_fees',
    ]);

    Route::post('/other-services-request', [
        'uses' => 'AccountController@request_services',
        'as' => 'request_services',
    ]);

    Route::get('/pay-other-services-student', [
        'uses' => 'AccountController@pay_other_services_fees',
        'as' => 'pay_other_services_fees',
    ]);

    Route::post('/remove-services-request', [
        'uses' => 'AccountController@remove_request_services',
        'as' => 'remove_request_services',
    ]);

    Route::get('/other-services-student/submitted', [
        'uses' => 'AccountController@submiited_other_services_fees',
        'as' => 'submiited_other_services_fees',
    ]);

    Route::get('/print-statement', [
        'uses' => 'AccountController@print_statement',
        'as' => 'print_statement',
    ]);

    Route::get('/ledge-account', [
        'uses' => 'AccountController@ledge_account',
        'as' => 'ledge-account',
    ]);

    Route::get('/print-statement/generate/from/{start}/to/{end}/student-statement', [
        'uses' => 'AccountController@print_statement_generate',
        'as' => 'print_statement_generate',
    ]);

    Route::get('/wallet-ledger-report/generate/from/{start}/to/{end}/wallet-ledger-report', [
        'uses' => 'AccountController@wallet_ledger_report',
        'as' => 'wallet-ledger-report',
    ]);

    Route::get('/transaction-history/student', [
        'uses' => 'AccountController@transaction_history_student',
        'as' => 'transaction_history_student',
    ]);

    Route::get('/wallet-topup', [
        'uses' => 'AccountController@top_up_wallet',
        'as' => 'top_up_wallet',
    ]);

    Route::post('/wallet-topup/save-details', [
        'uses' => 'AccountController@save_top_up_wallet',
        'as' => 'save_top_up_wallet',
    ]);

    Route::get('/get-wallet-top-up-details', [
        'uses' => 'AccountController@get_wallet_details',
        'as' => 'get_wallet_details',
    ]);

    Route::get('/Payment-successfully', [
        'uses' => 'AccountController@payment_successful',
        'as' => 'payment_successful',
    ]);

    Route::get('/Payment-failed', [
        'uses' => 'AccountController@payment_failed',
        'as' => 'payment_failed',
    ]);

    // Set Payment Deadline

    Route::post('/setpayment-deadlne', [
        'uses' => 'AccountController@payment_deadline',
        'as' => 'payment_deadline',
    ]);

    // Student Course Registeration

    Route::get('/student/course/registration/{prog}/{currentlevel}/{semester}/{academicyear}/{indexnumber}/{userid}', [
        'uses' => 'AccountController@register_course_student',
        'as' => 'register_course_student',
    ]);

    Route::get('/student/course-resgistered/{prog}/{currentlevel}/{semester}/{academicyear}/{userid}', [
        'uses' => 'AccountController@print_course_student',
        'as' => 'print_course_student',
    ]);

    Route::get('/student/resit/registration/{indexnumber}/{userid}', [
        'uses' => 'AccountController@register_resit_student',
        'as' => 'register_resit_student',
    ]);

    Route::post('/student/resit-registeration', [
        'uses' => 'AccountController@resit_student_save',
        'as' => 'resit_student_save',
    ]);
});

Route::group(['prefix' => 'OSMS/Chat',  'middleware' => 'auth'], function (): void {
    Route::get('/public-chat', [
        'uses' => 'ChatController@public_chat',
        'as' => 'public_chat',
    ]);

    Route::post('/public-chat/save', [
        'uses' => 'ChatController@public_chat_save',
        'as' => 'public_chat_save',
    ]);

    Route::get('/private-chat', [
        'uses' => 'ChatController@private_chat',
        'as' => 'private_chat',
    ]);

    Route::post('/fetch-message-prvate-chat', [
        'uses' => 'ChatController@private_chat_get_messages',
        'as' => 'private_chat_get_messages',
    ]);

    Route::post('/private-chat/save', [
        'uses' => 'ChatController@private_chat_save',
        'as' => 'private_chat_save',
    ]);
});

Route::group(['prefix' => 'OSMS/Communicate',  'middleware' => 'auth'], function (): void {
    Route::get('/send-mail', [
        'uses' => 'CommunicateController@send_mail',
        'as' => 'send_mail',
    ]);

    Route::post('/send-mail/send', [
        'uses' => 'CommunicateController@send_mail_now',
        'as' => 'send_mail_now',
    ]);

    Route::get('/send-sms', [
        'uses' => 'CommunicateController@send_sms',
        'as' => 'send_sms',
    ]);

    Route::post('/send-sms/send', [
        'uses' => 'CommunicateController@send_sms_now',
        'as' => 'send_sms_now',
    ]);
});

Route::group(['prefix' => 'Support-Tickets',  'middleware' => 'auth'], function (): void {
    Route::get('/all-tickets', [
        'uses' => 'SupportTicketController@all_tickets',
        'as' => 'all_tickets',
    ]);

    Route::get('/view-support-tickets/{id}', [
        'uses' => 'SupportTicketController@view_tickets',
        'as' => 'view_tickets',
    ]);

    Route::get('/create-new-ticket', [
        'uses' => 'SupportTicketController@create_ticket',
        'as' => 'create_ticket',
    ]);

    Route::post('/create-new-tickets/save', [
        'uses' => 'SupportTicketController@post_ticket',
        'as' => 'post_ticket',
    ]);

    Route::post('/post-basic-info', [
        'uses' => 'SupportTicketController@post_basicinfo',
        'as' => 'post_basicinfo',
    ]);

    Route::post('/reply-ticket', [
        'uses' => 'SupportTicketController@reply_ticket',
        'as' => 'reply_ticket',
    ]);

    Route::post('/post-ticket-file', [
        'uses' => 'SupportTicketController@post_ticket_file',
        'as' => 'post_ticket_file',
    ]);

    Route::post('/ticket-system-delete', [
        'uses' => 'SupportTicketController@delete_ticket',
        'as' => 'delete_ticket',
    ]);

    Route::post('/ticket-system-delete-file', [
        'uses' => 'SupportTicketController@delete_ticket_file',
        'as' => 'delete_ticket_file',
    ]);

    Route::post('/ticket-system-download', [
        'uses' => 'SupportTicketController@download_ticket_file',
        'as' => 'download_ticket_file',
    ]);

    Route::get('/ticket-system-download/{id}', [
        'uses' => 'SupportTicketController@dwn_ticket_file',
        'as' => 'dwn_ticket_file',
    ]);

    // Student Support Ticket

    Route::get('/create-new-ticket-student', [
        'uses' => 'SupportTicketController@create_ticket_student',
        'as' => 'create_ticket_student',
    ]);

    Route::get('/all-tickets-student', [
        'uses' => 'SupportTicketController@all_tickets_student',
        'as' => 'all_tickets_student',
    ]);

    Route::get('/view-support-tickets/student/{id}', [
        'uses' => 'SupportTicketController@view_tickets_student',
        'as' => 'view_tickets_student',
    ]);

    Route::post('/create-new-tickets-student/save', [
        'uses' => 'SupportTicketController@post_ticket_student',
        'as' => 'post_ticket_student',
    ]);

    Route::post('/reply-ticket-student', [
        'uses' => 'SupportTicketController@reply_ticket_student',
        'as' => 'reply_ticket_student',
    ]);

    Route::post('/post-ticket-file-student', [
        'uses' => 'SupportTicketController@post_ticket_file_student',
        'as' => 'post_ticket_file_student',
    ]);
});

Route::group(['prefix' => 'Results-Release',  'middleware' => 'auth'], function (): void {
    Route::get('/release-now', [
        'uses' => 'ResultsreleaseController@release_results',
        'as' => 'release_results',
    ]);

    Route::get('/releaseresult', [
        'uses' => 'ResultsreleaseController@release_now',
        'as' => 'release_now',
    ]);

    Route::get('/unreleaseresults', [
        'uses' => 'ResultsreleaseController@unrelease_now',
        'as' => 'unrelease_now',
    ]);

    Route::get('/cancel-student-results', [
        'uses' => 'ResultsreleaseController@cancel_results',
        'as' => 'cancel_results',
    ]);

    Route::get('/student-results/allstudents', [
        'uses' => 'ResultsreleaseController@allstudents_results',
        'as' => 'allstudents_results',
    ]);

    Route::get('/student/results/{id}', [
        'uses' => 'ResultsreleaseController@student_results_view',
        'as' => 'student_results_view',
    ]);

    Route::post('/student/cancel/request', [
        'uses' => 'ResultsreleaseController@student_cancel_results',
        'as' => 'student_cancel_results',
    ]);

    Route::post('/student/revert/results', [
        'uses' => 'ResultsreleaseController@student_revert_results',
        'as' => 'student_revert_results',
    ]);

    Route::post('/student/reenter/results', [
        'uses' => 'ResultsreleaseController@student_reenter_results',
        'as' => 'student_reenter_results',
    ]);

    Route::get('/student/cancel-results/session', [
        'uses' => 'ResultsreleaseController@student_cancel_results_session',
        'as' => 'student_cancel_results_session',
    ]);

    Route::post('/student/session/fetch/all-courses', [
        'uses' => 'ResultsreleaseController@student_session_all_courses',
        'as' => 'student_session_all_courses',
    ]);

    Route::post('/student/cancelresults', [
        'uses' => 'ResultsreleaseController@session_cancel_now',
        'as' => 'session_cancel_now',
    ]);
});

Route::group(['prefix' => 'HumanResource',  'middleware' => 'auth'], function (): void {
    Route::get('/addStaff', [
        'uses' => 'StaffController@addstaff',
        'as' => 'addstaff',
    ]);

    Route::post('/Staff-save', [
        'uses' => 'StaffController@savestaff',
        'as' => 'savestaff',
    ]);

    Route::post('/upload-doc', [
        'uses' => 'StaffController@uploaddoc',
        'as' => 'uploaddoc',
    ]);

    Route::get('/allStaff', [
        'uses' => 'StaffController@allStaff',
        'as' => 'allStaff',
    ]);

    Route::get('/Staffprofile', [
        'uses' => 'StaffController@Staffprofile',
        'as' => 'Staffprofile',
    ]);

    Route::get('/viewStaff/{id}', [
        'uses' => 'StaffController@viewStaff',
        'as' => 'viewStaff',
    ]);

    Route::get('/editStaff/{id}', [
        'uses' => 'StaffController@editStaff',
        'as' => 'editStaff',
    ]);

    Route::post('/update-staff-nfo', [
        'uses' => 'StaffController@update_staff_info',
        'as' => 'update_staff_info',
    ]);

    Route::post('/del-staff-upload-doc/{id}', [
        'uses' => 'StaffController@deletedoc',
        'as' => 'deletedoc',
    ]);

    Route::get('/Staff-attendance', [
        'uses' => 'StaffController@recordattendance',
        'as' => 'recordattendance',
    ]);

    Route::post('/Staff-attendance/fetch', [
        'uses' => 'StaffController@fetchstaff',
        'as' => 'fetchstaff',
    ]);

    Route::post('/Staff-attendance/save', [
        'uses' => 'StaffController@saveattendant',
        'as' => 'saveattendant',
    ]);

    Route::post('/staff-attendance/year-fetch', [
        'uses' => 'StaffController@yearfetch',
        'as' => 'yearfetch',
    ]);

    Route::get('/Staff-payroll', [
        'uses' => 'StaffController@add_payroll',
        'as' => 'add_payroll',
    ]);

    Route::post('/fetch-payroll', [
        'uses' => 'StaffController@payroll_fetch',
        'as' => 'payroll_fetch',
    ]);

    Route::get('/Staff-payroll/generate/{id}/{month}/{year}/{role}', [
        'uses' => 'StaffController@generate_payroll',
        'as' => 'generate_payroll',
    ]);

    Route::get('/Staff-payroll/earning', [
        'uses' => 'StaffController@genearn',
        'as' => 'genearn',
    ]);

    Route::get('/Staff-payroll/deduct', [
        'uses' => 'StaffController@gendeduct',
        'as' => 'gendeduct',
    ]);

    Route::post('/Staff-payroll/calculate', [
        'uses' => 'StaffController@calculate_payroll',
        'as' => 'calculate_payroll',
    ]);

    Route::get('/Staff-payroll/view-staff/{id}/payroll-info', [
        'uses' => 'StaffController@view_staff_payroll_now',
        'as' => 'view_staff_payroll_now',
    ]);

    Route::get('/Staff-leave', [
        'uses' => 'StaffController@staffleave',
        'as' => 'staffleave',
    ]);

    Route::get('/Staff-leave/requestleave', [
        'uses' => 'StaffController@requestleave',
        'as' => 'requestleave',
    ]);

    Route::post('/Staff-leave/save-requestleave', [
        'uses' => 'StaffController@save_requestleave',
        'as' => 'save_requestleave',
    ]);

    Route::post('/Staff-leave/update-requestleave', [
        'uses' => 'StaffController@update_requestleave',
        'as' => 'update_requestleave',
    ]);

    Route::post('/Staff-leave/leave-req-revert', [
        'uses' => 'StaffController@leave_req_revert',
        'as' => 'leave_req_revert',
    ]);

    Route::post('/Staff-payroll/fetch-payroll', [
        'uses' => 'StaffController@fetch_payroll_fetail',
        'as' => 'fetch_payroll_fetail',
    ]);

    Route::post('/Staff-payroll/save-payroll', [
        'uses' => 'StaffController@save_payroll_now',
        'as' => 'save_payroll_now',
    ]);

    Route::post('/Staff-payroll/view-payroll', [
        'uses' => 'StaffController@view_payroll_now',
        'as' => 'view_payroll_now',
    ]);

    Route::get('/Staff-directory/disable-staff', [
        'uses' => 'StaffController@disable_staff',
        'as' => 'disable_staff',
    ]);
});

Route::group(['prefix' => 'Empty',  'middleware' => 'auth'], function (): void {
});

Route::group(['prefix' => 'OSMS/Menu',  'middleware' => 'auth'], function (): void {
    Route::get('/add-menu', [
        'uses' => 'MenuController@add_menu',
        'as' => 'add-menu',
    ]);

    Route::post('/add-menu', [
        'uses' => 'MenuController@save_menu',
        'as' => 'save-menu',
    ]);

    Route::get('/edit-menu/{id}', [
        'uses' => 'MenuController@edit_menu',
        'as' => 'edit-menu',
    ]);

    Route::get('/rearrange-menu', [
        'uses' => 'MenuController@arrange_menu',
        'as' => 'arrange-menu',
    ]);

    Route::post('/rearrange-menu', [
        'uses' => 'MenuController@arrange_menu_save',
        'as' => 'arrange-menu-save',
    ]);

    Route::get('/rearrange-submenu/{id}', [
        'uses' => 'MenuController@arrange_submenu',
        'as' => 'arrange-submenu',
    ]);

    Route::post('/rearrange-submenu', [
        'uses' => 'MenuController@arrange_submenu_save',
        'as' => 'arrange-submenu-save',
    ]);

    Route::get('/delete-menu/{id}', [
        'uses' => 'MenuController@delete_menu',
        'as' => 'delete-menu',
    ]);

    //permissions

    Route::get('/add-permission', [
        'uses' => 'MenuController@add_permission',
        'as' => 'add-permission',
    ]);

    Route::post('/save-permission', [
        'uses' => 'MenuController@save_permission',
        'as' => 'save-permission',
    ]);

    Route::post('/save-permission-role', [
        'uses' => 'MenuController@save_permission_role',
        'as' => 'save-permission-role',
    ]);

    Route::get('/edit-permission/{id}', [
        'uses' => 'MenuController@edit_permission',
        'as' => 'edit-permission',
    ]);
});

//Accounts Controller

Route::post('/pay', [
    'uses' => 'PaymentController@redirectToGateway',
    'as' => 'pay',
]);
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');

Route::get('/paystack/all-transactions/student', [
    'uses' => 'PaymentController@getAlltransactions_student',
    'as' => 'paystack-all-transactions-student',
]);

Route::get('/paystack/transaction-details/{refid}', [
    'uses' => 'PaymentController@transaction_refid',
    'as' => 'transaction_refid',
]);

Route::get('/paystack/all-transactions', [
    'uses' => 'PaymentController@getAlltransactions',
    'as' => 'paystack-all-transactions',
]);

Route::get('/sitemap-view', [
    'uses' => 'WebController@sitemapview',
    'as' => 'sitemapview',
]);

Route::get('osmslogs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['prefix' => '',  'middleware' => 'auth'], function (): void {
    Route::get('/attendance', [
        'uses' => 'LMS\LMSController@lec_attendance',
        'as' => 'lms-lec-attendance',
    ]);

    Route::get('/attendance-report/{level}/{code}/{programme}/{session}/{date}', [
        'uses' => 'LMS\LMSController@attendancereportget',
        'as' => 'attendance-report-get',
    ]);

    Route::get('/attendance-report-generate/{level}/{code}/{programme}/{session}/{date}', [
        'uses' => 'LMS\LMSController@attendancereportgenerate',
        'as' => 'attendance-report-generate',
    ]);

    Route::post('/student/attendance-fetch', [
        'uses' => 'LMS\LMSController@getstudentsattenca',
        'as' => 'attendance-fetch-student',
    ]);

    Route::post('/student/attendance-fetch/save', [
        'uses' => 'LMS\LMSController@getstudentsattenca_save',
        'as' => 'attendance-fetch-student-save',
    ]);

    Route::post('/fetch-student/attendance', [
        'uses' => 'LMS\LMSController@lec_attendance_fetch_student',
        'as' => 'lms-lec-attendance-fetch-student',
    ]);

    Route::post('/fetch-student/attendance/save', [
        'uses' => 'LMS\LMSController@lec_attendance_fetch_student_save',
        'as' => 'lms-lec-attendance-fetch-student-save',
    ]);

    Route::get('/attendancereport', [
        'uses' => 'LMS\LMSController@attendancereport',
        'as' => 'attendancereport',
    ]);

    Route::post('/fetch-student/attendancereport', [
        'uses' => 'LMS\LMSController@attendancereport_fetch',
        'as' => 'attendance-fetch-fetch',
    ]);
});
