<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/OSMS/LMS/login', [
        'uses' => 'LMS\LMSController@login',
        'as' => 'lms-home',
]);

Route::post('/OSMS/LMS/login-check', [
    'uses' => 'LMS\LMSController@login_check',
    'as' => 'lms-login-check',
]);

Route::group(['prefix'=> 'OSMS/LMS/LMSLECTURER/', 'middleware' => 'auth'], function () {
    Route::get('/{code}/overview', [
        'uses' => 'LMS\LMSController@lec_overview',
        'as' => 'lms-lec-overview',
    ]);

    Route::post('/overview/save', [
        'uses' => 'LMS\LMSController@lec_overview_save',
        'as' => 'lms-lec-overview-save',
    ]);

    Route::get('/{code}/syllabus', [
        'uses' => 'LMS\LMSController@lec_syllabus',
        'as' => 'lms-lec-syllabus',
    ]);

    Route::get('/{code}/callendar', [
        'uses' => 'LMS\LMSController@lec_callendar',
        'as' => 'lms-lec-callendar',
    ]);

    Route::get('/{code}/callendar/edit-event/{id}', [
        'uses' => 'LMS\LMSController@lec_callendar_edit',
        'as' => 'lms-lec-callendar-edit',
    ]);

    Route::get('/{code}/callendar/fetch-events', [
        'uses' => 'LMS\LMSController@lec_callendar_get',
        'as' => 'lms-lec-callendar-get',
    ]);

    Route::post('/create-event/save', [
        'uses' => 'AcademicCalandarController@create_event_save',
        'as' => 'lms-lec-event-save',
    ]);

    Route::post('/callendar/save', [
        'uses' => 'LMS\LMSController@lec_callendar_save',
        'as' => 'lms-lec-callendar-save',
    ]);

    Route::get('/{code}/callendar/fetch-events-all', [
        'uses' => 'LMS\LMSController@lec_callendar_get_all',
        'as' => 'lms-lec-callendar-get-all',
    ]);

    Route::get('/{code}/announcements', [
        'uses' => 'LMS\LMSController@lec_announcements',
        'as' => 'lms-lec-announcements',
    ]);

    Route::post('/announcements/save', [
        'uses' => 'LMS\LMSController@lec_announcements_save',
        'as' => 'lms-lec-announcements-save',
    ]);

    Route::get('/{code}/announcements/edit/{id}', [
        'uses' => 'LMS\LMSController@lec_edit_announcement',
        'as' => 'lms-lec-edit-announcement',
    ]);

    Route::get('/delete/announcements/{id}', [
        'uses' => 'LMS\LMSController@lec_del_announcement',
        'as' => 'lms-lec-del-announcement',
    ]);

    Route::get('/{code}/test-quiz', [
        'uses' => 'LMS\LMSController@lec_test_quiz',
        'as' => 'lms-lec-test-quiz',
    ]);

    Route::get('/delete/test-quiz/{id}', [
        'uses' => 'LMS\LMSController@lec_del_test_quiz',
        'as' => 'lms-lec-del-test-quiz',
    ]);

    Route::get('/{code}/test-quiz/addquestion/{id}', [
        'uses' => 'LMS\LMSController@lec_addquestion_test_quiz',
        'as' => 'lms-lec-addquestion-test-quiz',
    ]);

    Route::get('/{code}/test-quiz/edit/{id}', [
        'uses' => 'LMS\LMSController@lec_edit_test_quiz',
        'as' => 'lms-lec-edit-test-quiz',
    ]);

    Route::get('/{code}/test-quiz/view-quiz-question/{id}', [
        'uses' => 'LMS\LMSController@lec_quisquestion_test_quiz',
        'as' => 'lms-lec-quisquestion-test-quiz',
    ]);

    Route::get('/{code}/test-quiz/addQuestion/more/{quanty}/{examid}', [
        'uses' => 'LMS\LMSController@more_questions',
        'as' => 'lms-lec-more-questions-test-quiz',
    ]);

    Route::get('/{code}/test-quiz/questions/edit/{id}', [
        'uses' => 'LMS\LMSController@lect_question_edit',
        'as' => 'lms-lec-question-edit',
    ]);

    Route::get('/{code}/test-quiz/student/examinations/viewscore/{id}', [
        'uses' => 'LMS\LMSController@view_exams_score',
        'as' => 'lms-lec-exmas-score',
    ]);

    Route::post('/test-quiz/save', [
        'uses' => 'LMS\LMSController@lec_test_quiz_save',
        'as' => 'lms-lec-test-quiz-save',
    ]);

    Route::get('/{code}/gradebook', [
        'uses' => 'LMS\LMSController@lec_gradebook',
        'as' => 'lms-lec-gradebook',
    ]);

    Route::post('/gradebook/save', [
        'uses' => 'LMS\LMSController@lec_gradebook_save',
        'as' => 'lms-lec-gradebook-save',
    ]);

    Route::get('/{code}/meetings', [
        'uses' => 'LMS\LMSController@lec_meetings',
        'as' => 'lms-lec-meetings',
    ]);

    Route::post('/meetings/save', [
        'uses' => 'LMS\LMSController@lec_meetings_save',
        'as' => 'lms-lec-meetings-save',
    ]);

    Route::get('/{code}/messages', [
        'uses' => 'LMS\LMSController@lec_messages',
        'as' => 'lms-lec-messages',
    ]);

    Route::post('/messages/save', [
        'uses' => 'LMS\LMSController@lec_messages_save',
        'as' => 'lms-lec-messages-save',
    ]);

    Route::get('/{code}/polls', [
        'uses' => 'LMS\LMSController@lec_polls',
        'as' => 'lms-lec-polls',
    ]);

    Route::post('/polls/save', [
        'uses' => 'LMS\LMSController@lec_polls_save',
        'as' => 'lms-lec-polls-save',
    ]);

    Route::get('/{code}/chatroom', [
        'uses' => 'LMS\LMSController@lec_chatroom',
        'as' => 'lms-lec-chatroom',
    ]);

    Route::post('/chatroom/save', [
        'uses' => 'LMS\LMSController@lec_chatroom_save',
        'as' => 'lms-lec-chatroom-save',
    ]);

    Route::get('/{code}/email', [
        'uses' => 'LMS\LMSController@lec_email',
        'as' => 'lms-lec-email',
    ]);

    Route::post('/email/save', [
        'uses' => 'LMS\LMSController@lec_email_save',
        'as' => 'lms-lec-email-send',
    ]);

    Route::get('/{code}/lesson-plan', [
        'uses' => 'LMS\LMSController@lec_lesson_plan',
        'as' => 'lms-lec-lesson-plan',
    ]);

    Route::get('/{code}/lesson-plan/{id}', [
        'uses' => 'LMS\LMSController@lec_lesson_plan_edit',
        'as' => 'lms-lec-lesson-plan-edit',
    ]);

    Route::get('/lesson-plan/delete/{id}', [
        'uses' => 'LMS\LMSController@lec_lesson_plan_delete',
        'as' => 'lms-lec-lesson-plan-delete',
    ]);

    Route::post('/lesson-plan/save', [
        'uses' => 'LMS\LMSController@lec_lesson_plan_save',
        'as' => 'lms-lec-lesson-plan-save',
    ]);

    Route::get('/{code}/lesson-docs', [
        'uses' => 'LMS\LMSController@lec_lesson_docs',
        'as' => 'lms-lec-lesson-docs',
    ]);

    Route::post('/lesson-docs/save', [
        'uses' => 'LMS\LMSController@lec_lesson_docs_save',
        'as' => 'lms-lec-lesson-docs-save',
    ]);

    Route::post('/lesson-docs/delete/{id}', [
        'uses' => 'LMS\LMSController@lec_lesson_docs_delete',
        'as' => 'lms-lec-lesson-docs-delete',
    ]);

    Route::get('/{code}/online-videos', [
        'uses' => 'LMS\LMSController@lec_online_videos',
        'as' => 'lms-lec-online-videos',
    ]);

    Route::get('/{code}/online-videos/edit/{id}', [
        'uses' => 'LMS\LMSController@lec_online_videos_edit',
        'as' => 'lms-lec-online-video-edit',
    ]);

    Route::post('/online-videos/save', [
        'uses' => 'LMS\LMSController@lec_online_video_save',
        'as' => 'lms-lec-online-video-save',
    ]);

    Route::post('/online-videos/delete/{id}', [
        'uses' => 'LMS\LMSController@lec_online_video_delete',
        'as' => 'lms-lec-online-video-delete',
    ]);

    Route::get('/{code}/online-assignments', [
        'uses' => 'LMS\LMSController@lec_online_assignments',
        'as' => 'lms-lec-online-assignments',
    ]);

    Route::get('/{code}/online-assignments/edit/{id}', [
        'uses' => 'LMS\LMSController@lec_online_assignment_edit',
        'as' => 'lms-lec-online-assignment_edit',
    ]);

    Route::get('/{code}/online-assignments/submitted/{id}', [
        'uses' => 'LMS\LMSController@lec_online_assignment_submitted',
        'as' => 'lms-lec-online-assignment-submitted',
    ]);

    Route::get('/{code}/public-chat/', [
        'uses' => 'LMS\LMSController@lec_public_chat',
        'as' => 'lms-lec-public-chat',
    ]);

    Route::get('/{code}/private-chat/', [
        'uses' => 'LMS\LMSController@lec_private_chat',
        'as' => 'lms-lec-private-chat',
    ]);

    Route::get('/{code}/siteinfo', [
        'uses' => 'LMS\LMSController@lec_siteinfo',
        'as' => 'lms-lec-siteinfo',
    ]);

    Route::post('/siteinfo/save', [
        'uses' => 'LMS\LMSController@lec_siteinfo_save',
        'as' => 'lms-lec-siteinfo-save',
    ]);

    Route::get('/{code}/help', [
        'uses' => 'LMS\LMSController@lec_help',
        'as' => 'lms-lec-help',
    ]);
});

