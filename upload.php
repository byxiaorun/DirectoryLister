<?php
/*
php ini
upload_max_filesize = 1G
post_max_size = 1G
max_execution_time = 300
max_input_time = 300

nginx.conf
http{
...
client_max_body_size 1G;
...
}
sever{
...
client_max_body_size  1G;
...}

*/
error_reporting(E_ALL); 
ini_set('display_errors', 1);

if (!empty($_FILES['myfile'])) {
    if ($_FILES['myfile']['error'] > 0) {
        echo "上传错误：";
        switch ($_FILES['myfile']['error']) {
            case 1:
                echo "上传文件大小超出配置文件规定值";
                break;
            case 2:
                echo "上传文件大小超出表单中的约定值";
                break;
            case 3:
                echo "上传文件不全";
                break;
            case 4:
                echo "没有上传文件";
                break;
            case 6:
                echo "找不到临时文件夹";
                break;
            case 7:
                echo "文件写入失败";
                break;
            default:
                echo "未知错误";
                break;
        }
    } else {
        $file_name = $_FILES["myfile"]["name"];
        $file_ext = substr($file_name, strrpos($file_name, '.') + 1);
        $file_size = $_FILES["myfile"]["size"] / 1024 / 1024;
        
        if (false) { // 在此处理文件类型和大小的判断
            echo "上传文件格式不正确，当前文件类型为：" . $_FILES['myfile']['type'];
        } else if ($file_size > 3000) {
            echo "上传文件不能超过3000M，当前文件大小为：" . sprintf("%.2f", $file_size) . "MB";
        } else if (file_exists("upload/" . $_FILES["myfile"]["name"])) {
            echo $_FILES["myfile"]["name"] . " 上传失败，文件已经存在。 ";
        } else {
            if (!is_dir("./upload")) {
                mkdir("./upload", 0777, true);
            }
            $path = './upload/' . $_FILES['myfile']['name'];
            if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {
                if (!move_uploaded_file($_FILES['myfile']['tmp_name'], $path)) {
                    echo "上传失败";
                } else {
                    if ($file_size < 1) {
                        if ($file_size < 0.0009765625) {
                            echo "文件:" . $_FILES['myfile']['name'] . "上传成功，文件大小为: " . sprintf("%.2f", $file_size * 1024 * 1024) . "B";
                        } else {
                            echo "文件:" . $_FILES['myfile']['name'] . "上传成功，文件大小为: " . sprintf("%.2f", $file_size * 1024) . "kB";
                        }
                    } else {
                        echo "文件:" . $_FILES['myfile']['name'] . "上传成功，文件大小为: " . sprintf("%.2f", $file_size) . "MB";
                    }
                }
            } else {
                echo "上传文件：" . $_FILES['myfile']['name'] . "不合法";
            }
        }
    }
}
?>