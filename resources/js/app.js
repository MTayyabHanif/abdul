window.$ = window.jQuery = require('./jquery.js');
require('./bootstrap');

require('alpinejs');


console.log('Yes');
console.log($('body').length);

$('.view_task').click(function(e){
    e.preventDefault();
    let modal = $(this).attr('data-modal');
    $('#' + modal).addClass('show_modal');
});

$('.save_task').click(function () {
    $(this).parents('.task_modal').find('form').submit();
});
$('.close_modal').click(function () {
    $(this).parents('.task_modal').removeClass('show_modal');
})