Route::group(['prefix'=> 'OSMS/LMS', 'middleware' => 'auth'], function () {
    Route::get('/home', [
        'uses' => 'LMS\LMSController@main',
        'as' => 'lms-main',
    ]);

    Route::get('/site', [
        'uses' => 'LMS\LMSController@lec_site',
        'as' => 'lms-site-view',
    ]);

    Route::get('/site-overview', [
        'uses' => 'LMS\LMSController@site_overview',
        'as' => 'lms-site-overview',
    ]);

    Route::post('/site-overview-enroll-course', [
        'uses' => 'LMS\LMSController@site_overview_enroll',
        'as' => 'lms-site-overview-enroll',
    ]);

    Route::get('/profile', [
        'uses' => 'LMS\LMSController@profile',
        'as' => 'lms-profile',
    ]);

    Route::get('/course-overview', [
        'uses' => 'LMS\LMSController@course_overview',
        'as' => 'lms-course-overview',
    ]);

    Route::get('/calendar', [
        'uses' => 'LMS\LMSController@calendar_student',
        'as' => 'lms-calendar-student',
    ]);

    Route::get('/calendar/getevents-all', [
        'uses' => 'LMS\LMSController@calendar_getevents',
        'as' => 'lms-calendar-getevents',
    ]);

    Route::get('/lesson-plan', [
        'uses' => 'LMS\LMSController@lesson_plan',
        'as' => 'lms-lesson-plan',
    ]);

    Route::get('/course-materials', [
        'uses' => 'LMS\LMSController@course_materials',
        'as' => 'lms-ourse-materials',
    ]);

    Route::get('/course-video', [
        'uses' => 'LMS\LMSController@course_video',
        'as' => 'lms-course-video',
    ]);

    Route::get('/Announcement', [
        'uses' => 'LMS\LMSController@Announcement',
        'as' => 'lms-Announcement',
    ]);

    Route::get('/Announcement-view', [
        'uses' => 'LMS\LMSController@announcement_view',
        'as' => 'lms-Announcement-view',
    ]);

    Route::get('/private-files', [
        'uses' => 'LMS\LMSController@private_file',
        'as' => 'lms-private-file',
    ]);

    Route::post('/private-files/delete/{id}', [
        'uses' => 'LMS\LMSController@private_file_delete',
        'as' => 'lms-private-file-delete',
    ]);

    Route::post('/private-files/save', [
        'uses' => 'LMS\LMSController@private_file_save',
        'as' => 'lms-private-file-save',
    ]);

    Route::get('/tests-quiz', [
        'uses' => 'LMS\LMSController@tests_quiz',
        'as' => 'lms-tests-quiz',
    ]);

    Route::get('/tests-quiz/start-exams/{id}', [
        'uses' => 'LMS\LMSController@tests_quiz_start',
        'as' => 'lms-tests-quiz-start',
    ]);

    Route::get('/tests-quiz/quiz/fetch/{studentname}/{examid}/{examtotal}/{mins}', [
        'uses' => 'LMS\LMSController@student_exams_start',
        'as' => 'lms-student-exams-start',
    ]);

    Route::get('/tests-quiz/examinations/viewscore/{id}', [
        'uses' => 'LMS\LMSController@retry_exam_results',
        'as' => 'lms-quiz-retry-score',
    ]);

    Route::get('/assignment', [
        'uses' => 'LMS\LMSController@assignment',
        'as' => 'lms-assignment',
    ]);

    Route::get('/assignment/assignment-view/{id}', [
        'uses' => 'LMS\LMSController@assignment_view',
        'as' => 'lms-assignment-view',
    ]);

    Route::get('/meeting-zoom', [
        'uses' => 'LMS\LMSController@zoom_meeting',
        'as' => 'lms-zoom-meeting',
    ]);

    Route::get('/chat-room-public', [
        'uses' => 'LMS\LMSController@chat_room_public',
        'as' => 'lms-chat-room-public',
    ]);

    Route::get('/chat-room-private', [
        'uses' => 'LMS\LMSController@chat_room_private',
        'as' => 'lms-chat-room-private',
    ]);

    Route::get('/calendar', [
        'uses' => 'LMS\LMSController@calendar',
        'as' => 'lms-calendar',
    ]);

    Route::post('/calendar/save', [
        'uses' => 'LMS\LMSController@calendar_save',
        'as' => 'lms-calendar-save',
    ]);

    Route::get('/calendar/getevents', [
        'uses' => 'LMS\LMSController@calendar_get',
        'as' => 'lms-calendar-get',
    ]);

    Route::get('/No-Information', [
        'uses' => 'LMS\LMSController@empty',
        'as' => 'lms-empty',
    ]);

    Route::get('/No-data-found', [
        'uses' => 'LMS\LMSController@nodata',
        'as' => 'lms-nodata',
    ]);

    Route::get('/my-courses', [
        'uses' => 'LMS\LMSController@my_courses',
        'as' => 'lms-my-courses',
    ]);

    Route::post('/my-courses/save', [
        'uses' => 'LMS\LMSController@my_courses_save',
        'as' => 'lms-my-courses-save',
    ]);

    Route::get('/attendance', [
        'uses' => 'LMS\LMSController@attendance',
        'as' => 'lms-attendance',
    ]);

    Route::post('/attendance/year-fetch', [
        'uses' => 'LMS\LMSController@attendance_year_fetch',
        'as' => 'lms-attendance-year-fetch',
    ]);
});
