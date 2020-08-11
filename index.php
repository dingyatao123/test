<?php
define('IN_ECS',true);

require_once '/data/config.php';
require_once '/data/cls_mysql.php';
date_default_timezone_set("Asia/Shanghai");
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = $db_name = NULL;

$act = empty($_REQUEST['act']) ? '' : $_REQUEST['act'];
if($act=='add'){
    $username = empty($_REQUEST['username']) ? '' : $_REQUEST['username'];
    $tel = empty($_REQUEST['tel']) ? '' : $_REQUEST['tel'];
    $score = empty($_REQUEST['score']) ? 0 : $_REQUEST['score'];

    $sql = "SELECT count(*) as num,scores FROM `records` WHERE username='$username' AND telnumber='$tel'";
    $row = $db->getRow($sql);
    if($row['num']>0){
        if($score>$row['scores']){
            $sql = "UPDATE `records` SET scores=$score WHERE username='$username' AND telnumber='$tel'";
            $db->query($sql);
        }
    }else{
        $sql = "INSERT INTO `records`(`username`,`telnumber`, `scores`) VALUES ('$username','$tel',$score)";
        $db->query($sql);
    }

    $res['total'] = 1;
    //$res['id'] = $db->insert_id();
    if($res === false){
        return false;
    }else{
        die(json_encode($res));
    }
}elseif($act=='phb'){
    $username = empty($_REQUEST['username']) ? '' : $_REQUEST['username'];
    $tel = empty($_REQUEST['tel']) ? '' : $_REQUEST['tel'];
    $score = empty($_REQUEST['score']) ? 0 : $_REQUEST['score'];

    //SELECT *,Rank() OVER ( ORDER BY scores desc ) number FROM `records`
    //SELECT *,ROW_NUMBER() OVER ( ORDER BY scores desc ) number FROM `records`

    $sql = "SELECT * FROM `records` ORDER BY scores desc";
    $arr = $db->getAll($sql);
    // $sql = "SELECT number FROM (SELECT *,ROW_NUMBER() OVER ( ORDER BY scores desc ) number FROM `records`) as q WHERE username='$username' AND telnumber='$tel'";
    // $num = $db->getOne($sql);

    foreach ($arr as $k => $v) {
        if($v['username']==$username && $v['telnumber']==$tel){
            $res['ph'] = $k+1;
            break;
        }
    }

    //$res['ph'] = $num;
    $res['data'] = $arr;

    if($res === false){
        return false;
    }else{
        die(json_encode($res));
    }
}
?>
<!DOCTYPE HTML>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>新天药业</title>
    <link rel="stylesheet" href="css/loading.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
</head>
<body>
<div class="index">
    <div id="audio_btn" class="off">
        <audio loop="" src="images/music.mp3?t=1" id="media" autoplay="" preload=""></audio>
    </div>
    <div class="page page1 active">
        <div id="app">
            <div class="text-wrapper">
                <div class="text part1">
                    <div>
                        <span class="letter"><div class="character">L</div> <span></span></span>
                        <span class="letter"><div class="character">o</div> <span></span></span>
                        <span class="letter"><div class="character">a</div> <span></span></span>
                        <span class="letter"><div class="character">d</div> <span></span></span>
                        <span class="letter"><div class="character">i</div> <span></span></span>
                        <span class="letter"><div class="character">n</div> <span></span></span>
                        <span class="letter"><div class="character">g</div> <span></span></span>
                    </div>
                </div>
                <div class="how-to"><span>正在加载中，请您耐心等待...</span></div>
            </div>
        </div>
    </div>
    <div class="page page2">
        <img class="pic2" src="images/1.jpg">
        <img class="pic2_2" src="images/2.png">
        <img class="pic2_3" src="images/3.png">
    </div>
    <div class="page page3">
        <div class="score">0</div>
        <img class="pic3" src="images/4.png">
        <div class="wd block">
            <img class="pic3_2" src="images/8.png">
            <p class="qes"><span></span><br><span></span></p>
            <div class="ans">
                <ul></ul>
            </div>
        </div>
        <div class="wd hide">
            <p class="username">姓　名 <input id="username" type="text" name="username"></p>
            <p class="tel">手机号 <input id="tel" type="tel" name="tel" min="11"></p>
            <p id="err"></p>
            <a class="btn">提交</a>
        </div>
    </div>
    <div class="page page4">
        <img class="pic4" src="images/23.png">
        <div class="res">
            <p></p>
            <p></p>
            <a class="return"></a>
        </div>
        <img class="pic4_2" src="images/21.png">
    </div>
    <div class="page page5">
        <img class="pic5" src="images/20.jpg">
        <img class="pic5_2" src="images/22.png">
        <div class="box">
            <ul>

            </ul>
        </div>
    </div>
</div>
</body>