<!DOCTYPE html>
<?php 
header("Content-type: text/html; charset=utf-8"); 
$md_path_all = $lister->getListedPath();
$suffix_array = explode('.', $_SERVER['HTTP_HOST']);
$suffix = end($suffix_array);
$md_path = explode($suffix, $md_path_all);
if($md_path[1] != ""){
    $md_path_last = substr($md_path[1], -1);;
    if($md_path_last != "/"){
        $md_file = ".".$md_path[1]."/README.html";
    }else{
        $md_file = ".".$md_path[1]."README.html";
    }
}
if(file_exists($md_file)){
    $md_text = file_get_contents($md_file);
}else{
    $md_text = "";
}
?>
<html>

<head>
    <title>小米内置应用|小润的私有云</title>
    <link rel="shortcut icon" href="resources/themes/bootstrap/img/folder.png" />
    <!-- 网站LOGO -->
    <link rel="stylesheet" href="https://fastly.jsdelivr.net/gh/byxiaorun/web-cdn/bootstrap/css/bootstrap.min.css" />
    <!-- CSS基本库 -->
    <link rel="stylesheet" href="https://fastly.jsdelivr.net/gh/byxiaorun/web-cdn/bootstrap/css/font-awesome.min.css" />
    <!-- 网站图标CSS式样 -->
    <link rel="stylesheet" href="https://fastly.jsdelivr.net/gh/byxiaorun/web-cdn/bootstrap/css/style.css" />
    <!-- 网站主要式样 -->
    <link rel="stylesheet" href="https://fastly.jsdelivr.net/gh/byxiaorun/web-cdn/bootstrap/css/prism.css" />
    <!-- 代码高亮式样 -->
    <script src="https://fastly.jsdelivr.net/gh/byxiaorun/web-cdn/bootstrap/js/jquery.min.js"></script>
    <!-- JS基本库 -->
    <script src="https://fastly.jsdelivr.net/gh/byxiaorun/web-cdn/bootstrap/js/bootstrap.min.js"></script>
    <!-- JS基本库 -->
    <script src="https://fastly.jsdelivr.net/gh/byxiaorun/web-cdn/bootstrap/js/prism.js"></script>
    <script src="https://fastly.jsdelivr.net/gh/byxiaorun/web-cdn/bootstrap/js/jquery.form.js"></script>
    <!-- 代码高亮JS依赖 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php file_exists('analytics.inc') ? include('analytics.inc') : false; ?>
    <script type="text/JavaScript">
        // 收藏本站 function AddFavorite(title, url) { try { window.external.addFavorite(url, title); } catch (e) { try { window.sidebar.addPanel(title, url, ""); } catch (e) { alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加"); } } }
    </script>
    <style>
    form {
        display: flex;
        border-radius: 10px;
    }

    .progress {
        position: relative;
        width: 30%;
        border: 1px solid #ddd;
        border-radius: 3px;
        margin-right:12%;
        margin-left:5%;
        background-color:#0000;
    }

    .bar {
        background-color: #0f8585;
        width: 0%;
        height: 30px;
        border-radius: 3px;
    }

    .percent {
        position: absolute;
        display: inline-block;
        top: 0px;
        left: 45%;
        color:#59b6ff;
    }
    </style>
</head>

