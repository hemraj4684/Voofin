<?php

//binding Repo
App::bind('Repository\UserInterface', 'Repository\Eloquent\UserRepo');
App::bind('Repository\BankInterface', 'Repository\Eloquent\BankRepo');
App::bind('Repository\RoleInterface', 'Repository\Eloquent\RoleRepo');
App::bind('Repository\CompanyInterface', 'Repository\Eloquent\CompanyRepo');
App::bind('Repository\BandInterface', 'Repository\Eloquent\BandRepo');
App::bind('Repository\BuyerInterface', 'Repository\Eloquent\BuyerRepo');
App::bind('Repository\SellerInterface', 'Repository\Eloquent\SellerRepo');
App::bind('Repository\PaymentInstructionInterface', 'Repository\Eloquent\PiRepo');
App::bind('Repository\RevenueInterface', 'Repository\Eloquent\RevenueRepo');
App::bind('Repository\NotificationInterface', 'Repository\Eloquent\NotificationRepo');
App::bind('Repository\ChatInterface', 'Repository\Eloquent\ChatRepo');
App::bind('Repository\FundingInterface', 'Repository\Eloquent\FundingRepo');
App::bind('Repository\InvoiceInterface', 'Repository\Eloquent\InvoiceRepo');
App::bind('Repository\POInterface', 'Repository\Eloquent\PORepo');
App::bind('Repository\ReportInterface', 'Repository\Eloquent\ReportRepo');

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return redirect()->intended('/auth/login');
});
Route::get('/login', function () {
    return redirect()->intended('/auth/login');
});
Route::get('/editProfile', function () {
    return view('editProfile.editProfile');
})->name('company.editProfile.view');

