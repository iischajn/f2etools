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
	    $.post('beautify/beautify.php', {type:cate, source:val}, function(result){
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
	    $.post('compressor/compress.php', {type:cate, source:val}, function(result){
	    	source.val(result);
	    	$('#result').html('压缩前：'+val.length+ '&nbsp;&nbsp;&nbsp;&nbsp;压缩后：'+result.length+'&nbsp;&nbsp;&nbsp;&nbsp;压缩率：'+
			((val.length-result.length)*100/val.length).toFixed(2)+'%');
	    });

    });
});
