window.addEventListener('load', function() {
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
		document.querySelector('#file-input').dispatchEvent(new MouseEvent('click'));
	});

	document.querySelector('#file-input').addEventListener('change', function() {
		var form = document.querySelector('#form-input');

		var formData = new FormData(form);
		window.uploadFiles(formData);

		form.reset();
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

		window.uploadFiles(params.slice(0, -1), true);

		document.querySelector('#btn-url-clear').dispatchEvent(new MouseEvent('click'));
		document.querySelector('#btn-url-close').dispatchEvent(new MouseEvent('click'));
	});

	// functions
	window.addError = function(value) {
		document.querySelector('#file-list').insertAdjacentHTML('beforeend', value);
	}

	window.addImage = function(value) {
		document.querySelector('#file-list').insertAdjacentHTML('beforeend', value);

		if (document.querySelectorAll('.file-item').length > 1) {
			document.querySelector('#get-all-link').style.display = 'block';
		}
	}

	window.updatePercentValue = function(percent) {
		document.querySelector('.progress').style.display = 'block';
		document.querySelector('.file-progress-bar').style.width = percent + '%';
		document.querySelector('.file-progress-percent').innerHTML = percent + '%';
	}
});