//bank routes
Route::group(['middleware' => 'auth', 'prefix' => 'bank'], function () {
    Route::group(['namespace' => 'Bank'], function () {
        Route::group(['middleware' => 'ACL'], function () {
            Route::get('/dashboard', 'BankDashboardController@index')->name('bank.dashboard.view');
            Route::get('/role', 'BankRoleController@index')->name('bank.role.view');
            Route::get('/role/add', 'BankRoleController@create')->name('bank.role.add');
            Route::get('/role/edit/{id}', 'BankRoleController@edit')->name('bank.role.edit');
            Route::post('/role/save', 'BankRoleController@store')->name('bank.role.save');

            //permision
            Route::get('/permission', 'BankRoleController@p_index')->name('bank.permission.view');
            Route::get('/permission/sync', 'BankRoleController@syncRolePermission')->name('bank.permission.sync');
            Route::get('/permission/add', 'BankRoleController@p_create')->name('bank.permission.add');
            Route::get('/permission/edit/{id}', 'BankRoleController@p_edit')->name('bank.permission.edit');
            Route::post('/permission/save', 'BankRoleController@p_store')->name('bank.permission.save');

            //naviagtion
            Route::get('/navigation', 'BankRoleController@n_index')->name('navigationListing');
            Route::get('/navigation/add', 'BankRoleController@n_create')->name('manageNavigation');
            Route::get('/navigation/edit/{id}', 'BankRoleController@n_edit')->name('manageNavigationById');
            Route::post('/bank/navigation/save', 'BankRoleController@n_store')->name('manageNavigation');

            //bank user route
            Route::get('/user', 'BankUserController@index')->name('bank.user.view');
            Route::get('/user/add', 'BankUserController@create')->name('bank.user.add');
            Route::get('/user/edit/{id}', 'BankUserController@edit')->name('bank.user.edit');
            Route::post('/user/save', 'BankUserController@store')->name('bank.user.save');
            Route::post('/user/updatepassword', 'BankUserController@updatePassword')->name('bank.user.updatePassword');
            Route::get('/user/resetPassword', function () {
                return view('bank.user.resetPassword');
            })->name('bank.user.resetPassword');
            Route::get('/user/change/status', 'BankUserController@changeStatus')->name('bank.user.edit.status');

            //company route
            Route::get('/company/user/{id}', 'BankUserController@index')->name('bank.company.user.view');
            Route::get('/company', 'BankCompanyController@index')->name('bank.company.view');
            Route::get('/company/add', 'BankCompanyController@create')->name('bank.company.add');
            Route::get('/company/edit/{id}', 'BankCompanyController@edit')->name('bank.company.edit');
            Route::post('/company/save', 'BankCompanyController@store')->name('bank.company.save');
            Route::get('/company/change/status', 'BankCompanyController@changeStatus')->name('company.edit.status');



            //Bands route
            Route::get('/band', 'BankBandController@index')->name('bank.band.view');
            Route::get('/band/add', 'BankBandController@create')->name('bank.band.add');
            Route::post('/band/save', 'BankBandController@store')->name('bank.band.save');
            Route::get('/band/edit/{id}', 'BankBandController@edit')->name('bank.band.edit');
            Route::post('/band/update/{id}', 'BankBandController@update')->name('bank.band.update');




            //******************basic master routes used by Deepak**************************************************//
            Route::get('/country', function () {
                return view('bank.country.bank_country');
            })->name('bank.country.view');

            Route::get('/state', function () {
                return view('bank.state.bank_state');
            })->name('bank.state.view');
            //djn route for bank configurations
            Route::get('/configurations', 'BankConfigurationController@index')->name('bank.configurations.view');
            //djn post for bank configuration
            Route::post('/bankconfigurationsave', 'BankConfigurationController@store')->name('bank.configurations.save');
            //djn get route for bandmappingview
            Route::get('/band/bandMapping', 'BankBandController@bandmappingview')->name('bank.band.bandMapping.view');
            Route::post('/band/bandMappingSave', 'BankBandController@savebandmapping')->name('bank.band.bandMapping.save');
            //route to display the band mapping
            Route::post('/band/bandmappingdisplay', 'BankBandController@bandmappingdisplay')->name('bank.band.bandmapping.display');
            //route to display the fundinglimits 

            Route::get('/fundingLimits', 'BankFundingLimitsController@index')->name('bank.fundingLimits.view');
            //route to save the funding limits

            Route::post('/fundinglimitssave', 'BankFundingLimitsController@store')->name('bank.fundingLimits.save');
            // Route::get('/fundinglimit/getcurrentvalue','BankFundingLimitsController@show')->name('bank.fundingLimits.current_exposure');
            //route to display revenue share map
            Route::get('/revenueSharing', 'BankRevenueController@index')->name('bank.revenueSharing.view');
            //route to save revenue share map
            Route::post('/revenuesharing/save', 'BankRevenueController@revenue_share_save')->name('bank.revenueSharing.save');


            Route::get('/discountingRequest', 'BankDiscountingRequestController@index')->name('bank.discountingRequest.view');

            //if(\Entrust::can('bank.iDiscounting.makerGetApprove'))
            Route::post('/iDiscounting/makerApprove', 'BankDiscountingRequestController@postApprove')->name('bank.iDiscounting.makerPostApprove');
            Route::post('/iDiscounting/checkerApprove', 'BankDiscountingRequestController@postApprove')->name('bank.iDiscounting.postApprove');


            Route::get('/bankLoan', function () {
                return view('bank.reports.bankLoanListing');
            })->name('bank.reports.bankLoanListing.view');

            Route::get('/maturingLoans', function () {
                return view('bank.reports.maturingLoansListing');
            })->name('bank.reports.maturingLoansListing.view');

            Route::get('/loansRejected', function () {
                return view('bank.reports.loansRejectedListing');
            })->name('bank.reports.loansRejectedListing.view');

            Route::get('/bankMaturedLoans', function () {
                return view('bank.reports.bankMaturedLoansListing');
            })->name('bank.reports.bankMaturedLoansListing.view');

            Route::get('/remittancesInward', function () {
                return view('bank.reports.remittancesInwardListing');
            })->name('bank.reports.remittancesInwardListing.view');

            Route::get('/remittanceOutward', function () {
                return view('bank.reports.remittanceOutwardListing');
            })->name('bank.reports.remittanceOutwardListing.view');

            Route::get('/treasaryFunding', function () {
                return view('bank.reports.treasaryFundingListing');
            })->name('bank.reports.treasaryFundingListing.view');

            Route::get('/sellerLimitUtilization', function () {
                return view('bank.reports.sellerLimitUtilizationListing');
            })->name('bank.reports.sellerLimitUtilizationListing.view');

            Route::get('/potentialDiscounting', function () {
                return view('bank.reports.potentialDiscountingListing');
            })->name('bank.reports.potentialDiscountingListing.view');

            Route::get('/discountingUsageReport', function () {
                return view('bank.reports.bankDiscountingUsageReportListing');
            })->name('bank.reports.bankDiscountingUsageReportListing.view');

            Route::get('/buyerBehaviourReport', function () {
                return view('bank.reports.buyerBehaviourReport');
            })->name('bank.reports.buyerBehaviourReport.view');



            //******************basic master routes used by Deepak ended here*****************************************//
        });
    });
});

