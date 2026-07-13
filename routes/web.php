<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\QualityManualController;
use App\Http\Controllers\StandardOperatingProcedureController;
use App\Http\Controllers\LogFormController;
use App\Http\Controllers\WorkInstructionController;
use App\Http\Controllers\LaboratoryRecordController;
use App\Http\Controllers\MoistureWorksheetController;
use App\Http\Controllers\WaterQualityWorksheetController;
use App\Http\Controllers\HistamineController;
use App\Http\Controllers\ParagrossController;
use App\Http\Controllers\PCRController;
use App\Http\Controllers\WaterPotabilityController;
use App\Http\Controllers\WaterBacteriologicalController;
use App\Http\Controllers\FishFisheryController;
use App\Http\Controllers\ReagentLogbookController;
use App\Http\Controllers\SterilityCheckController;
use App\Http\Controllers\HealthCertificateController;
use App\Http\Controllers\CitizenCharterSurveyController;
use App\Http\Controllers\TextBlastController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EquipmentController;

 Route::get('/login', function () {
        if (Auth::check()) {
            return redirect()->route('Dashboard');
        }
        return view('auth.login');
        // return redirect('/homepage');
    })->name('login'); 

    Route::post('login-user',[LoginController::class,'login_user'])->name('login-user');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/Dashboard',[DashboardController::class,'Dashboard'])->name('Dashboard');
    Route::get('/kiosk',[ClientController::class,'kiosk'])->name('kiosk');
    Route::get('/kiosk-form',[ClientController::class,'kiosk_forms'])->name('kiosk-form');
    Route::post('clients.store', [ClientController::class, 'store'])->name('clients.store');
    Route::middleware('auth')->group(function () {
    Route::post('/save-settings', [UserController::class, 'UserSettings']);
    Route::get('/get-user-settings', [UserController::class, 'getSettings']);
    //System Users Information
    Route::get('/profile',[UserController::class,'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'userUpdate'])->name('profile/update');
    Route::put('user/upload/update', [UserController::class, 'imageUpdate'])->name('user/upload/update');
    Route::get('/users/index', [UserController::class, 'index'])->name('users/index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users/create');
    Route::post('users.store', [UserController::class, 'store'])->name('users.store');
    Route::get('users.edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/users.details/{id}', [UserController::class, 'show'])->name('users.details');
    Route::put('/users.update', [UserController::class, 'update'])->name('users.update');
    Route::delete('user.delete/{id}', [UserController::class, 'hardDelete'])->name('users.delete');
    //Clients Information
    
    Route::get('/clients',[ClientController::class,'index'])->name('clients');
    Route::get('/create/clients', [ClientController::class, 'create'])->name('create/clients');
  
    Route::get('clients.edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients.update', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('clients.delete/{id}', [ClientController::class, 'hardDelete'])->name('clients.delete');
    
    // Quality Manual
    Route::get('/QM/index',[QualityManualController::class,'index'])->name('QM/index');
    Route::get('/QM/QM1-00',[QualityManualController::class,'QM1-00'])->name('QM/QM1-00');
    //SOP
    Route::get('/SOP/index',[StandardOperatingProcedureController::class,'index'])->name('SOP/index');
     //Log Form
    Route::get('/LF/index',[LogFormController::class,'index'])->name('LF/index');
    Route::get('/lf_03_05',[LogFormController::class,'lf_03_05'])->name('lf_03_05');
    Route::post('/lf_03_05.store',[LogFormController::class,'store'])->name('lf_03_05.store');
    Route::get('/equipments_book.index/{id}',[LogFormController::class,'equipments'])->name('equipments_book.index');
    Route::post('/equipments_lf_03_05.store',[LogFormController::class,'equipment_store'])->name('equipments_lf_03_05.store');
    //Laboratory Record
    Route::get('/LR/index',[LaboratoryRecordController::class,'index'])->name('LR/index');
    //Work Instruction
    Route::get('/WI/index',[WorkInstructionController::class,'index'])->name('WI/index');
    //test lab
    //RLA
    Route::get('/generate-rla-no', [LogFormController::class, 'generateRlaNo'])->name('generate.rla.no');
    Route::get('/get-latest-laboratory-code', [LogFormController::class, 'getLatestLaboratoryCode'])->name('get.latest.laboratory.code');
    Route::get('/lf_06_02',[LogFormController::class,'lf_06_02'])->name('lf_06_02');
    Route::get('/get-User-info/{id}', [LogFormController::class, 'getUserInfo']);
    Route::post('/lf_06_02.store',[LogFormController::class,'lf_06_02_store'])->name('lf_06_02.store');
    Route::get('/rla/{id}/edit', [LogFormController::class, 'edit'])->name('rla.edit');
    Route::put('/rla/{id}', [LogFormController::class, 'update'])->name('rla.update');
    Route::get('/rla/{id}/download-pdf', [LogFormController::class, 'downloadPdf'])->name('rla.download.pdf');
    Route::delete('rla.delete/{id}', [LogFormController::class, 'rladelete'])->name('rla.delete');
    Route::post('/update-statusRLA/{id}', [LogFormController::class, 'updateStatusRLA'])->name('update.statusRLA');
    //Order payment
    Route::get('/lf_06_03',[LogFormController::class,'lf_06_03'])->name('lf_06_03');
    Route::get('/order/{id}/payment', [LogFormController::class, 'payment'])->name('order.payment');
    Route::post('/paymentRLAForm/{id}', [LogFormController::class, 'lf_06_03_store'])->name('lf0603.store');
    Route::get('/OrderOfPayment/{id}/download-pdf', [LogFormController::class, 'downloadPdfOP'])->name('OrderOfPayment.download.pdf');
    Route::post('/update-statusOP/{id}', [LogFormController::class, 'updateStatusOP'])->name('update.statusOP');
    //Job Routing Form
    Route::get('/lf_06_04',[LogFormController::class,'lf_06_04'])->name('lf_06_04');
    Route::get('/job/{id}/routing', [LogFormController::class, 'jobrouting'])->name('job.jobrouting');
    Route::post('/routingForm/{id}', [LogFormController::class, 'lf_06_04_store'])->name('lf0604.store');
    Route::get('/RoutingForm/{id}/download-pdf', [LogFormController::class, 'downloadPdfRoutingForm'])->name('RoutingForm.download.pdf');
    Route::post('/update-statusJRF/{id}', [LogFormController::class, 'updateStatusJRF'])->name('update.statusJRF');
    //Equipment Logbooks // note naay duplicate aning equipment usage for viewing ra
    Route::get('/equipments_usage',[LogFormController::class,'equipments_usage'])->name('equipments_usage');
    Route::post('/equipment.scan',[LogFormController::class,'scan'])
    ->name('equipment.scan');
    //Sample Disposal Logbook
    Route::get('/sample_logbook',[LogFormController::class,'sample_disposal_logbook_index'])->name('sample_logbook');
    Route::get('/create_sample_logbook', [LogFormController::class, 'sample_disposal_logbook_create'])->name('create_sample_logbook');
    Route::post('/sample.store',[LogFormController::class,'sample_disposal_logbook_store'])->name('sample.store');
    Route::get('sample.edit/{id}', [LogFormController::class, 'edit_sample'])->name('sample.edit');
    Route::put('/sample.update', [LogFormController::class, 'update_sample'])->name('sample.update');
    Route::delete('sample.delete/{id}', [LogFormController::class, 'hardDelete_sample'])->name('sample.delete');
    Route::get('/get-RLA-info/{id}', [LogFormController::class, 'getRLAInfo']);
    Route::get('/sampledisposal.download-pdf', [LogFormController::class, 'downloadPdfSample'])->name('sampledisposal.download.pdf');
    //Equipments Plan
    Route::get('/equipment_plan/index', [LogFormController::class, 'equipment_plan_index'])->name('equipment_plan.index');
    Route::get('/equipment_plan/create', [LogFormController::class, 'equipment_plan_create'])->name('equipment_plan.create');
    Route::post('/equipment_plan/store', [LogFormController::class, 'equipment_plan_store'])->name('eequipment_plan.store');

    //Environmental Plan Form
    Route::get('/environmental_plan/index', [LogFormController::class,'environmental_plan_index'])->name('environmental_plan/index');
    Route::get('/environmental_plan/create', [LogFormController::class,'environmental_plan_create'])->name('environmental_plan/create');
    Route::post('/environmental_plan/store', [LogFormController::class,'environmental_plan_store'])->name('environmental_plan.store');
    Route::get('environmental.edit/{id}', [LogFormController::class, 'edit_environmental'])->name('environmental.edit');
    Route::put('/environmental.update', [LogFormController::class, 'update_environmental'])->name('environmental.update');
    Route::delete('environmental.delete/{id}', [LogFormController::class, 'hardDelete_environmental'])->name('environmental.delete');
    Route::get('/environmental.download-pdf', [LogFormController::class, 'downloadPdfEnvironmental'])->name('environmental.download.pdf');
    //Analyst Worksheet
    Route::get('/analyst_worksheet', [LogFormController::class,'analyst_worksheet'])->name('analyst_worksheet');
    Route::get('/analysis_worksheet/create/{id}', [LogFormController::class, 'create'])->name('analysis_worksheet.create');
    // Route::get('/analysis_worksheet.create/{id}', [LogFormController::class,'analysis_worksheet_create'])->name('analysis_worksheet.create');
    Route::post('/analysis_worksheet.store/{id}', [LogFormController::class,'analysis_worksheet_store'])->name('analysis_worksheet.store');
    //CHEM- WATER QUALITY
    Route::post('/WaterQualityWorksheet.store/{id}', [WaterQualityWorksheetController::class,'WaterQualityWorksheet'])->name('WaterQualityWorksheet.store');
    //CHEM - MOISTURE
    Route::post('/moisture-worksheet/store/{id}', [MoistureWorksheetController::class, 'MoistureWorksheet'])
    ->name('MoistureWorksheet.store');
    //CHEM- HISTAMINE
    Route::post('/histamine-worksheet/store/{id}', [HistamineController::class, 'storeHistamineWorksheet'])
    ->name('histamine_worksheet.store');
    //FIS- para & gross
    Route::post('/paragross-worksheet/store/{id}', [ParagrossController::class, 'storeParagrossWorksheet'])->name('paragross_worksheet.store');
    //FIS- pcr 
    Route::post('/pcr-worksheet/store/{id}', [PCRController::class, 'storePcrWorksheet'])->name('pcr_worksheet.store');
    //Fis- Health Certificate
    Route::get('/healthcertificate/index', [HealthCertificateController::class,'healthcertificate_index'])->name('healthcertificate/index');
    Route::get('/healthcertificate/create/{id}', [HealthCertificateController::class, 'create'])->name('healthcertificate.create');
    Route::post('/healthcertificate.store', [HealthCertificateController::class, 'store'])->name('healthcertificate.store');
    Route::get('/HC.download.pdf/{id}', [HealthCertificateController::class, 'downloadPdfHC'])->name('HC.download.pdf');
    //Micro- Water Potability
    Route::post('/water-potability-worksheet/store/{id}', [WaterPotabilityController::class, 'storeWaterPotabilityWorksheet'])->name('water_potability_worksheet.store');
    //Micro- Water Bacteriological
    Route::post('/water-bacteriology-worksheet/store/{id}', [WaterBacteriologicalController::class, 'storeWaterBacteriologyWorksheet'])->name('water_bacteriology_worksheet.store');
    //Micro - Fish and Fishery Products
    Route::post('/fish-fishery-worksheet/store/{id}', [FishFisheryController::class, 'storeFishFisheryWorksheet'])->name('fish_fishery_worksheet.store');
    Route::get('/analysis.download.pdf/{id}', [LogFormController::class, 'downloadPdfAnalysis'])->name('analysis.download.pdf');
    //Micro - Reagent Logbook 
    Route::get('/reagent-media-logbook', [ReagentLogbookController::class, 'reagentMediaLogbook'])->name('reagent_media_logbook.create');
    Route::post('/reagent-media-logbook/store', [ReagentLogbookController::class, 'storeReagentMediaLogbook'])->name('reagent_media_logbook.store');
    //Micro - Sterility Check
    Route::get('/sterility-check', [SterilityCheckController::class, 'sterilityCheck'])->name('sterility_check.create');
    Route::post('/sterility-check/store', [SterilityCheckController::class, 'storeSterilityCheck'])->name('sterility_check.store');
    //Update status for worksheet
    Route::post('/update-statusAW/{id}', [LogFormController::class, 'updateStatusAW'])->name('update.statusAW');
    //Releasing &Receiving
    Route::get('/releasing/index', [LogFormController::class,'releasing'])->name('releasing/index');
    Route::get('/releasing.download-pdf', [LogFormController::class, 'downloadPdfReleasing'])->name('releasing.download.pdf');
    //Report Test
    Route::get('/reporttest/index', [LogFormController::class,'ReportTest'])->name('reporttest/index');
    Route::get('/Reporttest/download/pdf/{id}', [LogFormController::class, 'ReportTestdownloadPdf'])->name('Reporttest.download.pdf');
    //Text Blast
    Route::get('/text_blast',[TextBlastController::class,'index'])->name('text_blast');
//Equipments
    Route::get('/equipments',[EquipmentController::class,'index'])->name('equipments.index');
    Route::get('/equipments/reports',[EquipmentController::class,'reports'])->name('equipments.reports');
    Route::get('/equipments/export',[EquipmentController::class,'export'])->name('equipments.export');
    Route::get('/equipments/create',[EquipmentController::class,'create'])->name('equipments.create');
    Route::post('/equipments',[EquipmentController::class,'store'])->name('equipments.store');
    Route::get('/equipments/{id}/edit',[EquipmentController::class,'edit'])->name('equipments.edit');
    Route::put('/equipments/{id}',[EquipmentController::class,'update'])->name('equipments.update');
    Route::delete('/equipments/{id}',[EquipmentController::class,'destroy'])->name('equipments.destroy');
    Route::get('/api/equipments/search',[EquipmentController::class,'searchEquipment'])->name('api.equipments.search');
    Route::get('/api/equipments/{id}/details',[EquipmentController::class,'getEquipmentDetails'])->name('api.equipments.details');
    Route::get('/api/users/search',[EquipmentController::class,'getUsers'])->name('api.users.search');
     //Text Blast
    Route::get('/payments.reports',[ReportController::class,'payments'])->name('payments.reports');
    Route::get('/customers.reports',[ReportController::class,'customers'])->name('customers.reports');
 });
    //ARTA SURVEY
    Route::get('/arta.create', [CitizenCharterSurveyController::class, 'arta'])->name('arta.create');
    Route::get('/citizen-charter-survey', [CitizenCharterSurveyController::class, 'index'])->name('citizen-charter-survey.index');
    Route::get('/citizen-charter-survey/create', [CitizenCharterSurveyController::class, 'create'])->name('citizen-charter-survey.create');
    Route::post('/citizen-charter-survey/store', [CitizenCharterSurveyController::class, 'store'])->name('citizen-charter-survey.store');
    Route::get('/citizen-charter-survey/edit/{id}', [CitizenCharterSurveyController::class, 'edit'])->name('citizen-charter-survey.edit');
    Route::post('/citizen-charter-survey/update/{id}', [CitizenCharterSurveyController::class, 'update'])->name('citizen-charter-survey.update');
    Route::delete('/citizen-charter-survey/delete/{id}', [CitizenCharterSurveyController::class, 'destroy'])->name('citizen-charter-survey.destroy');
    Route::get('/citizen-charter-survey/download/{id}', [CitizenCharterSurveyController::class, 'download'])->name('citizen-charter-survey.download');
