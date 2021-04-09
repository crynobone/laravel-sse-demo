<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

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

// Turn off output buffering
ini_set('output_buffering', 'off');
// Turn off PHP output compression
ini_set('zlib.output_compression', false);

//Flush (send) the output buffer and turn off output buffering
while (@ob_end_flush()) {
    //
}

// Implicitly flush the buffer(s)
ini_set('implicit_flush', true);
ob_implicit_flush(true);

function ping() {
    echo 'data: '.now()->toDatetimeString()."\n\n";
};

Route::get('/sse', function () {

    return Response::stream(function () {
        $i = 1;
        do {
            ping();
            sleep(1);
            $i++;
        } while ($i < 10);
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'X-Accel-Buffering' => 'no',
        'Cache-Control' => 'no-cache',
    ]);
});


Route::get('/', function () {
    return view('welcome');
});
