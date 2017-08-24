<?php
use \app\common\services\UrlService;
\app\assets\WebAsset::register($this);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>管理后台</title>
	<?php $this->head() ?>

</head>

<body class="gray-bg">
<?php $this->beginBody() ?>
<?=$content;?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
