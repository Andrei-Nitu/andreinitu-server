<!DOCTYPE html>
<html>
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?= $this->fetch('title') ?>
  </title>
  <?= $this->Html->meta('icon') ?>

  <?= $this->Html->css('base.css') ?>
  <?= $this->Html->css('cake.css') ?>

  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>

  <?= $this->Html->script('jquery-2.2.4.min.js') ?>
  <!-- <?= $this->Html->script('bootstrap.min.js') ?>-->

  <!--<?= $this->Html->css('bootstrap.min.css') ?>-->
  <?= $this->Html->css('font-awesome.min.css') ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

</head>
<body class="hold-transition login-page">
  <div class="wrapper">
      <?= $this->fetch('content') ?>
    </div>
  </div>
</body>
</html>
