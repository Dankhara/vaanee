<?php
// IGNORE
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Admin\StudioDashboardController;
use App\Http\Controllers\Admin\VoiceoverStudioResultController;
use App\Http\Controllers\Admin\TranscribeStudioResultController;
use App\Http\Controllers\Admin\VoiceCustomizationController;
use App\Http\Controllers\Admin\LanguageCustomizationController;
use App\Http\Controllers\Admin\SoundStudioSettingsController;
use App\Http\Controllers\Admin\VoiceoverStudioSettingsController;
use App\Http\Controllers\Admin\TranscribeStudioSettingsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\FinanceSubscriptionPlanController;
use App\Http\Controllers\Admin\FinancePrepaidPlanController;
use App\Http\Controllers\Admin\ReferralSystemController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\FinanceSettingController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\InstallController;
use App\Http\Controllers\Admin\UpdateController;
use App\Http\Controllers\Admin\Frontend\AppearanceController;
use App\Http\Controllers\Admin\Frontend\FrontendController;
use App\Http\Controllers\Admin\Frontend\BlogController;
use App\Http\Controllers\Admin\Frontend\CareerController;
use App\Http\Controllers\Admin\Frontend\PageController;
use App\Http\Controllers\Admin\Frontend\UseCaseController;
use App\Http\Controllers\Admin\Frontend\FAQController;
use App\Http\Controllers\Admin\Frontend\ReviewController;
use App\Http\Controllers\Admin\Settings\GlobalController;
use App\Http\Controllers\Admin\Settings\BackupController;
use App\Http\Controllers\Admin\Settings\OAuthController;
use App\Http\Controllers\Admin\Settings\ActivationController;
use App\Http\Controllers\Admin\Settings\SMTPController;
use App\Http\Controllers\Admin\Settings\RegistrationController;
use App\Http\Controllers\Admin\Settings\UpgradeController;
use App\Http\Controllers\Admin\VoiceClone\VoiceCloneScriptController;
use App\Http\Controllers\Admin\VoiceClone\VoiceCloningProfileController;
use App\Http\Controllers\Admin\VoiceClone\VoiceCloningResultsController;
use App\Http\Controllers\Admin\Webhooks\PaypalWebhookController;
use App\Http\Controllers\Admin\Webhooks\StripeWebhookController;
use App\Http\Controllers\Admin\Webhooks\PaystackWebhookController;
use App\Http\Controllers\Admin\Webhooks\RazorpayWebhookController;
use App\Http\Controllers\Admin\Webhooks\MollieWebhookController;
use App\Http\Controllers\Admin\Webhooks\CoinbaseWebhookController;
use App\Http\Controllers\CustomProjectsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserPasswordController;
use App\Http\Controllers\User\PurchaseHistoryController;
use App\Http\Controllers\User\PricingPlanController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ReferralController;
use App\Http\Controllers\User\UserSupportController;
use App\Http\Controllers\User\UserNotificationController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\STT\TranscribeStudioController;
use App\Http\Controllers\User\STT\TranscribeResultController;
use App\Http\Controllers\User\STT\TranscribeProjectController;
use App\Http\Controllers\User\TTS\VoiceoverStudioController;
use App\Http\Controllers\User\TTS\VoiceoverResultController;
use App\Http\Controllers\User\TTS\VoiceoverProjectController;
use App\Http\Controllers\User\TTS\SoundStudioController;
use App\Http\Controllers\User\TTS\VoiceController;
use App\Http\Controllers\User\UserVoiceProfileController;
use App\Http\Controllers\VoiceArtist\AllProjectsController;
use App\Http\Controllers\VoiceArtist\HelpsController;
use App\Http\Controllers\VoiceArtist\MyProjectsController;
use App\Http\Controllers\VoiceArtist\SettingsController;
use App\Http\Controllers\VoiceArtist\StudioController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now reate something great!
|
*/

// AUTH ROUTES
Route::middleware(['middleware' => 'PreventBackHistory'])->group(function () {
    require __DIR__ . '/auth.php';
});

// FRONTEND ROUTES
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'listen')->name('tts.voiceover');
    Route::get('/blog/{slug}', 'blogShow')->name('blogs.show');
    Route::post('/contact', 'contact')->name('contact');
    Route::get('/terms-and-conditions', 'termsAndConditions')->name('terms');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacy');
    Route::post('check-username-exists', 'check_username_exists')->name('check.username.exists');
    Route::get('/register-voice-artist', function () {
        return view('auth.register-voice-artist');
    });
});

// INSTAL ROUTES
Route::group(['prefix' => 'install', 'middleware' => 'install'], function () {
    Route::controller(InstallController::class)->group(function () {
        Route::get('/', 'index')->name('install');
        Route::get('/requirements', 'requirements')->name('install.requirements');
        Route::get('/permissions', 'permissions')->name('install.permissions');
        Route::get('/database', 'database')->name('install.database');
        Route::post('/database', 'storeDatabaseCredentials')->name('install.database.store');
        Route::get('/activation', 'activation')->name('install.activation');
        Route::post('/activation', 'activateApplication')->name('install.activation.activate');
    });
});

