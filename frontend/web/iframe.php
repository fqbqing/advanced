<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $_GET['title']?></title>
<style>
html, body{
padding: 0;
margin: 0;
height: 100%;
width: 100%;
overflow:hidden;
}
</style>
</head>
<body>
<?php

if(empty($_GET['u'])) {
 echo '未指定要加载的url';
}

$url = $_GET['u'];
?>
<iframe src="<?php echo $url?>" allowtransparency="true" frameborder="0" width="100%" height="100%"></iframe>
</body>
</html>
