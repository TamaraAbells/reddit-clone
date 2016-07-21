$(document).ready(function() {

	if ($("#post-creation-form").length) {
		var textpost = $('#textpost-field').val();

		if (getUrlVars()[0] == 'selfpost' || textpost == '1') {
			changePostType('text');
		}
	}

	// Selecting Post Type
	var postType = '';

	$('.post-type-selector').click(function() {
		postType = $(this).find('p').text();
		changePostType(postType);
	});

	function changePostType(postType) {
		var validPostTypes = ['link', 'text'];
		var inputId = "#" + postType + "-input";
		var selectorId = "#" + postType + "-selector"
		var textpost = postType == 'link' ? 0 : 1;
		
		if (validPostTypes.indexOf(postType) < 0) return;
		if ($(selectorId).hasClass('selected')) return;

		console.log("test?");

		$(".post-type-selector").removeClass('selected');
		$(selectorId).addClass('selected');

		$(".post-type-field").hide();
		$(inputId).show();

		$("#textpost-field").val(textpost);
	}

});

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}