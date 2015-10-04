$(function(){
	var appLocation = window.location;

	// links list
	$('#btn-links').on('click', function() {
		$('#overlay').fadeIn(150);
		$('#links-menu').fadeIn(150);
		$('#links-menu select').trigger('change');
		$('#links-input').select();
	});

	$('#btn-links-close').on('click', function() {
		$('#overlay').fadeOut(150);
		$('#links-menu').fadeOut(150);
	});

	$('#links-menu select').on('change', function() {
		var target = $(this).find(':selected').attr('data-target');

		var text = '';

		$('.' + target).each(function(index, value) {
			text += $(this).val() + '\n';
		});

		$('#links-input').val(text);
		$('#links-input').select();
	});

	// form upload
	$('#btn-disc').on('click', function() {
		$('#file-input').click();
	});

	$('#file-input').on('change', function() {
		var formData = new FormData(document.querySelector("#form-input"));
		uploadForm(formData);
	});

	// url upload
	$('#btn-url').on('click', function() {
		$('#overlay').fadeIn(150);
		$('#url-menu').fadeIn(150);
		$('#url-menu textarea').focus();
	});

	$('#btn-url-clear').on('click', function() {
		$('#url-menu textarea').val('');
		$('#url-menu textarea').focus();
	});

	$('#btn-url-close').on('click', function() {
		$('#overlay').fadeOut(150);
		$('#url-menu').fadeOut(150);
	});

	$('#btn-url-upload').on('click', function() {
		var inputValue = $('#url-input').val();
		if (inputValue.length == 0) {
			$('#url-menu textarea').focus();
			return;
		}

		var inputArray = inputValue.split('\n');

		$.post("upload.php", {urls: inputArray}, function(data) {
			$('#btn-url-clear').trigger('click');
			$('#btn-url-close').trigger('click');
			addImagesFromArray(data);
		});
	});

	// file drop
	$('html').on('dragover', function(event) {
		event.preventDefault();  
		event.stopPropagation();
	});

	$('html').on('drop', function(event) {
		event.preventDefault();
		event.stopPropagation();

		var formData = new FormData();
		for (var i = 0; i < event.originalEvent.dataTransfer.files.length; i++) {
			formData.append("files[]", event.originalEvent.dataTransfer.files[i]);
		}

		uploadForm(formData);
	});
	
	// functions
	function addImagesFromArray(text) {
		var result = JSON.parse(text);

		for (var i = 0; i < result.length; i++) {
			var fileName = result[i].name;

			if (result[i].error.upload == 1) {
				var errorTypeText = 'Reason: ';

				if (result[i].error.type == 1) {
					errorTypeText += 'bad type';
					errorTypeText += ', ';
				}

				if (result[i].error.size == 1) {
					errorTypeText += 'bad size';
					errorTypeText += ', ';
				}

				if (result[i].error.host == 1) {
					errorTypeText += 'this host is blacklisted';
					errorTypeText += ', ';
				}

				if (result[i].error.type == 0 && result[i].error.size == 0 && result[i].error.host == 0) {
					errorTypeText = 'server error';
					errorTypeText += ', ';
				}

				errorTypeText = errorTypeText.slice(0, errorTypeText.length - 2);
				errorTypeText += '.';

				$.post('file_item_error.php', {name: fileName, error: errorTypeText}, function(data) {
					$('#file-list').append(data);
				});

				continue;
			}

			var fileUrl = appLocation + result[i].url;
			var fileThumbnailUrl = appLocation + 'thumb/' + result[i].url;
			var fileSize = result[i].size;

			$.post('file_item.php', {url: fileUrl, thumbUrl: fileThumbnailUrl, name: fileName, size: fileSize}, function(data) {
				$('#file-list').append(data);

				if ($('.file-item').length > 1) {
					$('#get-all-link').show();
				}
			});
		}
	}

	function uploadForm(formData) {
		var request = new XMLHttpRequest();
		request.open("POST", "upload.php");

		request.onload = function(event) {
			addImagesFromArray(event.target.responseText);
		};

		request.upload.addEventListener('progress', function(event) {
			updatePercentValue(parseInt(event.loaded / event.total * 100));
		}, false);

		request.send(formData);
	}

	function updatePercentValue(percent) {
		$('.progress').css('display', 'block');
		$('.file-progress-bar').css('width', percent + '%');
		$('.file-progress-percent').html(percent + '%');
	}
});
