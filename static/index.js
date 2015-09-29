$(document).ready(function() {
	$('select.dropdown').dropdown();
    $('.menu .item').tab();
    $('.ui.sidebar').sidebar('attach events', '.launch.button');
    $('.ui.checkbox').checkbox();
    
    $('.tabular.menu .item').click(function(){
    	$(this).siblings().removeClass('active');
    	$(this).addClass('active');
    });    

    $('#beautify_btn').click(function(){
    	var source = $('#beautify_input');
    	var val = source.val();
    	var cate = $('#beautify .menu .item.active').data('val');
    	if (!val) {
            return $('#beautify_input').focus();
        }
        if (cate === 'js') {
	        var result = js_beautify(val);
	        source.val(result);
	        return;
	    }
	    $.post('fl/beautify.php', {type:cate, source:val}, function(result){
	    	source.val(result);
	    });

    });

    $('#compressor_btn').click(function(){
    	var source = $('#compressor_input');
    	var val = source.val();
    	var cate = $('#compressor .menu .item.active').data('val');

    	if (!val) {
            return $('#compressor_input').focus();
        }
	    $.post('fl/compress.php', {type:cate, source:val}, function(result){
	    	source.val(result);
	    	$('#result').html('压缩前：'+val.length+ '&nbsp;&nbsp;&nbsp;&nbsp;压缩后：'+result.length+'&nbsp;&nbsp;&nbsp;&nbsp;压缩率：'+
			((val.length-result.length)*100/val.length).toFixed(2)+'%');
	    });

    });
});


$(function(){
    function sortByTimes(a, b){
        return b.count - a.count;
    }
    function sortByLen(a, b) {
        return b.len - a.len;
    }

    var WORD_REGEXP = /(\b\w+\b)|[\u2E80-\u9FFF]/g;

    function parse(text){
        var word_arr = text.match(WORD_REGEXP);
        var ret_arr = build(word_arr);
        return ret_arr;
    }
    function build(in_arr){

        function createItem(word){
            var item = {};
            item.count = 1;
            item.word = word;
            item.len = word.length;
            return item;
        }

        var ret_arr = [];
        var ret_obj = {};
        $.each(in_arr, function(i, word){
            if(!word) {
                return;
            }
            var item = ret_obj[word];
            if(item){
                item.count++;
            }else{
                item = {
                    count:1,
                    word:word,
                    len:word.length
                };
                ret_obj[word] = item;
            }
        });
        $.each(ret_obj, function(i, obj){
            ret_arr.push(obj);
        });
        return ret_arr;

    }

    $('#wordcount_btn').click(function(){
        var source = $('#wordcount_input');
        var val = source.val();
        var arr = parse(val);

        arr.sort(sortByTimes);

        var str_arr = [];

        for (var i = 0, len = arr.length; i < len; i++) {
            var item = arr[i];
            str_arr.push(item.word + ' x ' + item.count + ' <br>');
        };

        $('#wordcount_parse').html(str_arr.join(''));

    });

    $('#wordcount_save_btn').click(function(){

    });

});

