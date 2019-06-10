<script>

$( ".menubutton" ).click(function() {
	$('.menubutton').removeClass('orange darken-1');
	if ($(this).attr('id') != 'soundhubbutton')
		$(this).addClass('orange darken-1');
	
	sendxmlhttp($(this).attr('value'));
});

$(document).on('click', ".buttonjq", function() {
	
	sendxmlhttp($(this).attr('value'));
	
});

function sendxmlhttp(query) {

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById('contentContainer').innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", query, false);
	xmlhttp.send();
	
}
</script>