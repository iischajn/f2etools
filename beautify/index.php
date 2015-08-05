<?php
$file = "num.php";
$num = 0;
if(file_exists($file)){
	$num = intval(require_once $file);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Js/Css/HTML美化工具</title>
    <style>
    * {
        padding: 0;
        margin: 0
    }
    
    .clearfix:after {
        content: '\20';
        display: block;
        height: 0;
        clear: both
    }
    
    .clearfix {
        zoom: 1
    }
    
    body {
        min-width: 1000px;
    }
    
    h1 {
        padding: 20px 0;
        font-size: 40px;
        margin-left: 20px;
    }
    
    .list {
        margin-top: 20px;
        margin-left: 20px;
    }
    
    .list li {
        float: left;
        list-style: none;
        width: 150px;
        text-align: center;
        background: #ccc;
        height: 40px;
        line-height: 40px;
        margin-right: 10px;
        -webkit-border-top-left-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        cursor: pointer;
    }
    
    .list li.on {
        background: #666;
        color: #fff
    }
    
    #result {
        margin-left: 20px;
        padding-bottom: 20px;
    }
    </style>
    <link href="/Public/css/apps/bc-mis.css?002.css" rel="stylesheet" type="text/css" media="screen">
    <script type="text/javascript" src="http://s0.qhimg.com/lib/qwrap/113.js"></script>
    <script type="text/javascript" src="jsbeautify.js"></script>
</head>

<body style="text-align:left;">
    <div id="hd" style="margin:0 10px;">
        <div>
            <a class="logo" href="/Index/index" title="返回首页"><img src="/Public/css/mis/images/logo.png"></a>
            <h1 style="float:left;font-size:36px;font-weight:bold;line-height:95px;margin-left:20px;color:gray">Js/Css/HTML美化工具</h1>
            <ul class="home-header">
                <li style="border:none;"><a href="/index/index">奇舞团首页</a></li>
            </ul>
        </div>
    </div>
    <ul class="list clearfix">
        <li>Javascript美化</li>
        <li class="">HTML美化</li>
        <li class="">CSS美化</li>
    </ul>
    <div style="padding:20px;padding-top:0px;">
        <textarea style="width:100%;height:400px;" id="source" placeholder="要美化的代码"></textarea>
        <div>
            <button style="font-size:20px;padding:5px 20px;margin-left:30%;" id="btn">美化</button>
        </div>
    </div>
    <div id="result">
    </div>
    <div id="ft">©2012&nbsp;奇舞团 @ 360.cn
        <br/><span style="color:gray">技术支持请联系：welefen / 李成银 / 老六 (已经使用了<?php echo $num?>次)</span></div>
    <script>
    Dom.ready(function() {
        var lis = W('.list li'),
            current = 0,
            h = location.hash.substr(1),
            c = ['js', 'html', 'css'],
            s = c.indexOf(h);

        W('#btn').click(function() {
            var source = W('#source');
            var value = source.val();
            if (!value) {
                return source[0].focus();
            }
            var type = c[current];
            if (type === 'js') {
                var result = js_beautify(value);
                source.val(result);
                return;
            }
            QW.Ajax.post('beautify.php', ({
                type: c[current],
                source: value
            }), function(result) {
                source.val(result);
            })
        })

        if (s == -1) s = 0;
        current = s;
        lis[current].className = 'on';
        W('#s' + current).setStyle("display", 'inline-block');
        lis.forEach(function(li, i) {
            W(li).click(function() {
                if (current === i) return;
                lis[current].className = '';
                W('#s' + current).setStyle("display", 'none');
                current = i;
                location.hash = c[i];
                lis[current].className = 'on';
                W('#s' + current).setStyle("display", 'inline-block');
            })
        })
    });
    </script>
</body>

</html>
