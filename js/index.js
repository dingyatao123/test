window.onload = function () {
    $('.page1').removeClass('active');
    $('.page2').addClass('active');
    $('.page2 .pic2_2').addClass('animate__animated animate__backInDown');
    setTimeout("$('.page2 .pic2_3').addClass('animate__animated animate__tada');",1200);
}

var arr = [
    {"question":"“大姨妈”每个月都准时来找你吗？","answer": [10,0,5],"optain":["“大姨妈”月月规律“到岗”","“大姨妈”偶尔不规律","“大姨妈”已经和我告别快半年了"]},
    {"question":"你对自己的睡眠评价是？","answer": [5,0,10],"optain":["睡了也白睡，梦里多受罪","别的我不行，失眠熬夜第一名","一觉到天明，谁都叫不醒"]},
    {"question":"比起以前，现在总是觉得热，更容易出汗？","answer": [0,10,5],"optain":["经常大汗淋漓","从来不出汗，清凉又自在","以前没注意，好像有点符合"]},
    {"question":"觉得自己脾气怎么样？","answer":[0,5,10],"optain":["暴脾气，惹我者必诛之","脾气着急易发火，尚能自控","佛系没脾气，云淡风也轻"]},
    {"question":"你对护肤品、保养品怎么看？","answer": [5,10,0],"optain":["平时会做日常基础保养","天生丽质，皮肤好到无需保养","用最贵的面膜熬最贵的夜"]},
    {"question":"您是否经常容易伤风感冒","answer":[10,5,0],"optain":["半年没有去过药店、医院了","偶尔伤风感冒，3天自愈","经常伤风感冒，换季就生病"]},
    {"question":"平时觉得哪里疼？","answer":[0,5,10],"optain":["浑身上下都会疼","偶尔头疼，骨头疼","即使下雨天也全身活络没影响"]},
    {"question":"您的体力怎么样？","answer":[0,10,5],"optain":["面如菜色，没有活力","力大如牛，最爱远游","爬了四楼抖一抖"]},
    {"question":"您对目前的生活是否感到满意？","answer":[5,10,0],"optain":["生活还算过得去","每天开心，乐不思蜀","唉声叹气，遗恨悔过"]},
    {"question":"您还记得之前做过哪些题目吗？","answer":[10,5,0],"optain":["我还能说出第一题的题目呢","能记得一半左右","健忘是我的老毛病"]}
];

var a=[];
var score=0;

function cq(id){//显示下一题
    //console.log(a);
    //console.log(id);
    var s=0;
    for(i=0,len=a.length;i<len;i++){
        s+=arr[i].answer[a[i]-1];
    }
    score=s;
    $(".page3 .score").html(score);

    //移出
    setTimeout("$('.page3 .qes').addClass('animate__animated animate__backOutUp');",400);
    setTimeout("$('.page3 .pic3_2').addClass('animate__animated animate__backOutUp');",400);
    setTimeout("$('.page3 .ans').addClass('animate__animated animate__backOutDown');",400);
    if(id<10){
        setTimeout("$('.page3 .qes span:first-child').html('"+(id+1)+"/10');",800);//改值
        setTimeout("$('.page3 .qes span:last-child').html('"+arr[id].question+"');",800);
        setTimeout("$('.page3 .ans ul').html('');",800);
        for(i=0,len=arr[id].optain.length;i<len;i++){
            setTimeout("$('.page3 .ans ul').append('<a qustionid=\""+(id+1)+"\"><li>"+arr[id].optain[i]+"</li></a>');",800);
        }

        setTimeout("$('.page3 .qes').removeClass('animate__animated animate__backOutUp');",800);//显示
        setTimeout("$('.page3 .pic3_2').attr('src','images/"+(id+8)+".png').removeClass('animate__animated animate__backOutUp');",800);//显示
        setTimeout("$('.page3 .ans').removeClass('animate__animated animate__backOutDown');",800);//显示
    }else{
        setTimeout("$('.page3 .wd:nth-child(3)').removeClass('block').addClass('hide');$('.page3 .wd:nth-child(4)').addClass('block').removeClass('hide');",800);//显示
    }
}

