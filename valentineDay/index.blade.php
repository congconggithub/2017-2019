<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>情高意真 相爱财生</title>
    <script src="https://image.gcs1688.com/static/common/common.min.js"></script>
    <style>
        /*内容样式*/
        *{margin: 0; padding: 0; box-sizing: border-box;}
        body,html{background:#ffffff;}
        img.mainBg {width: 100%; display: block; }

        .lover-prize , .lover-mine , .lover-link{position: relative; width: 100%;}
        #prizeList {position: absolute; bottom: 0; text-align: center; width: 100%; height: 0.613rem; line-height: 0.613rem;
            overflow: hidden; color: #ffffff; font-size: 0.347rem;}
        .probability-funding , .probability-times {font-size: 0.24rem; color:#fffefe; border-bottom: solid 0.013rem #fffefe;
            position: absolute; bottom: 1.85rem;}
        .probability-funding {left: 2.9rem;}
        .probability-times {left:7.45rem;}
        .mine-today {position: absolute; bottom: 0.05rem; width: 100%; padding: 0 0.3rem;}
        .mine-funding , .mine-times {float: left; width: 50%; text-align: center; font-size: 0.293rem; color: #68484d;}
        .mine-funding span , .mine-times span {color: #c2262a;}
        .lover-winner {color: #6f4046; font-size: 0.293rem; position: relative;}
        .winnerList-ul {position: absolute; top: 2.2rem;  width: 100%; padding: 0 1rem; text-align: center;}
        .winnerList-ul li {line-height: 0.9rem;}
        .winnerList-ul li div {float: left;}
        .winnerList-ul li .prize {width: 27%;}
        .winnerList-ul li .none{width: 55%;}
        .winnerList-ul li .user{width: 29%;}
        .winnerList-ul li .num{width: 26%;}
        .winnerList-ul li .time{width: 17%;}
        .lover-now { position: fixed; bottom: 0;}
        .lover-rule {position: fixed; right: 0; top:6rem; width: 0.64rem;}
        .lover-rule img {width: 0.64rem;}
        .ruleDetail {width: 100%; position: relative;}
        .ruleDetail .loverRuleDetail{width: 8.667rem; height: 11.84rem;}
        .ruleDetail .loverClose {position: absolute;right: 0.4rem; top:0.48rem; width: 0.373rem; height: 0.373rem;}
    </style>
</head>
<body>
    <div class="lover-main">
        <div class="lover-prize">
            <img src="https://image.gcs1688.com/activity/2019ValentineDay/lover1.png" class="mainBg">
            <div id="prizeList">
                <ul>

                </ul>
            </div>
        </div>
        <div class="lover-mine">
            <img src="https://image.gcs1688.com/activity/2019ValentineDay/lover2.png" class="mainBg">
            <div class="mine-probability">
                <div class="probability-funding">
                    0%
                </div>
                <div class="probability-times">
                    0%
                </div>
            </div>
            <div class="mine-today">
                <div class="mine-funding">
                    <p>本日已累计出借：<span>0元</span></p>
                </div>
                <div class="mine-times">
                    <p>本日已出借次数：<span>0次</span></p>
                </div>
            </div>
        </div>
        <div class="lover-winner">
            <img src="https://image.gcs1688.com/activity/2019ValentineDay/lover3.png" class="mainBg">
            <ul class="winnerList-ul">
                <li class="ulList ulList520">
                     <div class="prize"> 520元现金奖</div>
                     <div class="none">暂无数据</div>
                     <div class="time">17:20</div>
                </li>
                <li class="ulList ulList1314">
                    <div class="prize">1314元现金奖</div>
                    <div class="none">暂无数据</div>
                    <div class="time">22:18</div>
                </li>
            </ul>
        </div>
        <div class="lover-link">
            <img src="https://image.gcs1688.com/activity/2019ValentineDay/lover4.png" class="mainBg">
        </div>
        <img src="https://image.gcs1688.com/activity/2019ValentineDay/lover5.png" class="mainBg">
        <img src="https://image.gcs1688.com/activity/2019ValentineDay/lover6.png" class="mainBg">
    </div>
    <div class="lover-rule">
        <img src="https://image.gcs1688.com/activity/2019ValentineDay/loverRule.png" class="loverRule">
        <img src="https://image.gcs1688.com/activity/2019ValentineDay/loverHistory.png" class="loverHistory">
    </div>
    <footer>
        <div class="lover-now">
            <img src="https://image.gcs1688.com/activity/2019ValentineDay/loverbtn.png" class="mainBg">
        </div>
    </footer>

</body>
<script>
    var mineUrl = window.config.domain + '/activate/ValentineDay/index';
    var timeUrl = window.config.domain + '/activate/ValentineDay/time';
    var prizeUrl = window.config.domain + '/activate/ValentineDay/historyPrizeList';
    var todayUrl = window.config.domain + '/activate/ValentineDay/prizeList';
    var startT = '';
    var endT = '';
    var nowTime = '';

    $(function() {
        checkUser();
        FastClick.attach(document.body);

        getTime();
        getPrizeList();
        todayPrizeList();

        setTimeout(function () {
            getMyProbability();
        },500);

        //文字向上滑动
        $(document).ready(function(){
            setInterval('AutoScroll("#prizeList")',3000);
        });
        /*查看规则*/
        $(document).on('click','.loverRule',function () {
            ruleHtml = '<div class="ruleDetail"><img src="https://image.gcs1688.com/activity/2019ValentineDay/loverRuleDetail.png" class="loverRuleDetail"><img src="https://image.gcs1688.com/activity/2019ValentineDay/loverClose.png" class="loverClose"></div>';

            var ruleLay = layer.open({
                type: 1,
                area: ['8.667rem','11.84rem'],
                skin: 'bless',
                shadeClose: true,
                content: ruleHtml
            });
            $(".loverClose").on("click",function () {
                layer.close(ruleLay);
            });
        });
        // 历史纪录跳转
        $(document).on('click','.loverHistory',function () {
            window.location.href =window.config.domain + '/activate/ValentineDay/historyPrizeList';
        });
        // 立即出借
        $(document).on('click','.lover-now',function () {
            if (isStart()) {
                goProductList();
            }
        });

    });
    //获取时间
    var getTime = function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: timeUrl,
            type: 'post',
            data: {},
            success: function (res) {
                startT = res.start;
                endT = res.end;
                nowTime = res.current;
            }
        })
    };
    /* 文字往上滚动效果 */
    function AutoScroll(obj){
        $(obj).find("ul:first").animate({
            marginTop:"-0.333rem"
        },500,function(){
            $(this).css({marginTop:"0rem"}).find("li:first").appendTo(this);
        });
    };
    // 头部滚动 , 历史中奖纪录
    function getPrizeList() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:  prizeUrl,
            type: 'post',
            data: {},
            success: function (res) {
                if(res.status == 200){
                    var data = res.data;
                    var html = '';
                    data.forEach(function (val) {
                        html += ' <li class="winner">' +
                            '         <span>'+formatDate(val.addtime)+'&nbsp;'+ val.mobile +'&nbsp;抽中'+val.prizeMoney+'元现金</span>' +
                            '     </li>'  ;
                    });
                    $("#prizeList ul").append(html);
                }
            },
            error: function () {
            }
        })
    };
    // 我的中奖概率
    function getMyProbability(){
        $.ajax({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url:  mineUrl,
             type: 'post',
//             data: {token:'VEtfMjAxOTAxMjQxOTM5MjlfOTA3ODNfMDU4MjA5X1c1bGVLVFluUU5TL1VGZGVnOE9GdCtGVzJo\ncGxwcHMwRFprV3dRQUVvdFk9Cg=='},
             data: {token:window.config.token},
             success: function(res){
                if(res.status == 200){
                    $(".probability-funding").html(res.data.rate1);
                    $(".probability-times").html(res.data.rate2);
                    $(".mine-funding span" ).html(res.data.totalInvestMoney + "元");
                    $(".mine-times span" ).html(res.data.totalInvestTime + "次");
                }
             }
        })
    };
    // 今日中奖名单
    function todayPrizeList(){
        $.ajax({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url:  todayUrl,
             type: 'post',
             data: {},
             success: function(res){
                if(res.status == 200){
                    if(res.data.length>0){
                    console.log(res.data.length)
                        var data = res.data;
                        var html = '';
                        var numORtimes  ='';
                        data.forEach(function (val) {
                            if (val.money == 520 ){
                                numORtimes = val.num + '次' ;
                                html = ' <li class="ulList">'+
                                        '<div class="prize">'+ val.money +'元现金奖</div>'+
                                        '<div class="user">'+ val.mobile + '</div>'+
                                        '<div class="num">'+ numORtimes +'</div>'+
                                        '<div class="time"> 17:20</div>' +
                                     '</li>' ;
                                $(".ulList520").html(html);
                            }else if(val.money == 1314){
                                numORtimes = val.investMoney +'元'
                                html = ' <li class="ulList">'+
                                            '<div class="prize">'+ val.money +'元现金奖</div>'+
                                            '<div class="user">'+ val.mobile + '</div>'+
                                            '<div class="num">'+ numORtimes +'</div>'+
                                            '<div class="time">22:18</div>' +
                                         '</li>' ;
                                $(".ulList1314").html(html);
                            }

                        });

                    }
                }
             }
        })
    };
    function formatDate(timestamp){
        var date = new Date(timestamp);
        var newDate = date.setTime(timestamp)
        var year = date.getFullYear();
        var month = addZero(date.getMonth() + 1);
        var day = addZero(date.getDate());
        return  month + '月' + day +'日';
    };

    function addZero(num) {
        return num < 10 ? '0' + num : num;
    };

    var tip = function(info){
        layer.open({
            skin: 'msg',
            content: '<div style="line-height:1.5;"><p style="color:#fff;font-size:0.4rem;">'+info+'</p></div>',
            time: 2
        });
    };
    /*活动是否开始*/
    var isStart = function(needLogin) {
        if(!window.config.isInApp) {
            window.location.href = "http://a.app.qq.com/o/simple.jsp?pkgname=com.gcs.phone";
            return false;
        }
        var startTime = new Date().formatTimestamp(startT);
        var endTime = new Date().formatTimestamp(endT);
        if(nowTime < startTime){
            layer.open({
                content:'<div style="line-height:1.5;"><p style="color:#fff;font-size:0.6rem;">活动未开始！</p>'+
                    '<p style="color:#fff;font-size:0.5rem;">活动时间:'+startT.substring(0,10)+'~'+endT.substring(0,10)+'</p></div>',
                time: 2
            });
            return false;
        }else if(nowTime > endTime) {
            layer.open({
                content:'<div style="line-height:1.5;"><p style="color:#fff;font-size:0.6rem;">活动已结束！</p>'+
                    '<p style="color:#fff;font-size:0.5rem;">活动时间:'+startT.substring(0,10)+'~'+endT.substring(0,10)+'</p></div>',
                time: 2
            });
            return false;
        }
        if(!window.config.isLogin) {
            login();
            return false;
        }
        return true;
    }
    /*防止滑动*/
    var mo = function(e) {
        e.preventDefault()
    }
    var stop = function() {
        document.body.style.overflow='hidden';
        document.addEventListener("touchmove",mo,false);
    }
    var move = function() {
        document.body.style.overflow='';
        document.removeEventListener("touchmove",mo,false);
    }
    Date.prototype.formatTimestamp = function (val) {
        var f = val.split(' ', 2);
        var d = (f[0] ? f[0] : '').split('-', 3);
        var t = (f[1] ? f[1] : '').split(':', 3);
        return (new Date(
            parseInt(d[0], 10) || null,
            (parseInt(d[1], 10) || 1) - 1,
            parseInt(d[2], 10) || null,
            parseInt(t[0], 10) || null,
            parseInt(t[1], 10) || null,
            parseInt(t[2], 10) || null
        )).getTime();
    }
</script>
</html>
