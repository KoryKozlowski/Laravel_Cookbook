<?php

Route::get('userresults', function()
{
   return 'Your username is: ' . Input::old('username')
   . '<br>Your favorite color is: ' . Input::old('color'); 
});

Route::get('userform', function()
{
   return View::make('userform');
});

Route::post('userform', function()
{
   // Process form data
   return Redirect::to('userresults')->withInput(Input::only('username', 'color'));  
});
