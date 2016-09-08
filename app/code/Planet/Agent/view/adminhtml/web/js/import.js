require(['jquery'],function($){
    $(window).load(function() {
        $(document).on('change', '#xlsx_file', function(){
           $('.submit-import').trigger('click');
        });
    });
});