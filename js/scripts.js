$(function(){

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
					var fileName = result[i].name;

					if (result[i].error.upload == 1) {
						var errorTypeText;

						if (result[i].error.upload.type == 1 && result[i].error.upload.size == 1) {
							errorTypeText = 'Type and size error.';
						} else if (result[i].error.upload.type == 1) {
							errorTypeText = 'Type error.';
						} else if (result[i].error.upload.size == 1) {
							errorTypeText = 'Size error.';
						} else {
							errorTypeText = 'Server error.';
						}

						$.get('file_item_error.html', function(data) {
							var content = $('<div>').html(data);
							content.find('p').html('File ' + fileName + ' has been not uploaded. ' + errorTypeText);
							$('#file-list').append(content.html());
						});

						continue;
					}

					var url = window.location + 'file/' + result[i].url;

					$.get('file_item.html', function(data) {
						var content = $('<div>').html(data);

						content.find('.link').attr('value', url);

						content.find('a.direct_link').attr('href', url);
						content.find('input.direct_link').attr('value', url);

						content.find('.img_small').attr('src', url);

						content.find('.bb_pwi').attr('value', '[url=' + url + '][img]' + url + '[/img][/url]');
						content.find('.bb_image').attr('value', '[img]' + url + '[/img]');

						content.find('.html_pwi').attr('value', '<a href="' + url + '" target="_blank"><img src"' + url + '" attr="' + name + '"></a>');
						content.find('.html_image').attr('value', '<img src"' + url + '" attr="' + fileName + '">');

						$('#file-list').append(content.html());
					});
				}
			}
		}).submit();
	});
	
});