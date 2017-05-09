jQuery(document).ready(function(){
// If unauthorized user add body class mempressUnauthorized

// Check if the unauthorized message exists anywhere in the body
var mempressUnauthorized = jQuery("div").hasClass("mepr-unauthorized-message");

// Are we on a page were the Divi page builder is used?
var pageBuilderUsed = jQuery("body").hasClass("et_pb_pagebuilder_layout");

// If so add mempressUnauthorized class to body for additional styling
if (mempressUnauthorized == true && pageBuilderUsed == true){
      jQuery("body").addClass("mempressUnauthorized");
}

// Quick temporary fix for sorting eventbrite events
if(jQuery("body").hasClass("page-template-past-eventbrite-index")){

  articles = jQuery("#content-area article").reverse().detach();
  jQuery("#content-area").append(articles);
}

});
