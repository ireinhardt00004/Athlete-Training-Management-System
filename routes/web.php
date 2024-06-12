<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\vendor\Chatify\MessenggerController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChecklistResponseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ConcernController;
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
    //CHECK DATABASE CONNECTION
    Route::get('/test-db-connection', function () {
            try {
                DB::connection()->getPdo();
                return "Database connection established!";
            } catch (\Exception $e) {
                return "Could not connect to the database. Error: " . $e->getMessage();
            }
        });    
    Route::get('/', function () {
        return view('home');
    });
    //contact us
    Route::post('/submit-concern', [ConcernController::class, 'store'])->name('submit-concern');
      Route::get('/pre', function () {
        return view('preloader');
    });

Route::middleware(['auth'])->group(function () {
    
    // Dashboard Route
    //Route::get('/dashboard', function () {
    //    return view('app.index');
    //});
     //Route::get('/404', function () {
     //   return view('errors.404');
   // });
    
    //EVENT
    Route::get('/calendar/{sport_id}',[EventController::class,'index'])->name('event.index');
    Route::post('/calendar-post/{sport_id}',[EventController::class,'store'])->name('event.store');
    // Define a route for deleting events by ID
    Route::post('/event-delete', [EventController::class, 'destroy'])->name('events.destroy');
    
    //ACTIVITY LOGS
    Route::get('activity-logs',[ActivityLogController::class,'index'])->name('logs.index');
    Route::delete('clearall-logs',[ActivityLogController::class,'clearAll'])->name('clearall.log');
    Route::delete('/delete-log/{id}',  [ActivityLogController::class, 'delete'])->name('delete.log');
    Route::get('/export-logs', [ActivityLogController::class, 'exportLogs'])->name('export.logs');


    // Edit Profile (provided by Breeze)
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    

    //DASHBOARD FOR CLASS
    Route::get('/class/{sport_id}',[ClassController::class,'index'])->name('class-page');
    //Material page 
    Route::get('/material/{id}', [ClassController::class, 'fetchClassPage'])->name('material.page');

    Route::get('list-athlete/{id}',[CoachController::class,'athleteList'])->name('athletelist');
    //CHECKLIST
    Route::get('/checklist/{id}',[ChecklistController::class,'index'])->name('checklists.index');
    Route::post('/checklist-create/{id}',[ChecklistController::class,'save'])->name('checklists.create');
    Route::get('/checklist-details/{logId}', [ChecklistController::class, 'fetchChecklistedit']);
        Route::put('/checklist-update',[ChecklistController::class, 'update'])->name('checklist-updates');
    Route::delete('/checklist-delete/{id}',[ChecklistController::class,'delete'])->name('delete.checklist');

    //INSIDE OF CHECKLIST
    Route::get('/checklist-form/{id}',[ChecklistController::class,'editIndex'])->name('checklist-page');
    //checklist form for athlete
    Route::get('/checklist-fetch/{id}',[ChecklistResponseController::class,'fetchFormforUsers'])->name('checklistform-fetchpage');
    //submit form route for athlete
    Route::post('/checklist-submit/{id}',[ChecklistResponseController::class,'submitForm'])->name('submit-checklist');

    //save checklist by coach
    Route::post('/checklistfield-store/{id}', [ChecklistController::class, 'store'])->name('checklists.store');
    Route::delete('/reset-form/{id}',[ChecklistController::class,'resetForm'])->name('reset.checklistform');
    Route::post('/save-form/{id}',[ChecklistController::class,'saveChecklistForm'])->name('save.checklistform');

    //MY PROFILE
    Route::get('/my-profile/{id}',[UserController::class,'userProfile'])->name('my-profile');
    //fetch bdate using ajax
    Route::get('/fetchUserData', [UserController::class,'fetchUserData'])->name('fetchUserData');
});

