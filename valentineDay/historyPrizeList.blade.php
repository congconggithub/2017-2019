<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
     <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>历史中奖纪录</title>
    <script src="https://image.gcs1688.com/static/common/common.min.js"></script>
    <style>
        *{margin: 0; padding: 0; box-sizing: border-box;}
        .lover-historyWinner {width: 100%;}
        .history-tittle {background-color: #fafafa; color: #999999; font-size: 0.32rem; line-height:0.933rem; height:0.933rem;;text-align: center; }
        .data , .userName , .prize {float: left; width: 33.33%;}
        .history-ul {background-color: #ffffff; color: #333333; font-size: 0.347rem; text-align: center; }
        .history-ul .history-list {line-height: 1.453rem; height: 1.453rem; border-bottom: solid 0.013rem #e1e4eb;}
    </style>
</head>
<body>
<div class="lover-historyWinner">
    <div class="history-tittle">
        <div class="data">日期</div>
        <div class="userName">用户名</div>
        <div class="prize">中奖金额</div>
    </div>
    <ul class="history-ul">

    </ul>
</div>

<script type="text/javascript">
    var urlHistory = window.config.domain + '/activate/ValentineDay/historyPrizeList';

    $(function () {
        getPrizeList();
        formatDate(1548237793000)
    })
        /* 历史中奖纪录 */
        function getPrizeList() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:  urlHistory,
                type: 'post',
                data: {},
                success: function (res) {
                    if(res.status == 200){
                    console.log(res)
                        var data = res.data;
                        var html = '';
                        data.forEach(function (val) {
                            html += '     <li class="history-list">'+
                                                  '<div class="data">'+
                                                     formatDate(val.addtime) +
                                                  '</div>'+
                                                  '<div class="userName">'+
                                                      val.mobile +
                                                  '</div>'+
                                                  '<div class="prize">¥'+
                                                      val.prizeMoney +
                                                  '</div>'
                                              '</li>' ;
                        });
                        $(".history-ul").append(html);
                    }
                },
                error: function () {
                }
            })
        };

    function formatDate(timestamp){
        var date = new Date(timestamp);
        var newDate = date.setTime(timestamp)
        var year = date.getFullYear();
        var month = addZero(date.getMonth() + 1);
        var day = addZero(date.getDate());
        return  year + '.'+month + '.' + day;
    }
    function addZero(num) {
        return num < 10 ? '0' + num : num;
    }
</script>
</body>
</html>
