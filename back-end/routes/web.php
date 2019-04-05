<?php

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

// header("Access-Control-Allow-Origin:*");


$router->get('/' , 'Frontend\Home@index');
$router->get('/chi-tiet' , 'Frontend\Home@index');

$router->get('/chi-tiet/{slug}/{id}' , ['as' => "Frontend.Detail.index", 'uses' => 'Frontend\Detail@index']);
//$router->get('/admin/info' , ['as' => "Admin.info.index", 'uses' => 'AdminController\@info']);
//$router->get('/{tag}' , 'Frontend\Filter@index');
// $router->get('/home' , function(){
//     return view('Homepage/Home');
// });
// $router->get('/getlink' , 'Admin\VideoController@getLink');

$router->group(['prefix' => 'api/v1','middleware' => 'cors' ], function() use($router) {

    $router->get('/menu' , ['as' => "Api.MenuController.index", 'uses' => 'Api\MenuController@index']);
    $router->get('posts' , ['as' => "Api.PostsController.index", 'uses' => 'Api\PostsController@index']);

}); 


// $router->get("getdata" , 'Admin\MovieController@getdata');

$router->group(['prefix' => 'admin'], function() use($router) {
    $router->get('/login', ['as' => "Admin.AdminController.login", 'uses' => 'Admin\AdminController@login']);
    $router->get('/forgotpassword', ['as' => "Admin.AdminController.forgot", 'uses' => 'Admin\AdminController@forgot']);
    $router->post('/forgotpassword', ['as' => "Admin.AdminController.doForgot", 'uses' => 'Admin\AdminController@doForgot']);
    $router->post('/confirmCodeChangePass', ['as' => "Admin.AdminController.confirmCodeChangePass", 'uses' => 'Admin\AdminController@confirmCodeChangePass']);
    $router->post('/login', ['as' => "Admin.AdminController.doLogin", 'uses' => 'Admin\AdminController@doLogin']);
    $router->post('/logout', ['as' => "Admin.AdminController.logout", 'uses' => 'Admin\AdminController@logout']);
    // $router->post('/changepass', ['as' => "Admin.AdminController.changepass", 'uses' => 'Admin\AdminController@changepass']);

    
    $router->group(['middleware' => ['auth.admin']], function() use($router) {
        $router->get('/', [
            'as'   => "Admin.IndexController.index", 
            'uses' => 'Admin\IndexController@index'
        ]);
        $router->post('/changepass', [
            'as'   => "Admin.AdminController.changepass", 
            'uses' => 'Admin\AdminController@changepass'
        ]);


        $router->get('user/lock/{id}', [
            'as'         => "Admin.AdminController.lockuser", 
            'uses'       => 'Admin\AdminController@lockuser', 
            'middleware' => 'auth.admin'
        ]);
        $router->get('user/unlock/{id}', [
            'as'         => "Admin.AdminController.unlockuser", 
            'uses'       => 'Admin\AdminController@unlockuser',
            'middleware' => 'auth.admin'
        ]);
        $router->get('user/info', [
            'as'         => "Admin.AdminController.info", 
            'uses'       => 'Admin\AdminController@info',
            'middleware' => 'auth.admin'
        ]);
        resource_admin($router, 'user', 'AdminController' , 'auth.master');
        resource_admin($router, 'group', 'AdminGroupController' , 'auth.master');
        resource_admin($router, 'config', 'ConfigController');
        resource_admin($router, 'banner', 'BannerController');
        resource_admin($router, 'tags', 'TagsController');
        resource_admin($router, 'genre', 'GenreController');
        resource_admin($router, 'country', 'CountryController');
        resource_admin($router, 'menu', 'MenuController');
        resource_admin($router, 'posts', 'PostsController');
        resource_admin($router, 'video', 'VideoController');
        
        
    });
});

$router->any('/{any}', 'Frontend\Home@index_reactjs')->where('any', '.*');
// $router->get('/chi-tiet/{slug}/{id}' , ['as' => "Frontend.Detail.index", 'uses' => 'Frontend\Detail@index']);
// $router->get('/{tag}' , 'Frontend\Filter@index');


function resource_admin(&$router, $uri, $controller , $middleware = null) {
        $router->get($uri, [
            'as'   => "Admin.$uri.index", 
            'uses' => "Admin\\$controller@index"
        ]);
        $router->any("$uri/detail/{id}", [
            'as'   => "Admin.$uri.detail", 
            'uses' => "Admin\\$controller@detail"
        ]);
        $router->any($uri.'/add', [
            'as'         => "Admin.$uri.store", 
            'uses'       => "Admin\\$controller@store",
            'middleware' => 'auth.admin',
        ]);

        $router->get($uri.'/del/{id}', [
            'as'         => "Admin.$uri.delete", 
            'uses'       => "Admin\\$controller@delete",
            'middleware' => 'auth.admin'
        ]);
        

}
