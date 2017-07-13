<html>
<head>
    <title>Upload</title>
</head>
<body>

<form role="form" action="/save" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="inputfile">上传文件</label>
        <input type="file" id="inputfile" name="image">
        <p class="help-block"></p>
    </div>
    <button type="submit" class="btn btn-default">提交</button>
</form>

</body>
</html>