<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\FreelancerDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HourlyController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SocialAuthController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [HomeController::class, 'allCategories'])->name('categories');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::post('/contactStore', [HomeController::class, 'store'])->name('contact.store');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us');
Route::get('/how-it-works', [HomeController::class, 'howWorks'])->name('how-it-works');
Route::get('/help-support', [HomeController::class, 'helpSupport'])->name('help-support');

Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/privacy-policy', function () {
    return view('frontend.privacy-policy');
})->name('privacy-policy');
Route::get('/terms-conditions', function () {
    return view('frontend.terms-conditions');
})->name('terms-conditions');

Route::post('username-check', [RegisterController::class, 'usernameCheck']);
Route::match(['get', 'post'], '/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [RegisterController::class, 'accountLogin'])->name('login');
Route::post('/login', [RegisterController::class, 'checkLogin']);
Route::get('/verify-account/{username}/{token}', [RegisterController::class, 'VerifyAccount'])->name('verify');
// Socail Login
Route::get('login/facebook', [SocialAuthController::class, 'redirectToFacebookProvider']);
Route::get('facebook/callback', [SocialAuthController::class, 'FacebookProviderCallback']);
Route::post('facebook/register', [SocialAuthController::class, 'facebookRegister']);
Route::get('login/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('google/callback', [SocialAuthController::class, 'GoogleProviderCallback']);
Route::post('google/register', [SocialAuthController::class, 'googleRegister']);

Route::get('/logout', [RegisterController::class, 'logout'])->name('logout');
// Forgot Password routes
Route::get('/forgot-password', [RegisterController::class, 'forgotPasswordRoute'])->name('forgot-password');
Route::post('/password/email', [RegisterController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{email}/{token}', [RegisterController::class, 'showPasswordResetForm']);
Route::post('/reset-password', [RegisterController::class, 'resetPassword']);

// Profile
Route::middleware(['auth'])->group(function (): void {
    Route::resource('profile', ProfileController::class);
    Route::match(['get', 'post'], '/edit-profile', [ProfileController::class, 'edit_profile']);
    // Skills
    Route::post('/add_skill', [ProfileController::class, 'add_skill']);
    Route::delete('/delete-skill/{id}', [ProfileController::class, 'deleteSkill']);
    // Langauge
    Route::post('/add_language', [ProfileController::class, 'addLanguage']);
    Route::delete('/delete-language/{id}', [ProfileController::class, 'deleteLanguage']);
    // Experience
    Route::post('/add-experience', [ProfileController::class, 'addExperience']);
    Route::delete('/delete-experience/{id}', [ProfileController::class, 'deleteExperience']);
    Route::post('/edit-experience', [ProfileController::class, 'editExperience']);
    // Education
    Route::post('/add-education', [ProfileController::class, 'addEducation']);
    Route::delete('/delete-education/{id}', [ProfileController::class, 'deleteEducation']);
    Route::post('/edit-education', [ProfileController::class, 'editEducation']);
    // Project / portfolio
    Route::post('/add-project', [ProfileController::class, 'addProject']);
    Route::delete('/delete-project/{id}', [ProfileController::class, 'deleteProject']);
    Route::post('/edit-project', [ProfileController::class, 'editProject']);
    // Certifications
    Route::post('/add-certificate', [ProfileController::class, 'addCertificate']);
    Route::delete('/delete-certificate/{id}', [ProfileController::class, 'deleteCertificate']);
    Route::post('/edit-certificate', [ProfileController::class, 'editCertificate']);

    Route::post('/crop_upload', [ProfileController::class, 'storeImage']);
    Route::post('/crop_upload_cover', [ProfileController::class, 'storeCoverImage']);
    Route::post('/verification-request', [ProfileController::class, 'verification'])->name('verification-request');
    // Read Notification
    Route::post('/readNotification/{id}', [NotificationController::class, 'readNotification']);
    Route::get('/notificationCount/{id}', [NotificationController::class, 'notificationCount']);

    Route::get('/account-setting', function () {
        return view('frontend.account-setting');
    })->name('account-setting');
    // Jobs
    Route::resource('job', JobsController::class);
    Route::post('update-job', [JobsController::class, 'updateJob'])->name('job.updateJob');

    Route::get('job-detail/{id}', [JobsController::class, 'show'])->name('job.show');
    Route::get('manage-jobs', [JobsController::class, 'manageJobs'])->name('job.manage-jobs');

    Route::get('completed-jobs', [JobsController::class, 'completedJobs'])->name('job.completed-jobs');
    Route::get('cancelled-jobs', [JobsController::class, 'cancelledJobs'])->name('job.cancelled-jobs');
    Route::get('ongoing-jobs', [JobsController::class, 'onGoingJobs'])->name('job.ongoing-jobs');

    Route::get('ongoing-job/{id}', [JobsController::class, 'onGoingJobsDetail'])->name('job.ongoing-job');
    Route::post('/weeklyhours-store', [JobsController::class, 'storeWeeklyHours'])->name('weeklyhours.store');

    Route::get('dashboards', [FreelancerDashboardController::class, 'index'])->name('freelancer-dashboard');
    Route::get('dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::post('save-freelancer', [FreelancerController::class, 'saveFreelancer']);
    Route::post('save-job', [FreelancerController::class, 'saveJob']);

    Route::get('saved-items', [FreelancerController::class, 'savedItems'])->name('freelancers.saved-items');

    // Proposal
    Route::resource('proposal', ProposalController::class);
    Route::get('/job-proposal/{id}', [ProposalController::class, 'jobProposal']);
    Route::get('/proposals', [ProposalController::class, 'allProposalClient'])->name('proposals');
    Route::post('/hire-freelancer', [ProposalController::class, 'hireFreelancer'])->name('hire-freelancer');
    Route::post('/reject-freelancer', [ProposalController::class, 'rejectFreelancer'])->name('reject-freelancer');

    Route::post('/update-project-status', [ProposalController::class, 'projectStatus'])->name('update-project-status');

    // Chat Controller
    Route::get('messages', [ChatController::class, 'index'])->name('messages');
    Route::get('friendsList/{id}', [ChatController::class, 'friendsList']);
    Route::post('add-friend', [ChatController::class, 'addFriend'])->name('add-friend');
    Route::post('singleChat', [ChatController::class, 'singleChat']);
    Route::post('send-message', [ChatController::class, 'send']);
    Route::post('seenMessage', [ChatController::class, 'seenMessage']);
    Route::get('messsageCount/{id}', [ChatController::class, 'messsageCount']);

    Route::resource('transactions', PaymentController::class);
    Route::post('pay-now', [PaymentController::class, 'payNow']);
    Route::post('transaction-agree', [PaymentController::class, 'agreeTransaction']);
    Route::get('transaction-link/{id}', [PaymentController::class, 'linkTransaction']);

    // Route::post('deliver-order',[PaymentController::class,'shipProduct']);

    // Route::post('receive-order',[PaymentController::class,'receiveProduct']);

    Route::get('rating/{job_id}', [RatingController::class, 'show'])->name('job.feedback');
    Route::post('add-rating', [RatingController::class, 'store'])->name('add-rating');

    // Paypal
    Route::get('/paypal-demo', function () {
        return view('frontend.paypal-demo');
    })->name('paypal-demo');
    Route::get('/payment/deposit', function () {
        return view('frontend.payments.deposit');
    })->name('payments.deposit');

    Route::get('payment', [PayPalController::class, 'payment'])->name('payment');
    Route::get('cancel', [PayPalController::class, 'cancel'])->name('payment.cancel');
    Route::get('payment/success', [PayPalController::class, 'success'])->name('payment.success');

    Route::get('paymentFixed', [PayPalController::class, 'paymentFixed'])->name('paymentFixed');
    Route::get('cancelFixed', [PayPalController::class, 'cancelFixed'])->name('payment.cancelFixed');
    Route::get('payment/successFixed', [PayPalController::class, 'successFixed'])->name('payment.successFixed');

    // Paypal Payouts
    Route::get('withdraw', function () {
        return view('frontend.payout.index');
    })->name('withdraw');
    Route::get('payout', [PayoutController::class, 'payout'])->name('payout');

    // Milestone deposit OR Reject
    Route::post('/milestone/depositOrReject/{id}', [MilestoneController::class, 'depositOrReject'])->name('milestone.depositOrReject');
    // Milestone Release OR Refund OR Dispute
    Route::post('/milestone/rrd/{id}', [MilestoneController::class, 'ReleaseRefundDispute'])->name('milestone.rrd');
    Route::post('/milestone/destory/{id}', [MilestoneController::class, 'destory'])->name('milestone.destory');
    Route::post('/milestone/deposit', [MilestoneController::class, 'deposit'])->name('milestone.deposit');

    // Hourly deposit OR Reject
    Route::post('/hourly/depositOrReject/{id}', [HourlyController::class, 'depositOrReject'])->name('hourly.depositOrReject');
    // Hourly Release OR Refund OR Dispute
    Route::post('/hourly/rrd/{id}', [HourlyController::class, 'ReleaseRefundDispute'])->name('hourly.rrd');
    Route::post('/hourly/destory/{id}', [HourlyController::class, 'destory'])->name('hourly.destory');
    Route::post('/hourly/deposit', [HourlyController::class, 'deposit'])->name('hourly.deposit');
});

Route::resource('freelancers', FreelancerController::class);
Route::get('freelancer/{username}', [FreelancerController::class, 'show'])->name('freelancers.show');
Route::get('client/{username}', [FreelancerController::class, 'client'])->name('user.client');

Route::get('get-freelancers', [FreelancerController::class, 'getFreelancers']);
Route::get('get-freelancers-lang', [FreelancerController::class, 'getFreelancersLang']);
// Report User
Route::post('report-user', [FreelancerController::class, 'reportUser']);
Route::get('jobs/{category}', [JobsController::class, 'categoryJobs'])->name('job.category');
// Filter and Sorting
Route::get('sort-jobs', [JobsController::class, 'getJobs']);
Route::get('cat-search', [JobsController::class, 'catSearch']);
Route::get('loc-search', [JobsController::class, 'locationSearch']);
Route::get('lang-search', [FreelancerController::class, 'languageSearch']);

Route::name('admin.')->namespace('Admin')->prefix('admin')->group(function (): void {
    Route::namespace('Auth')->middleware('guest:admin')->group(function (): void {
        Route::match(['get', 'post'], '/login', [AdminController::class, 'adminLogin'])->name('login');
    });
    Route::namespace('Auth')->middleware('auth:admin')->group(function (): void {

      // Route::get('/', function(){
        //   return view('admin.index');
        // });
        Route::get('/', [AdminController::class, 'main']);

        Route::resource('users', '\App\Http\Controllers\Admin\AdminController');
        Route::get('/freelancers-list', [AdminController::class, 'index'])->name('freelancers-list');
        Route::get('/clients-list', [AdminController::class, 'clientsList'])->name('clients-list');
        Route::get('/verification-list', [AdminController::class, 'verificationList'])->name('verification-list');
        Route::post('/verify/{id}', [AdminController::class, 'verify']);
        Route::post('/reject-verify/{id}', [AdminController::class, 'rejectVerify']);
        Route::get('/blocked-users/', [AdminController::class, 'blockedUsers'])->name('blocked-users');
        Route::post('/unblock-users/{id}', [AdminController::class, 'unblockUsers'])->name('unblock-users');
        Route::resource('projects', '\App\Http\Controllers\Admin\ProjectController');
        Route::resource('categories', '\App\Http\Controllers\Admin\CategoriesController');
        Route::resource('skills', '\App\Http\Controllers\Admin\SkillController');
        Route::resource('supports', '\App\Http\Controllers\Admin\SupportController');
        Route::resource('languages', '\App\Http\Controllers\Admin\LanguageController');
        Route::resource('reports', '\App\Http\Controllers\Admin\ReportController');
        Route::post('block-user/{id}', [ReportController::class, 'blockUser']);

        Route::post('/logout', function () {
            Auth::guard('admin')->logout();

            return redirect()->action([
                AdminController::class,
                'adminLogin',
            ]);
        })->name('logout');
    });
});
