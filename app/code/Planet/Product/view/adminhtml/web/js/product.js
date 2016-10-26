require(['jquery'],function($){
    $(window).load(function() {
        $(document).on('change', '#xlsx_file', function(){
           $('.submit-import').trigger('click');
        });

        $(document).on('click', '#save', function(){
           $('.submit-order').trigger('click');
        });
    });
});