// PAYMENT GATEWAY WEBHOOKS ROUTES
Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handleStripe'])->name('stripe.webhook');
Route::post('/webhooks/paypal', [PaypalWebhookController::class, 'handlePaypal']);
Route::post('/webhooks/paystack', [PaystackWebhookController::class, 'handlePaystack']);
Route::post('/webhooks/razorpay', [RazorpayWebhookController::class, 'handleRazorpay']);
Route::post('/webhooks/mollie', [MollieWebhookController::class, 'handleMollie'])->name('mollie.webhook');
Route::post('/webhooks/coinbase', [CoinbaseWebhookController::class, 'handleCoinbase']);

// LOCALE ROUTES
Route::get('/locale/{lang}', [LocaleController::class, 'language'])->name('locale');

// UPDATE ROUTE
Route::get('/update/now', [UpdateController::class, 'updateDatabase']);


// ADMIN ROUTES
Route::group(['prefix' => 'admin', 'middleware' => ['verified', 'role:admin', 'PreventBackHistory', 'set_application_configurations']], function () {

    // ADMIN DASHBOARD ROUTES
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // ADMIN STUDIO DASHBOARD ROUTES
    Route::controller(StudioDashboardController::class)->group(function () {
        Route::get('/studio/dashboard', 'index')->name('admin.studio.dashboard');
    });

    // ADMIN VOICEOVER RESULT ROUTES
    Route::controller(VoiceoverStudioResultController::class)->group(function () {
        Route::get('/text-to-speech/results/list', 'listResults')->name('admin.voiceover.results');
        Route::get('/text-to-speech/result/{id}/show', 'show')->name('admin.voiceover.result.show');
        Route::post('/text-to-speech/results/result/delete', 'delete');
    });

    // ADMIN TRANSCRIBE RESULT ROUTES
    Route::controller(TranscribeStudioResultController::class)->group(function () {
        Route::get('/speech-to-text/results/list', 'listResults')->name('admin.transcribe.results');
        Route::get('/speech-to-text/result/{id}/show', 'show')->name('admin.transcribe.result.show');
        Route::post('/speech-to-text/results/delete', 'delete');
    });

    // ADMIN VOICEOVER VOICE CUSTOMIZATION ROUTES
    Route::controller(VoiceCustomizationController::class)->group(function () {
        Route::get('/text-to-speech/voices', 'voices')->name('admin.voiceover.voices');
        Route::get('/text-to-speech/clone/voices', 'cloneVoices')->name('admin.voiceover.clone.voices');


        Route::post('/text-to-speech/voices/avatar/upload', 'changeAvatar');
        Route::post('/text-to-speech/voice/update', 'voiceUpdate');
        Route::post('/text-to-speech/voices/voice/activate', 'voiceActivate');
        Route::post('/text-to-speech/voices/voice/deactivate', 'voiceDeactivate');
        Route::get('/text-to-speech/voices/activate/all', 'voicesActivateAll');
        Route::get('/text-to-speech/voices/deactivate/all', 'voicesDeactivateAll');
    });

    // ADMIN TRANSCRIBE LANGUAGE CUSTOMIZATION ROUTES
    Route::controller(LanguageCustomizationController::class)->group(function () {
        Route::get('/speech-to-text/languages', 'languages')->name('admin.transcribe.languages');
        Route::post('/speech-to-text/language/update', 'languageUpdate');
        Route::post('/speech-to-text/languages/language/activate', 'languageActivate');
        Route::post('/speech-to-text/languages/language/deactivate', 'languageDeactivate');
        Route::get('/speech-to-text/languages/activate/all', 'languagesActivateAll');
        Route::get('/speech-to-text/languages/deactivate/all', 'languagesDeactivateAll');
    });

    // ADMIN SOUND STUDIO SETTINGS ROUTES
    Route::controller(SoundStudioSettingsController::class)->group(function () {
        Route::get('/text-to-speech/sound-studio', 'index')->name('admin.sound.studio');
        Route::get('/text-to-speech/voice-cloning', 'voiceCloning')->name('admin.studio.voice-cloning');
        Route::post('/text-to-speech/voice-cloning', 'createVoiceCloning')->name('admin.studio.create-voice-cloning');


        Route::post('/text-to-speech/sound-studio', 'store')->name('admin.sound.studio.store');
        Route::get('/text-to-speech/sound-studio/{id}/show', 'show')->name('admin.sound.studio.show');
        Route::get('/text-to-speech/sound-studio/music', 'music')->name('admin.sound.studio.music');
        Route::post('/text-to-speech/sound-studio/music/public', 'public');
        Route::post('/text-to-speech/sound-studio/music/private', 'private');
        Route::post('/text-to-speech/sound-studio/music/upload', 'upload');
        Route::post('/text-to-speech/sound-studio/music/delete', 'deleteMusic');
        Route::post('/text-to-speech/sound-studio/music/result/delete', 'deleteResult');
    });

    // ADMIN VOICEOVER STUDIO SETTINGS ROUTES
    Route::controller(VoiceoverStudioSettingsController::class)->group(function () {
        Route::get('/text-to-speech/settings', 'index')->name('admin.voiceover.settings');
        Route::post('/text-to-speech/settings', 'store')->name('admin.voiceover.settings.store');
    });

    // ADMIN TRANSCRIBE STUDIO SETTINGS ROUTES
    Route::controller(TranscribeStudioSettingsController::class)->group(function () {
        Route::get('/speech-to-text/settings', 'index')->name('admin.transcribe.settings');
        Route::post('/speech-to-text/settings', 'store')->name('admin.transcribe.settings.store');
    });

    // ADMIN USER MANAGEMENT ROUTES
    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/accounts/dashboard', 'index')->name('admin.user.dashboard');
        Route::get('/accounts/activity', 'activity')->name('admin.user.activity');
        Route::get('/accounts/list', 'listUsers')->name('admin.user.list');
        Route::post('/accounts', 'store')->name('admin.user.store');
        Route::get('/accounts/create', 'create')->name('admin.user.create');
        Route::get('/accounts/{user}/show', 'show')->name('admin.user.show');
        Route::get('/accounts/{user}/edit', 'edit')->name('admin.user.edit');
        Route::get('/accounts/{user}/storage', 'storage')->name('admin.user.storage');
        Route::post('/accounts/{user}/increase', 'increase')->name('admin.user.increase');
        Route::put('/accounts/{user}/update', 'update')->name('admin.user.update');
        Route::put('/accounts/{user}', 'change')->name('admin.user.change');
        Route::post('/accounts/delete', 'delete');
    });

    // ADMIN FINANCE - DASHBOARD & TRANSACTIONS & SUBSCRIPTION LIST ROUTES
    Route::controller(FinanceController::class)->group(function () {
        Route::get('/finance/dashboard', 'index')->name('admin.finance.dashboard');
        Route::get('/finance/transactions', 'listTransactions')->name('admin.finance.transactions');
        Route::put('/finance/transaction/{id}/update', 'update')->name('admin.finance.transaction.update');
        Route::get('/finance/transaction/{id}/show', 'show')->name('admin.finance.transaction.show');
        Route::get('/finance/transaction/{id}/edit', 'edit')->name('admin.finance.transaction.edit');
        Route::post('/finance/transaction/delete', 'delete');
        Route::get('/finance/subscribers', 'listSubscriptions')->name('admin.finance.subscriptions');
    });

    // ADMIN FINANCE - CANCEL USER SUBSCRIPTION
    Route::post('/finance/subscriptions/cancel', [PaymentController::class, 'stopSubscription']);

    // ADMIN FINANCE - SUBSCRIPTION PLAN ROUTES
    Route::controller(FinanceSubscriptionPlanController::class)->group(function () {
        Route::get('/finance/subscription', 'index')->name('admin.finance.plans');
        Route::post('/finance/subscription', 'store')->name('admin.finance.plan.store');
        Route::get('/finance/subscription/create', 'create')->name('admin.finance.plan.create');
        Route::get('/finance/subscription/{id}/show', 'show')->name('admin.finance.plan.show');
        Route::get('/finance/subscription/{id}/edit', 'edit')->name('admin.finance.plan.edit');
        Route::put('/finance/subscription/{id}', 'update')->name('admin.finance.plan.update');
        Route::post('/finance/subscription/delete', 'delete');
    });

    // ADMIN FINANCE - PREPAID PLAN ROUTES
    Route::controller(FinancePrepaidPlanController::class)->group(function () {
        Route::get('/finance/prepaid', 'index')->name('admin.finance.prepaid');
        Route::post('/finance/prepaid', 'store')->name('admin.finance.prepaid.store');
        Route::get('/finance/prepaid/create', 'create')->name('admin.finance.prepaid.create');
        Route::get('/finance/prepaid/{id}/show', 'show')->name('admin.finance.prepaid.show');
        Route::get('/finance/prepaid/{id}/edit', 'edit')->name('admin.finance.prepaid.edit');
        Route::put('/finance/prepaid/{id}', 'update')->name('admin.finance.prepaid.update');
        Route::post('/finance/prepaid/delete', 'delete');
    });

    // ADMIN FINANCE - REFERRAL ROUTES
    Route::controller(ReferralSystemController::class)->group(function () {
        Route::get('/referral/settings', 'index')->name('admin.referral.settings');
        Route::post('/referral/settings', 'store')->name('admin.referral.settings.store');
        Route::get('/referral/{order_id}/show', 'paymentShow')->name('admin.referral.show');
        Route::get('/referral/payouts', 'payouts')->name('admin.referral.payouts');
        Route::get('/referral/payouts/{id}/show', 'payoutsShow')->name('admin.referral.payouts.show');
        Route::put('/referral/payouts/{id}/store', 'payoutsUpdate')->name('admin.referral.payouts.update');
        Route::get('/referral/payouts/{id}/cancel', 'payoutsCancel')->name('admin.referral.payouts.cancel');
        Route::delete('/referral/payouts/{id}/decline', 'payoutsDecline')->name('admin.referral.payouts.decline');
        Route::get('/referral/top', 'topReferrers')->name('admin.referral.top');
    });

    // ADMIN FINANCE - INVOICE SETTINGS
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/settings/invoice', 'index')->name('admin.settings.invoice');
        Route::post('/settings/invoice', 'store')->name('admin.settings.invoice.store');
    });

    // ADMIN FINANCE SETTINGS ROUTES
    Route::controller(FinanceSettingController::class)->group(function () {
        Route::get('/finance/settings', 'index')->name('admin.finance.settings');
        Route::post('/finance/settings', 'store')->name('admin.finance.settings.store');
    });

    // ADMIN SUPPORT ROUTES
    Route::controller(SupportController::class)->group(function () {
        Route::get('/support', 'index')->name('admin.support');
        Route::put('/support/{ticked_id}', 'update')->name('admin.support.update');
        Route::get('/support/{ticket_id}/show', 'show')->name('admin.support.show');
        Route::post('/support/delete', 'delete');
    });

    // ADMIN NOTIFICATION ROUTES
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('admin.notifications');
        Route::get('/notifications/sytem', 'system')->name('admin.notifications.system');
        Route::get('/notifications/create', 'create')->name('admin.notifications.create');
        Route::post('/notifications', 'store')->name('admin.notifications.store');
        Route::get('/notifications/{id}/show', 'show')->name('admin.notifications.show');
        Route::get('/notifications/system/{id}/show', 'systemShow')->name('admin.notifications.systemShow');
        Route::get('/notifications/mark-all', 'markAllRead')->name('admin.notifications.markAllRead');
        Route::get('/notifications/delete-all', 'deleteAll')->name('admin.notifications.deleteAll');
        Route::post('/notifications/delete', 'delete');
    });

    // ADMIN GENERAL SETTINGS - GLOBAL SETTINGS
    Route::controller(GlobalController::class)->group(function () {
        Route::get('/settings/global', 'index')->name('admin.settings.global');
        Route::post('/settings/global', 'store')->name('admin.settings.global.store');
    });

    // ADMIN GENERAL SETTINGS - DATABASE BACKUP
    Route::controller(BackupController::class)->group(function () {
        Route::get('/settings/backup', 'index')->name('admin.settings.backup');
        Route::get('/settings/backup/create', 'create')->name('admin.settings.backup.create');
        Route::get('/settings/backup/{file_name}', 'download')->name('admin.settings.backup.download');
        Route::get('/settings/backup/{file_name}/delete', 'destroy')->name('admin.settings.backup.delete');
    });

    // ADMIN GENERAL SETTINGS - SMTP SETTINGS
    Route::controller(SMTPController::class)->group(function () {
        Route::post('/settings/smtp/test', 'test')->name('admin.settings.smtp.test');
        Route::get('/settings/smtp', 'index')->name('admin.settings.smtp');
        Route::post('/settings/smtp', 'store')->name('admin.settings.smtp.store');
    });

    // ADMIN GENERAL SETTINGS - REGISTRATION SETTINGS
    Route::controller(RegistrationController::class)->group(function () {
        Route::get('/settings/registration', 'index')->name('admin.settings.registration');
        Route::post('/settings/registration', 'store')->name('admin.settings.registration.store');
    });

    // ADMIN GENERAL SETTINGS - OAUTH SETTINGS
    Route::controller(OAuthController::class)->group(function () {
        Route::get('/settings/oauth', 'index')->name('admin.settings.oauth');
        Route::post('/settings/oauth', 'store')->name('admin.settings.oauth.store');
    });

    // ADMIN GENERAL SETTINGS - ACTIVATION SETTINGS
    Route::controller(ActivationController::class)->group(function () {
        Route::get('/settings/activation', 'index')->name('admin.settings.activation');
        Route::post('/settings/activation', 'store')->name('admin.settings.activation.store');
        Route::get('/settings/activation/remove', 'remove')->name('admin.settings.activation.remove');
        Route::delete('/settings/activation/destroy', 'destroy')->name('admin.settings.activation.destroy');
        Route::get('/settings/activation/manual', 'showManualActivation')->name('admin.settings.activation.manual');
        Route::post('/settings/activation/manual', 'storeManualActivation')->name('admin.settings.activation.manual.store');
    });

    // ADMIN FRONTEND SETTINGS - APPEARANCE SETTINGS
    Route::controller(AppearanceController::class)->group(function () {
        Route::get('/settings/appearance', 'index')->name('admin.settings.appearance');
        Route::post('/settings/appearance', 'store')->name('admin.settings.appearance.store');
    });

    // ADMIN FRONTEND SETTINGS - FRONTEND SETTINGS
    Route::controller(FrontendController::class)->group(function () {
        Route::get('/settings/frontend', 'index')->name('admin.settings.frontend');
        Route::post('/settings/frontend', 'store')->name('admin.settings.frontend.store');
    });

    // ADMIN FRONTEND SETTINGS - BLOG MANAGER
    Route::controller(BlogController::class)->group(function () {
        Route::get('/settings/blog', 'index')->name('admin.settings.blog');
        Route::get('/settings/blog/create', 'create')->name('admin.settings.blog.create');
        Route::post('/settings/blog', 'store')->name('admin.settings.blog.store');
        Route::put('/settings/blogs/{id}', 'update')->name('admin.settings.blog.update');
        Route::get('/settings/blogs/{id}/edit', 'edit')->name('admin.settings.blog.edit');
        Route::post('/settings/blog/delete', 'delete');
    });

    // ADMIN GENERAL SETTINGS - USE CASE MANAGER
    Route::controller(UseCaseController::class)->group(function () {
        Route::get('/settings/usecase', 'index')->name('admin.settings.usecase');
        Route::get('/settings/usecase/create', 'create')->name('admin.settings.usecase.create');
        Route::post('/settings/usecase', 'store')->name('admin.settings.usecase.store');
        Route::put('/settings/usecases/{id}', 'update')->name('admin.settings.usecase.update');
        Route::get('/settings/usecases/{id}/edit', 'edit')->name('admin.settings.usecase.edit');
        Route::post('/settings/usecase/delete', 'delete');
    });

    // ADMIN FRONTEND SETTINGS - FAQ MANAGER
    Route::controller(FAQController::class)->group(function () {
        Route::get('/settings/faq', 'index')->name('admin.settings.faq');
        Route::get('/settings/faq/create', 'create')->name('admin.settings.faq.create');
        Route::post('/settings/faq', 'store')->name('admin.settings.faq.store');
        Route::put('/settings/faqs/{id}', 'update')->name('admin.settings.faq.update');
        Route::get('/settings/faqs/{id}/edit', 'edit')->name('admin.settings.faq.edit');
        Route::post('/settings/faq/delete', 'delete');
    });

    // ADMIN FRONTEND SETTINGS - REVIEW MANAGER
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/settings/review', 'index')->name('admin.settings.review');
        Route::get('/settings/review/create', 'create')->name('admin.settings.review.create');
        Route::post('/settings/review', 'store')->name('admin.settings.review.store');
        Route::put('/settings/reviews/{id}', 'update')->name('admin.settings.review.update');
        Route::get('/settings/reviews/{id}/edit', 'edit')->name('admin.settings.review.edit');
        Route::post('/settings/review/delete', 'delete');
    });

    // ADMIN FRONTEND SETTINGS - Career MANAGER
    Route::group(['prefix' => 'settings', 'as' => 'admin.settings.'], function () {
        Route::resource('/careers', CareerController::class);
        Route::post('/career/delete', [CareerController::class, 'delete']);
    });


    // ADMIN FRONTEND SETTINGS - PAGE MANAGER (PRIVACY & TERMS)
    Route::controller(PageController::class)->group(function () {
        Route::get('/settings/terms', 'index')->name('admin.settings.terms');
        Route::post('/settings/terms', 'store')->name('admin.settings.terms.store');
    });

    // ADMIN GENERAL SETTINGS - UPGRADE SOFTWARE
    Route::controller(UpgradeController::class)->group(function () {
        Route::get('/settings/upgrade', 'index')->name('admin.settings.upgrade');
        Route::post('/settings/upgrade', 'upgrade')->name('admin.settings.upgrade.start');
    });

    // ADMIN VOICE CLONE ROUTES

    Route::group(['prefix' => 'voice-clone', 'as' => 'voice.clone.'], function () {
        Route::controller(VoiceCloneScriptController::class)->group(function () {
            Route::get('/voice-clone-script', 'voice_clone_script')->name('voice.clone.script');
            Route::get('/create-voice-clone-script', 'create_voice_clone_script')->name('create.voice.clone.script');
            Route::post('/store-voice-clone-script', 'store_voice_clone_script')->name('store.voice.clone.script');
            Route::get('/edit-voice-clone-script/{id}', 'edit_voice_clone_script')->name('edit.voice.clone.script');
            Route::patch('/update-voice-clone-script/{id}', 'update_voice_clone_script')->name('update.voice.clone.script');
            Route::post('/delete-voice-clone-script', 'delete_language_and_scripts')->name('delete.voice.clone.script');
            Route::post('/delete-voice-clone-language-script', 'delete_language_script')->name('delete.voice.clone.language.script');
        });
        Route::controller(VoiceCloningProfileController::class)->group(function () {
            Route::get('/voice-cloning-profiles', 'voice_cloning_profiles')->name('voice.cloning.profiles');
        });
        Route::controller(VoiceCloningResultsController::class)->group(function () {
            Route::get('/voice-cloning-results', 'voice_cloning_results')->name('voice.cloning.results');
        });
    });

    Route::get('/clear', function () {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
    });

    Route::get('/symlink', function () {
        Artisan::call('storage:link');
    });

    Route::get('/run-raw-sql-seeder', function () {
        $existingRole = DB::table('roles')->where('name', 'voice-artist')->first();
        if (!$existingRole) {
            DB::statement(
                "INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'voice-artist', 'web', '2024-02-05 23:39:26', '2024-02-05 23:39:26')"
            );
        }
    });
});


