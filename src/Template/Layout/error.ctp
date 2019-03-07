<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error</title>
</head>
<body>
<?= $this->fetch('content') ?>
<div>
    <?php echo $this->Html->link(__('Back'), 'javascript:history.back()') ?>
</div>
</body>
</html>
