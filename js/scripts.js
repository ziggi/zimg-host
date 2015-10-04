window.addEventListener('load', function() {
	var appLocation = window.location;

	// links list
	document.querySelector('#btn-links').addEventListener('mousedown', function() {
		document.querySelector('#overlay').style.display = 'block';
		document.querySelector('#links-menu').style.display = 'block';
		document.querySelector('#links-menu select').dispatchEvent(new Event('change'));
		document.querySelector('#links-input').select();
	});

	document.querySelector('#btn-links-close').addEventListener('mousedown', function() {
		document.querySelector('#overlay').style.display = 'none';
		document.querySelector('#links-menu').style.display = 'none';
	});

	document.querySelector('#links-menu select').addEventListener('change', function() {
		var target = this.options[this.selectedIndex].dataset.target;

		var text = '';

		[].forEach.call(document.querySelectorAll('.' + target), function(element) {
			text += element.value + '\n';
		});

		document.querySelector('#links-input').value = text;
		document.querySelector('#links-input').select();
	});

	// form upload
	document.querySelector('#btn-disc').addEventListener('click', function() {
		document.querySelector('#file-input').dispatchEvent(new Event('click'));
	});

	document.querySelector('#file-input').addEventListener('change', function() {
		var formData = new FormData(document.querySelector('#form-input'));
		uploadFiles(formData);
	});

	// url upload
	document.querySelector('#btn-url').addEventListener('click', function() {
		document.querySelector('#overlay').style.display = 'block';
		document.querySelector('#url-menu').style.display = 'block';
		document.querySelector('#url-menu textarea').focus();
	});

	document.querySelector('#btn-url-clear').addEventListener('click', function() {
		document.querySelector('#url-menu textarea').value = '';
		document.querySelector('#url-menu textarea').focus();
	});

	document.querySelector('#btn-url-close').addEventListener('click', function() {
		document.querySelector('#overlay').style.display = 'none';
		document.querySelector('#url-menu').style.display = 'none';
	});

	document.querySelector('#btn-url-upload').addEventListener('click', function() {
		var inputValue = document.querySelector('#url-input').value;
		if (inputValue.length == 0) {
			document.querySelector('#url-menu textarea').focus();
			return;
		}

		var params = '';
		var inputArray = inputValue.split('\n');

		for (var i in inputArray) {
			params += 'urls[]=' + inputArray[i] + '&';
		}

		uploadFiles(params.slice(0, -1), true);

		document.querySelector('#btn-url-clear').dispatchEvent(new Event('click'));
		document.querySelector('#btn-url-close').dispatchEvent(new Event('click'));
	});

	// file drop
	document.querySelector('html').addEventListener('dragover', function(event) {
		event.preventDefault();
	});

	document.querySelector('html').addEventListener('drop', function(event) {
		event.preventDefault();

		var formData = new FormData();
		for (var i = 0; i < event.dataTransfer.files.length; i++) {
			formData.append("files[]", event.dataTransfer.files[i]);
		}

		uploadFiles(formData);
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
					document.querySelector('#file-list').innerHTML += event.target.responseText;
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
				document.querySelector('#file-list').innerHTML += event.target.responseText;

				if (document.querySelectorAll('.file-item').length > 1) {
					document.querySelector('#get-all-link').style.display = 'block';
				}
			};

			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			request.send('url=' + fileUrl + '&' + 'thumbUrl=' + fileThumbnailUrl + '&name=' + fileName + '&size=' + fileSize);
		}
	}

	function uploadFiles(data, url) {
		var request = new XMLHttpRequest();
		request.open('POST', 'upload.php');

		request.onload = function(event) {
			addImagesFromArray(event.target.responseText);
		};

		request.upload.addEventListener('progress', function(event) {
			updatePercentValue(parseInt(event.loaded / event.total * 100));
		}, false);

		if (url) {
			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		}

		request.send(data);
	}

	function updatePercentValue(percent) {
		document.querySelector('.progress').style.display = 'block';
		document.querySelector('.file-progress-bar').style.width = percent + '%';
		document.querySelector('.file-progress-percent').innerHTML = percent + '%';
	}
});
