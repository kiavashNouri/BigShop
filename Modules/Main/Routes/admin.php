<?php

Route::get('/modules',[\Modules\Main\Http\Controllers\Admin\ModuleController::class,'index'])->name('modules.index');
Route::patch('/modules/{module}/dissble',[\Modules\Main\Http\Controllers\Admin\ModuleController::class,'disable'])->name('modules.disable');
Route::patch('/modules/{module}/enable',[\Modules\Main\Http\Controllers\Admin\ModuleController::class,'enable'])->name('modules.enable');
