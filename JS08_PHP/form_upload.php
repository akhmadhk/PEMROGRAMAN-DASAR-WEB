<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
</head>
<body>
    <h2>Form Upload File</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Pilih file yang ingin diupload:<br>
        <input type="file" name="myfile"><br><br>
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>