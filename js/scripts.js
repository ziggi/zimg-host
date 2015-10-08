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
				showErrorMessage(fileName, getErrorMessage(result[i].error));
				continue;
			}

			var fileUrl = appLocation + result[i].url;
			var fileThumbnailUrl = appLocation + 'thumb/' + result[i].url;
			var fileSize = result[i].size;

			var request = new XMLHttpRequest();
			request.open('POST', 'api/file_item.php');

			request.onload = function(event) {
				window.addImage(event.target.responseText);
			};

			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			request.send('url=' + fileUrl + '&' +
			             'thumbUrl=' + fileThumbnailUrl + '&' +
			             'name=' + fileName + '&' +
			             'size[width]=' + fileSize.width + '&' +
			             'size[height]=' + fileSize.height + '&' +
			             'size[filesize]=' + fileSize.filesize);
		}
	}

	window.uploadFiles = function(data, url) {
		if (typeof data.getAll === 'function' && !url) {
			var files = data.getAll('files[]');

			var request = new XMLHttpRequest();
			request.open('POST', 'api/validate.php');

			request.onload = function(event) {
				var result = JSON.parse(event.target.responseText);

				// show error messages and remove wrong items
				var i = result.length;

				while (i--) {
					var fileName = result[i].name;

					if (result[i].error.upload == 1) {
						showErrorMessage(fileName, getErrorMessage(result[i].error));
						result.splice(i, 1);
					}
				}

				// make new FormData without wrong items
				var newData = new FormData();

				for (i in files) {
					for (j in result) {
						if (result[j].name === files[i].name) {
							newData.append('files[]', files[i]);
						}
					}
				}

				// upload
				if (newData.getAll('files[]').length > 0) {
					upload(newData, url);
				}
			}

			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			request.send('files=' + JSON.stringify(files, ['name', 'size', 'type']));
		} else {
			upload(data, url);
		}
	}

	function upload(data, url) {
		var request = new XMLHttpRequest();
		request.open('POST', 'api/upload.php');

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

	function showErrorMessage(fileName, errorTypeText) {
		var request = new XMLHttpRequest();
		request.open('POST', 'api/file_item_error.php');

		request.onload = function(event) {
			window.addError(event.target.responseText);
		};

		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send('name=' + fileName + '&' + 'error=' + errorTypeText);
	}

	function getErrorMessage(error) {
		var errorTypeText = 'Reason: ';

		if (error.type == 1) {
			errorTypeText += 'bad type, ';
		}

		if (error.size == 1) {
			errorTypeText += 'bad size, ';
		}

		if (error.host == 1) {
			errorTypeText += 'this host is blacklisted, ';
		}

		if (error.type == 0 && error.size == 0 && error.host == 0) {
			errorTypeText = 'server error, ';
		}

		errorTypeText = errorTypeText.slice(0, -2) + '.';

		return errorTypeText;
	}
});