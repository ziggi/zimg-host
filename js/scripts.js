window.addEventListener('load', function() {
	var appLocation = window.location;

	// file drop
	document.querySelector('html').addEventListener('dragover', function(event) {
		event.preventDefault();
	});

	document.querySelector('html').addEventListener('drop', function(event) {
		event.preventDefault();

		if (event.dataTransfer.files.length > 0) {
			var formData = new FormData();
			for (var i = 0; i < event.dataTransfer.files.length; i++) {
				formData.append("files[]", event.dataTransfer.files[i]);
			}

			window.uploadFiles(formData);
		}
	});

	// functions
	function addImagesFromArray(text) {
		var result = JSON.parse(text);

		for (var i in result) {
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

				errorTypeText = errorTypeText.slice(0, -2) + '.';

				var request = new XMLHttpRequest();
				request.open('POST', 'file_item_error.php');

				request.onload = function(event) {
					window.addError(event.target.responseText);
				};

				request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				request.send('name=' + fileName + '&' + 'error=' + errorTypeText);

				continue;
			}

			var fileUrl = appLocation + result[i].url;
			var fileThumbnailUrl = appLocation + 'thumb/' + result[i].url;
			var fileSize = result[i].size;

			var request = new XMLHttpRequest();
			request.open('POST', 'file_item.php');

			request.onload = function(event) {
				window.addImage(event.target.responseText);
			};

			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			request.send('url=' + fileUrl + '&' + 'thumbUrl=' + fileThumbnailUrl + '&name=' + fileName + '&size=' + fileSize);
		}
	}

	window.uploadFiles = function(data, url) {
		var request = new XMLHttpRequest();
		request.open('POST', 'upload.php');

		request.onload = function(event) {
			addImagesFromArray(event.target.responseText);
		};

		request.upload.addEventListener('progress', function(event) {
			window.updatePercentValue(parseInt(event.loaded / event.total * 100));
		}, false);

		if (url) {
			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		}

		request.send(data);
	}
});