<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Intervention\Image\Facades\Image;

$router->get('/form', function (\Illuminate\Http\Request $request) use ($router) {

    $form = require 'form.php';

    return $form;
});

$router->post('/form', function (\Illuminate\Http\Request $request) use ($router) {

    /** @var \Intervention\Image\Image $image */
    $image = Image::make($request->file('image'));

    $path = storage_path();
    $filename = $request->file('image')->getClientOriginalName();

    $smallThumb = $path . '\\small' . $filename;
    $image->resize(100, null, function ($constraint) {
        return $constraint->aspectRatio();
    })->save($smallThumb);

    /** @var \Intervention\Image\Image $image */
    $image = Image::make($request->file('image'));

    $mediumThumb = $path . '\\medium' . $filename;
    $image->resize(250, null, function ($constraint) {
        return $constraint->aspectRatio();
    })->save($mediumThumb);

    /** @var \Intervention\Image\Image $image */
    $image = Image::make($request->file('image'));

    $actual = $path . '\\actual' .$filename;
    $image->save($actual);

    dd($image);

});