// 验证手机号
function isPhoneNo(phone) {
    var pattern = /^1[34578]\d{9}$/;
    return pattern.test(phone);
}

$(document).ready(function(){
    var media = $("#media")[0];
    media.pause();
    $("#audio_btn").click(function(){
        if($(this).hasClass("rotate")){
            $(this).removeClass("rotate");
            media.pause();
        }else{
            $(this).addClass("rotate");
            media.play();
        }
    });
    $(".page2 .pic2_3").click(function () {
        $('.page2').removeClass('active');$('.page3').addClass('active');
       
        $(".page3 .qes span:first-child").html('1/10');
        $(".page3 .qes span:last-child").html(arr[0].question);
        $(".page3 .ans ul").html('');
        for(i=0,len=arr[0].optain.length;i<len;i++){
            $(".page3 .ans ul").append('<a qustionid="1" href="javascript: void(0);"><li>'+arr[0].optain[i]+'</li></a>');
        }
    });

    $('body').on('click','.page3 .ans ul a',function(){
        var id = parseInt($(this).attr('qustionid'));
        var ch = $(this).index()+1;
        if(a.length>=id){
            return;
        }
        a.push(ch);
        if(arr[id-1].answer[ch-1]==10){//答案改色
            $(this).addClass('r');
        }else{
            $(this).addClass('w');
        }
        setTimeout("$(this).removeClass('r w');",400);//答案还原
        cq(id);
    });

    $('body').on('click','.btn',function(){
        var username=$("#username").val();
        var tel=$("#tel").val();
        if ($.trim(tel).length == 0) {
            $("#err").html("<img src='images/19.png'> 手机号没有输入");
            return;
        }else if (isPhoneNo($.trim(tel)) == false) {
            $("#err").html("<img src='images/19.png'> 手机号码不正确");
            return;
        }else{
            $("#tel").focus(function() {
                $("#err").html("");
            });
        }

        $('.page4 .res p:first-child()').text(score);
        if(score>=80){
            $('.page4 .pic4').attr('src','images/23.png');
        }
        else if(score>=60 && score<80){
            $('.page4 .pic4').attr('src','images/24.png');
        }
        else if(score<60){
            $('.page4 .pic4').attr('src','images/25.png');
        }
        //$('.page4 .res p:nth-child(2)').html(ms);
        $('.page3').removeClass('active');$('.page4').addClass('active');
        $.ajax({
            url: '/xtyy/index.php?act=add',
            type: 'post',
            data: {username:username,tel: tel ,score: score},
            dataType: 'json',
            error: function () {
                console.log(-1);
                return false;
            },
            success: function(resp) {
                console.log(resp);
                if(resp.total==1){
                    //alert('成功！');
                }else{
                    //alert('失败！');
                }
            }
        });
    });
    $('body').on('click','.page4 .return',function(){
        location.reload();
    });
    $('body').on('click','.page4 .pic4_2',function(){
        var username=$("#username").val();
        var tel=$("#tel").val();
        $('.page4').removeClass('active');$('.page5').addClass('active');
        $('.page5 .box ul').html('');
        $.ajax({
            url: '/xtyy/index.php?act=phb',
            type: 'post',
            data: {username:username,tel: tel ,score: score},
            dataType: 'json',
            error: function () {
                console.log(-1);
                return false;
            },
            success: function(resp) {
                //console.log(resp);
                $('.page5 .box ul').append('<li>排行第'+resp.ph+'名</li>');
                for(var i=0,j=resp.data.length;i<j;i++){
                    $('.page5 .box ul').append('<li><span>第'+(i+1)+'名</span><span>'+resp.data[i].username+'</span><span>'+resp.data[i].scores+'</span></li>');
                }
                //resp.ph
            }
        });
    });
    $('body').on('click','.page5 .pic5_2',function(){
        $('.page5').removeClass('active');$('.page4').addClass('active');
    });
});