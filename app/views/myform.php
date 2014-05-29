<h1>User Info</h1>

<?php $messages = $errors->all('<p style="color:red">:message</p>') ?>

<?php 
foreach($messages as $msg)
{
   echo $msg;
}
?>

<?= Form::open() ?>

<?= Form::label('email', 'Email ') ?>
<?= Form::text('email', Input::old('email')) ?>

<br>

<?= Form::label('username', 'Username ') ?>
<?= Form::text('username', Input::old('username')) ?>

<br>

<?= Form::label('password', 'Password ')?>
<?= Form::password('password') ?>
<?= Form::text('no_email', '', array('style' => 'display:none')) ?>

<br>

<?= Form::submit('Send it!') ?>

<?= Form::close() ?> 