// REGISTERED USER ROUTES
Route::group(['prefix' => 'account', 'middleware' => ['verified', 'role:user|admin|subscriber|voice-artist', 'PreventBackHistory', 'set_application_configurations']], function () {

    // USER Custom Projects ROUTES
    Route::controller(CustomProjectsController::class)->group(function () {
        Route::get("/custom-projects", "index");
        Route::post("/create-custom-project", "store");
        // user.transcribe.voice-over
    });

    // USER DASHBOARD ROUTES
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('user.dashboard');
        Route::get('/projects', 'projects')->name('user.projects');
        Route::get('/project/{id}/show/{type?}', 'showProject')->name('user.video.show-project');

        Route::get('/dashboard/edit', 'edit')->name('user.dashboard.edit');
        Route::get('/dashboard/edit/defaults', 'editDefaults')->name('user.dashboard.edit.defaults');
        Route::post('/dashboard/edit/defaults/project', 'project');
        Route::put('/dashboard/update/{user}', 'update')->name('user.dashboard.update');
        Route::put('/dashboard/update/defaults/{user}', 'updateDefaults')->name('user.dashboard.update.defaults');
        Route::post('/dashboard/store/voice-over', 'storeVoiceOver')->name('user.dashboard.store.voice-over');


        // user.transcribe.voice-over
    });

    // CHANGE USER PASSWORD ROUTES
    Route::controller(UserPasswordController::class)->group(function () {
        Route::get('/dashboard/security', 'index')->name('user.security');
        Route::post('/dashboard/security/password/{id}', 'update')->name('user.security.password');
        Route::post('/dashboard/security/google/{id}', 'security')->name('user.security.google');
    });

    // USER PURCHASE HISTORY ROUTES
    Route::controller(PurchaseHistoryController::class)->group(function () {
        Route::get('/purchases', 'index')->name('user.purchases');
        Route::get('/purchases/show/{id}', 'show')->name('user.purchases.show');
        Route::get('/purchases/subscriptions', 'subscriptions')->name('user.purchases.subscriptions');
    });

    // USER PRICING PLAN ROUTES
    Route::controller(PricingPlanController::class)->group(function () {
        Route::get('/pricing/plans', 'index')->name('user.plans');
        Route::get('/pricing/plan/subscription/{id}', 'subscribe')->name('user.plan.subscribe')->middleware('unsubscribed');
        Route::get('/pricing/plan/prepaid/{id}', 'checkout')->name('user.prepaid.checkout');
    });

    // USER PAYMENT ROUTES
    Route::controller(PaymentController::class)->group(function () {
        Route::post('/payments/pay/{id}', 'pay')->name('user.payments.pay')->middleware('unsubscribed');
        Route::post('/payments/pay/prepaid/{id}', 'payPrePaid')->name('user.payments.pay.prepaid');
        Route::post('/payments/approved/razorpay', 'approvedRazorpayPrepaid')->name('user.payments.approved.razorpay');
        Route::get('/payments/success/braintree', 'braintreeSuccess')->name('user.payments.approved.braintree');
        Route::get('/payments/approved', 'approved')->name('user.payments.approved');
        Route::get('/payments/cancelled', 'cancelled')->name('user.payments.cancelled');
        Route::post('/payments/subscription/razorpay', 'approvedRazorpaySubscription')->name('user.payments.subscription.razorpay');
        Route::get('/payments/subscription/approved', 'approvedSubscription')->name('user.payments.subscription.approved');
        Route::get('/payments/subscription/cancelled', 'cancelledSubscription')->name('user.payments.subscription.cancelled')->middleware('unsubscribed');
        Route::post('/subscriptions/cancel', 'stopSubscription');
    });

    // USER REFERRAL ROUTES
    Route::controller(ReferralController::class)->group(function () {
        Route::get('/referral', 'index')->name('user.referral');
        Route::post('/referral/settings', 'store')->name('user.referral.store');
        Route::get('/referral/gateway', 'gateway')->name('user.referral.gateway');
        Route::post('/referral/gateway', 'gatewayStore')->name('user.referral.gateway.store');
        Route::get('/referral/payouts', 'payouts')->name('user.referral.payout');
        Route::post('/referral/email', 'email')->name('user.referral.email');
        Route::get('/referral/payouts/create', 'payoutsCreate')->name('user.referral.payout.create');
        Route::post('/referral/payouts/store', 'payoutsStore')->name('user.referral.payout.store');
        Route::get('/referral/all', 'referrals')->name('user.referral.referrals');
        Route::get('/referral/payouts/{id}/show', 'payoutsShow')->name('user.referral.payout.show');
        Route::get('/referral/payouts/{id}/cancel', 'payoutsCancel')->name('user.referral.payout.cancel');
        Route::delete('/referral/payouts/{id}/decline', 'payoutsDecline')->name('user.referral.payout.decline');
    });

    // USER INVOICE ROUTES
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/payments/invoice/{order_id}/generate', 'generatePaymentInvoice')->name('user.payments.invoice');
        Route::get('/payments/invoice/{id}/show', 'showPaymentInvoice')->name('user.payments.invoice.show');
        Route::get('/payments/invoice/{order_id}/transfer', 'bankTransferPaymentInvoice')->name('user.payments.invoice.transfer');
    });

    // USER SUPPORT REQUEST ROUTES
    Route::controller(UserSupportController::class)->group(function () {
        Route::get('/support', 'index')->name('user.support');
        Route::post('/support', 'store')->name('user.support.store');
        Route::get('/support/create', 'create')->name('user.support.create');
        Route::get('/support/{ticket_id}/show', 'show')->name('user.support.show');
        Route::post('/support/delete', 'delete');
    });

    // USER NOTIFICATION ROUTES
    Route::controller(UserNotificationController::class)->group(function () {
        Route::get('/notification', 'index')->name('user.notifications');
        Route::get('/notification/{id}/show', 'show')->name('user.notifications.show');
        Route::post('/notification/delete', 'delete');
        Route::get('/notifications/mark-all', 'markAllRead')->name('user.notifications.markAllRead');
        Route::get('/notifications/delete-all', 'deleteAll')->name('user.notifications.deleteAll');
        Route::post('/notifications/mark-as-read', 'markNotification')->name('user.notifications.mark');
    });

    // USER SEARCH ROUTES
    Route::any('/search', [SearchController::class, 'index'])->name('search');

    // ALL TEXT TO SPEECH ROUTES
    Route::group(['prefix' => 'text-to-speech'], function () {

        // VOICEOVER STUDIO ROUTES
        Route::controller(VoiceoverStudioController::class)->group(function () {
            Route::get('/', 'index')->name('user.voiceover');
            Route::get('/video-dub-studio', 'videoDubStudio')->name('user.video.dub-studio');

            Route::post('/create/project', 'createProject')->name('user.video.create-project');
            Route::post('/upload/video', 'uploadVideo')->name('user.video.upload');
            Route::post('/upload/video/meta-data', 'uploadVideoMetaData')->name('user.video.upload.meta-data');
            Route::get('/generate-transcript', 'generateTranscript')->name('user.generate-transcript');
            Route::post('/generate-transcript', 'patchGenerateTranscript')->name('user.patch-generate-transcript');
            Route::get('/generate-target-transcript', 'generateTargetTranscript')->name('user.generate-target-transcript');
            Route::post('/generate-target-transcript', 'patchGenerateTargetTranscript')->name('user.patch-generate-target-transcript');
            Route::get('/audio-dub-studio', 'audioDubStudio')->name('user.audio.dub-studio');
            Route::get('/text-dub-studio', 'textDubStudio')->name('user.text.dub-studio');
            Route::post('/upload/user-custom-transcript', 'upload_custom_transcript')->name('user.upload.custom.transcript');

            Route::post('/', 'synthesize')->name('user.voiceover.synthesize');
            Route::post('/listen', 'listen')->name('user.voiceover.listen');
            Route::post('/listen-row', 'listenRow');
            Route::get('/{id}/show', 'show')->name('user.voiceover.show');
            Route::post('/audio', 'audio');
            Route::post('/delete', 'delete');
            Route::post('/config', 'config');
        });

        // VOICEOVER RESULT ROUTES
        Route::controller(VoiceoverResultController::class)->group(function () {
            Route::get('/result', 'index')->name('user.voiceover.results');
            Route::get('/result/{id}/show', 'show')->name('user.voiceover.results.show');
            Route::post('/result/delete', 'delete');
        });

        // VOICEOVER PROJECT ROUTES
        Route::controller(VoiceoverProjectController::class)->group(function () {
            Route::get('/project', 'index')->name('user.voiceover.projects');
            Route::post('/project', 'store');
            Route::post('/project/result/delete', 'delete');
            Route::get('/project/change', 'change')->name('user.voiceover.projects.change');
            Route::get('/project/change/stats', 'changeStatus')->name('user.voiceover.projects.change.stats');
            Route::get('/project/result/{id}/show', 'show')->name('user.voiceover.projects.show');
            Route::put('/project', 'update')->name('user.voiceover.project.update');
            Route::delete('/project', 'destroy')->name('user.voiceover.project.delete');
        });

        // SOUND STUDIO ROUTES
        Route::controller(SoundStudioController::class)->group(function () {
            Route::get('/sound-studio', 'index')->name('user.sound.studio');

            Route::get('/audio-enhancer', 'audioEnhancer')->name('user.sound.audio_enhancer');
            Route::get('/audio-enhancer/status', 'audioEnhancementStatus')->name('user.sound.audio_enhancement.status');
            Route::get('/music-gen-studio', 'musicGenStudio')->name('user.sound.music_gen_studio');

            Route::get('/sound-studio/results', 'results')->name('user.sound.studio.results');
            Route::get('/sound-studio/result/{id}/show', 'show')->name('user.sound.studio.show');
            Route::get('/sound-studio/result/{id}/show-studio/', 'showStudio')->name('user.sound.studio.show.studio');
            Route::post('/sound-studio/result/delete', 'delete');
            Route::post('/sound-studio/final/result/delete', 'deleteStudioResult');
            Route::get('/sound-studio/settings', 'settings')->name('sound-studio.settings');
            Route::post('/sound-studio/music/merge', 'merge');
            Route::post('/sound-studio/music/upload', 'upload');
            Route::post('/sound-studio/music/delete', 'deleteMusic');
            Route::get('/sound-studio/music/list', 'list')->name('user.sound.studio.music.list');
        });

        // ALL VOICES ROUTES
        Route::controller(VoiceController::class)->group(function () {
            Route::get('/voices', 'index')->name('user.voiceover.voices');
            Route::post('/voices/change', 'change');
        });
    });

    // ALL SPEECH TO TEXT ROUTES
    Route::group(['prefix' => 'speech-to-text'], function () {

        // TRANSCRIBE RESULT ROUTES
        Route::controller(TranscribeResultController::class)->group(function () {
            Route::get('/result', 'index')->name('user.transcribe.results');
            Route::get('/result/{id}/show', 'show')->name('user.transcribe.results.show');
            Route::post('/result/delete', 'delete');
            Route::post('/result/transcript', 'transcript');
            Route::post('/result/transcript/save', 'transcriptSave');
            Route::post('/results/transcript/live', 'transcript');
            Route::post('/results/transcript/save', 'transcriptSave');
        });

        // TRANSCRIBE PROJECT ROUTES
        Route::controller(TranscribeProjectController::class)->group(function () {
            Route::get('/project', 'index')->name('user.transcribe.projects');
            Route::post('/project', 'store');
            Route::put('/project', 'update')->name('user.transcribe.project.update');
            Route::delete('/project', 'destroy')->name('user.transcribe.project.delete');
            Route::post('/project/result/delete', 'delete');
            Route::get('/project/change', 'change')->name('user.transcribe.projects.change');
            Route::get('/project/change/stats', 'changeStatus')->name('user.transcribe.projects.change.stats');
            Route::get('/project/result/{id}/show', 'show')->name('user.transcribe.projects.show');
        });

        // TRANSCRIBE STUDIO ROUTES
        Route::controller(TranscribeStudioController::class)->group(function () {
            Route::get('/', 'fileTranscribe')->name('user.transcribe.file');
            Route::get('/record', 'recordTranscribe')->name('user.transcribe.record');
            if (config('stt.enable.aws_live') == 'on') {
                Route::post('/live', 'transcribeLive')->name('user.transcribe.transcribe.live');
                Route::get('/live', 'liveTranscribe')->name('user.transcribe.live');
                Route::get('/settings/live', 'settingsLive');
                Route::get('/settings/live/limits', 'settingsLiveLimits');
            }
            Route::post('/', 'transcribe')->name('user.transcribe.transcribe');
            Route::get('/settings', 'settings')->name('user.transcribe.settings');
            Route::get('/{id}/show/file', 'showFile')->name('user.transcribe.show.file');
            Route::get('/{id}/show/record', 'showRecord')->name('user.transcribe.show.record');
        });
    });
    Route::group(['prefix' => 'my-voice-profile', 'as' => 'user.'], function () {
        Route::controller(UserVoiceProfileController::class)->group(function () {
            Route::get('/record-user-voice', 'record_user_voice')->name('record.user.voice');
            Route::get('/get-language-code-script', 'get_language_code_script')->name('get.language.code.script');
            Route::post('/upload-user-voice-profile-script', 'upload_user_voice_profile_script')->name('upload.user.voice.profile.script');
        });
    });
    // VOICE ARTIST ROLE ROUTES
    Route::group(['prefix' => 'account/voice-artist'], function () {
        Route::get('/audio-settings', [SettingsController::class, 'show_audio_settings_page'])->name('voice.artist.show.audio.settings.page');
        Route::get('/studio-view', [StudioController::class, 'show_studio_view'])->name('voice.artist.show.studio.view');
        Route::get('/help-view', [HelpsController::class, 'show_help_view'])->name('voice.artist.show.help.view');
        Route::post('save-audio-settings', [SettingsController::class, 'save_audio_settings'])->name('voice.artist.save.audio.settings');
        Route::get('/voice-profile-settings', [SettingsController::class, 'voice_profile_settings'])->name('voice.artist.show.voice.profile.settings.page');
        Route::get('/wallet-settings', [SettingsController::class, 'wallet_settings'])->name('voice.artist.show.wallet.settings.page');
        Route::get('/show-my-projects', [MyProjectsController::class, 'show_my_projects'])->name('voice.artist.show.my.projects.page');
        Route::get('/show-all-projects', [AllProjectsController::class, 'show_all_projects'])->name('voice.artist.show.all.projects.page');
    });
});
