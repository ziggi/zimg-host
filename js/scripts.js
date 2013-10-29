$(window).load(function () {

	$('#btn-disc').on('click', function () {
		$('#file-input').click();
	});

	$('#file-input').on('change', function () {
		$('#form-input').ajaxForm({
			complete: function(xhr) {
				var result = JSON.parse(xhr.responseText);

				for (var i = 0; i < result.length; i++) {
					$('#file-list').append('<p><img src="http://127.0.0.1/img.ziggi.org/file/' + result[i].url + '"></p>');
				}
			}
		}).submit();
	});
	
});