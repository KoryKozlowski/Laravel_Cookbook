<?php

Route::get('/', function()
{
   return View::make('hello');
});

Route::post('myform', array('before' => 'csrf', function()
{
   $rules = array(
      'email'    => 'required | email | min:6',
      'username' => 'required | min:6',
      'password' => 'required',
      'no_email' => 'honey_pot'
   );

   $messages = array(
      'min' => 'Way too short! The :attribute must be at least :min characters in length.',
      'username.required' => 'We need to know who you are, please.',
      'password.required' => 'We cannot let you in without a password.',
      'honey_pot' => 'Nothing should be in this field.'
   );

   $validation = Validator::make(Input::all(), $rules, $messages);

   if($validation->fails())
   {
      return Redirect::to('myform')->withErrors($validation)->withInput();
   }

   return Redirect::to('userresults')->withInput();
}));

Route::get('myform', function()
{
    return View::make('myform');
});

Route::get('userresults', function()
{
   // die & dump validated input
   return dd(Input::old());
});

Route::get('userform', function()
{
   return View::make('userform');
});

Route::post('userform', function()
{
   $rules = array(
      'email'    => 'required | email | different:username',
      'username' => 'required | min:6',
      'password' => 'required | same:password_confirm'
   );

   $validation = Validator::make(Input::all(), $rules);

   if($validation->fails())
   {
      return Redirect::to('userform')->withErrors($validation)->withInput();
   }

   return Redirect::to('userresults')->withInput();
});

Route::get('fileform', function()
{
   return View::make('fileform');
});

Route::post('fileform', function()
{
   $rules = array(
      'myfile' => 'mimes:doc,docx,pdf,txt | max:1000'
   );

   $validation = Validator::make(Input::all(), $rules);

   if($validation->fails())
   {
      return Redirect::to('fileform')->withErrors($validation)->withInput();
   }
   else
   {
      $file = Input::file('myfile');

      if($file->move('files', $file->getClientOriginalName()))
      {
         return 'Success';
      }
      else
      {
        return 'Error';
      }
   }
});

//-- If honey_pot is not empty, it has been filled in by a bot
Validator::extend('honey_pot', function($attribute, $value, $parameters)
{
   return $value == '';
});

Route::get('redactor', function()
{
   return View::make('redactor');
});

Route::post('redactorupload', function()
{
   $rules = array(
      'file' => 'image | max:10000'
   );

   $validation = Validator::make(Input::all(), $rules);
   $file = Input::file('file');

   if($validation->fails())
   {
      return FALSE;
   }
   else
   {
      if($file->move('files', $file->getClientOriginalName()))
      {
         return Response::json(array('filelink' => 'files/' . $file->getClientOriginalName()));
      }
      else
      {
         return FALSE;
      }
   }
});

Route::post('redactor', function()
{
  return dd(Input::all());
});

Route::get('imageform', function()
{
  return View::make('imageform');
});

Route::post('imageform', function()
{
  $rules = array(
    'image' => 'required | mimes:jpeg,jpg | max:10000'
  );

  $validation = Validator::make(Input::all(), $rules);

  if($validation->fails())
  {
    return Redirect::to('imageform')->withErrors($validation);
  }
  else
  {
    $file = Input::file('image');
    $file_name = $file->getClientOriginalName();

    if($file->move('images', $file_name))
    {
      return Redirect::to('jcrop')->with('image', $file_name);
    }
    else
    {
      return "Error uploading file: $filename";
    }
  }
});

Route::get('jcrop', function()
{
  return View::make('jcrop')->with('image', 'images/' . Session.get('image'));
});

Route::post('jcrop', function()
{
  $quality = 90;
  $src = Input::get('image');
  $img = imagecreatefromjpeg($src);
  $dest = ImageCreateTrueColor(Input::get('w'), Input::get('h'));
  imagecopyresampled($dest, $img, 0, 0, Input::get('x'), Input::get('y'), Input::get('w'), Input::get('h'), Input::get('w'), Input::get('h'));
  imagejpeg($dest, $src, $quality);

  return "<img src='" . $src . "'>";
});
