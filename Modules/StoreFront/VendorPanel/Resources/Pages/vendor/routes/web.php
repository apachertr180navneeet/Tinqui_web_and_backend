<?php

use Illuminate\Support\Facades\Route;
use Modules\StoreFront\VendorPanel\Http\Controllers\item\VendorItemController;
use Modules\StoreFront\VendorPanel\Http\Controllers\vendor\MyVendorController;

Route::prefix('vendor-panel/')->middleware(["vendorAccess"])->group(function () {

    Route::prefix('vendor_item')->group(function () {
        Route::controller(VendorItemController::class)->group(function () {
            Route::put('/duplicate/{item}', 'duplicateRow')->name('vendor_item.duplicate');
            Route::put('/deeplink/{item}', 'deeplink')->name('vendor_item.deeplink');
            Route::put('/', 'search')->name('vendor_item.search');
            Route::put('/screen-display-ui-setting', "screenDisplayUiStore")->name("vendor_item.screenDisplayUiSetting.store");
            // Route::post('/custom-field/image-replace/{id}', "customFieldImageReplace")->name('customField.imageReplace');
            Route::put('/status/{item}', 'statusChange')->name('vendor_item.statusChange');
            // Route::post('/upload-multi', 'uploadMulti');
            Route::post('/remove-multi', 'removeMulti')->name('vendor_item.removeMulti');

        });
    });

    Route::resource('/vendor_item', VendorItemController::class);

    Route::resource('/vendor_info', MyVendorController::class);

});

