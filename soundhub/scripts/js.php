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

$(document).on('change', "#photoinput", function() {
	
	$('#filepath').show();
	$('#filepath').html("<small>" + $(this).val().split(/(\\|\/)/g).pop() + "</small>");
	
});

$(document).on('click', "#submit_user_edit", function() {
	
	sendxmlhttp($(this).attr('value') + '?phone=' + encodeURI($('#phoneinput').val()) + '&description=' + encodeURI($('#descriptioninput').val()), $('#photoinput')[0].files[0]);
	
});

$(document).on('click', "#submit_upload", function() {
	
	let query = $(this).attr('value');
	query += 'title='+encodeURI($('#uploadtrackname').val());
	query += '&genre_id='+encodeURI($('#uploadgenre').val());
	query += '&playlist_id='+encodeURI($('#uploadplaylist').val());
	
	sendxmlhttp(query, $('#uploadtrack')[0].files[0]);
	
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

function sendxmlhttp(query, fl) {

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.file = fl;
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById('contentContainer').innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", query, false);
	xmlhttp.send();
	
}

</script>