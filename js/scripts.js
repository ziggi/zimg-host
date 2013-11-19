$(window).load(function () {

	$('#btn-disc').on('click', function () {
		$('#file-input').click();
	});

	$('#file-input').on('change', function () {
		$('#form-input').ajaxForm({
			beforeSend: function() {
				// TODO: create 0% progress bar's
			},
			uploadProgress: function(event, position, total, percentComplete) {
				// TODO: usage percentComplete for showing upload progress
			},
			complete: function(xhr) {
				var result = JSON.parse(xhr.responseText);

				for (var i = 0; i < result.length; i++) {
					if (result[i].error.upload == 1) {
						$('#file-list').append('<div class="file-item"><p>Файл ' + result[i].name + ' не загружен из-за ошибки</p></div>');
						continue;
					}

					var url = window.location + 'file/' + result[i].url;

					$('#file-list').append('\
      <div class="file-item">\
        <p><a href="' + url + '" target="_blank"><img src="' + url + '" alt="' + result[i].name + '"></a></p>\
        <table>\
          <tbody>\
            <tr><td>Изображение</td><td><input type="text" value="' + url + '"></td></tr>\
            <tr><td>Превью с увеличением, BB код</td><td><input type="text" value=""></td></tr>\
            <tr><td>Картинка, BB код</td><td><input type="text" value="[img]' + url + '[/img]"></td></tr>\
            <tr><td>Превью с увеличением, HTML код</td><td><input type="text" value=""></td></tr>\
            <tr><td>Картинка, HTML код</td><td><input type="text" value=\'<img src="' + url + '" alt="' + result[i].name + '">\'></td></tr>\
          </tbody>\
        </table>\
      </div>');
				}
			}
		}).submit();
	});
	
});