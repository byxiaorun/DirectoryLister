# 一个逗比魔改的Directory Lister~


![GitHub](https://img.shields.io/github/license/mashape/apistatus.svg)


### 魔改特点：

我之所以使用Directory Lister，就是因为这个程序非常的简洁，符合我心中对 目录列表程序的定义，在使用期间，根据我个人喜好和审美做了一些改变。
- 界面式样魔改
- 支持中文目录和文件名
- 支持显示各文件夹内的简介说明
- 默认调用的各种CDN文件本地化
- 等等 ...

### 更新记录

 - 2018/09/27，修复 当网页内容高度接近于窗口高度时，底部 footer 与网页内容重叠的问题。
 - 2018/08/20，更新 不需要再手动配置域名后缀了，新版本会自动检测。
 - 2018/08/20，更新 网站式样 - 素色简洁风（参见下图）。
 - 2018/07/18，修复 当程序位置网站子目录下时，CSS JS 路径错误的问题。
 - 2018/03/26，修复 当前文件夹下无 README.html 文件时，PHP会提示警告的问题。
 
![新旧式样手机效果对比](https://github.com/byxiaorun/DirectoryLister/raw/master/Compared.png)

### 演示示例：

逗比云 https://softs.wtf (需挂代理)

### 下载安装：

下载后，解压并上传到已经搭建好 PHP环境 的服务器中，然后就可以上传文件和创建文件夹了！

- Github打包：https://github.com/ToyoDAdoubiBackup/DirectoryLister/archive/master.zip

- 逗比云打包：[https://softs.run/Website/Directory Lister魔改版(by-Toyo) v2.6.1.zip](https://softs.run/Website/Directory%20Lister%E9%AD%94%E6%94%B9%E7%89%88%28by-Toyo%29%20v2.6.1.zip)

#### 文件结构
假设你的虚拟主机是 `/home/wwwroot/xxx.xx`
``` bash
/home/wwwroot/xxx.xx/
├─ resources/
│   ├ themes/
│   │ └ bootstrap/
│   │    ├ css/
│   │    ├ fonts/
│   │    ├ img/
│   │    ├ js/
│   │    ├ default_footer.php # 底部公共文件 #
│   │    ├ default_header.php # 顶部公共文件（可以放网站流量统计代码） #
│   │    └ index.php # 网页主文件，其中可以修改顶部公告栏内容 #
│   │
│   ├ DirectoryLister.php
│   ├ config.php
│   └ fileTypes.php
│
├ README.html # 该文件夹页面内的 说明简介文件 #
├ index.php
│
├─ 其他文件夹/
│   ├ 其他文件.txt
│   └ README.html # 该文件夹页面内的 说明简介文件 #
│
└ 其他文件.txt
```
### 注意事项：

#### 不显示文件和目录

如果安装 lnmp一键包上传Directory Lister后，Directory Lister不显示文件和目录，那么可能是 PHP函数` scandir `被禁用了，取消禁用即可。
``` bash
sed -i 's/,scandir//g' /usr/local/php/etc/php.ini
# 取消scandir函数禁用
/etc/init.d/php-fpm restart
# 重启 PHP生效
```
#### 程序放在网站子目录不显示 README.html 的解决方法

因为程序有个判断 `README.html` 路径的代码，而如果是正常使用域名或IP(即使加上)，都是可以自适应的。

但是如果把程序放在子目录下，就会无法获取正确 `README.html` 路径，需要你手动修改下程序里的一句代码。

假设你将程序放在了子目录 `zimulu` 中（也就是 `http://xxx.xx/zimulu` 才能访问到程序网页）。

首先打开该文件： `/resources/themes/bootstrap/index.php`  

找到第5行的： `$suffix_array = explode('.', $_SERVER['HTTP_HOST']);`  

将其修改为： `$suffix_array = explode('.', $_SERVER['HTTP_HOST']."/zimulu");`

#### 简介功能说明

我也不知道该给这个功能起什么名字，好捉急偶。

可以在每个文件夹下面放一个 `README.html` 文件，这个文件里写着 简介说明内容即可，格式参考自带的示例文件。

为了避免中文乱码，把 `README.html` 文件用 UTF-8无BOM编码 保存！

#### 文件修改说明

修改网站中头部导航标题，去这个文件里搜索 `DOUBI Soft` 然后全部替换为自己要改的。  
`/resources/DirectoryLister.php `

修改网站标签栏的标题，去这个文件里把开头 `<title>` 标签中的` DOUBI Soft `替换为自己要改的。  
`/resources/themes/bootstrap/index.php `

修改网站顶部公告栏内容，去这个文件里搜索 `顶部公告栏`。  
`/resources/themes/bootstrap/index.php `

网站头部公共文件：  
`/resources/themes/bootstrap/default_header.php `

网站底部公共文件：  
`/resources/themes/bootstrap/default_footer.php `

如果想要插入流量统计代码，那只需要把代码写到 `default_header.php` 文件内即可。

---

我的博客 逗比根据地(需挂代理)：https://doub.io/dbrj-3/

本程序基于 Directory Lister原版魔改：http://www.directorylister.com/
