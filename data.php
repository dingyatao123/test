<?php
define('IN_ECS',true);

require_once '/data/config.php';
require_once '/data/cls_mysql.php';
date_default_timezone_set("Asia/Shanghai");
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = $db_name = NULL;

?>
<!DOCTYPE HTML>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>新天药业</title>
</head>
<body>
<style type="text/css">
<!--
a:link {
 color: #001fff;
 text-decoration: none;
}
a:visited {
 color: #001fff;
 text-decoration: none;
}
a:hover {
 color: #001fff;
}
a:active {
 color: #001fff;
 text-decoration: none;
}
td{text-align: center;padding: 5px 0;}
th{padding: 10px 0;}
.tr1{
    background: #f8f8f8;
}
.last span,.last a{padding: 0 10px;}
.btn{background: #409eff;padding: 4px 10px;font-size: 14px;margin-left: 10px;border-radius: 5px;color: #fff!important;display: inline-block;}
-->
</style>


<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30" colspan="4" align="center" style="color:#ffffff;font-size:20px;background:#f1afa5;">新天药业答题用户列表 <a class="btn" href="excel.php">导出EXCEL</a></td>
  </tr>
<tr>
  <th>排名</th>
  <th>姓名</th>
  <th>手机号</th>
  <th>得分</th>
</tr>

<?php
$sql = "select count(*) as amcount from records";
$amcount=$db->getOne($sql);   //统计记录数 

if(empty($_GET['page']))  
{
  $page=0;    //页数为0而给值0
}
else
{
  $page=$_GET['page'];
  if($page<0)
  {
    $page=0;
  }
  if($page>=ceil($amcount/10))
  {
     $page=ceil($amcount/10)-1;    //判断页数
  }
}
$sql = "select * from records order by scores desc limit ".($page*10).",10";
$arr=$db->getAll($sql);
foreach($arr as $k => $rs)    //输出部分
{
?>

  <tr class="tr<?php echo $k%2 ?>">
    <td width="20%" height="30" style="border-bottom:solid #ddd 1px; font-size:14px; color:#000099;">NO.<?=$page*10+$k+1?></td>
    <td width="30%" height="30" style="border-bottom:solid #ddd 1px; font-size:14px; color:#000099;"><?=$rs["username"]?></td>
    <td width="30%" style="border-bottom:solid #ddd 1px; font-size:14px; color:#000099;"><?=$rs["telnumber"]?></td>
    <td width="20%" height="30" style="border-bottom:solid #ddd 1px; font-size:14px; color:#000099;"><?=$rs["scores"]?>分</td>
  </tr>

<?php 
}
?> 

<tr class="last">
    <td height="36" colspan="4" align="right" style="font-size=12;"><span>共<font color=red><?=ceil($amcount/10)?></font>页</span><span>当前第<font color=red><?=$page+1?></font>页</span>
 <?php
  if($page>0)
  {
 ?>
    <a href="?page=0">首页</a>
 <a href="?page=<?=$page-1?>">上页</a>
    <?php
    }
 else
 {
 echo "<font color=gray><span>首页</span><span>上页</span></font>";
 }
 if($page<ceil($amcount/10)-1)
 {
 ?>
 <a href="?page=<?=$page+1?>">下页</a>
 <a href="?page=<?=ceil($amcount/10)-1?>">尾页</a> </td>
 <?php
    }
 else
 {
 echo "<font color=gray><span>下页</span><span>尾页</span></font>";
 }
 ?>
  </tr>
</table>
</body>