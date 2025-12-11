<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ListConfigController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\PublicListController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\EventPhotoController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TieCuttingController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS (Visitantes)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// [CORREÇÃO] A rota de Termos deve ser PÚBLICA
Route::view('/termos-de-uso', 'termos')->name('termos');

// Galeria Pública
Route::get('/lista/{list}/galeria', [GalleryController::class, 'show'])
     ->name('list.gallery');

// Jogo da Gravata Público
Route::get('/lista/{list}/gravata', [TieCuttingController::class, 'show'])
     ->name('list.gravata');

// Lista Pública (Genérica)
Route::get('/lista/{list}/{slug?}', [PublicListController::class, 'show'])
     ->name('list.public.show');

// Ações Públicas (POST)
Route::post('/lista/{list}/fotos', [EventPhotoController::class, 'store'])
    ->name('public.photos.store');

Route::post('/lista/{list}/rsvp', [RsvpController::class, 'store'])
     ->name('list.public.rsvp');

Route::post('/pagar/{gift}', [PublicListController::class, 'pay'])
    ->name('public.gift.pay');

Route::post('/fotos/{photo}/like', [GalleryController::class, 'like'])->name('photos.like');
Route::post('/fotos/{photo}/comment', [GalleryController::class, 'comment'])->name('photos.comment');


/*
|--------------------------------------------------------------------------
| ROTAS DE AUTENTICAÇÃO (Login, Cadastro)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ROTAS PRIVADAS - PARTE 1 (Acesso Básico)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Onboarding
    Route::get('/onboarding', [OnboardingController::class, 'create'])->name('onboarding.create');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Paywall / Plano
    Route::get('/plano', function() {
        $user = auth()->user();
        $list = $user->list ?? null;

        $planoAtivo = false;
        if ($list) {
            $planoAtivo = $list->plano_pago &&
                          $list->plano_expires_at &&
                          \Carbon\Carbon::parse($list->plano_expires_at)->isFuture();
        }

        if ($planoAtivo) {
            return redirect()->route('dashboard');
        }

        return view('plano.index', ['list' => $list]);
    })->name('plano.index');

    Route::get('/plano/pagar', [PaymentController::class, 'createPayment'])->name('plano.pagar');
    Route::get('/plano/sucesso', [PaymentController::class, 'paymentSuccess'])->name('plano.sucesso');
});

/*
|--------------------------------------------------------------------------
| WEBHOOKS (sem auth/CSRF)
|--------------------------------------------------------------------------
*/
Route::post('/webhook/mercadopago', [PaymentController::class, 'handleWebhook'])
    ->name('webhook.mercadopago');

/*
|--------------------------------------------------------------------------
| ROTAS PRIVADAS - PARTE 2 (Painel Admin Completo)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'checklist'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/dismiss-tutorial', [DashboardController::class, 'dismissTutorial'])
         ->name('dashboard.dismiss-tutorial');

    // RSVP (Admin) e PDF
    Route::get('/rsvp', [RsvpController::class, 'index'])->name('rsvp.index');
    Route::get('/rsvp/download-pdf', [RsvpController::class, 'downloadPdf'])->name('rsvp.export.pdf');
    Route::post('/rsvp', [RsvpController::class, 'adminStore'])->name('rsvp.admin.store');
    Route::resource('rsvp', RsvpController::class)
        ->only(['edit','update','destroy'])
        ->names('rsvp');

    // Configurações
    Route::get('/configuracoes', [ListConfigController::class, 'edit'])->name('list.config.edit');
    Route::post('/configuracoes', [ListConfigController::class, 'update'])->name('list.config.update');

    // Presentes
    Route::resource('presentes', GiftController::class);

    // Extrato
    Route::get('/extrato', [TransactionController::class, 'index'])->name('extrato.index');
    Route::post('/extrato/approve/{transaction}', [TransactionController::class, 'approve'])
         ->name('extrato.approve');

    // Gestão de Fotos
    Route::get('/fotos', [EventPhotoController::class, 'index'])->name('photos.index');
    Route::post('/fotos/{photo}/approve', [EventPhotoController::class, 'approve'])->name('photos.approve');
    Route::delete('/fotos/{photo}', [EventPhotoController::class, 'destroy'])->name('photos.destroy');

    // Compartilhar
    Route::get('/compartilhar', function () {
        $list = auth()->user()->list;
        return view('compartilhar', ['list' => $list]);
    })->name('list.share');

    // Feedback
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // Configuração da Gravata (Admin)
    Route::get('/gravata/config', [TieCuttingController::class, 'edit'])->name('gravata.edit');
    Route::post('/gravata/config', [TieCuttingController::class, 'update'])->name('gravata.update');

});
