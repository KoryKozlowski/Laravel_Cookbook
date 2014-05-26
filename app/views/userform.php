<h1>User Info</h1>
<?= Form::open() ?>
<?= Form::label('username', 'Username') ?>
<?= Form::text('username') ?>
<br>
<?= Form::label('password', 'Password')?>
<?= Form::password('password') ?>
<br>
<?= Form::label('color', 'Favorite Color') ?>
<?= Form::select('color', array('red' => 'red', 'green' => 'green', 'blue' => 'blue')) ?>
<br>
<?= Form::submit('Send it!') ?>
<?= Form::close() ?> 
