$(function(){

	$('#btn-url').on('click', function () {
		$('#overlay').fadeIn(150);
		$('#url-menu').fadeIn(150);
		$('#url-menu textarea').focus();
	});

	$('#btn-url-clear').on('click', function () {
		$('#url-menu textarea').val('');
		$('#url-menu textarea').focus();
	});

	$('#btn-url-close').on('click', function () {
		$('#overlay').fadeOut(150);
		$('#url-menu').fadeOut(150);
	});

	$('#btn-disc').on('click', function () {
		$('#file-input').click();
	});

	$('#file-input').on('change', function () {
		$('#form-input').ajaxForm({
			beforeSend: function() {
				$('.progress').css('display', 'block');
				updatePercentValue(0);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				updatePercentValue(percentComplete);
			},
		    success: function() {
		    	updatePercentValue(100);
		    },
			complete: function(xhr) {
				var result = JSON.parse(xhr.responseText);

				for (var i = 0; i < result.length; i++) {
					var fileName = result[i].name;

					if (result[i].error.upload == 1) {
						var errorTypeText;

						if (result[i].error.type == 1 && result[i].error.size == 1) {
							errorTypeText = 'Type and size error.';
						} else if (result[i].error.type == 1) {
							errorTypeText = 'Type error.';
						} else if (result[i].error.size == 1) {
							errorTypeText = 'Size error.';
						} else {
							errorTypeText = 'Server error.';
						}

						$.get('file_item_error.php', {name: fileName, error: errorTypeText}, function(data) {
							$('#file-list').append(data);
						});

						continue;
					}

					var fileUrl = window.location + 'file/' + result[i].url;

					$.get('file_item.php', {url: fileUrl, name: fileName}, function(data) {
						$('#file-list').append(data);
					});
				}
			}
		}).submit();
	});
	
	function updatePercentValue(percent) {
		$('.file-progress-bar').css('width', percent + '%');
		$('.file-progress-percent').html(percent + '%');
	}
});