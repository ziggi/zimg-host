# zimg-host

Simple image hosting service

# Demo

http://img.ziggi.org/

# Backend requirement

- PHP >= 5.3.0
- GD extension

# Installation

- Copy files into your website directory (subdirectories are supported)
- Change config.php if you need
- Make sure that the file/ directory is writable by web server

# Config for nginx

If you are using nginx instead Apache, this configuration example can be useful to you:
```
location / {
	try_files $uri $uri/ /index.php?$args;
}
```

# Usage in CURL

You can upload images using CURL.

Some examples:
```
curl -F files[]=@image.jpg http://img.ziggi.org/api/upload.php
curl -F files[]=@image1.jpg -F files[]=@image2.jpg http://img.ziggi.org/api/upload.php
curl -F urls[]=http://i.imgur.com/VCcArdF.jpg?1 http://img.ziggi.org/api/upload.php
curl -F urls[]=http://i.imgur.com/VCcArdF.jpg?1 -F urls[]=http://i.imgur.com/hdsdwsS.jpg?1 http://img.ziggi.org/api/upload.php
```

Password protect upload:
```
curl -u whatever:YOUR_PASSWORD -F urls[]=http://i.imgur.com/VCcArdF.jpg?1 http://img.ziggi.org/api/upload.php
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
		"url":"mijhmyhS.jpg"
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
		"url":"GyDIPAGC.jpg"
	}
]
```
