<?php

Route::get('/', function()
{
   return View::make('hello');   
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