//ADMIN ONLY ROUTE
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.index');
    //add sport
    Route::post('/add-sport',[AdminController::class,'addSport'])->name('add.sport');
    //fetch sport
    Route::get('/get-sport-details', [AdminController::class, 'getSportDetails']);
    //edit sport 
    Route::put('/update-sport-details', [AdminController::class, 'editSport'])->name('update.sport');
    //delete sport
    Route::post('/delete-sport/{sportId}',[AdminController::class,'deleteSport'])->name('delete.sport');

    //add coach
    Route::get('/coach-list', [AdminController::class, 'coachIndex'])->name('coachz.index');
    Route::post('/add-coach', [AdminController::class, 'addCoach'])->name('add.coach');
    Route::delete('/delete-coach/{id}',  [AdminController::class, 'deleteCoach'])->name('delete.coach');
    Route::delete('/remove-coach/{id}',  [AdminController::class, 'removeCoach'])->name('remove.coach');
    Route::get('/export-coaches', [AdminController::class,'exportCoaches'])->name('export.coaches');

    //users logs
    //ACTIVITY LOGS
    Route::get('user-logs',[ActivityLogController::class,'adminIndex'])->name('logs.admin');

    //add athlete
   Route::get('/athlete-list', [AdminController::class, 'indexAthlete'])->name('athlete.index');
   Route::post('/add-athlete', [AdminController::class, 'addAthlete'])->name('add.athlete');
   Route::get('/get-coaches', [AdminController::class,'getCoaches']);
   Route::delete('/delete-athlete/{id}',  [AdminController::class, 'deleteAthlete'])->name('delete.athlete');
   Route::get('/export-athletes', [AdminController::class,'exportAthletes'])->name('export.athletes');


   Route::get('/calendar',[EventController::class,'adminIndex'])->name('event.adminindex');
   Route::post('/admincalendar-post',[EventController::class,'adminStore'])->name('event.adminpost');
   //edit user credential
   Route::put('/edit-credentials/{id}',[AdminController::class,'updateUserCredentials'])->name('edit-usercredentials'); 
   Route::put('/edit-coach-credentials/{id}',[AdminController::class,'updatecoachCredentials'])->name('edit-coachcredentials'); 

   //add admin
     Route::get('/add-admin',[AdminController::class,'adminIndex'])->name('add.adminindex'); 
     Route::post('/store-admin',[AdminController::class,'addAdmin'])->name('add.admin');
     Route::delete('/delete-admin/{id}',  [AdminController::class, 'deleteAdmin'])->name('delete.admin');
     Route::get('/export-admins', [AdminController::class,'exportAdmins'])->name('export.admins');
     //export users logs
    Route::get('/export-user-logs', [ActivityLogController::class, 'exportUsersLogs'])->name('export.userlogs');
    //clear cache
    Route::get('/clear-cache', [AdminController::class, 'clearCache'])->name('clearCache');
    //concern form
    Route::get('/contact/us/',[ConcernController::class,'getConcern'])->name('contact-us.admin');
    Route::match(['get', 'post'],'/contact-us/reply',[ConcernController::class,'sendReply'])->name('contact-us-reply');
    Route::get('/fetch-concern/{id}', [ConcernController::class,'fetchConcern'])->name('fetch-concern');
    Route::post('/clear-all/concern/', [ConcernController::class,'deleteAll'])->name('contact-clearlogz');  
    Route::get('/download-concern', [ConcernController::class, 'downloadCSV'])->name('download-concern');  
    Route::delete('/delete-concern', [ConcernController:: class, 'deleteConcern'])->name('contact-deletez');  

});

//USER ONLY ROUTE
Route::middleware(['auth', 'user'])->group(function () {
    
    Route::get('/dashboard',[AthleteController::class,'index'])->name('user.index');
    Route::get('/class-sport/{sport_id}',[UserController::class,'index'])->name('sport-page');

    Route::post('/user-store/{id}',[UserController::class,'storeUserData'])->name('athlete-credentials');
    Route::get('/coach-credentialz/{coach_id}', [ClassController::class, 'coachProfile'])->name('coachcred-page');
});

//COACH ONLY ROUTE
Route::middleware(['auth', 'coach'])->group(function () {
  
    Route::get('/coach-dashboard', [CoachController::class,'index'])->name('coach.index');
    Route::post('/change-cover/{id}',[ClassController::class,'customCover'])->name('custom.class');
    Route::get('/stats/{id}', [ChecklistResponseController::class,'processedData'])->name('stats.index');
      //post materials
    Route::post('/store-materials', [MaterialController::class, 'store'])->name('store-materials');
    Route::delete('/delete-material',[MaterialController::class,'deleteMaterial'])->name('material.delete');
    //Ajax request to fetch material details
    Route::get('/materials/{id}/edit', [MaterialController::class,'edit']);
    //update material or content
    Route::put('/update-material',[MaterialController::class,'update'])->name('material.update');
    //fetch the user who fill up the forms
    Route::get('/fetch-checklist-table/{id}',[ChecklistResponseController::class,'getFormSubmittor'])->name('response-from-user');
    //rate coach and mark as done task
    Route::post('/rate/{id}', [RatingController::class, 'rating'])->name('rate-task');
    Route::post('/mark-as-done/{id}',[RatingController::class,'markAsDone'])->name('mark-as-done');

    //ADD ATHLETE
    Route::post('/register-athlete', [CoachController::class, 'addAthlete'])->name('register.athlete');
    //delete athlete
    Route::delete('/delete-athlete-account/{id}',  [CoachController::class, 'deleteAthlete'])->name('delete.athleteAccount');
    //coach profile
    Route::get('/coach-profile',[CoachController::class, 'coachProfile'])->name('coach.profile');
    //save coach credentials
    Route::post('/coach-credentials/{id}', [CoachController::class, 'updateCredentials'])->name('coach-credentials');
    //delete credential
    Route::delete('/credentials/{id}', [CoachController::class, 'destroyCred'])->name('credentials.destroy');
    

});

        


require __DIR__.'/auth.php';
