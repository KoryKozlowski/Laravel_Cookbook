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