//buyer routes
Route::group(['middleware' => 'auth', 'prefix' => 'buyer'], function () {
    Route::group(['namespace' => 'Buyer'], function () {

        Route::group(['middleware' => 'ACL'], function () {
            //dashborad
            Route::get('/dashboard', 'BuyerDashboardController@index')->name('buyer.dashboard.view');
            Route::get('/dashboard/show', 'BuyerDashboardController@showDashData')->name('buyer.dashboard.view');


            //Chats Route
            Route::get('/chat-user', 'BuyerChatController@getChatUsers')->name('buyer.chatUsers.view');
            Route::get('/chat/{uuid}', 'BuyerChatController@index')->name('buyer.chat.view');
            Route::post('/chat/save', 'BuyerChatController@create')->name('buyer.chat.save');


            Route::get('/role', 'BuyerRoleController@index')->name('buyer.role.view');
            Route::get('/role/add', 'BuyerRoleController@create')->name('buyer.role.add');
            Route::get('/role/edit/{id}', 'BuyerRoleController@edit')->name('buyer.role.edit');
            Route::post('/role/save', 'BuyerRoleController@store')->name('buyer.role.save');

            Route::get('/user', 'BuyerUserController@index')->name('buyer.user.view');
            Route::get('/user/add', 'BuyerUserController@create')->name('buyer.user.add');
            Route::get('/user/edit/{id}', 'BuyerUserController@edit')->name('buyer.user.edit');
            Route::post('/user/save', 'BuyerUserController@store')->name('buyer.user.save');
            //**************************************************
            Route::get('/buyerConfiguration', 'BuyerConfigurationController@view')->name('buyer.buyerConfiguration.view');
            //djn buyerconfigsave
            Route::post('/buyerconfigurationssave', 'BuyerConfigurationController@save')->name('buyer.config.save');

            /* seller tax and PI settings routes starts here */
            Route::get('/sellerSetting', 'BuyerConfigurationController@sellerSettingView')->name(
                    'buyer.buyerConfiguration.sellerSetting');
            Route::get('/sellerSetting/edit/{id}', 'BuyerConfigurationController@sellerSettingEdit')->name(
                    'buyer.sellerSetting.edit');
            Route::post('/sellerSetting/save', 'BuyerConfigurationController@sellerSettingSave')->name(
                    'buyer.sellerSetting.save');
            /* seller tax and PI settings routes ends here */

            //Purchase Order Route
            Route::get('/po', 'PurchaseOrderController@index')->name('buyer.poListing.view');

            Route::get('/po/show', 'PurchaseOrderController@autocomplete')->name('buyer.poListing.show');
            /* this route is for showing PO details on click of po number through ajax started here */
            Route::get('/po/show/{id}', 'PurchaseOrderController@show')->name('buyer.po.show');
            /* this route is for showing PO details on click of po number through ajax ended here */
            Route::get('/po/add', 'PurchaseOrderController@create')->name('buyer.po.add');
            Route::get('/po/view', 'PurchaseOrderController@view')->name('buyer.po.view');
            Route::get('/po/edit/{id}', 'PurchaseOrderController@edit')->name('buyer.po.edit');
            Route::get('/po/destroy/{id}', 'PurchaseOrderController@destroy')->name('buyer.po.delete');
            Route::post('/po/store', 'PurchaseOrderController@store')->name('buyer.poListing.save');
            Route::get('/po/approve/{id}', 'PurchaseOrderController@approve')->name('buyer.po.approve');
            Route::get('/po/reject/{id}', 'PurchaseOrderController@reject')->name('buyer.po.reject');

            Route::post('/po/upload/', 'PurchaseOrderController@upload')->name('buyer.po.upload');

            Route::get('/po/deleteAttachment/{id}', 'PurchaseOrderController@deleteAttachment')->name('buyer.po.deleteAttachment');
            Route::get('/invoice', 'BuyerInvoiceController@index')->name('buyer.invoice.view');
            Route::get('/invoice/invoiceDetails/{id}', 'BuyerInvoiceController@showInvoiceModal')->name('buyer.invoice.invoiceDetails');
            Route::get('/invoice/showPoModal/{id}', 'BuyerInvoiceController@showPoModal')->name('buyer.invoice.showPoModal');
            Route::post('/invoice/upload/', 'BuyerInvoiceController@upload')->name('buyer.invoice.upload');
            Route::get('/invoice/approve/{id}', 'BuyerInvoiceController@approve')->name('buyer.invoice.approve');
            Route::post('/invoice/reject', 'BuyerInvoiceController@reject')->name('buyer.invoice.reject');
            Route::get('/invoice/showSeller', 'BuyerInvoiceController@showSeller')->name('buyer.invoice.showSeller');

            Route::get('/invoice/checker/{id}', function () {
                return view('buyer.invoice.view');
            })->name('buyer.invoice.checker');

            Route::get('/piListing', 'BuyerPiController@index')->name('buyer.piListing.view');
            Route::post('/piListing/store', 'BuyerPiController@store')->name('buyer.piListing.save');
            Route::get('/piListing/showPiModal/{id}', 'BuyerPiController@showPiModal')->name('buyer.piListing.showPiModal');
            Route::post('/piListing/uploadPi', 'BuyerPiController@uploadPi')->name('buyer.piListing.uploadPi');
            Route::get('/piListing/approve/{id}', 'BuyerPiController@approve')->name('buyer.piListing.approve');
            Route::post('/piListing/reject', 'BuyerPiController@reject')->name('buyer.piListing.reject');

            Route::get('/remittances', function () {
                return view('buyer.remittances.remittances');
            })->name('buyer.remittances.view');

            Route::get('/buyerPIReport', 'BuyerReportController@getPiReport')->name('buyer.reports.piReportListing.view');

            Route::get('/discountingUsageReport', 'BuyerReportController@discountingUsageReport')->name('buyer.reports.discountingUsageReportListing.view');

            Route::get('/buyerLimitUtilization', function () {
                return view('buyer.reports.limitUtilizationListing');
            })->name('buyer.reports.limitUtilizationListing.view');
        });

        Route::get('/po/poPresentYN', 'PurchaseOrderController@poPresentYN')->name('buyer.po.poPresentYN');
        //**************************************************
    });
});

