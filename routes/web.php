<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


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

// Route::group(['middleware' => ['web']], function()    
// {
	//Route::auth();
	// Authentication Routes...
	Route::get('login', 'Auth\AuthController@showLoginForm');
	Route::post('login', 'Auth\AuthController@login'); // method "post" dari form login
	Route::get('/', array('as'=>'admin', 'uses'=> 'AdminController@index'));
	Route::get('logout', 'Auth\AuthController@logout');	
// });

//Route as admin
Route::group(['middleware' => ['auth','level:11']], function()    
{	
	// Pengumuman 
	Route::get('admin/pengumuman',array('as'=>'admin.pengumuman', 'uses'=> 'Admin\PengumumanController@index'));
	Route::get('admin/tambahpengumuman', array('as'=>'admin.tambahpengumuman.show', 'uses'=> 'Admin\PengumumanController@showTambahPengumuman'));
	Route::post('admin/pengumuman/tambah', array('as'=>'admin.tambahpengumuman', 'uses'=> 'Admin\PengumumanController@tambah'));
	Route::get('admin/pengumuman/{id}/hapus', array('as'=>'admin.hapuspengumuman', 'uses'=> 'Admin\PengumumanController@hapus'));
	Route::get('admin/pengumuman/{id}/edit', array('as'=>'admin.editpengumuman', 'uses'=> 'Admin\PengumumanController@editpengumuman'));
	Route::put('admin/pengumuman/{id}/simpanedit', array('as'=>'admin.pengumuman.simpanedit', 'uses'=> 'Admin\PengumumanController@simpanedit'));

	// Departemen
	Route::get('admin/departemen',array('as'=>'admin.departemen', 'uses'=> 'Admin\DepartemenController@index'));
	Route::get('admin/tambahdepartemen', array('as'=>'admin.tambahdepartemen.show', 'uses'=> 'Admin\DepartemenController@showTambahDepartemen'));
	Route::post('admin/departemen/tambah', array('as'=>'admin.tambahdepartemen', 'uses'=> 'Admin\DepartemenController@tambah'));
	Route::get('admin/departemen/{id}/hapus', array('as'=>'admin.hapusdepartemen', 'uses'=> 'Admin\DepartemenController@hapus'));
	Route::get('admin/departemen/{id}/edit', array('as'=>'admin.editdepartemen', 'uses'=> 'Admin\DepartemenController@editdepartemen'));
	Route::put('admin/departemen/{id}/simpanedit', array('as'=>'admin.departemen.simpanedit', 'uses'=> 'Admin\DepartemenController@simpanedit'));

	// Trainee
	Route::get('admin/trainee',array('as'=>'admin.trainee', 'uses'=> 'Admin\TraineeController@index'));
	Route::get('admin/tambahtrainee', array('as'=>'admin.tambahtrainee.show', 'uses'=> 'Admin\TraineeController@showTambahTrainee'));
	Route::post('admin/trainee/tambah', array('as'=>'admin.tambahtrainee', 'uses'=> 'Admin\TraineeController@tambah'));
	Route::get('admin/trainee/{id}/hapus', array('as'=>'admin.hapustrainee', 'uses'=> 'Admin\TraineeController@hapus'));
	Route::get('admin/trainee/{id}/edit', array('as'=>'admin.edittrainee', 'uses'=> 'Admin\TraineeController@edittrainee'));
	Route::put('admin/trainee/{id}/simpanedit', array('as'=>'admin.trainee.simpanedit', 'uses'=> 'Admin\TraineeController@simpanedit'));
	Route::get('admin/trainee/{id}/detail', array('as'=>'admin.detailtrainee', 'uses'=> 'Admin\TraineeController@detail'));

	// Trainer
	Route::get('admin/trainer',array('as'=>'admin.trainer', 'uses'=> 'Admin\TrainerController@index'));
	Route::get('admin/tambahtrainer', array('as'=>'admin.tambahtrainer.show', 'uses'=> 'Admin\TrainerController@showTambahTrainer'));
	Route::post('admin/trainer/tambah', array('as'=>'admin.tambahtrainer', 'uses'=> 'Admin\TrainerController@tambah'));
	Route::get('admin/trainer/{id}/hapus', array('as'=>'admin.hapustrainer', 'uses'=> 'Admin\TrainerController@hapus'));
	Route::get('admin/trainer/{id}/edit', array('as'=>'admin.edittrainer', 'uses'=> 'Admin\TrainerController@edittrainer'));
	Route::put('admin/trainer/{id}/simpanedit', array('as'=>'admin.trainer.simpanedit', 'uses'=> 'Admin\TrainerController@simpanedit'));
	Route::get('admin/trainer/{id}/detail', array('as'=>'admin.detail', 'uses'=> 'Admin\TrainerController@detail'));

	// Modul 
	Route::get('admin/modul_learn',array('as'=>'admin.modul_learn', 'uses'=> 'Admin\ModulController@index'));
	Route::get('admin/tambahmodul_learn', array('as'=>'admin.tambahmodul_learn.show', 'uses'=> 'Admin\ModulController@showTambahModul'));
	Route::post('admin/modul_learn/tambah', array('as'=>'admin.tambahmodul_learn', 'uses'=> 'Admin\ModulController@tambah'));
	Route::get('admin/modul_learn/{id}/hapus', array('as'=>'admin.hapusmodul_learn', 'uses'=> 'Admin\ModulController@hapus'));
	Route::get('admin/modul_learn/{id}/edit', array('as'=>'admin.editmodul_learn', 'uses'=> 'Admin\ModulController@editmodul_learn'));
	Route::put('admin/modul_learn/{id}/simpanedit', array('as'=>'admin.modul_learn.simpanedit', 'uses'=> 'Admin\ModulController@simpanedit'));

	// Materi Ajar 
	Route::get('admin/materi_ajar',array('as'=>'admin.materi_ajar', 'uses'=> 'Admin\MateriAjarController@index'));
	Route::get('admin/tambahmateri_ajar', array('as'=>'admin.tambahmateri_ajar.show', 'uses'=> 'Admin\MateriAjarController@showTambahMateriAjar'));
	Route::post('admin/materi_ajar/tambah', array('as'=>'admin.tambahmateri_ajar', 'uses'=> 'Admin\MateriAjarController@tambah'));
	Route::get('admin/materi_ajar/{id}/hapus', array('as'=>'admin.hapusmateri_ajar', 'uses'=> 'Admin\MateriAjarController@hapus'));
	Route::get('admin/materi_ajar/{id}/edit', array('as'=>'admin.editmateri_ajar', 'uses'=> 'Admin\MateriAjarController@editmateri_ajar'));
	Route::put('admin/materi_ajar/{id}/simpanedit', array('as'=>'admin.materi_ajar.simpanedit', 'uses'=> 'Admin\MateriAjarController@simpanedit'));
	Route::get('admin/materi_ajar/{id}/download', array('as'=>'admin.download_materi_ajar', 'uses'=> 'Admin\MateriAjarController@download'));

	// Tugas 
	Route::get('admin/tugas',array('as'=>'admin.tugas', 'uses'=> 'Admin\TugasController@index'));
	Route::get('admin/tambahtugas', array('as'=>'admin.tambahtugas.show', 'uses'=> 'Admin\TugasController@showTambahTugas'));
	Route::post('admin/tugas/tambah', array('as'=>'admin.tambahtugas', 'uses'=> 'Admin\TugasController@tambah'));
	Route::get('admin/tugas/{id}/hapus', array('as'=>'admin.hapustugas', 'uses'=> 'Admin\TugasController@hapus'));
	Route::get('admin/tugas/{id}/edit', array('as'=>'admin.edittugas', 'uses'=> 'Admin\TugasController@edittugas'));
	Route::put('admin/tugas/{id}/simpanedit', array('as'=>'admin.tugas.simpanedit', 'uses'=> 'Admin\TugasController@simpanedit'));		
	Route::get('admin/tugas/{id}/peserta_koreksi', array('as'=>'admin.peserta_koreksi', 'uses'=> 'Admin\TugasController@ShowPesertaKoreksiTugas'));
	Route::put('admin/tugas/trainee/{id}/update_nilai_tugas', array('as'=>'admin.update_nilai_peserta_koreksi', 'uses'=> 'Admin\TugasController@updateNilaiTugasTrainee'));
	// Download Tugas Trainee
	Route::get('admin/tugas/{id}/download_tugas_trainee', array('as'=>'admin.download_tugas', 'uses'=> 'Admin\TugasController@download_tugas_trainee'));

	// Ujian 
	Route::get('admin/ujian',array('as'=>'admin.ujian', 'uses'=> 'Admin\UjianController@index'));
	Route::get('admin/tambahujian', array('as'=>'admin.tambahujian.show', 'uses'=> 'Admin\UjianController@showTambahUjian'));
	Route::post('admin/ujian/tambah', array('as'=>'admin.tambahujian', 'uses'=> 'Admin\UjianController@tambah'));
	Route::get('admin/ujian/{id}/hapus', array('as'=>'admin.hapusujian', 'uses'=> 'Admin\UjianController@hapus'));
	Route::get('admin/ujian/{id}/edit', array('as'=>'admin.editujian', 'uses'=> 'Admin\UjianController@editujian'));
	Route::put('admin/ujian/{id}/simpanedit', array('as'=>'admin.ujian.simpanedit', 'uses'=> 'Admin\UjianController@simpanedit'));
	Route::get('admin/ujian/{id}/detail', array('as'=>'admin.detail_ujian', 'uses'=> 'Admin\UjianController@detail'));
	Route::get('admin/ujian_trainee/{id}/hapus', array('as'=>'admin.hapus_ujian_trainee', 'uses'=> 'Admin\UjianController@destroy'));
	Route::get('admin/trainee_ujian/{id}', array('as'=>'admin.trainee_ujian.show', 'uses'=> 'Admin\TraineeJawabUjianController@show'));
	Route::get('admin/ujian/{id}', array('as'=>'.ujian.show', 'uses'=> 'Admin\UjianController@show'));

	// Soal Ujian 
	Route::get('admin/soal_ujian',array('as'=>'admin.soal_ujian', 'uses'=> 'Admin\SoalUjianController@index'));
	Route::get('admin/tambah_soal_ujian', array('as'=>'admin.tambah_soal_ujian.show', 'uses'=> 'Admin\SoalUjianController@showTambahSoalUjian'));
	Route::post('admin/soal_ujian/tambah', array('as'=>'admin.tambah_soal_ujian', 'uses'=> 'Admin\SoalUjianController@tambah'));
	Route::get('admin/soal_ujian/{id}/hapus', array('as'=>'admin.hapus_soal_ujian', 'uses'=> 'Admin\SoalUjianController@hapus'));
	Route::get('admin/soal_ujian/{id}/edit', array('as'=>'admin.edit_soal_ujian', 'uses'=> 'Admin\SoalUjianController@edit'));
	Route::put('admin/soal_ujian/{id}/simpanedit', array('as'=>'admin.soal_ujian.simpanedit', 'uses'=> 'Admin\SoalUjianController@simpanedit'));
	Route::get('admin/soal_ujian/{id}/detail', array('as'=>'admin.detail_soal_ujian', 'uses'=> 'Admin\SoalUjianController@detail'));
	
	// Show Nilai by Departemen
	Route::get('admin/nilai_trainee', array('as'=>'admin.get_nilai_trainee.departemen.modul_learn', 'uses'=>'Admin\NilaiController@showDepartemenNilai'));
	Route::post('admin/nilai_trainee', array('as'=>'admin.post_nilai_trainee.departemen.modul_learn', 'uses'=>'Admin\NilaiController@showDepartemenNilai'));

	Route::get('admin/nilai_ujian',array('as'=>'admin.nilai_ujian', 'uses'=> 'Admin\NilaiUjianController@index'));
	Route::get('admin/tambahnilai_ujian', array('as'=>'admin.tambahnilai_ujian.show', 'uses'=> 'Admin\NilaiUjianController@showTambahNilaiUjian'));
	Route::post('admin/nilai_ujian/tambah', array('as'=>'admin.tambahnilai_ujian', 'uses'=> 'Admin\NilaiUjianController@tambah'));
	Route::get('admin/nilai_ujian/{id}/hapus', array('as'=>'admin.hapusnilai_ujian', 'uses'=> 'Admin\NilaiUjianController@hapus'));
	Route::get('admin/nilai_ujian/{id}/edit', array('as'=>'admin.editnilai_ujian', 'uses'=> 'Admin\NilaiUjianController@editnilai_ujian'));
	Route::put('admin/nilai_ujian/{id}/simpanedit', array('as'=>'admin.nilai_ujian.simpanedit', 'uses'=> 'Admin\NilaiUjianController@simpanedit'));

	// Menu Tambahan : SMS 
	Route::get('admin/message/send',array('as'=>'admin.message.form', 'uses'=> 'Admin\MessageController@form'));		
	Route::post('admin/message/send', array('as'=>'admin.message.send', 'uses'=> 'Admin\MessageController@kirimPesan'));	
	Route::post('admin/message/sending', array('as'=>'admin.message.sendEditedMessage', 'uses'=> 'Admin\MessageController@kirimPesanEdit'));
	Route::get('admin/message/send/{id}/edit', array('as'=>'admin.message_edit.send', 'uses'=> 'Admin\MessageController@edit'));	
	Route::get('admin/test_view', array('as'=>'admin.test_view', 'uses'=> 'AdminController@test_view'));

	// Menu User / Pengguna
	Route::get('admin/user',array('as'=>'admin.user', 'uses'=> 'AdminController@index_user'));
	Route::get('admin/tambahuser',array('as'=>'admin.user.tambah_user', 'uses'=> 'AdminController@showTambahUser'));	
	Route::post('admin/user/tambah',array('as'=>'admin.user.tambah', 'uses'=> 'AdminController@createAkunNew'));
	Route::get('admin/user/{id}/hapus', array('as'=>'admin.hapususer', 'uses'=> 'AdminController@hapus'));
	Route::get('admin/user/{id}/edit', array('as'=>'admin.edituser', 'uses'=> 'AdminController@edituser'));	
	Route::put('admin/user/{id}/simpanedit', array('as'=>'admin.user.simpanedit', 'uses'=> 'AdminController@simpanedit'));	
	Route::get('admin/user/{id_user}/ubahpassword',array('as'=>'admin.user.ubah_password', 'uses'=> 'AdminController@showUbahPasswordUserAdmin'));
	Route::post('admin/user/simpanubahpassworduser', array('as'=>'admin.user.simpanubahpassword', 'uses'=> 'AdminController@simpanubahpassworduser'));	

});

