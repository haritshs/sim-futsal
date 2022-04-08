<?php
use App\Events\BookingSubmitted;
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
Route::get('/counter', function () {
    return view('counter');
});
Route::get('/sender', function () {
    return view('sender');
});
Route::post('/sender', function () {

    $text = request()->text;
    event(new BookingSubmitted($text));
});
/*Route::get('/', function () {
    return view('app');
});*/
Route::get('/', 'AppController@index')->name('landing');
Route::get('/lapangan/{id}/{tanggal}', 'AppController@jadwal_lapangan')->name('jadwal_lapangan');
Route::get('/lapangan', 'AppController@lapangan')->name('lapangan');
//Route::get('/lapangan/{id}', 'AppController@tampil_lapangan')->name('detail_lapangan');
Route::get('/api/check-booking',  'Api\BookingController@verifikasi' )->name('api.booking-check');
Route::get('/galeri', 'AppController@galeri')->name('galeri');
Route::get('/futsal', 'AppController@futsal')->name('futsal');
Route::get('/coba_api', 'AppController@galeri')->name('galeri');

Route::get('/kirim_notif', function () {
    return view('coba');
});

Route::post('/tespayment', 'PembayaranController@gopayPayment');
//Route::get('/detail_turnamen/{id}', 'AppController@detail_turnamen')->name('detail_turnamen');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', 'ProfileController@index' )->name('index.profile');
    //Route::get('/tim', 'TimController@create' )->name('tim.create');
    Route::resource('pertanyaan', 'PertanyaanController');
    Route::resource('komentar', 'KomentarController');
    Route::get('/lapangan/{id}', 'AppController@tampil_lapangan')->name('detail_lapangan');
    Route::get('/detail_turnamen/{id}', 'AppController@detail_turnamen')->name('detail_turnamen');
    
    //Route::get('tim/create', ['as' => 'tim.create', 'uses' => 'TimController@create']);
    Route::get('daftar-tim', ['as' => 'daftar_tim', 'uses' => 'TimController@daftar_tim']);
    //Route::post('tambah_tim', 'AppController@tambah_tim' )->name('app.tambah_tim');
    Route::post('tambah-tim', ['as' => 'tim.tambah-team', 'uses' => 'TimController@store' ]);
    Route::get('sparing', ['as' => 'sparing.tampil_sparing', 'uses' => 'SparingController@tampil_sparing' ]);
    Route::post('sparing/lawan-sparing/{id}', ['as' => 'sparing.lawan-sparing', 'uses' => 'SparingController@lawan_sparing' ]);
    Route::get('sparing/pemenang/{id}', ['as' => 'sparing.pemenang', 'uses' => 'SparingController@tampil_pemenang' ]);
    //Route::post('create-client', ['as' => 'create-client', 'uses' => 'BookingController@createClient' ]);
    Route::resource('pendaftaran_turnamen', 'PendaftaranTurnamenController');
    Route::post('/pertanyaan/komentar_pertanyaan/{id}', 'PertanyaanController@komentar_pertanyaan')->name('pertanyaan.komentar_pertanyaan');
    Route::put('/profile/{id}/edit', 'ProfileController@update' )->name('index.profile');
    Route::get('/api/booking/{id}',  'Api\BookingController@getByUser' )->name('api.booking');
    Route::get('/booking', 'BookingController@index' )->name('index.booking');
    Route::get('store', 'BookingController@store' )->name('booking.store');
    //Route::get('add_voucher', 'BookingController@add_voucher' )->name('booking.add_voucher');
    Route::get('add_voucher/{id}', ['as' => 'add_voucher', 'uses' => 'BookingController@add_voucher' ]);
    Route::delete('/booking', 'BookingController@remove_voucher' )->name('booking.remove_voucher');
    //Route::get('daftar_turnamen', 'AppController@daftar_turnamen')->name('app.daftar_turnamen');
    Route::post('daftar-turnamen/{id}', ['as' => 'app.daftar-turnamen', 'uses' => 'AppController@daftar_turnamen']);
    /*Route::match(['get', 'post'], '/booking', [
        'uses' => 'BookingController@index',
        'as'   => 'index.booking',
    ]);*/
    Route::post('/booking', 'BookingController@store' )->name('store.booking');
    
    /*Route::post('/booking', 'BookingController@store', function () {

        $bookid = request()->id;
        $username = request()->name;
        event(new BookingSubmitted($bookid, $username));
    });*/
    Route::post('/daftar_sparing', 'BookingController@daftarSparing' )->name('daftarSparing.booking');
    Route::get('/update_status/{id}', 'PembayaranController@update_status');
    Route::get('/update_status_sparing/{id}', 'PembayaranController@update_status_sparing');
    Route::get('/booking/pembayaran/{id}', 'BookingController@pembayaran' )->name('pembayaran.booking');
    Route::get('/sparing/pembayaran/{id}', 'SparingController@pembayaran' )->name('pembayaran.sparing');
    //Route::get('/sparing/pemenang/{id}', 'SparingController@tampil_pemenang')->name('pemenang.sparing');
    Route::get('/turnamen/pembayaran/{id}', 'PendaftaranTurnamenController@pembayaran' )->name('pembayaran.sparing');
    Route::post('/booking/konfirmasi_booking/{id}', 'BookingController@konfirmasi_booking' )->name('konfirmasi_booking.booking');
    Route::get('/booking/sukses_booking/{id}', 'BookingController@sukses_booking' )->name('sukses_booking.booking');
    Route::get('/booking/sukses_sparing/{id}', 'BookingController@sukses_sparing' )->name('sukses_sparing.booking');
    Route::get('/booking/batal_booking/{id}', 'BookingController@batal_booking' )->name('batal_booking.booking');
    //Route::get('/pembayaran', 'PembayaranController@render');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function() {

    // Login Routes...
        Route::get('login', ['as' => 'admin.login', 'uses' => 'AdminAuth\LoginController@showLoginForm']);
        Route::post('login', ['uses' => 'AdminAuth\LoginController@login']);
        Route::post('logout', ['as' => 'admin.logout', 'uses' => 'AdminAuth\LoginController@logout']);
    
    // Registration Routes...
        Route::get('register', ['as' => 'admin.register', 'uses' => 'AdminAuth\RegisterController@showRegistrationForm']);
        Route::post('register', ['uses' => 'AdminAuth\RegisterController@register']);
    
    // Password Reset Routes...
        /*Route::get('password/reset', ['as' => 'admin.password.reset', 'uses' => 'AdminAuth\ForgotPasswordController@showLinkRequestForm']);
        Route::post('password/email', ['as' => 'admin.password.email', 'uses' => 'AdminAuth\ForgotPasswordController@sendResetLinkEmail']);
        Route::get('password/reset/{token}', ['as' => 'admin.password.reset.token', 'uses' => 'AdminAuth\ResetPasswordController@showResetForm']);
        Route::post('password/reset', ['uses' => 'AdminAuth\ResetPasswordController@reset']);*/
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::resource('karyawan', 'KaryawanController');
    Route::resource('absensi', 'AbsensiController');
    Route::resource('jabatan', 'JabatanController');
    Route::resource('shift', 'ShiftController');
    Route::post('jabatan/create/notification/jabatan/notification', 'JabatanController@notification');
    Route::post('notification/jabatan/notification', 'JabatanController@notification');
    //Route::get('/', 'Admin\BookingController@getNotif');
    //Route::get('dashboard', 'Admin\BookingController@getNotif')->name('admin.notifikasi');

    Route::resource('pendapatan', 'PendapatanController');
    Route::resource('pengeluaran', 'PengeluaranController');
    Route::resource('voucher', 'VoucherController');
    Route::resource('turnamen', 'TurnamenController');
    Route::post('turnamen/bracket', 'TurnamenController@save_bracket')->name('turnamen.save_bracket');
    // Route::get('turnamen/bracket', function () {
    //     return view('turnamen.bracket');
    // });
    Route::resource('sparing', 'SparingController');
    Route::resource('pemenang_sparing', 'PemenangSparingController');
    Route::resource('tim', 'TimController');
    //Route::match(['put', 'patch'], '/jabatan/update_pendapatan/{id}', 'JabatanController@update_pendapatan');
    //Route::match(['put', 'patch'], '/jabatan/update_potongan/{id}', 'JabatanController@update_potongan');
    Route::match(['put', 'patch'], '/pendapatan/update_potongan/{id}',[
        'as' => 'pendapatan.update_potongan',
        'uses' => 'PendapatanController@update_potongan'
    ]);
    Route::match(['put', 'patch'], '/pendapatan/update_pendapatan/{id}',[
        'as' => 'pendapatan.update_pendapatan',
        'uses' => 'PendapatanController@update_pendapatan'
    ]);
    Route::resource('kehadiran', 'KehadiranController');
    Route::get('kehadiran/absen/{id}', 'KehadiranController@absen')->name('kehadiran.absen');
    Route::post('kehadiran/simpan', 'KehadiranController@simpan_absen')->name('kehadiran.simpan_absen');
    Route::resource('lapangan', 'LapanganController');
    Route::resource('penggajian', 'PenggajianController');
    //Route::get('penggajian/cari', 'PenggajianController@index');
    //Route::get('penggajian/cari', ['as' => 'penggajian.cari', 'uses' => 'PenggajianController@filter']);
    //Route::get('gaji/filter', ['as' => 'penggajian.filter', 'uses' => 'PenggajianController@filter']);
    Route::get('gaji/filter', 'PenggajianController@filter')->name('gaji.filter');
    
    Route::get('gaji/filter/detail/{id}/{bulan}/{tahun}', 'PenggajianController@detailFilter')->name('penggajian.detail_filter');
    //Route::get('/cetak/slip/{id}/{bulan}/{tahun}', 'PenggajianController@cetak_slip');
    //Route::get('/penggajian/cetakslip/{id}', 'PenggajianController@cetak_slip');
    Route::get('penggajian/cetakslip/{id}', ['as' => 'penggajian.cetakslip', 'uses' => 'PenggajianController@cetak_slip']);
    Route::get('penggajian/cetakslip/{id}/{bulan}/{tahun}', ['as' => 'penggajian.cetak_detail_slip', 'uses' => 'PenggajianController@cetak_detail_slip']);
    Route::resources(['user' => 'UserController']);
    Route::post('kehadiran/check_in', ['as' => 'kehadiran.check_in', 'uses' => 'KehadiranController@check_in']);
    Route::get('booking', 'Admin\BookingController@index')->name('admin.booking');
    
    Route::get('booking.detail', 'Admin\BookingController@booking_detail')->name('admin.booking.detail');
    Route::get('booking/detail', ['as' => 'booking.detail_booking', 'uses' => 'BookingController@detail_booking']);
    Route::get('api/booking', 'Api\BookingController@index')->name('api.booking');
    //Route::put('jabatan/{id}/update_pendapatan', 'JabatanController@update_pendapatan');
    //Route::put('jabatan/{id}/update_potongan', 'JabatanController@update_potongan');
    //Route::put('booking/{id}/verifikasi_booking', 'Admin\BookingController@verifikasi_booking')->name('admin.verifikasi-booking');
    //Route::put('booking/{id}/batal_booking', 'Admin\BookingController@batal_booking')->name('admin.batal-booking');
    Route::put('booking/{id}/cancel', 'Admin\BookingController@cancel')->name('admin.cancel-book');
    Route::put('booking/{id}/verify', 'Admin\BookingController@verifikasi_booking')->name('admin.verify-book');
    Route::get('laporan', 'Admin\BookingController@laporan')->name('laporan.booking'); 
    //Route::get('laporan/cetaklaporan', 'Admin\BookingController@cetak_laporan')->name('cetak_laporan.booking');
    //Route::get('laporan/cetaklaporan', ['as' => 'laporan.cetaklaporan', 'uses' => 'Admin\BookingController@cetak_laporan']);
    /*Route::get('show/laporan', 'Admin\ManageBookingController@showLaporan')->name('showlaporan.booking');
    Route::resources([
        'lapang' => 'Admin\LapangController',
        'user' => 'Admin\ManageUserController',
    ]);
    Route::put('user/{id}/ban', ['uses' => 'Admin\ManageUserController@ban']);
    Route::put('user/{id}/unbanned', ['uses' => 'Admin\ManageUserController@unban']);*/
});


Route::get('test', function () {
    try {

        event(new App\Events\BookingSubmitted('tes'));
        return "Event has been sent!";
    } catch (Exception $e) {
        return $e->getMessage();
    }
});

