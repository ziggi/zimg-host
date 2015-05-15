# zimg-host

Simple image hosting service

# Demo

http://img.ziggi.org/

# Usage in CURL

Some examples:
```
curl -F files[]=@image.jpg http://img.ziggi.org/upload.php
curl -F files[]=@image1.jpg -F files[]=@image2.jpg http://img.ziggi.org/upload.php
curl -F urls[]=http://i.imgur.com/VCcArdF.jpg?1 http://img.ziggi.org/upload.php
curl -F urls[]=http://i.imgur.com/VCcArdF.jpg?1 -F urls[]=http://i.imgur.com/hdsdwsS.jpg?1 http://img.ziggi.org/upload.php
```
example of result string (formatted for readability):
```json
[
	{
		"name":"image1.jpg",
		"type":2,
		"size":
		{
			"width":420,
			"height":336,
			"filesize":26834
		},
		"error":
		{
			"upload":0,
			"type":0,
			"size":0
		},
		"url":"ccc762c11f336cfa9fdbcc1b7ea4c1a3.jpg"
	},
	{
		"name":"image2.jpg",
		"type":2,
		"size":
		{
			"width":703,
			"height":442,
			"filesize":88604
		},
		"error":
		{
			"upload":0,
			"type":0,
			"size":0
		},
		"url":"f05b3f3eb1fa61431a7dddca9b4351fc.jpg"
	}
]
```