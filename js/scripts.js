$(window).load(function () {

	$('#btn-disc').on('click', function () {
		$('#file-input').click();
		return false;
	});

	$('#file-input').on('change', function () {
		$('#form-input').ajaxForm({
			complete: function(xhr) {
				console.log(xhr.responseText);
			}
		}).submit();
	});
	
});