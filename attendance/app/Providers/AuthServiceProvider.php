<?php

namespace App\Providers;

use HeyMan;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //how to use the gates forcade
        Gate::define('delete-booking', function ($user) {
            return $user->isAdmin;
        });

        $this->authorizeAdminRoutes();
    }

    private function authenticateRoutes(): void
    {
    }

    private function validateRequests(): void
    {
    }

    private function authorizeAdminRoutes(): void
    {
        Gate::define('isAdmin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('islecturer', function ($user) {
            return $user->islecturer();
        });

        Gate::define('isHr', function ($user) {
            return $user->isHr();
        });

        Gate::define('isStudent', function ($user) {
            return $user->isStudent();
        });

        Gate::define('isAdmissioncommittee', function ($user) {
            return $user->isAdmissioncommittee();
        });

        Gate::define('isNationalservice', function ($user) {
            return $user->isNationalservice();
        });

        Gate::define('isAccounts', function ($user) {
            return $user->isAccounts();
        });

        Gate::define('isNabco', function ($user) {
            return $user->isNabco();
        });

        Gate::define('isFront_desk_help', function ($user) {
            return $user->isFront_desk_help();
        });

        Gate::define('isItHrAccountsAdmission', function ($user) {
            return $user->isItHrAccountsAdmission();
        });

        Gate::define('isAccountLecturer', function ($user) {
            return $user->isAccountLecturer();
        });

        HeyMan::whenYouHitRouteName([
            'admissions-home', 'admissions-all', 'admissions-update-programme',
            'admissions-approve-admission', 'admissions-all-view', 'admissions-home-level-100',
            'admissions-all-level1', 'admissions-home-level-100-app', 'admissions-all-level1-app', 'admissions-home-level-200', 'admissions-all-level2', 'admissions-home-level-200-app', 'admissions-all-level2-app', 'admissions-home-level-300', 'admissions-all-level3', 'admissions-home-level-300-app', 'admissions-all-level3-app', 'admissions-confirm', 'admissions-all-confirm', 'admissions-all-confirm-now', 'admissions-confirm-letter', 'admissions-confirm-all', 'admissions-confirm-all-data', 'admissions-unconfirm-all', 'admissions-unconfirm-all-data', 'add-students', 'add-students-save', 'add-academic-year', 'academic-year-update-status', 'academic-year-edit', 'academic-year-update-year', 'release_results', 'release_now', 'unrelease_now', 'cancel_results', 'allstudents_results', 'student_results_view', 'student_cancel_results', 'student_revert_results', 'student_reenter_results', 'student_cancel_results_session', 'student_session_all_courses', 'session_cancel_now',
        ])->thisGateShouldAllow('isAdmissioncommittee')->otherwise()->abort(403, 'You do not have permission to perform this action.');

        HeyMan::whenYouHitRouteName(['add-user-role', 'user-role-save',
            'user-permission-save', 'edit-role-perm', 'edit-role-update', 'edit-perm-update', 'assingn-role-to-permission', 'assingn-role-to-permission-save', 'edit-role-assign-to-permission', 'users-roles-display',
        ])->thisGateShouldAllow('isAdmin')->otherwise()->abort(403, 'You do not have permission to perform this action.');

        HeyMan::whenYouHitRouteName(['lecturer-student-fullname', 'lecturer-student-assignment', 'lecturer-student-assignment-post', 'lecturer-student-assignment-view', 'lecturer-student-assignment-edit', 'lecturer-student-assignment-update', 'lecturer-student-assignment-delete'])->thisGateShouldAllow('islecturer')->otherwise()->abort(403, 'You do not have permission to perform this action.');

        HeyMan::whenYouHitRouteName([
            'add-mandatory-fees', 'save-mandatory-fees', 'edit-mandatory-fees', 'delete-mandatory-fees', 'add_other_services', 'save_other_services', 'edit_other_services', 'delete_other_services', 'add_fees_master', 'view_fees_level100', 'view_fees_level200', 'view_fees_level300', 'view_fees_level400', 'save_fees_master_man', 'save_fees_master_otherservice', 'delete_fees_master', 'edit_fees_master', 'update_fees_master', 'dispatch_fees', 'dispatch_fees_now', 'payment_deadline', 'all_transactions', 'search_student', 'register_course_student', 'print_course_student', 'register_resit_student', 'resit_student_save',
        ])->thisGateShouldAllow('isAccounts')->otherwise()->abort(403, 'You do not have permission to perform this action.');

        HeyMan::whenYouHitRouteName(['logout-user-force', 'logout-user-force-update', 'logout-user-force-enable'])
            ->thisGateShouldAllow('isItHrAccountsAdmission')->otherwise()->abort(403, 'You do not have permission to perform this action.');

        HeyMan::whenYouHitRouteName([''])
            ->thisGateShouldAllow('isHr')->otherwise()->abort(403, 'You do not have permission to perform this action.');

        HeyMan::whenYouHitRouteName(['lecturer-student-results', 'lecturer-student-fullname', 'lecturer-student-results-save'])
            ->thisGateShouldAllow('isAccountLecturer')->otherwise()->abort(403, 'You do not have permission to perform this action.');

        HeyMan::whenYouHitRouteName(['all-students'])
            ->thisGateShouldAllow('islecturer', 'isAdmin')->otherwise()->abort(403, 'You do not have permission to perform this action.');
    }

    private function authorizeEloquentModels(): void
    {
    }
}
