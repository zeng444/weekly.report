## 使用说明

### 原理

- 提取git中你提交日志中带有指定识别符的内容，并用于生成excel格式的周报内容

### 配置文件

- 设置配置文件configs/Config.php

```php
return [
   'repo' => [
        [
            'name' => '融保界',
            'path' => '/data/backend.insurance.genius',
        ],
        [
            'name' => '周报',
            'path' => '/data/report',
        ],
    ],
    'download_folder' => 'down',
    'identifier' => 'rep',
    'author' => 'Robert',
    'title' => '%s年云基物衡工作周报表',
    'real_name' => '曾维骐',
    'department' => 'R&D',
    'auto_pull' => false,
    'debug' => true,
];
```
 

- repo  

仓库目录repo.name仓库项目名；repo.path 仓库路径

- download_folder

生成周报存放目录

- identifier

指定提取git日志的识别符，一般是一组字符串，默认rep(report的缩写)，此标签忽略大小写，主要使用方式如下

```
git commit -m "[rep] t1外面这里的将全部被提取"
git commit -m "[rep:t2里面这里的将全部被提取] t2外面这里的文字不被提取 "
```
 以上两条生成最终周报信息为

```
 t1外面这里的将全部被提取
 t2里面这里的将全部被提取
```

- author

提取日志的指定作者，对应git日志作者

- title

生成周报内的表头名称 %s 指定年份，系统自动替换

- real_name

生成周报内的真名

- department

生成周报内的部门

- auto_pull

更新git日志后再生成周报

- debug

用markdown格式的输出预览周报

### 使用说明

- 生成15条一周内的日志周报

```
./Run
```

- 生成5条一周内的日志周报

```
./Run 5
```

- 生成5条指定日期到当前的日志周报

```
./Run 5 2019-07-04
```

- 生成5条指定日期时间到当前的日志周报

```
./Run 5 '2019-07-04 12:00:00'
```