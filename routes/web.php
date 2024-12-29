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

	// Modul Menu 
	Route::get('admin/materi_modul',array('as'=>'admin.materi_modul', 'uses'=> 'Admin\MateriModulController@index'));
	Route::get('admin/tambahmateri_modul', array('as'=>'admin.tambahmateri_modul.show', 'uses'=> 'Admin\MateriModulController@showTambahMateriModul'));
	Route::post('admin/materi_modul/tambah', array('as'=>'admin.tambahmateri_modul', 'uses'=> 'Admin\MateriModulController@tambah'));
	Route::get('admin/materi_modul/{id}/hapus', array('as'=>'admin.hapusmateri_modul', 'uses'=> 'Admin\MateriModulController@hapus'));
	Route::get('admin/materi_modul/{id}/edit', array('as'=>'admin.editmateri_modul', 'uses'=> 'Admin\MateriModulController@editmateri_modul'));
	Route::put('admin/materi_modul/{id}/simpanedit', array('as'=>'admin.materi_modul.simpanedit', 'uses'=> 'Admin\MateriModulController@simpanedit'));
	Route::get('admin/materi_modul/{id}/download', array('as'=>'admin.download_materi_modul', 'uses'=> 'Admin\MateriModulController@download'));

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

	// Quiz 
	Route::get('admin/quiz',array('as'=>'admin.quiz', 'uses'=> 'Admin\QuizController@index'));
	Route::get('admin/tambahquiz', array('as'=>'admin.tambahquiz.show', 'uses'=> 'Admin\QuizController@showTambahQuiz'));
	Route::post('admin/quiz/tambah', array('as'=>'admin.tambahquiz', 'uses'=> 'Admin\QuizController@tambah'));
	Route::get('admin/quiz/{id}/hapus', array('as'=>'admin.hapusquiz', 'uses'=> 'Admin\QuizController@hapus'));
	Route::get('admin/quiz/{id}/edit', array('as'=>'admin.editquiz', 'uses'=> 'Admin\QuizController@editquiz'));
	Route::put('admin/quiz/{id}/simpanedit', array('as'=>'admin.quiz.simpanedit', 'uses'=> 'Admin\QuizController@simpanedit'));
	Route::get('admin/quiz/{id}/detail', array('as'=>'admin.detail_quiz', 'uses'=> 'Admin\QuizController@detail'));
	Route::get('admin/quiz_trainee/{id}/hapus', array('as'=>'admin.hapus_quiz_trainee', 'uses'=> 'Admin\QuizController@destroy'));
	Route::get('admin/trainee_quiz/{id}', array('as'=>'admin.trainee_quiz.show', 'uses'=> 'Admin\TraineeJawabQuizController@show'));
	Route::get('admin/quiz/{id}', array('as'=>'.quiz.show', 'uses'=> 'Admin\QuizController@show'));

	// Soal Quiz 
	Route::get('admin/soal_quiz',array('as'=>'admin.soal_quiz', 'uses'=> 'Admin\SoalQuizController@index'));
	Route::get('admin/tambah_soal_quiz', array('as'=>'admin.tambah_soal_quiz.show', 'uses'=> 'Admin\SoalQuizController@showTambahSoalQuiz'));
	Route::post('admin/soal_quiz/tambah', array('as'=>'admin.tambah_soal_quiz', 'uses'=> 'Admin\SoalQuizController@tambah'));
	Route::get('admin/soal_quiz/{id}/hapus', array('as'=>'admin.hapus_soal_quiz', 'uses'=> 'Admin\SoalQuizController@hapus'));
	Route::get('admin/soal_quiz/{id}/edit', array('as'=>'admin.edit_soal_quiz', 'uses'=> 'Admin\SoalQuizController@edit'));
	Route::put('admin/soal_quiz/{id}/simpanedit', array('as'=>'admin.soal_quiz.simpanedit', 'uses'=> 'Admin\SoalQuizController@simpanedit'));
	Route::get('admin/soal_quiz/{id}/detail', array('as'=>'admin.detail_soal_quiz', 'uses'=> 'Admin\SoalQuizController@detail'));
	
	// Show Nilai by Departemen
	Route::get('admin/nilai_trainee', array('as'=>'admin.get_nilai_trainee.departemen.modul_learn', 'uses'=>'Admin\NilaiController@showDepartemenNilai'));
	Route::post('admin/nilai_trainee', array('as'=>'admin.post_nilai_trainee.departemen.modul_learn', 'uses'=>'Admin\NilaiController@showDepartemenNilai'));

	Route::get('admin/nilai_quiz',array('as'=>'admin.nilai_quiz', 'uses'=> 'Admin\NilaiQuizController@index'));
	Route::get('admin/tambahnilai_quiz', array('as'=>'admin.tambahnilai_quiz.show', 'uses'=> 'Admin\NilaiQuizController@showTambahNilaiQuiz'));
	Route::post('admin/nilai_quiz/tambah', array('as'=>'admin.tambahnilai_quiz', 'uses'=> 'Admin\NilaiQuizController@tambah'));
	Route::get('admin/nilai_quiz/{id}/hapus', array('as'=>'admin.hapusnilai_quiz', 'uses'=> 'Admin\NilaiQuizController@hapus'));
	Route::get('admin/nilai_quiz/{id}/edit', array('as'=>'admin.editnilai_quiz', 'uses'=> 'Admin\NilaiQuizController@editnilai_quiz'));
	Route::put('admin/nilai_quiz/{id}/simpanedit', array('as'=>'admin.nilai_quiz.simpanedit', 'uses'=> 'Admin\NilaiQuizController@simpanedit'));

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
	// Modul Menu 
	Route::get('trainer/materi_modul',array('as'=>'trainer.materi_modul', 'uses'=> 'Admin\MateriModulController@index_trainer'));
	Route::get('trainer/tambahmateri_modul', array('as'=>'trainer.tambahmateri_modul.show', 'uses'=> 'Admin\MateriModulController@showTambahMateriModul_trainer'));
	Route::post('trainer/materi_modul/tambah', array('as'=>'trainer.tambahmateri_modul', 'uses'=> 'Admin\MateriModulController@tambah_trainer'));
	Route::get('trainer/materi_modul/{id}/hapus', array('as'=>'trainer.hapusmateri_modul', 'uses'=> 'Admin\MateriModulController@hapus_trainer'));
	Route::get('trainer/materi_modul/{id}/edit', array('as'=>'trainer.editmateri_modul', 'uses'=> 'Admin\MateriModulController@editmateri_modul_trainer'));
	Route::put('trainer/materi_modul/{id}/simpanedit', array('as'=>'trainer.materi_modul.simpanedit', 'uses'=> 'Admin\MateriModulController@simpanedit_trainer'));
	Route::get('trainer/materi_modul/{id}/download', array('as'=>'trainer.download_materi_modul', 'uses'=> 'Admin\MateriModulController@download_trainer'));	
	// Tugas 	
	Route::get('trainer/tugas', array('as'=>'trainer.tugas', 'uses'=> 'Admin\TugasController@index_trainer'));
	Route::get('trainer/tambahtugas', array('as'=>'trainer.tambahtugas.show', 'uses'=> 'Admin\TugasController@showTambahTugas'));
	Route::post('trainer/tugas/tambah', array('as'=>'trainer.tambahtugas', 'uses'=> 'Admin\TugasController@tambah'));
	Route::get('trainer/tugas/{id}/hapus', array('as'=>'trainer.hapustugas', 'uses'=> 'Admin\TugasController@hapus'));
	Route::get('trainer/tugas/{id}/edit', array('as'=>'trainer.edittugas', 'uses'=> 'Admin\TugasController@edittugas'));
	Route::put('trainer/tugas/{id}/simpanedit', array('as'=>'trainer.tugas.simpanedit', 'uses'=> 'Admin\TugasController@simpanedit'));		
	Route::get('trainer/tugas/{id}/peserta_koreksi', array('as'=>'trainer.peserta_koreksi', 'uses'=> 'Admin\TugasController@ShowPesertaKoreksiTugas'));
	Route::put('trainer/tugas/trainee/{id}/update_nilai_tugas', array('as'=>'trainer.update_nilai_tugas', 'uses'=> 'Admin\TugasController@updateNilaiTugasTrainee'));
	Route::get('trainer/message/send',array('as'=>'trainer.message.form', 'uses'=> 'Admin\MessageController@form'));		
	Route::get('trainer/message/send/{id}/edit', array('as'=>'trainer.message_edit.send', 'uses'=> 'Admin\MessageController@edit'));
	Route::post('trainer/message/sending', array('as'=>'trainer.message.sendEditedMessage', 'uses'=> 'Admin\MessageController@sendEditedMessage'));
	// Download Tugas Trainee
	Route::get('trainer/tugas/{id}/download_tugas_trainee', array('as'=>'trainer.download_tugas', 'uses'=> 'Admin\TugasController@download_tugas_trainee'));
	// Quiz 
	Route::get('trainer/quiz',array('as'=>'trainer.quiz', 'uses'=> 'Admin\QuizController@index'));
	Route::get('trainer/tambahquiz', array('as'=>'trainer.tambahquiz.show', 'uses'=> 'Admin\QuizController@showTambahQuiz'));
	Route::post('trainer/quiz/tambah', array('as'=>'trainer.tambahquiz', 'uses'=> 'Admin\QuizController@tambah'));
	Route::get('trainer/quiz/{id}/hapus', array('as'=>'trainer.hapusquiz', 'uses'=> 'Admin\QuizController@hapus'));
	Route::get('trainer/quiz/{id}/edit', array('as'=>'trainer.editquiz', 'uses'=> 'Admin\QuizController@editquiz'));
	Route::put('trainer/quiz/{id}/simpanedit', array('as'=>'trainer.quiz.simpanedit', 'uses'=> 'Admin\QuizController@simpanedit'));
	Route::get('trainer/quiz/{id}/detail', array('as'=>'trainer.detail_quiz', 'uses'=> 'Admin\QuizController@detail'));
	Route::get('trainer/quiz_trainee/{id}/hapus', array('as'=>'trainer.hapus_quiz_trainee', 'uses'=> 'Admin\QuizController@destroy'));
	Route::get('trainer/trainee_quiz/{id}', array('as'=>'trainer.trainee_quiz.show', 'uses'=> 'Admin\TraineeJawabQuizController@show'));
	Route::get('trainer/quiz/{id}', array('as'=>'.quiz.show', 'uses'=> 'Admin\QuizController@show'));
	// Soal Quiz 
	Route::get('trainer/soal_quiz',array('as'=>'trainer.soal_quiz', 'uses'=> 'Admin\SoalQuizController@index'));
	Route::get('trainer/tambah_soal_quiz', array('as'=>'trainer.tambah_soal_quiz.show', 'uses'=> 'Admin\SoalQuizController@showTambahSoalQuiz'));
	Route::post('trainer/soal_quiz/tambah', array('as'=>'trainer.tambah_soal_quiz', 'uses'=> 'Admin\SoalQuizController@tambah'));
	Route::get('trainer/soal_quiz/{id}/hapus', array('as'=>'trainer.hapus_soal_quiz', 'uses'=> 'Admin\SoalQuizController@hapus'));
	Route::get('trainer/soal_quiz/{id}/edit', array('as'=>'trainer.edit_soal_quiz', 'uses'=> 'Admin\SoalQuizController@edit'));
	Route::put('trainer/soal_quiz/{id}/simpanedit', array('as'=>'trainer.soal_quiz.simpanedit', 'uses'=> 'Admin\SoalQuizController@simpanedit'));
	Route::get('trainer/soal_quiz/{id}/detail', array('as'=>'trainer.detail_soal_quiz', 'uses'=> 'Admin\SoalQuizController@detail_trainer'));
	// Show Nilai by Departemen
	Route::get('trainer/nilai_trainee', array('as'=>'trainer.get_nilai_trainee.departemen.modul_learn', 'uses'=>'Admin\NilaiController@showDepartemenNilai'));
	Route::post('trainer/nilai_trainee', array('as'=>'trainer.post_nilai_trainee.departemen.modul_learn', 'uses'=>'Admin\NilaiController@showDepartemenNilai'));


	//trainer/trainer
	Route::get('trainer/trainer/{id}/detail', array('as'=>'trainer.detail_trainer', 'uses'=> 'Admin\TrainerController@detail_trainer'));
	Route::get('trainer/trainer/ubahpassword',array('as'=>'trainer.user.ubah_password', 'uses'=> 'AdminController@showUbahPasswordUser'));
	Route::post('trainer/trainer/simpanubahpassworduser', array('as'=>'trainer.user.simpanedit', 'uses'=> 'AdminController@simpanubahpassworduser'));
	Route::get('trainer/trainee_quiz/{id}', array('as'=>'trainer.trainee_quiz.show', 'uses'=> 'Admin\TraineeJawabQuizController@show'));
	Route::get('trainer/quiz/{id}', array('as'=>'trainee.get_quizs.show', 'uses'=> 'Admin\QuizController@show'));	
	Route::get('trainer/quiz_trainee/{id}/hapus', array('as'=>'trainer.hapus_quiz_trainee', 'uses'=> 'Admin\QuizController@destroy'));
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
	// Modul Menu 
	Route::get('trainee/materi_modul',array('as'=>'trainee.materi_modul', 'uses'=> 'Admin\MateriModulController@index_trainee'));
	Route::get('trainee/materi_modul/{id}/download', array('as'=>'trainee.download_materi_modul', 'uses'=> 'Admin\MateriModulController@download_trainee'));

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
	Route::get('trainee/tugas/{id}/hapus', array('as'=>'trainee.hapusmateri_modul', 'uses'=> 'Admin\TugasController@hapus_tugas_trainee'));
	Route::get('trainee/tugas/{id}/download', array('as'=>'trainee.tugas_download', 'uses'=> 'Admin\MateriModulController@download_tugas_trainee'));
	Route::get('trainee/tugas',array('as'=>'trainee.tugas', 'uses'=> 'Admin\TugasController@index_trainee'));


	// trainee/quiz
	Route::get('trainee/quiz',array('as'=>'trainee.get_quiz', 'uses'=> 'Admin\QuizController@index_trainee'));	
	Route::get('trainee/quiz/{id}/detail', array('as'=>'trainee.detail_quiz', 'uses'=> 'Admin\QuizController@detail'));
	Route::post('trainee/quiz',array('as'=>'trainee.post_quiz', 'uses'=> 'Admin\QuizController@store_trainee'));
	Route::get('trainee/quiz/{id}', array('as'=>'trainee.get_quiz.show', 'uses'=> 'Admin\QuizController@show'));	
	Route::get('trainee/trainee_quiz/{id}', array('as'=>'trainee.trainee_quiz.show', 'uses'=> 'Admin\TraineeJawabQuizController@show'));	
	Route::get('trainee/quizs/{quizs}/soals/{soals}', array('as'=>'trainee.soal_quiz.show', 'uses'=> 'Admin\SoalQuizController@show'));	
	Route::put('trainee/quizs/{quizs}/soals/{soals} ', array('as'=>'trainee.soal_quiz_update.show', 'uses'=> 'Admin\SoalQuizController@update'));	

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