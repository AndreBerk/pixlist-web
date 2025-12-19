<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Controllers Imports
|--------------------------------------------------------------------------
*/
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
use App\Http\Controllers\EventPhotoController;   // Admin (Moderação / ver fotos)
use App\Http\Controllers\PublicPhotoController;  // Público (Upload)
use App\Http\Controllers\GalleryController;      // Público (Visualizar Galeria)
use App\Http\Controllers\TieCuttingController;
use App\Http\Controllers\VowsController;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS (Visitantes)
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('welcome');

/**
 * Termos (público)
 * - ROTA OFICIAL: /termos => name('terms')
 * - ALIAS (compatibilidade): /termos/alias => name('termos')
 * - URL antiga: /termos-de-uso -> redirect /termos
 */
Route::view('/termos', 'termos')->name('terms');

// alias SÓ para não quebrar views antigas que usam route('termos')
Route::redirect('/termos-alias', '/termos')->name('termos');

// url antiga opcional
Route::redirect('/termos-de-uso', '/termos')->name('termos.redirect');

/** Visualização Pública da Lista */
Route::get('/lista/{list}/galeria', [GalleryController::class, 'show'])->name('list.gallery');
Route::get('/lista/{list}/gravata', [TieCuttingController::class, 'show'])->name('list.gravata');
Route::get('/lista/{list}/{slug?}', [PublicListController::class, 'show'])->name('list.public.show');

/** Ações Públicas (POST) */
Route::post('/lista/{list}/fotos', [PublicPhotoController::class, 'store'])->name('public.photos.store');
Route::post('/lista/{list}/rsvp', [RsvpController::class, 'store'])->name('list.public.rsvp');
Route::post('/pagar/{gift}', [PublicListController::class, 'pay'])->name('public.gift.pay');

/** Interações da Galeria */
Route::post('/fotos/{photo}/like', [GalleryController::class, 'like'])->name('photos.like');
Route::post('/fotos/{photo}/comment', [GalleryController::class, 'comment'])->name('photos.comment');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ROTAS DO USUÁRIO LOGADO (Pré-dashboard / Configuração inicial)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /** Aceite de termos — passo obrigatório */
    Route::get('/aceitar-termos', fn () => view('terms-accept'))->name('terms.accept');

    Route::post('/aceitar-termos', function (Request $request) {
        $request->validate([
            'accept_terms' => 'accepted',
        ]);

        $user = $request->user();

        $user->forceFill([
            'terms_accepted_at' => now(),
            'terms_version'     => 'v1.0',
            'terms_ip'          => $request->ip(),
        ])->save();

        return redirect()->route('dashboard');
    })->name('terms.store');

    /** Onboarding */
    Route::get('/onboarding', [OnboardingController::class, 'create'])->name('onboarding.create');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    /** Perfil */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /** Plano (pré-dashboard também pode acessar se você quiser) */
    Route::get('/plano', function () {
        return view('plano.index', [
            'list' => Auth::user()->list,
        ]);
    })->name('plano.index');
});

/*
|--------------------------------------------------------------------------
| WEBHOOKS (Pagamentos)
|--------------------------------------------------------------------------
*/
Route::post('/webhook/mercadopago', [PaymentController::class, 'handleWebhook'])->name('webhook.mercadopago');

/*
|--------------------------------------------------------------------------
| PAINEL ADMINISTRATIVO (Área Restrita)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'checklist', 'terms.accepted'])->group(function () {

    /** Dashboard */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/dismiss-tutorial', [DashboardController::class, 'dismissTutorial'])->name('dashboard.dismiss-tutorial');

    /** Configurações */
    Route::get('/configuracoes', [ListConfigController::class, 'edit'])->name('list.config.edit');
    Route::post('/configuracoes', [ListConfigController::class, 'update'])->name('list.config.update');

    /** Presentes */
    Route::resource('presentes', GiftController::class);

    /** Extrato */
    Route::get('/extrato', [TransactionController::class, 'index'])->name('extrato.index');
    Route::post('/extrato/{transaction}/aprovar', [TransactionController::class, 'approve'])->name('extrato.approve');

    /** RSVP (Admin) */
    Route::get('/rsvp', [RsvpController::class, 'index'])->name('rsvp.index');
    Route::post('/rsvp', [RsvpController::class, 'adminStore'])->name('rsvp.admin.store');
    Route::get('/rsvp/{rsvp}/editar', [RsvpController::class, 'edit'])->name('rsvp.edit');
    Route::put('/rsvp/{rsvp}', [RsvpController::class, 'update'])->name('rsvp.update');
    Route::delete('/rsvp/{rsvp}', [RsvpController::class, 'destroy'])->name('rsvp.destroy');
    Route::get('/rsvp/exportar-pdf', [RsvpController::class, 'exportPdf'])->name('rsvp.export.pdf');

    /** Fotos (Admin moderação) */
    Route::get('/fotos', [EventPhotoController::class, 'index'])->name('photos.index');
    Route::patch('/fotos/{photo}/aprovar', [EventPhotoController::class, 'approve'])->name('photos.approve');
    Route::delete('/fotos/{photo}', [EventPhotoController::class, 'destroy'])->name('photos.destroy');

    /** Votos */
    Route::get('/votos', [VowsController::class, 'index'])->name('vows.index');
    Route::post('/votos', [VowsController::class, 'update'])->name('vows.update');
    Route::any('/votos/imprimir/{role}', [VowsController::class, 'print'])->name('vows.print');

    Route::post('/votos/enviar-codigo', [VowsController::class, 'sendResetCode'])->name('vows.send_code');
    Route::get('/votos/verificar/{role}', [VowsController::class, 'verifyCodePage'])->name('vows.verify_page');
    Route::post('/votos/resetar', [VowsController::class, 'resetWithCode'])->name('vows.reset_with_code');

    /** Gravata (admin edit) */
    Route::get('/gravata', [TieCuttingController::class, 'edit'])->name('gravata.edit');
    Route::post('/gravata', [TieCuttingController::class, 'update'])->name('gravata.update');

    /** Compartilhar */
    Route::get('/compartilhar', function () {
        return view('compartilhar', [
            'list' => Auth::user()->list,
        ]);
    })->name('list.share');

    /** Feedback */
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    /** Plano (admin) */
    Route::get('/plano', fn () => view('plano.index', ['list' => auth()->user()->list]))->name('plano.index');
    Route::post('/plano/pagar', [PaymentController::class, 'createPreference'])->name('plano.pagar');

    Route::post('/tutorial/dismiss', [DashboardController::class, 'dismissTutorial'])->name('tutorial.dismiss');

    Route::resource('despesas', ExpenseController::class)->only(['index', 'store', 'update', 'destroy']);
});
