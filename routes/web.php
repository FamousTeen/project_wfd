<?php

use App\Models\Admin;
use App\Models\Event;
use App\Models\Account;
use App\Models\Training;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetController;
use App\Http\Controllers\MisaController;
use App\Http\Resources\TrainingResource;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MisaDetailController;
use App\Http\Controllers\EventDetailController;
use App\Http\Controllers\AnnouncementController;
use App\Models\Meet;
use App\Models\Misa;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('main/mainpage');
})->name('main_page');


Route::get('/signUp', function () {
    return view('authentication/sign_up');
})->name('sign_up');

// Page Login yang asli
Route::get('/mainLogin', function () {
    return view('authentication/login');
})->name('start_login');


// Route::middleware('redirect.role')->group(callback: function () {
Route::get('/login', [AuthController::class, 'login'])->name('login');
// });

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth:account'])->group(function () {
    Route::get('/account/dashboard', [AccountController::class, 'dashboard'])->name('account.dashboard');
});

// buat acara
Route::resource('events', EventController::class)->names([
    'index' => 'events.index',
    'create' => 'events.create',
    'store' => 'events.store',
    'show' => 'events.show',
    'edit' => 'events.edit',
    'update' => 'events.update',
    'destroy' => 'events.destroy',
]);


// buat pelatihan
Route::resource('trainings', TrainingController::class)->except('edit')->names([
    'index' => 'trainings.index',
    'create' => 'trainings.create',
    'store' => 'trainings.store',
    'show' => 'trainings.show',
    'update' => 'trainings.update',
    'destroy' => 'trainings.destroy',
]);

Route::get('/trainings/edit/{group}/{training}', [TrainingController::class, 'edit'])->name('trainings.edit');

//Jadwal Anggota
Route::get('/jadwal', [MisaController::class, 'index'])->name('jadwal_anggota');

//Dashboard
// Route::get('/dashboard_anggota', [DashboardController::class, 'index'])->name('dashboard_anggota');


Route::resource('accounts', AccountController::class)->except(['store'])->names([
    'index' => 'accounts.index',
    'create' => 'accounts.create',
    'show' => 'accounts.show',
    'edit' => 'accounts.edit',
    'update' => 'accounts.update',
    'destroy' => 'accounts.destroy',
]);

Route::post('/store-account', [AccountController::class, 'store'])->name('store_account');


// buat testing
Route::get('/evaluasi', [MisaDetailController::class, 'show'])->name('evaluasi_anggota');

// Evaluasi Anggota (Pengawas)
Route::get('/evaluasi_pengawas', function () {
    return view('anggota/evaluasi_pengawas');
})->name('evaluasi_pengawas_anggota');

Route::resource('misas', MisaController::class)->names([
    'index' => 'misas.index',
    'create' => 'misas.create',
    'store' => 'misas.store',
    'show' => 'misas.show',
    'edit' => 'misas.edit',
    'update' => 'misas.update',
    'destroy' => 'misas.destroy',
]);
Route::get('/jadwal_misa', [MisaController::class, 'showMisaList'])->name('admin.jadwal_misa');
Route::post('/misas/{misa}/add-anggota', [MisaController::class, 'addAnggota'])->name('misas.addAnggota');


// 'edit' => 'misas.edit',
// 'update' => 'misas.update',

Route::resource('templates', TemplateController::class)->names([
    'index' => 'templates.index',
    'store' => 'templates.store',
    'show' => 'templates.show',
    'destroy' => 'templates.destroy'
]);

Route::resource('announcements', AnnouncementController::class);

// buat testing
Route::get('/post_pengumuman', function () {
    return view('admin/post_pengumuman');
})->name('pengumuman_admin');

// buat testing
Route::get('/profile_admin', [AdminController::class, 'index'])->name('profile_admin');

// buat testing
Route::get('/profile_anggota', [AccountController::class, 'index'])->name('profile_anggota');

/* --------EDIT PROFILE ANGGOTA-------- */
// redirect ke page edit profile anggota
Route::get('/edit_profile_anggota', [AccountController::class, 'edit'])->name('edit_profile_anggota');

Route::get('/edit_profile_admin', [AdminController::class, 'edit'])->name('edit_profile_admin');

// post data edit profile anggota
Route::put('/update_profile_anggota', [AccountController::class, 'update'])->name('update_profile_anggota');

// post data edit profile admin
Route::put('/update_profile_admin', [AdminController::class, 'update'])->name('update_profile_admin');

// post data edit pp anggota
Route::put('/update_pp_anggota', [AccountController::class, 'updatePP'])->name('update_pp_anggota');

// post data edit pp admin
Route::put('/update_pp_admin', [AdminController::class, 'updatePP'])->name('update_pp_admin');
/* --------END EDIT PROFILE ANGGOTA-------- */

//Lihat list Anggota
Route::get('/list_anggota', function () {
    return view('admin/list_anggota');
})->name('list_anggota');

// update isi evaluasi
Route::put('/update_evaluasi/{id}', [MisaDetailController::class, 'updateEval'])->name('update_evaluasi');

Route::get('/update_evaluasi/{id}/{answer}', [MisaDetailController::class, 'updateConfirmation'])->name('update_konfirmasi');

//Lihat list Anggota
Route::get('/konfirmasi', function () {
    $user = null;
    if (Auth::guard('admin')->check()) {
        $user = Auth::guard('admin')->user();
    } elseif (Auth::guard('account')->check()) {
        $user = Auth::guard('account')->user();
    }

    // Fetch data for the dashboard
    $userData = Account::query()->where(
        'email',
        $user->email
    )->where('password', $user->password)->firstOrFail();


    return view('anggota/konfirmasi', [
        'user' => $userData
    ]);
})->name('konfirmasi');

