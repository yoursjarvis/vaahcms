<?php



Route::group(
    [
        'prefix'     => 'backend',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'PublicController@login' )
            ->name( 'vh.backend' );
        //------------------------------------------------
        Route::get( '/login', 'PublicController@redirectToLogin' )
            ->name( 'vh.backend.login' );
        //------------------------------------------------
        Route::post( '/signin/post', 'PublicController@postLogin' )
            ->name( 'vh.backend.signin.post' );
        //------------------------------------------------
        Route::post( '/sendResetCode/post', 'PublicController@postSendResetCode' )
            ->name( 'vh.backend.sendResetCode.post' );
        //------------------------------------------------
        Route::post( '/resetPassword/post', 'PublicController@postResetPassword' )
            ->name( 'vh.backend.resetPassword.post' );
        //------------------------------------------------
        Route::post( '/signin/generate/otp', 'PublicController@postGenerateOTP' );
        //------------------------------------------------
        Route::get( '/logout', 'PublicController@logout' )
            ->name( 'vh.backend.logout' );
        //-----------------------------------------------

        Route::group(
            [
                'prefix'     => 'json',
                'middleware' => ['web'],
            ],
            function () {
                //------------------------------------------------
                Route::post( '/assets', 'JsonController@getPublicAssets' )
                    ->name( 'vh.backend.json.assets' );
                //------------------------------------------------
                Route::post( '/is-logged-in', 'JsonController@isLoggedIn' )
                    ->name( 'vh.backend.json.is_logged_in' );
                //------------------------------------------------
                Route::post( '/permissions', 'JsonController@getPermissions' )
                    ->name( 'vh.backend.json.permissions' );
                //------------------------------------------------

                //------------------------------------------------
            });
        //------------------------------------------------
    });

Route::group(
    [
        'prefix'     => 'backend#',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------

        Route::get('/reset-password/{reset_password_code}', 'PublicController@resetPassword')
            ->name('vh.reset');
        //------------------------------------------------
    });






Route::group(
    [
        'prefix'     => 'backend',
        'middleware' => ['web', 'has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::post( '/notices/mark-as-read', 'Settings\NotificationsController@markAsRead' )
            ->name( 'vh.backend.notices.mark_as_read' );
        //------------------------------------------------

        Route::group(
            [
                'prefix'     => 'json',
                'middleware' => ['web', 'has.backend.access'],
            ],
            function () {
                //------------------------------------------------
                Route::get( '/users/{name?}', 'JsonController@getUsers' )
                    ->name( 'vh.backend.json.users' );
                //------------------------------------------------

                //------------------------------------------------
            });

        //------------------------------------------------

        Route::get( '/dashboard/getItem', 'DashboardController@getItem' )
            ->name( 'vh.backend.dashboard.item' );
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::post( '/signin/post', 'PublicController@postLogin' )
            ->name( 'vh.backend.signin.post' );
        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
    });