// seller routes
Route::group(['middleware' => 'auth', 'prefix' => 'seller'], function () {
    Route::group(['namespace' => 'Seller'], function () {
        Route::group(['middleware' => 'ACL'], function () {
            Route::get('/dashboard', 'SellerDashboardController@index')->name('seller.dashboard.view');

            //Chats Route
            Route::get('/chat-user', 'SellerChatController@getChatUsers')->name('seller.chatUsers.view');
            Route::get('/chat/{uuid}', 'SellerChatController@index')->name('seller.chat.view');
            Route::post('/chat/save', 'SellerChatController@create')->name('seller.chat.save');

            Route::get('/role', 'SellerRoleController@index')->name('seller.role.view');
            Route::get('/role/add', 'SellerRoleController@create')->name('seller.role.add');
            Route::get('/role/edit/{id}', 'SellerRoleController@edit')->name('seller.role.edit');
            Route::post('/role/save', 'SellerRoleController@store')->name('seller.role.save');

            Route::get('/user', 'SellerUserController@index')->name('seller.user.view');
            Route::get('/user/add', 'SellerUserController@create')->name('seller.user.add');
            Route::get('/user/edit/{id}', 'SellerUserController@edit')->name('seller.user.edit');
            Route::post('/user/save', 'SellerUserController@store')->name('seller.user.save');

            //**************************************************
            Route::get('/sellerConfiguration', 'SellerConfigurationController@index')->name('seller.sellerConfiguration.view');
            /* djn code to post seller form details */
            Route::post('/sellerconfigurationsave', 'SellerConfigurationController@store')->name('seller.sellerconfiguration.store');
            //**************************************************

            /*             * *********** invoice route *********** */
            Route::get('/invoice/flip', function () {
                return view('seller.invoice.invoiceflip');
            })->name('seller.invoiceflip.flip');

            Route::get('/invoice', 'SellerInvoiceController@index')->name('seller.invoice.view');
            Route::get('/invoice/add', 'SellerInvoiceController@create')->name('seller.invoice.add');
            Route::get('/invoice/edit/{id}', 'SellerInvoiceController@edit')->name('seller.invoice.edit');
            Route::get('/invoice/show', 'SellerInvoiceController@autocompleteBuyer')->name('seller.invoice.show'); //added by sunil-19012016
            Route::get('/invoice/showPo', 'SellerInvoiceController@autocompletePo')->name('seller.invoice.showPo'); //added by sunil-19012016
            Route::post('/invoice/store', 'SellerInvoiceController@store')->name('seller.invoice.save');
            Route::get('/invoice/poItem', 'SellerInvoiceController@poItem')->name('seller.invoice.poItem');
            Route::get('/invoice/destroy/{id}', 'SellerInvoiceController@destroy')->name('seller.invoice.delete');
            Route::get('/invoice/invoiceDetails/{id}', 'SellerInvoiceController@show')->name('seller.invoice.invoiceDetails');
            Route::get('/invoice/showPoModal/{id}', 'SellerInvoiceController@showPoModal')->name('seller.invoice.showPoModal');
            Route::get('/invoice/deleteAttachment/{id}', 'SellerInvoiceController@deleteAttachment')->name('seller.invoice.deleteAttachment');

            Route::post('/invoice/upload/', 'SellerInvoiceController@upload')->name('seller.invoice.upload');
            Route::get('/invoice/approve/{id}', 'SellerInvoiceController@approve')->name('seller.invoice.approve');
            Route::post('/invoice/reject', 'SellerInvoiceController@reject')->name('seller.invoice.reject');
            Route::get('/invoice/flipToInvoice/{id}', 'SellerInvoiceController@flipToInvoice')->name('seller.invoice.flipToInvoice');
            Route::get('/invoice/showBuyer', 'SellerInvoiceController@showBuyer')->name('seller.invoice.showBuyer');
            Route::get('/invoice/checkInvoiceNumber', 'SellerInvoiceController@checkInvoiceNumber')->name('seller.invoice.checkInvoiceNumber');
            /* seller po related routes starts here */
            Route::get('/poListing', 'SellerPOrderController@index')->name('seller.poListing.view');
            Route::get('/po/approve/{id}', 'SellerPOrderController@approve')->name('seller.po.approve');
            Route::get('/po/reject/{id}', 'SellerPOrderController@reject')->name('seller.po.reject');
            Route::post('/po/upload/', 'SellerPOrderController@upload')->name('seller.po.upload');
            Route::post('/buyerList', 'SellerPOrderController@buyerList')->name('seller.buyer.list');

            /* seller po related routes ends here */

            /* Route::get('/invoice/checker/{id}',function () {
              return view('seller.invoice.view');
              })->name('seller.invoice.checker'); */
            /* this route is for showing PO details on click of po number through ajax started here */
            Route::get('/po/show/{id}', 'SellerPOrderController@show')->name('seller.po.show');
            /* this route is for showing PO details on click of po number through ajax ended here */
            Route::get('/piListing', 'SellerPiController@index')->name('seller.piListing.view');
            Route::get('/piListing/paymentRequest', 'SellerPiController@paymentRequest')->name('seller.piListing.paymentRequest');
            Route::get('/piListing/showPiModal/{id}', 'SellerPiController@showPiModal')->name('seller.piListing.showPiModal');
            Route::get('/piListing/calculateBankCharge', 'SellerPiController@calculateBankCharge')->name('seller.piListing.calculateBankCharge');

            Route::get('/remittances', function () {
                return view('seller.remittances.remittances');
            })->name('seller.remittances.view');

            Route::get('/iDiscounting', 'SellerIDiscountingController@index')->name('seller.iDiscounting.view');
            Route::post('/iDiscounting/storeDiscounting', 'SellerIDiscountingController@storeDiscounting')->name('seller.iDiscounting.storeDiscounting');
            Route::get('/iDiscounting/iDisModal/{id}', 'SellerIDiscountingController@showPiModal')->name('seller.iDiscounting.showPiModal');
            Route::get('/iDiscounting/requestPayment/iDisModal', 'SellerIDiscountingController@requestPayment')->name('seller.iDiscounting.requestPayment');
            Route::post('/iDiscounting/requestPayment/iDisModal', 'SellerIDiscountingController@postRequestPayment')->name('seller.iDiscounting.postRequestPayment');
            //Route::get('/iDiscounting/approve', 'SellerIDiscountingController@getApprove')->name('seller.iDiscounting.getApprove');
            Route::post('/iDiscounting/approve', 'SellerIDiscountingController@postApprove')->name('seller.iDiscounting.postApprove');
            Route::get('/discountingRequest', 'SellerIDiscountingController@getDiscountingRequest')->name('seller.discountingRequestListing.view');


            /* seller Report routes Statr here */

            Route::get('/invoice/checker/{id}', function () {
                return view('seller.reports.invoice.view');
            })->name('seller.reports.invoice.checker');

            Route::get('/inwardRemittanceReport', function () {
                return view('seller.reports.inwardRemittanceReportListing');
            })->name('seller.reports.inwardRemittanceReportListing.view');

            Route::get('/potentialDiscountingReport', 'SellerReportController@potentialDiscountingReport')->name('seller.reports.potentialDiscountingReportListing.view');

            Route::get('/discountingUsageReport', 'SellerReportController@discountingUsageReport')->name('seller.reports.sellerDiscountingUsageReportListing.view');
            Route::get('/discountingUsageCSV', 'SellerReportController@downloadDiscountingUsageCSV')->name('seller.reports.sellerDiscountingUsageReportListing.csv');
            Route::get('/discountingReport', 'SellerDiscountingReportController@index')->name('seller.reports.sellerDiscountingReportListing.view');
        });


        //**************************************************
    });
});

