<html>
    <head>
        <title>test email</title>
    </head>

    <body>

    {{$name}}
    </body>
</html>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>找回密码链接</title>
	</head>
	<body>
		<p>亲爱的用户您好:</p>
		<p>您已经向系统申报要求取回密码.请点击以下链接按步骤找回支付密码</p>
		<a href="{{ $url }}">{{$name}}</a>
	</body>
	<script>
	</script>	
</html>