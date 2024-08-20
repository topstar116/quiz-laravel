<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Create RESUMEPDF</title>
    <style>
        body {
            font-family: ipag;
        }

        .resumepdf {
            width: 100%;
            padding: 5%;
        }

        .title {
            width: 100%;
            text-align: center;
            padding: 5% 0;
        }

        .content {
            letter-spacing: 2px;
        }
    </style>
</head>

<body>
    <div class="resumepdf">
        {!! $resume_content !!}
    </div>

</body>

</html>
