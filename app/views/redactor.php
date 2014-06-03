<!DOCTYPE html>
<html>
   <head>
      <title>Laravel and Redactor</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/redactor.css" />
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
      <script src="js/redactor.min.js"></script>
   </head>
   <body>
      <?= Form::open() ?>
      <?= Form::label('mytext', 'My Text')  ?>
      <br>
      <?= Form::textarea('mytext', '', array('id' => 'mytext')) ?>
      <br>
      <?= Form::submit('Send It!') ?>
      <?= Form::close() ?>
      <script type="text/javascript">
         $(function() {
            $('#mytext').redactor({
               imageUpload: 'redactorupload'
            });
         });
      </script>
   </body>
</html>
