require('./bootstrap');

window.$ = window.jQuery = require( "jquery" );

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


jQuery(document).ready(function($){

    setTimeout(() => {
        $('#status_massage'). slideUp('slow');
    }, 2000);


//task filter box

$('#task_filter_btn').on('click', function(){
    var text =$(this).text();
    if(text == 'Task Filtering'){
        $(this).text('Close Filtering');
    }
    if(text == 'Close Filtering'){
            $(this).text('Task Filtering');
        }



     $('#task_filter').slideToggle('slow');

})


});

CKEDITOR.replace('description');


