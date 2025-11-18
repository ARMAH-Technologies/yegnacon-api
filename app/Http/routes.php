<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'oauth'], function ($api) {
        $api->post('authorize', 'App\Http\Controllers\Auth\AuthController@authorizeClient');
    });

    $api->post('users', 'App\Http\Controllers\UserController@store');
    $api->get('news', 'App\Http\Controllers\NewsController@index');
    $api->get('news/{news_id}', 'App\Http\Controllers\NewsController@show');
    $api->get('tenders', 'App\Http\Controllers\TenderController@index');
    $api->get('tenders/categories', 'App\Http\Controllers\TenderController@getUserTendersByCategories');
    $api->get('products', 'App\Http\Controllers\ProductController@index');
    $api->get('vacancies', 'App\Http\Controllers\VacancyController@index');
    $api->get('activeProjects', 'App\Http\Controllers\ActiveProjectController@index');
    $api->get('users', 'App\Http\Controllers\UserController@index');
    $api->get('send_tenders', 'App\Http\Controllers\TenderController@sendYesterdayTendersToUsers');
    $api->get('categories', 'App\Http\Controllers\BaseController@getAllCategories');
    $api->get('projects', 'App\Http\Controllers\ProjectController@index');
    $api->get('categories', 'App\Http\Controllers\CategoryController@getCategories');//?type={type}



    //test routes
    $api->get('test', 'App\Http\Controllers\TestController@index');

    // Protected routes
    $api->group(['namespace' => 'App\Http\Controllers', 'middleware' => 'api.auth'], function ($api) {
//Begin New Routes
        //Company Routes
        //leaves
        $api->get('companies/{company_id}/leaves', 'LeaveController@getCompanyLeaves');
        $api->post('companies/{company_id}/leaves', 'LeaveController@addCompanyLeave');
        $api->put('companies/{company_id}/leaves', 'LeaveController@updateCompanyLeave');
        $api->delete('companies/{company_id}/leaves/{leave_id}', 'LeaveController@deleteCompanyLeave');
        //employees
        $api->get('companies/{company_id}/employees', 'EmployeeController@index');
        $api->get('companies/{company_id}/employees/{employee_id}', 'EmployeeController@show');
        $api->put('companies/{company_id}/employees/{employee_id}', 'EmployeeController@update');
        $api->post('companies/{company_id}/employees/', 'EmployeeController@store');
        $api->delete('companies/{company_id}/employees/{employee_id}', 'EmployeeController@destroy');

        $api->get('companies/{company_id}/employees/{employee_id}/skills', 'EmployeeController@skills');
        $api->get('companies/{company_id}/employees/{employee_id}/educations', 'EmployeeController@educations');
        $api->get('companies/{company_id}/employees/{employee_id}/experiences', 'EmployeeController@experiences');


        //employee leaves
        $api->get('companies/{company_id}/employees/{employee_id}/leaves', 'LeaveController@allBalance');
        $api->get('companies/{company_id}/employees/{employee_id}/leaves/{leave_id}', 'LeaveController@balance');
        //employee leave requests
        $api->get('companies/{company_id}/employees/{employee_id}/requests', 'LeaveRequestController@requestHistory');
        $api->get('companies/{company_id}/employees/{employee_id}/requests/{request_id}', 'LeaveRequestController@requestDetail');
        $api->post('companies/{company_id}/employees/{employee_id}/requests', 'LeaveRequestController@addRequest');
        $api->put('companies/{company_id}/employees/{employee_id}/requests/{request_id}', 'LeaveRequestController@updateRequest');
        $api->delete('companies/{company_id}/employees/{employee_id}/requests/{request_id}', 'LeaveRequestController@deleteRequest');
        //company leave request
        $api->get('companies/{company_id}/requests', 'LeaveRequestController@allRequests');

        // Leave routes
        $api->get('leaves', 'LeaveController@index');
        $api->get('leaves/default', 'LeaveController@giveDefault');
        $api->post('leaves', 'LeaveController@store');
        $api->put('leaves/{leave_id}', 'LeaveController@update');
        $api->delete('leaves/{leave_id}', 'LeaveController@destroy');

        //test

        $api->get('employees/{userId}', 'EmployeeController@getData');
        $api->get('companies/{userId}/getdata', 'EmployeeController@getCompanyData');
//End of new routes

        //Statistics routes
        $api->get('users/stat', 'UserController@getStatistics');
        $api->get('tenders/stat', 'TenderController@getStatistics');
        $api->get('vacancies/stat', 'VacancyController@getStatistics');
        $api->get('products/stat', 'ProductController@getStatistics');
        $api->get('proformas/stat', 'ProformaController@getStatistics');

        //user routes
        $api->get('users/{user_id}', 'UserController@show');
        $api->put('users', 'UserController@update');
        $api->delete('users/{user_id}', 'UserController@destroy');
        $api->get('user', 'UserController@getCurrentUser');
        $api->get('users/{user_id}/status/{status}', 'UserController@changeStatus');
        $api->get('users/{user_id}/password/{oldPassword}/{newPassword}', 'UserController@changePassword');
        $api->get('users/{user_id}/passwordReset/{newPassword}', 'UserController@resetPassword');


        //Subscription Packages Routes
        $api->get('subscription_packages', 'UserSubscriptionPackageController@index');

        //SalesMen Routes
        $api->get('sales', 'SalesController@index');

        //User Subscription Routes
        $api->post('subscribe', 'UserController@subscribe');

        //projects route
        $api->get('users/{user_id}/projects', 'ProjectController@getUserProjects');
        $api->post('users/{user_id}/projects', 'ProjectController@store');
        $api->get('projects/{project_id}', 'ProjectController@show');
        $api->put('projects', 'ProjectController@update');
        $api->delete('projects/{project_id}', 'ProjectController@destroy');


        //role routes
        $api->get('roles', 'RoleController@index');
        $api->post('roles', 'RoleController@store');
        $api->get('roles/{role_id}', 'RoleController@show');
        $api->post('users/{user_id}/roles', 'RoleController@assignRoleToUser');
        $api->get('users/{user_id}/roles', 'RoleController@getUserRoles');

        //category routes
        $api->post('categories', 'CategoryController@store');
        $api->put('categories', 'CategoryController@update');
        $api->delete('categories/{category_id}', 'CategoryController@destroy');

        $api->get('users/{user_id}/categories', 'CategoryController@getUserCategories');
        $api->post('users/{user_id}/categories', 'CategoryController@attachUserToCategories');

        //permission routes
        $api->get('permissions', 'PermissionController@getAllPermissions');
        $api->post('roles/{role_id}/permissions', 'PermissionController@assignPermissionToRole');

        //product routes

        $api->post('products', 'ProductController@store');
        $api->get('products/{product_id}', 'ProductController@show');
        $api->put('products', 'ProductController@update');
        $api->delete('products/{product_id}', 'ProductController@destroy');
        $api->get('users/{user_id}/products', 'ProductController@getUserProducts');

        //Subscription Routes
        //$api->get('users/{user_id}/subscription',)

        //vacancy routes
        $api->post('vacancies', 'VacancyController@store');
        $api->get('vacancies/{vacancy_id}', 'VacancyController@show');
        $api->put('vacancies', 'VacancyController@update');
        $api->delete('vacancies/{vacancy_id}', 'VacancyController@destroy');
        $api->get('users/{user_id}/vacancies', 'VacancyController@getUserVacancies');
        $api->get('companies/{company_id}/vacancies', 'VacancyController@getCompanyVacancies');

        //tender routes
        $api->post('tenders', 'TenderController@store');
        $api->get('tenders/{tender_id}', 'TenderController@show');
        $api->put('tenders', 'TenderController@update');
        $api->delete('tenders/{tender_id}', 'TenderController@destroy');
        $api->get('users/{user_id}/tenders', 'TenderController@getUserTenders');
        $api->get('companies/{company_id}/tenders', 'TenderController@getCompanyTenders');

        //activeProject routes
        $api->post('users/{user_id}/activeProjects', 'ActiveProjectController@store');
        $api->get('activeProjects/{active_project_id}', 'ActiveProjectController@show');
        $api->put('activeProjects', 'ActiveProjectController@update');
        $api->delete('activeProjects/{active_project_id}', 'ActiveProjectController@destroy');
        $api->get('users/{user_id}/activeProjects', 'ActiveProjectController@getUserActiveProjects');

        //proforma routes
        $api->get('proformas', 'ProformaController@index');
        $api->post('proformas', 'ProformaController@request');
        $api->post('users/{user_id}/proformas/{proforma_id}/reply', 'ProformaController@reply');
        $api->get('proformas/{proforma_id}', 'ProformaController@show');
        $api->put('proformas', 'ProformaController@update');
        $api->delete('proformas/{proforma_id}', 'ProformaController@destroy');
        $api->get('users/{user_id}/proformas/products', 'ProformaController@getUserProductProformaRequests');
        $api->get('users/{user_id}/proformas/projects', 'ProformaController@getUserProjectProformaRequests');
        $api->get('users/{user_id}/proformas/company_projects', 'ProformaController@getProjectFromCompanyProformaRequests');
        $api->get('users/{user_id}/proformas/consultants', 'ProformaController@getUserConsultantProformaRequests');
        $api->get('proformas/{proforma_id}/reply', 'ProformaController@getProformaResponses');
        $api->get('proformas/{proforma_id}/reply/priceComparison', 'ProformaController@getProformaRequestItems');
        $api->get('proformaResponses/{proforma_response_id}', 'ProformaController@getProformaResponseDetail');

        //rate and review routes
        $api->post('users/{user_id}/rate', 'RateController@rate');
        $api->post('users/{user_id}/review', 'RateController@review');

        //notification routes
        $api->get('users/{user_id}/notifications', 'NotificationController@getUserNotifications');
        $api->get('notifications/{notification_id}', 'NotificationController@show');
        $api->get('notifications', 'NotificationController@index');
        $api->post('notifications', 'NotificationController@storeNotification');
        $api->get('notifications/find/{id}', 'NotificationController@findNotification');

        //file upload routes
        $api->post('file/{item_type}/{item_id}', 'FileController@upload');
        $api->post('file/{file_id}', 'FileController@update');

        //news routes
        $api->post('news', 'NewsController@store');
        $api->put('news', 'NewsController@update');
        $api->delete('news/{news_id}', 'NewsController@destroy');

        //comment routes
        $api->post('news/{news_id}/comments', 'NewsController@storeComment');

        //professionals routes
        $api->post('professionals/{professional_id}/experience', 'UserController@addExperience');

        //groups routes
        $api->post('groups', 'GroupController@store');
        $api->put('groups/{group_id}', 'GroupController@update');
        $api->post('groups/{group_id}/users', 'GroupController@addUserToGroup');
        $api->get('groups/{group_id}', 'GroupController@show');
        $api->get('users/{user_id}/groups', 'UserController@getUserGroups');
        $api->delete('groups/{group_id}', 'GroupController@destroy');
    });
});



