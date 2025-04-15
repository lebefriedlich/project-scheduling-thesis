<?php

use App\Http\Controllers\Mahasiswa\SkripsiController;
use App\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Mahasiswa\SemhasController;
use App\Http\Controllers\Mahasiswa\SemproController;
use App\Http\Middleware\CheckIsUser;
use Illuminate\Support\Facades\Auth;

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');

// Handle callback dari Google setelah login
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(Auth::user()->is_admin ? route('admin.index') : route('user'));
    }

    return view('pages.auth', ['title' => 'Auth']);
})->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', CheckIsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/', App\Livewire\Admin\Index::class)->name('admin.index');

    Route::get('/submission', App\Livewire\Admin\Submission\Index::class)->name('admin.submission.index');
    Route::get('/show-document-sempro/{id}', App\Livewire\Admin\ShowDocument\Sempro::class)->name('admin.show-document.sempro');
    Route::get('/show-document-semhas/{id}', App\Livewire\Admin\ShowDocument\Semhas::class)->name('admin.show-document.semhas');
    Route::get('/show-document-skripsi/{id}', App\Livewire\Admin\ShowDocument\Skripsi::class)->name('admin.show-document.skripsi');

    Route::get('/acc-schedule/{exam_id}/{exam_type}', App\Livewire\Admin\AccSchedule\Index::class)->name('admin.acc-schedule.index');

    Route::get('/periode', App\Livewire\Admin\Periode\Index::class)->name('admin.periode.index');
    Route::get('/periode/store', App\Livewire\Admin\Periode\Store::class)->name('admin.periode.store');
    Route::get('/periode/edit/{id}', App\Livewire\Admin\Periode\Edit::class)->name('admin.periode.edit');

    Route::get('/location', App\Livewire\Admin\Location\Index::class)->name('admin.location.index');
    Route::get('/location/store', App\Livewire\Admin\Location\Store::class)->name('admin.location.store');
    Route::get('/location/edit/{id}', App\Livewire\Admin\Location\Edit::class)->name('admin.location.edit');

    Route::get('/import-jadwal-mengajar-dosen', App\Livewire\Admin\JadwalMengajarDosen\Index::class)->name('admin.jadwal-mengajar-dosen.index');

    Route::get('/lecturer', App\Livewire\Admin\Lecturer\Index::class)->name('admin.lecturer.index');
    Route::get('/lecturer/store', App\Livewire\Admin\Lecturer\Store::class)->name('admin.lecturer.store');
    Route::get('/lecturer/edit/{id}', App\Livewire\Admin\Lecturer\Edit::class)->name('admin.lecturer.edit');
});

Route::middleware(['auth', CheckIsUser::class])->group(function () {
    Route::get('/user', function () {
        return redirect('/user/sempro');
    })->name('user');

    Route::prefix('user')->group(function () {
        Route::get('/sempro', [SemproController::class, 'index'])->name('user.sempro.index');
        Route::post('/sempro', [SemproController::class, 'store'])->name('user.sempro.store');

        Route::get('/semhas', [SemhasController::class, 'index'])->name('user.semhas.index');
        Route::post('/semhas', [SemhasController::class, 'store'])->name('user.semhas.store');

        Route::get('/skripsi', [SkripsiController::class, 'index'])->name('user.skripsi.index');
        Route::post('/skripsi', [SkripsiController::class, 'store'])->name('user.skripsi.store');
    });
});