//Route as trainer
Route::group(['middleware' => ['auth','level:12']], function()    
{	
	// Departemen
	Route::get('trainer/departemen',array('as'=>'trainer.departemen', 'uses'=> 'Admin\DepartemenController@index_trainer'));
	// Materi Ajar 
	Route::get('trainer/materi_ajar',array('as'=>'trainer.materi_ajar', 'uses'=> 'Admin\MateriAjarController@index_trainer'));
	Route::get('trainer/tambahmateri_ajar', array('as'=>'trainer.tambahmateri_ajar.show', 'uses'=> 'Admin\MateriAjarController@showTambahMateriAjar_trainer'));
	Route::post('trainer/materi_ajar/tambah', array('as'=>'trainer.tambahmateri_ajar', 'uses'=> 'Admin\MateriAjarController@tambah_trainer'));
	Route::get('trainer/materi_ajar/{id}/hapus', array('as'=>'trainer.hapusmateri_ajar', 'uses'=> 'Admin\MateriAjarController@hapus_trainer'));
	Route::get('trainer/materi_ajar/{id}/edit', array('as'=>'trainer.editmateri_ajar', 'uses'=> 'Admin\MateriAjarController@editmateri_ajar_trainer'));
	Route::put('trainer/materi_ajar/{id}/simpanedit', array('as'=>'trainer.materi_ajar.simpanedit', 'uses'=> 'Admin\MateriAjarController@simpanedit_trainer'));
	Route::get('trainer/materi_ajar/{id}/download', array('as'=>'trainer.download_materi_ajar', 'uses'=> 'Admin\MateriAjarController@download_trainer'));	
	// Tugas 	
	Route::get('trainer/tugas',array('as'=>'trainer.tugas', 'uses'=> 'Admin\TugasController@index'));
	Route::get('trainer/tambahtugas', array('as'=>'trainer.tambahtugas.show', 'uses'=> 'Admin\TugasController@showTambahTugas'));
	Route::post('trainer/tugas/tambah', array('as'=>'trainer.tambahtugas', 'uses'=> 'Admin\TugasController@tambah'));
	Route::get('trainer/tugas/{id}/hapus', array('as'=>'trainer.hapustugas', 'uses'=> 'Admin\TugasController@hapus'));
	Route::get('trainer/tugas/{id}/edit', array('as'=>'trainer.edittugas', 'uses'=> 'Admin\TugasController@edittugas'));
	Route::put('trainer/tugas/{id}/simpanedit', array('as'=>'trainer.tugas.simpanedit', 'uses'=> 'Admin\TugasController@simpanedit'));		
	Route::get('trainer/tugas/{id}/peserta_koreksi', array('as'=>'trainer.peserta_koreksi', 'uses'=> 'Admin\TugasController@ShowPesertaKoreksiTugas'));
	Route::put('trainer/tugas/trainee/{id}/update_nilai_tugas', array('as'=>'trainer.update_nilai_tugas', 'uses'=> 'Admin\TugasController@updateNilaiTugasTrainee'));
	Route::get('trainer/message/send/{id}/edit', array('as'=>'trainer.message_edit.send', 'uses'=> 'Admin\MessageController@edit'));
	Route::post('trainer/message/sending', array('as'=>'trainer.message.sendEditedMessage', 'uses'=> 'Admin\MessageController@sendEditedMessage'));
	// Download Tugas Trainee
	Route::get('trainer/tugas/{id}/download_tugas_trainee', array('as'=>'trainer.download_tugas', 'uses'=> 'Admin\TugasController@download_tugas_trainee'));
	// Ujian 
	Route::get('trainer/ujian',array('as'=>'trainer.ujian', 'uses'=> 'Admin\UjianController@index'));
	Route::get('trainer/tambahujian', array('as'=>'trainer.tambahujian.show', 'uses'=> 'Admin\UjianController@showTambahUjian'));
	Route::post('trainer/ujian/tambah', array('as'=>'trainer.tambahujian', 'uses'=> 'Admin\UjianController@tambah'));
	Route::get('trainer/ujian/{id}/hapus', array('as'=>'trainer.hapusujian', 'uses'=> 'Admin\UjianController@hapus'));
	Route::get('trainer/ujian/{id}/edit', array('as'=>'trainer.editujian', 'uses'=> 'Admin\UjianController@editujian'));
	Route::put('trainer/ujian/{id}/simpanedit', array('as'=>'trainer.ujian.simpanedit', 'uses'=> 'Admin\UjianController@simpanedit'));
	Route::get('trainer/ujian/{id}/detail', array('as'=>'trainer.detail_ujian', 'uses'=> 'Admin\UjianController@detail'));
	Route::get('trainer/ujian_trainee/{id}/hapus', array('as'=>'trainer.hapus_ujian_trainee', 'uses'=> 'Admin\UjianController@destroy'));
	Route::get('trainer/trainee_ujian/{id}', array('as'=>'trainer.trainee_ujian.show', 'uses'=> 'Admin\TraineeJawabUjianController@show'));
	Route::get('trainer/ujian/{id}', array('as'=>'.ujian.show', 'uses'=> 'Admin\UjianController@show'));
	// Soal Ujian 
	Route::get('trainer/soal_ujian',array('as'=>'trainer.soal_ujian', 'uses'=> 'Admin\SoalUjianController@index'));
	Route::get('trainer/tambah_soal_ujian', array('as'=>'trainer.tambah_soal_ujian.show', 'uses'=> 'Admin\SoalUjianController@showTambahSoalUjian'));
	Route::post('trainer/soal_ujian/tambah', array('as'=>'trainer.tambah_soal_ujian', 'uses'=> 'Admin\SoalUjianController@tambah'));
	Route::get('trainer/soal_ujian/{id}/hapus', array('as'=>'trainer.hapus_soal_ujian', 'uses'=> 'Admin\SoalUjianController@hapus'));
	Route::get('trainer/soal_ujian/{id}/edit', array('as'=>'trainer.edit_soal_ujian', 'uses'=> 'Admin\SoalUjianController@edit'));
	Route::put('trainer/soal_ujian/{id}/simpanedit', array('as'=>'trainer.soal_ujian.simpanedit', 'uses'=> 'Admin\SoalUjianController@simpanedit'));
	Route::get('trainer/soal_ujian/{id}/detail', array('as'=>'trainer.detail_soal_ujian', 'uses'=> 'Admin\SoalUjianController@detail'));
	// Show Nilai by Departemen
	Route::get('trainer/nilai_trainee', array('as'=>'trainer.get_nilai_trainee.departemen.modul_learn', 'uses'=>'Admin\NilaiController@showDepartemenNilai'));
	Route::post('trainer/nilai_trainee', array('as'=>'trainer.post_nilai_trainee.departemen.modul_learn', 'uses'=>'Admin\NilaiController@showDepartemenNilai'));


	//trainer/trainer
	Route::get('trainer/trainer/{id}/detail', array('as'=>'trainer.detail_trainer', 'uses'=> 'Admin\TrainerController@detail_trainer'));
	Route::get('trainer/trainer/ubahpassword',array('as'=>'trainer.user.ubah_password', 'uses'=> 'AdminController@showUbahPasswordUser'));
	Route::post('trainer/trainer/simpanubahpassworduser', array('as'=>'trainer.user.simpanedit', 'uses'=> 'AdminController@simpanubahpassworduser'));
	Route::get('trainer/trainee_ujian/{id}', array('as'=>'trainer.trainee_ujian.show', 'uses'=> 'Admin\TraineeJawabUjianController@show'));
	Route::get('trainer/ujian/{id}', array('as'=>'trainee.get_ujians.show', 'uses'=> 'Admin\UjianController@show'));	
	Route::get('trainer/ujian_trainee/{id}/hapus', array('as'=>'trainer.hapus_ujian_trainee', 'uses'=> 'Admin\UjianController@destroy'));
	// profile
	Route::get('trainer/trainer/edit', array('as'=>'trainer.edittrainer', 'uses'=> 'Admin\TrainerController@edit_asTrainer'));
	Route::put('trainer/trainer/simpanedit', array('as'=>'trainer.trainer.simpanedit', 'uses'=> 'Admin\TrainerController@simpanedit_asTrainer'));

	// Form
	Route::get('trainer/forum/{id_tugas}',array('as'=>'trainer.get_forum', 'uses'=> 'Admin\ForumController@index_trainee'));	
	Route::post('trainer/forum',array('as'=>'trainer.post_forum', 'uses'=> 'Admin\ForumController@tambah'));
});