//Input jadwal admin
Route::get('/input_misa', function () {
    return view('admin/input_misa');
})->name('input_misa');

//Input foto admin
Route::get('/input_foto', function () {
    return view('admin/input_foto');
})->name('input_foto');

//input event
Route::get('/input_event', function () {
    $user = Auth::guard('admin')->user();
    $accounts = Account::all();

    $admins = Admin::where('id', '!=', $user->id)->get();

    return view('admin/input_event', [
        'accounts' => $accounts,
        'admins' => $admins
    ]);
})->name('input_event');

/* KHUSUS PENGURUS */
//pengumuman
Route::get('/pengumuman_pengurus', [AnnouncementController::class, 'showForPengurus'])->name('pengumuman_pengurus');

Route::post('/post_pengumuman_pengurus', [AnnouncementController::class, 'post_pengumuman_pengurus'])->name('post_pengumuman_pengurus');

Route::put('/update_pengumuman_pengurus/{id}', [AnnouncementController::class, 'update_pengumuman_pengurus'])->name('update_pengumuman_pengurus');

Route::get('/delete_pengumuman_pengurus/{id}', [AnnouncementController::class, 'delete_pengumuman_pengurus'])->name('delete_pengumuman_pengurus');
//end pengumuman

Route::get('/events/search/{detail}', function (string $detail) {
    $events = Event::where('title', 'LIKE', '%' . $detail . '%')
        ->orWhere('date', 'LIKE', '%' . $detail . '%')
        ->with('eventDetails.account')
        ->get();

    return EventResource::collection($events);
});

// buat ajax event
Route::get('/events/searchs/all', function () {
    Log::info('events/all route accessed');
    $events2 = Event::where('status', 1)->with('eventDetails.account')->get();


    return EventResource::collection(resource: $events2);
});

Route::get('/events/search', function (string $detail) {
    $events = Event::where('title', 'LIKE', '%' . $detail . '%')
        ->orWhere('date', 'LIKE', '%' . $detail . '%')
        ->with('eventDetails.account')
        ->get();

    return EventResource::collection($events);
});

Route::put('/events/search/delete/{id}', function (string $id) {
    $training = Event::where('id', (int)$id)->firstOrFail();
    $training->update(['status' => 0]);

    return redirect()->route('events.index')->with('success', 'Pelatihan berhasil dihapus');
});


// buat ajax pelatihan
Route::get('/trainings/searchs/all', function () {
    Log::info('trainings/searchs/all route accessed');
    $events2 = Training::where('status', 1)
        ->with('groups')->get();


    return TrainingResource::collection($events2);
});

Route::get('/trainings/search/{detail}', function (string $detail) {
    $trainings = Training::with('groups')
        ->whereHas('groups', function ($query) use ($detail) {
            $query->where('name', 'LIKE', '%' . $detail . '%');
        })
        ->orWhere('training_date', 'LIKE', '%' . $detail . '%')
        ->get();

    Log::info(gettype($trainings));

    return TrainingResource::collection($trainings);
});

Route::put('/trainings/search/delete/{id}', function (string $id) {
    $training = Training::where('id', (int)$id)->firstOrFail();
    $training->update(['status' => 0]);

    return redirect()->route('trainings.index')->with('success', 'Pelatihan berhasil dihapus');
});

//dokumen
Route::get('/dokumen_pengurus', function () {
    return view('admin/khusus_pengurus/dokumen_pengurus');
})->name('dokumen_pengurus');


//jadwal
Route::get('/jadwal_pengurus', function () {
    $meets = Meet::where('permission', 1)->get();
    return view('admin/khusus_pengurus/jadwal_pengurus', compact('meets'));
})->name('jadwal_pengurus');


Route::resource('meets', MeetController::class);

Route::put('updateMeetPengurus', [MeetController::class, 'updatePengurus'])->name('meets_updatePengurus');

//jadwal_misa (konfirmasi admin)
Route::get('/jadwal_misa', function () {
    $misas = Misa::where('active', 1)->get();
    return view('admin/jadwal_misa', compact('misas'));
})->name('jadwal_misa');

//list evaluasi ( admin)
Route::get('/list_evaluasi', [MisaDetailController::class, 'showEvalAdmin'])->name('list_evaluasi');

//jadwal pelatihan(anggota)
Route::get('/jadwal_pelatihan', function () {
    return view('anggota/jadwal_pelatihan');
})->name('jadwal_pelatihan');

/* LIST ANGGOTA DI ADMIN PAGE */
// show list anggota
Route::get('/list_anggota', [AdminController::class, 'showListAnggota'])->name('list_anggota');

// update status anggota
Route::get('/update_status_anggota/{id}', [AdminController::class, 'updateStatusAnggota'])->name('updateStatusAnggota');
/* END LIST ANGGOTA DI ADMIN PAGE */

Route::get('/delete_anggota/{id}', [AdminController::class, 'deleteAnggota'])->name('delete_anggota');

//jadwal pelatihan(admin)
Route::get('input_pelatihan', function() {
    return view('admin/training/input_pelatihan');
})->name('input_pelatihan');

Route::get('/input_anggota_pelatihan', function() {
    return view('/admin/training/input_anggota_pelatihan');
})->name('input_anggota_pelatihan');

Route::post('/store_training', [AdminController::class, 'storeTraining'])->name('store_training');

Route::get('/input_anggota_pelatihan', function() {
    return view('/admin/training/input_anggota_pelatihan');
})->name('input_anggota_pelatihan');
