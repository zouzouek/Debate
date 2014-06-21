function main_search(){
    $('#search').qtip({
        content: $("#searchdiv"),
        hide: {
            fixed: 'true', 
            delay: '200', 
            effect: function(){
                $(this).slideUp();
            }
        },
        show: {
            effect: function(){
                $(this).slideDown();
            }
        },
        position: {
            my: 'top center',  // Position my top left...
            at: 'bottom center', // at the bottom right of...
            target: $('#search') // my target
        },
        style: 'qtip-tipsy' //'qtip-bootstrap'
    });
           
}
function execute_search(link){
    window.location = link;
}

$("#searchbar").on('keyup', function(e) {
    var input = $.trim($('#searchbar').val());
    if(e.which == 13 && input !="") {
        var link = 'search.php?q='+encodeURIComponent(input);
        execute_search(link);
    }
});

$("#entersearch a").on('click', function(e) {
    e.preventDefault();
    var input = $.trim($('#searchbar').val());
    if(input != ""){
        var link = 'search.php?q='+input;
        execute_search(link);
    }
});