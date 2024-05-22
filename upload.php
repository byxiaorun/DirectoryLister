<?php
error_reporting(E_ALL ^ E_NOTICE); 
if (!empty($_FILES['myfile'])) {//判断上传内容是否为空
    if ($_FILES['myfile']['error'] > 0) {//判断上传错误信息
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
        }
    } else {
        $file_name=$_FILES["myfile"]["name"];
        $file_ext=substr($file_name,strrpos($file_name,'.')+1);
        list($maintype, $subtype) = explode("/", $_FILES['myfile']['type']);
        $file_size = $_FILES["myfile"]["size"]/1024/1024;
        if(/*($subtype!="vnd.android.package-archive")||(strtolower($file_ext)!='apk' && strtolower($file_ext)!='apks' && strtolower($file_ext)!='xapk')*/false){
            echo "上传文件格式不正确，当前文件类型为：" .$_FILES['myfile']['type'];
        }else if($file_size>3000){
        	echo "上传文件不能超过30M，当前文件大小为：" .sprintf("%.2f", $file_size)."MB";
        }
        // 判断当期目录下的 upfile 目录是否存在该文件
        else if (file_exists("upload/" . $_FILES["myfile"]["name"]))
        {
            echo $_FILES["myfile"]["name"] . " 上传失败，文件已经存在。 ";
        } else {
            if (!is_dir("./upload")) {//判断指定目录是否存在
                mkdir("./upload");//创建目录
            }
            $path = './upload/'.$_FILES['myfile']['name'];//定义上传文件名和存储位置
            if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {//判断文件上传是否为HTTP POST上传
                if (!move_uploaded_file($_FILES['myfile']['tmp_name'],$path)) {//执行上传操作
                    echo "上传失败";
                } else {
                  if($file_size<1){
                  if($file_size<0.0009765625){echo "文件:" .$_FILES['myfile']['name'] ."上传成功，文件大小为: ".sprintf("%.2f", $file_size*1024*1024)."B";}
                  else{echo "文件:" .$_FILES['myfile']['name'] ."上传成功，文件大小为: ".sprintf("%.2f", $file_size*1024)."kB";}}
                  else{echo "文件:" .$_FILES['myfile']['name'] ."上传成功，文件大小为: ".sprintf("%.2f", $file_size)."MB";}
                }
            } else {
                echo "上传文件：".$_FILES['myfile']['name']."不合法";
            }
        }
    }
}
?>