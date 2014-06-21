/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var imageSearch;


function searchComplete(message) {
    // Check that we got results
    var stuff = message.split("-");
    var cap = stuff[1].replace(/\s/g, '_');
    if ( imageSearch.results.length > 0) {
        // Grab our content div, clear it.
        var contentDiv = document.getElementById('content');


        // Loop through our results, printing them to the page.
        var results = imageSearch.results;
        
        // for (var i = 0; i < results.length; i++) {
        // For each result write it's title and image to the screen
        var result = results[0];

        var imgContainer = document.createElement('li');
        var room = document.createElement('a');
        var hcap = cap.replace(/\#/, '');
        room.href = "room.php?cat=" + stuff[0] + "&tag=" + hcap;


        var newImg = document.createElement('img');
        // There is also a result.url property which has the escaped version
        newImg.src = result.url;



        var caption = document.createElement('p');
        caption.className = "flex-caption";
        var text=document.createElement('span');
        text.innerHTML = cap;
        text.id="caption";
        
        caption.appendChild(text);
        room.appendChild(newImg);
        room.appendChild(caption);
        imgContainer.appendChild(room);
        //alert(newImg);
        contentDiv.appendChild(imgContainer);

    }
}

function OnLoad(query) {
    // Our ImageSearch instance.
    imageSearch = new google.search.ImageSearch();

    // Restrict to extra large images only
    imageSearch.setRestriction(google.search.ImageSearch.RESTRICT_IMAGESIZE,
            google.search.ImageSearch.IMAGESIZE_LARGE);
    imageSearch.setRestriction(google.search.ImageSearch.RESTRICT_RIGHTS,
            google.search.ImageSearch.RIGHTS_MODIFICATION);


    imageSearch.setRestriction(
            google.search.ImageSearch.RESTRICT_FILETYPE,
            google.search.ImageSearch.FILETYPE_JPG
            );
    imageSearch.setResultSetSize(1);
    // Here we set a callback so that anytime a search is executed, it will call
    // the searchComplete function and pass it our ImageSearch searcher.
    // When a search completes, our ImageSearch object is automatically
    // populated with the results.

    imageSearch.setSearchCompleteCallback(this, searchComplete, [query]);
    var q = query.split("-");
    // Find me a beautiful car.
   //if (q[0] === "Sports") {
     var topic = q[1].replace(/\s/g, ' versus ');
        imageSearch.execute(topic + " " + q[0]);
    //}
    /*else {
        imageSearch.execute(q[1] + " " + q[0]);
    }*/

}