//super admin route

/*Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Admin'], function () {
        Route::group(['middleware' => 'ACL'], function () {
            Route::get('/dashboard', 'AdminDashboardController@index')->name('admin.dashboard.view');
            Route::get('/role', 'AdminRoleController@index')->name('admin.role.view');
            Route::get('/role/add', 'AdminRoleController@create')->name('admin.role.add');
            Route::get('/role/edit/{id}', 'AdminRoleController@edit')->name('admin.role.edit');
            Route::post('/role/save', 'AdminRoleController@store')->name('admin.role.save');

            //permision
            Route::get('/permisdassion', 'AdminRoleController@p_index')->name('admin.permission.view');
            Route::get('/permission/add', 'AdminRoleController@p_create')->name('admin.permission.add');
            Route::get('/permission/sync', 'AdminRoleController@syncRolePermission')->name('admin.permission.sync');
            Route::get('/permission/edit/{id}', 'AdminRoleController@p_edit')->name('admin.permission.edit');
            Route::post('/permission/save', 'AdminRoleController@p_store')->name('admin.permission.save');

            //naviagtion
            Route::get('/navigation', 'AdminRoleController@n_index')->name('navigationListing');
            Route::get('/navigation/add', 'AdminRoleController@n_create')->name('manageNavigation');
            Route::get('/navigation/edit/{id}', 'AdminRoleController@n_edit')->name('manageNavigationById');
            Route::post('/admin/navigation/save', 'AdminRoleController@n_store')->name('manageNavigation');

            //admin user route
            Route::get('/user', 'AdminUserController@index')->name('admin.user.view');
            Route::get('/user/add', 'AdminUserController@create')->name('admin.user.add');
            Route::get('/user/edit/{id}', 'AdminUserController@edit')->name('admin.user.edit');
            Route::post('/user/save', 'AdminUserController@store')->name('admin.user.save');
            Route::get('/user/change/status', 'AdminUserController@changeStatus')->name('admin.edit.status');
            Route::get('/user/resetPassword', function () {
                return view('admin.user.resetPassword');
            });
        });
    });
});*/


