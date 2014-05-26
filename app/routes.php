<?php

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
