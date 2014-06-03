<h1>Laravel and Jcrop</h1>
<?= Form::open(array('files' => true)) ?>
<?= Form::label('image', 'My Image')?>
<br>
<?= Form::file('image') ?>
<br>
<?= Form::submit('Upload!') ?>
<?= Form::close() ?>