//Route as trainee
Route::group(['middleware' => ['auth','level:13']], function()    
{	
	// trainee/departemen_trainee
	Route::get('trainee/departemen_trainee',array('as'=>'trainee.departemen_trainee', 'uses'=> 'Admin\TraineeController@departemen_trainee'));
	// Materi Ajar 
	Route::get('trainee/materi_ajar',array('as'=>'trainee.materi_ajar', 'uses'=> 'Admin\MateriAjarController@index_trainee'));
	Route::get('trainee/materi_ajar/{id}/download', array('as'=>'trainee.download_materi_ajar', 'uses'=> 'Admin\MateriAjarController@download_trainee'));

	// trainee/pengumuman
	Route::get('trainee/pengumuman',array('as'=>'trainee.pengumuman', 'uses'=> 'Admin\PengumumanController@index_trainee'));
	Route::get('trainee/pengumuman/{id}/edit', array('as'=>'trainee.editpengumuman', 'uses'=> 'Admin\PengumumanController@detailpengumuman'));

	// trainee/nilai
	Route::get('trainee/nilai',array('as'=>'trainee.get_nilai', 'uses'=> 'Admin\NilaiController@showTraineeDepartemenNilai'));
	Route::post('trainee/nilai',array('as'=>'trainee.post_nilai', 'uses'=> 'Admin\NilaiController@showTraineeDepartemenNilai'));

	// trainee/tugas	
	Route::get('trainee/tugas/{id}/detail_tugas_trainee', array('as'=>'trainee.detail_tugas', 'uses'=> 'Admin\TugasController@show_detail_tugas_trainee'));
	Route::get('trainee/tugas/{id}/download_tugas_trainee', array('as'=>'trainee.download_tugas', 'uses'=> 'Admin\TugasController@download_tugas_trainee'));
	Route::post('trainee/tugas/tambah', array('as'=>'trainee.tambah.tugas', 'uses'=> 'Admin\TugasController@tambah_tugas_trainee'));
	Route::get('trainee/tugas/{id}/hapus', array('as'=>'trainee.hapusmateri_ajar', 'uses'=> 'Admin\TugasController@hapus_tugas_trainee'));
	Route::get('trainee/tugas/{id}/download', array('as'=>'trainee.tugas_download', 'uses'=> 'Admin\MateriAjarController@download_tugas_trainee'));
	Route::get('trainee/tugas',array('as'=>'trainee.tugas', 'uses'=> 'Admin\TugasController@index_trainee'));


	// trainee/ujian
	Route::get('trainee/ujian',array('as'=>'trainee.get_ujian', 'uses'=> 'Admin\UjianController@index_trainee'));	
	Route::get('trainee/ujian/{id}/detail', array('as'=>'trainee.detail_ujian', 'uses'=> 'Admin\UjianController@detail'));
	Route::post('trainee/ujian',array('as'=>'trainee.post_ujian', 'uses'=> 'Admin\UjianController@store_trainee'));
	Route::get('trainee/ujian/{id}', array('as'=>'trainee.get_ujian.show', 'uses'=> 'Admin\UjianController@show'));	
	Route::get('trainee/trainee_ujian/{id}', array('as'=>'trainee.trainee_ujian.show', 'uses'=> 'Admin\TraineeJawabUjianController@show'));	
	Route::get('trainee/ujians/{ujians}/soals/{soals}', array('as'=>'trainee.soal_ujian.show', 'uses'=> 'Admin\SoalUjianController@show'));	
	Route::put('trainee/ujians/{ujians}/soals/{soals} ', array('as'=>'trainee.soal_ujian_update.show', 'uses'=> 'Admin\SoalUjianController@update'));	

	//trainee/trainee
	Route::get('trainee/trainee/{id}/detail', array('as'=>'trainee.detailtrainee', 'uses'=> 'Admin\TraineeController@detail_trainee'));
	Route::get('trainee/trainee/ubahpassword',array('as'=>'trainee.user.ubah_password', 'uses'=> 'AdminController@showUbahPasswordUser'));
	Route::post('trainee/trainee/simpanubahpassworduser', array('as'=>'trainee.user.simpanedit', 'uses'=> 'AdminController@simpanubahpassworduser'));
	// profile
	Route::get('trainee/trainee/edit', array('as'=>'trainee.edittrainee', 'uses'=> 'Admin\TraineeController@edit_asTrainee'));
	Route::put('trainee/trainee/simpanedit', array('as'=>'trainee.trainee.simpanedit', 'uses'=> 'Admin\TraineeController@simpanedit_asTrainee'));

	// Form
	Route::get('trainee/forum/{id_tugas}',array('as'=>'trainee.forum', 'uses'=> 'Admin\ForumController@index_trainee'));	
	Route::post('trainee/forum',array('as'=>'trainee.tambah_forum', 'uses'=> 'Admin\ForumController@tambah'));

});