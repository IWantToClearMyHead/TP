<?php

$upfile = $_FILES['upfile'];

function upload_file($files, $path = "./upload", $imagesExt = ['jpg', 'png', 'jpeg', 'gif', 'mp4', 'zip', 'apk'])
{
    // 判断错误号
    if (@$files['error'] == 00) {
        // 判断文件类型
        $ext = strtolower(pathinfo(@$files['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $imagesExt)) {
            return "sad";
        }

        // 判断是否存在上传到的目录
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // 生成唯一的文件名
        $fileName = md5(uniqid(microtime(true), true)) . '.' . $ext;

        // 将文件名拼接到指定的目录下
        $destName = $path . "/" . $fileName;

        // 进行文件移动
        if (!move_uploaded_file($files['tmp_name'], $destName)) {
            return "upload nok...";
        }
        return "upload ok!";
    } else {
        // 根据错误号返回提示信息
        switch (@$files['error']) {
            case 1:
                echo "上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值";
                break;
            case 2:
                echo "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值";
                break;
            case 3:
                echo "文件只有部分被上传";
                break;
            case 4:
                echo "没有文件被上传";
                break;
            case 6:
            case 7:
                echo "系统错误";
                break;
        }
    }

}

echo upload_file($upfile);
?>
