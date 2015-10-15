window.addEventListener('load', function() {
	// form upload
	document.querySelector('#btn-disc').addEventListener('click', function() {
		document.querySelector('#file-input').dispatchEvent(new MouseEvent('click'));
	});

	document.querySelector('#file-input').addEventListener('change', function() {
		var form = document.querySelector('#form-input');

		var formData = new FormData(form);
		window.uploadFiles(formData);

		form.reset();
	});

	// url upload
	document.querySelector('#btn-url-upload').addEventListener('click', function() {
		var inputValue = document.querySelector('#url-input').value;
		if (inputValue.length == 0) {
			return;
		}

		var params = '';
		var inputArray = inputValue.split('\n');

		for (var i in inputArray) {
			params += 'urls[]=' + inputArray[i] + '&';
		}

		window.uploadFiles(params.slice(0, -1), true);

		document.querySelector('#url-input').value = '';
	});

	// functions
	window.addError = function(value) {
		document.querySelector('#main-grid').insertAdjacentHTML('beforeend', value);
	}

	window.addImage = function(value) {
		document.querySelector('#main-grid').insertAdjacentHTML('beforeend', value);
	}

	window.updatePercentValue = function(percent) {
		if (percent >= 100) {
			document.querySelector('#progress').style.display = 'none';
		} else {
			document.querySelector('#progress').style.display = 'block';
			document.querySelector('#progress').MaterialProgress.setProgress(percent);
		}
	}
});
