<?php

namespace Config;

use CodeIgniter\Commands\Utilities\Routes;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
// $routes->get('/masuk', 'Home::masuk');
// $routes->get('/daftar', 'Home::daftar');
$routes->get('/tentang', 'Home::tentang');
$routes->get('/kontak', 'Home::kontak', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/kirimkeDev', 'Home::kirimkeDev', ['filter' => 'auth']);
$routes->get('/tes1', 'Home::tes1', ['filter' => 'auth']);
// $routes->get('/profil', 'Home::profil');
// $routes->get('/hasil', 'Home::hasil');
// $routes->get('/biodata', 'Home::biodata');
// $routes->get('/datanak', 'Home::datanak');
// $routes->get('/cardatanak', 'Home::cardatanak');
$routes->get('/tanyahli', 'Home::tanyahli');
$routes->get('/terimakasih', 'Home::terimakasih');
$routes->get('/visi', 'Home::visi');
$routes->get('/misi', 'Home::misi');
$routes->get('/carakerja', 'Home::carakerja');
// $routes->get('/invoice', 'Home::invoice1');
// $routes->get('/invoice2', 'Home::invoice2');

// rute gyto punya
$routes->match(['get', 'post'], '/masuk', 'Users::index');
$routes->match(['get', 'post'], '/daftar', 'Users::register');
$routes->match(['get', 'post'], '/verifikasi', 'Users::verifikasi');
$routes->get('/keluar', 'Users::logout', ['filter' => 'auth']);

$routes->match(['get', 'post'], '/profil', 'Anak::index', ['filter' => 'auth']);
$routes->get('/biodata', 'Anak::tambah', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/save', 'Anak::save', ['filter' => 'auth']);
$routes->get('/edit/(:num)', 'Anak::edit/$1', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/update', 'Anak::update', ['filter' => 'auth']);
$routes->delete('/hapus/(:num)', 'Anak::delete/$1', ['filter' => 'auth']);

$routes->match(['get', 'post'], '/test', 'Test::index', ['filter' => 'auth']);
$routes->get('/pilihAnak/(:num)', 'Test::pilihAnak/$1', ['filter' => 'auth']);
$routes->get('/awalTest', 'Test::awalTest', ['filter' => 'auth']);
$routes->get('/startTest', 'Test::startTest', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/collectTest', 'Test::collectTest', ['filter' => 'auth']);
$routes->get('/selesai', 'Test::selesai', ['filter' => 'auth']);

$routes->get('/riwayat', 'Riwayat::index', ['filter' => 'auth']);
$routes->get('/pilihRiwayat/(:num)', 'Riwayat::pilihRiwayat/$1', ['filter' => 'auth']);
$routes->get('/print/(:any)/(:num)', 'Riwayat::print/$1/$2', ['filter' => 'auth']);
$routes->get('/kirimHasil/(:any)/(:num)', 'Riwayat::kirimHasil/$1/$2', ['filter' => 'auth']);

//rute untuk blog
$routes->get('/blog', 'Blog::index');
$routes->get('/detailblog/(:any)', 'Blog::detail/$1');

$routes->get('/testing', 'Home::test');

$routes->group('admin', function ($routes) {
    $routes->get('dashboard', 'admin\dashboard::index');
    $routes->get('products', 'admin\products::index');
    $routes->get('products/create', 'admin\products::create');
    $routes->match(['get', 'post'], 'products/save', 'admin\products::save');
    $routes->delete('products/(:num)', 'admin\products::delete/$1');
    $routes->get('products/edit/(:segment)', 'admin\products::edit/$1');
    $routes->match(['get', 'post'], 'products/update/(:num)', 'admin\products::update/$1');
    $routes->match(['get', 'post'], 'products/uploadImages', 'admin\products::uploadImages');
});




/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