// Authentication routes...
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');
Route::get('/user/resetPassword', 'Auth\AuthController@getresetPassword')->name('admin.user.resetPassword');
Route::post('/user/updatepassword', 'Auth\AuthController@updatePassword');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail')->name('admin.email.resetPassword');
Route::post('password/email', 'Auth\PasswordController@postEmail')->name('admin.email.resetPassword.save');


// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


// Registration routes...
Route::get('/auth/register', 'Auth\AuthController@getRegister');
Route::post('/auth/register', 'Auth\AuthController@postRegister');

// for Both means buyer+seller routes...
Route::get('/both/selection', 'Auth\AuthController@getUserType');
Route::post('/both/selection', 'Auth\AuthController@postUserType');

//////////////////////////////////////////////API STARTS////////////////////////////////////////////
Route::group(['prefix' => 'API/v1'], function () {
    Route::post('/login', 'API\APIUserAuthController@postLogin');
    Route::get('/userinfo', 'API\APIUserController@getUserInfo');
    Route::get('/userpermission', 'API\APIUserController@getPermission');
    Route::get('/bankconfigurations', 'API\APIUserController@getBankConfiguration');

    Route::group(['middleware' => 'APIAclAuth'], function () {


        Route::get('/invoice', 'API\APISellerController@index')->name('seller.invoice.view');
        Route::post('/invoice', 'API\APISellerController@createInvoice')->name('seller.invoice.add');
        Route::put('/invoice', 'API\APISellerController@createInvoice')->name('seller.invoice.edit');


        //Route::get('/invoice/poItem/{poUuid}', 'SellerInvoiceController@poItem')->name('A.seller.invoice.poItem');
        Route::get('/invoice/poItem/{poUuid}', 'API\APISellerController@poItem')->name('seller.invoice.poItem');
        Route::get('/invoice/{uuid}', 'API\APISellerController@show')->name('seller.invoice.invoiceDetails');
        Route::get('/sellerInvoiceByStatus/{status}', 'API\APISellerController@getInvoicesByStatus')->name('seller.invoiceByStatus.view');
        Route::get('/buyer/search/{search}', 'API\APISellerController@searchBuyerByText')->name('seller.invoice.show');
        Route::get('/buyer/po/search/{search}/{id}', 'API\APISellerController@searchBuyerPo')->name('seller.invoice.showPo');

        Route::get('/seller/invoice/destroy/{id}', 'API\APISellerController@deleteInvoice')->name('seller.invoice.delete');
        Route::get('/seller/invoice/approve/{uuid}', 'API\APISellerController@approveInvoice')->name('seller.invoice.approve');
        Route::post('/seller/invoice/reject', 'API\APISellerController@rejectInvoice')->name('seller.invoice.reject');

        Route::get('/seller/po/approve/{uuid}', 'API\APISellerController@approvePO')->name('seller.po.approve');
        Route::get('/seller/po/reject/{uuid}', 'API\APISellerController@rejectPO')->name('seller.po.reject');
        Route::get('/invoice/flipToInvoice/{id}', 'API\APISellerController@flipToInvoice')->name('seller.invoice.flipToInvoice');

        Route::get('/invoice/showBuyer', 'SellerInvoiceController@showBuyer')->name('seller.invoice.showBuyer');
        Route::get('/invoice/checkInvoiceNumber', 'SellerInvoiceController@checkInvoiceNumber')->name('seller.invoice.checkInvoiceNumber');


        Route::get('/po', 'API\APISellerController@getPO')->name('seller.poListing.view');
        Route::get('/po/{uuid}', 'API\APISellerController@getPOByUuid')->name('seller.po.show');
        Route::get('/sellerPOByStatus/{status}', 'API\APISellerController@sellerPOByStatus')->name('seller.poByStatus.show');

        //Payment Instructions
        Route::get('/pi', 'API\APISellerController@getPi')->name('seller.piListing.view');
        Route::get('/pi/{uuid}', 'API\APISellerController@getPiDetail')->name('seller.piListing.showPiModal');

        Route::get('/seller/buyerList', 'API\APISellerController@getSellerBuyerList')->name('seller.buyer.list');
        //IDiscounting seller

        Route::get('/iDiscounting/{date}/{type}', 'API\APISellerController@iDiscounting')->name('seller.iDiscounting.view');
        Route::post('/iDiscounting/storeDiscounting', 'API\APISellerController@storeDiscounting')->name('seller.iDiscounting.storeDiscounting');

        Route::post('/iDiscounting/requestPayment', 'API\APISellerController@requestPayment')->name('seller.iDiscounting.requestPayment');
        Route::post('/discountingRequest', 'API\APISellerController@getDiscountingRequest')->name('seller.discountingRequestListing.view');
        Route::post('/discountingRequest/changestatus', 'API\APISellerController@postApprove')->name('seller.iDiscounting.postApprove');

        Route::get('/buyer/po', 'API\APIBuyerController@index')->name('A.buyer.poListing.view');
        Route::get('/buyer/po/{uuid}', 'API\APIBuyerController@getPOByUuid')->name('buyer.po.show');
        Route::get('/buyerPOByStatus/{status}', 'API\APIBuyerController@buyerPOByStatus')->name('buyer.poByStatus.show');
        Route::get('/buyer/invoice/{uuid}', 'API\APIBuyerController@getInvoiceByUuid')->name('buyer.invoice.invoiceDetails');
        Route::get('/buyerInvoiceByStatus/{status}', 'API\APIBuyerController@getInvoicesByStatus')->name('buyer.invoiceByStatus.view');
        //Route::post('/buyer/po/add', 'API\APIBuyerController@createPO')->name('API.buyer.po.add');
        Route::get('/dashboardData', 'API\APISellerController@getDashboardData')->name('seller.dashboard.view');

        Route::post('/buyer/poPresentYN', 'API\APIBuyerController@poPresentYN')->name('buyer.poPresentYN');
        Route::get('/buyer/associateSeller', 'API\APIBuyerController@associateSeller')->name('buyer.poListing.show');
        Route::post('/buyer/po/add', 'API\APIBuyerController@store')->name('buyer.poListing.save');
        Route::post('/buyer/po/approve', 'API\APIBuyerController@approve')->name('buyer.po.approve');
        Route::post('/buyer/po/reject', 'API\APIBuyerController@reject')->name('A.buyer.po.reject');
        Route::post('/buyer/po/delete', 'API\APIBuyerController@destroy')->name('buyer.po.delete');

        Route::post('/buyer/invoice/approve', 'API\APIBuyerController@approveInvoice')->name('buyer.invoice.approve');
        Route::post('/buyer/invoice/reject', 'API\APIBuyerController@rejectInvoice')->name('buyer.invoice.reject');
        Route::post('/buyer/pi/approve', 'API\APIBuyerController@approvePI')->name('buyer.piListing.reject');
        Route::post('/buyer/pi/reject', 'API\APIBuyerController@rejectPI')->name('buyer.piListing.reject');
        Route::get('/buyer/dashboard/show', 'API\APIBuyerController@showDashData')->name('buyer.dashboard.view');
        
        Route::get('/buyer/pi', 'API\APIBuyerController@getPi')->name('buyer.piListing.view');
        Route::get('/buyer/pi/{uuid}', 'API\APIBuyerController@getPiDetail')->name('buyer.piListing.showPiModal');

    });

    Route::get('/currency', 'API\APIMasterController@currency');
});
//////////////////////////////////////////////API ENDS////////////////////////////////////////////
