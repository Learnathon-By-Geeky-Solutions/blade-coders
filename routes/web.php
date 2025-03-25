<?php

use App\Http\Controllers\AbilitySupportController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventSpeakerController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\FaqCategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\OurProcessController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParentReviewController;
use App\Http\Controllers\PasswordResetLinkSendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuperServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

$middlewares = ['auth'];

if (config('setting.email_verification')) {
    $middlewares[] = 'verified';
}

Route::middleware($middlewares)->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::patch('benefits/status/{benefit}', [BenefitController::class, 'status'])->name('benefits.status');
    Route::resource('benefits', BenefitController::class);

    Route::patch('ability-supports/status/{abilitySupport}', [AbilitySupportController::class, 'status'])->name('ability-supports.status');
    Route::resource('ability-supports', AbilitySupportController::class);

    Route::patch('our-processes/status/{ourProcess}', [OurProcessController::class, 'status'])->name('our-processes.status');
    Route::resource('our-processes', OurProcessController::class);

    Route::resource('services', ServiceController::class);
    Route::resource('products', ProductController::class);
    Route::resource('superservices', SuperServiceController::class);

    Route::patch('event-speakers/status/{eventSpeaker}', [EventSpeakerController::class, 'status'])->name('event-speakers.status');
    Route::resource('event-speakers', EventSpeakerController::class);

    Route::patch('event-types/status/{eventType}', [EventTypeController::class, 'status'])->name('event-types.status');
    Route::resource('event-types', EventTypeController::class);

    Route::resource('events', EventController::class);

    Route::resource('roles', RoleController::class);

    Route::get('languages/translation/{language}', [LanguageController::class, 'translation'])->name('languages.translation');
    Route::post('languages/translation/{language}', [LanguageController::class, 'translationUpdate']);
    Route::patch('languages/status/{language}', [LanguageController::class, 'status'])->name('languages.status');
    Route::resource('languages', LanguageController::class);

    Route::post('users/{user}/password-reset-link', PasswordResetLinkSendController::class)->name('password-reset-link.send');
    Route::resource('users', UserController::class)->except(['create', 'edit']);

    Route::post('mailboxes/{mailbox}/send', [MailboxController::class, 'send'])->name('mailboxes.send');
    Route::resource('mailboxes', MailboxController::class)->except(['create', 'edit']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'store'])->name('settings.store');
    Route::post('settings/send-test-mail', [SettingController::class, 'sendTestMail'])->name('settings.send-test-mail');

    Route::patch('currencies/status/{currency}', [CurrencyController::class, 'status'])->name('currencies.status');
    Route::resource('currencies', CurrencyController::class)->except(['create', 'edit']);

    Route::patch('faq-categories/status/{faqCategory}', [FaqCategoryController::class, 'statusUpdate'])->name('faq-categories.status');
    Route::resource('faq-categories', FaqCategoryController::class)->except(['create', 'edit']);
    Route::patch('faqs/status/{faq}', [FaqController::class, 'statusUpdate'])->name('faqs.status');
    Route::resource('faqs', FaqController::class)->except(['create', 'edit']);

    Route::patch('parent-reviews/status/{parentReview}', [ParentReviewController::class, 'statusUpdate'])->name('parent-reviews.status');
    Route::resource('parent-reviews', ParentReviewController::class)->except(['create', 'edit']);

    Route::resource('pages', PageController::class)->except(['show']);

    Route::patch('blog-categories/status/{blogCategory}', [BlogCategoryController::class, 'statusUpdate'])->name('blog-categories.status');
    Route::resource('blog-categories', BlogCategoryController::class)->except(['create', 'show']);
    Route::resource('blogs', BlogController::class)->except(['show']);

    Route::patch('resources/status/{resource}', [ResourceController::class, 'statusUpdate'])->name('resources.status');
    Route::resource('resources', ResourceController::class)->except(['create', 'edit']);
});

require __DIR__.'/auth.php';