<body>
    <div id="page-navbar" class="top">
        <div class="container">
            <h2 class="logo">
              <img src="resources/themes/bootstrap/img/folder.png" alt="logo" style="width: 35px;">
                <?php $breadcrumbs = $lister->listBreadcrumbs(); ?>
                
                    <?php foreach($breadcrumbs as $breadcrumb): ?>
                        <?php if ($breadcrumb != end($breadcrumbs)): ?>
                                <a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['text']; ?></a>
                                <span class="divider">/</span>
                        <?php else: ?>
                            <?php echo $breadcrumb['text']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
              </h2>
        </div>
    </div>
    <div class="path-announcement navbar navbar-default">
        <div class="path-announcement2 container">
            <!-- 顶部公告栏 -->
            <p><i class="fa fa-volume-down"></i>这里是小米内置应用合集，建议使用小米内置浏览器下载（或者下载后用小米内置的文件管理&开发者模式-关闭Miui优化）即可覆盖安装,上传已限制apk格式，名字尽量为 应用名+版本号(XX提供）.apk</p>
            <!-- 顶部公告栏 -->
        </div>
    </div>
    <div class="container" id="top">
        <div class="page-content container" id="container_page">
            <?php file_exists('header.php') ? include('header.php') : include($lister->getThemePath(true) . "/default_header.php"); ?>
            <?php if($lister->getSystemMessages()): ?>
            <?php foreach ($lister->getSystemMessages() as $message): ?>
            <div class="alert alert-<?php echo $message['type']; ?>">
                <?php echo $message['text']; ?>
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
            <div id="directory-list-header">
                <div class="row">
                    <div class="col-md-7 col-sm-6 col-xs-10">文件</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 text-right">大小</div>
                    <div class="col-md-3 col-sm-4 hidden-xs text-right">最后修改时间</div>
                </div>
            </div>
            <div id="upload" style="margin-left:1%;">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="myfile" style="color: #59b6ff;width:40%"/>
                    <br>
                  <div class="progress"><div class="bar"></div> <div class="percent">0%</div></div> 
                  <br>
                    <input type="submit" value="上传文件" style="width:20%;height: 10%;">
                </form>
                
                <div id="status"></div>
                <script>
                $(function() {
                    var bar = $('.bar');
                    var percent = $('.percent');
                    var status = $('#status');
                    $('form').ajaxForm({
                        beforeSerialize: function() {
                            //alert("表单数据序列化前执行的操作！");
                            //$("#txt2").val("java");//如：改变元素的值
                        },
                        beforeSubmit: function() {
                            //alert("表单提交前的操作");
                             //alert("表单提交前的操作");
                            var fileData = $("input[type='file']")[0].files[0];
                            var filesize = fileData.size/1024/1024;
                            var filename =fileData.name;
                            if (filesize > 3000) {
                                alert("文件大小超过限制，最多30M,");
                                return false;
                            }
                        /*    if (!/\.(apk|apks|xapk)$/.test(filename)){
                            	alert("上传的文件格式错，仅支持apk格式上传");
                                return true;
                                
                            }*/
                            //if($("#txt1").val()==""){return false;}//如：验证表单数据是否为空
                        },
                        beforeSend: function() {
                            status.empty();
                            var percentVal = '0%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                        },
                        uploadProgress: function(event, position, total, percentComplete) { //上传的过程
                            //position 已上传了多少
                            //total 总大小
                            //已上传的百分数
                            var percentVal = percentComplete + '%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                            //console.log(percentVal, position, total);
                        },
                        success: function(data) { //成功
                            var percentVal = '100%';
                            bar.width(percentVal)
                            percent.html(percentVal);
                            alert(data);
                        },
                        error: function(err) { //失败
                            alert("表单提交异常！" + err.msg);
                        },
                        complete: function(xhr) { //完成
                            status.html(xhr.responseText);
                        }
                    });

                });
                </script>
            </div>
            <ul id="directory-listing" class="nav nav-pills nav-stacked">
                <?php foreach($dirArray as $name => $fileInfo): ?>
                <li data-name="<?php echo $name; ?>" data-href="<?php echo $fileInfo['url_path']; ?>">
                    <a href="<?php echo $fileInfo['url_path']; ?>" class="clearfix" data-name="<?php echo $name; ?>">
                        <div class="row">
                            <span class="file-name col-md-7 col-sm-6 col-xs-9">
                                    <i class="fa <?php echo $fileInfo['icon_class']; ?> fa-fw"></i>
                                    <?php echo $name; ?>
                                </span>
                            <span class="file-size col-md-2 col-sm-2 col-xs-3 text-right">
                                    <?php echo $fileInfo['file_size']; ?>
                                </span>
                            <span class="file-modified col-md-3 col-sm-4 hidden-xs text-right">
                                    <?php echo $fileInfo['mod_time']; ?>
                                </span>
                        </div>
                    </a>
                    <?php if (is_file($fileInfo['file_path'])): ?>
                    <?php else: ?>
                    <?php if ($lister->containsIndex($fileInfo['file_path'])): ?>
                    <a href="<?php echo $fileInfo['file_path']; ?>" class="web-link-button" <?php if($lister->externalLinksNewWindow()): ?>target="_blank"<?php endif; ?>>
                                    <i class="fa fa-external-link"></i>
                                </a>
                    <?php endif; ?>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- READMNE 说明 -->
        <?php
        if($md_text != ""){
            echo $md_text;
        }
        ?>
            <!-- READMNE 说明 -->
    </div>
    <hr style="margin-bottom: 0;margin-top: 40px;" />
    <?php file_exists('footer.php') ? include('footer.php') : include($lister->getThemePath(true) . "/default_footer.php"); ?>
    <script type="text/javascript">
    window.onload = function() {
        changeDivHeight();
    }
    window.onresize = function() {
        changeDivHeight();
    }

    function changeDivHeight() {
        if (document.getElementById("container_readme")) {
            container_readme.style.marginBottom = '0';
        }

        ScrollHeight_body = document.body.scrollHeight - 1;
        InnerHeight_window = window.innerHeight;
        ClientHeight_top = container_top.clientHeight + 60;

        //console.log(ScrollHeight_body, InnerHeight_window, container_top.clientHeight, ClientHeight_top, InnerHeight_window);

        if (ScrollHeight_body > InnerHeight_window) {
            if (ClientHeight_top > InnerHeight_window) {
                container_top.style.marginBottom = '0';
                container_page.style.marginBottom = '0';
                if (document.getElementById("container_readme")) {
                    container_readme.style.marginTop = '20px';
                }
            } else {
                container_top.style.marginBottom = '';
                container_page.style.marginBottom = '';
                if (document.getElementById("container_readme")) {
                    container_readme.style.marginTop = '';
                }
            }
        }
    }
    </script>
</body>

</html>