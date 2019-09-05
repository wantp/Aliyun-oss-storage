# Aliyun-oss-storage for Laravel 5+
这是一个基于[jacobcyl/Aliyun-oss-storage](https://github.com/jacobcyl/Aliyun-oss-storage)的扩展包，在为Storage添加oss驱动的基础上，添加了sts临时授权的用法。

## Require
- Laravel 7+
- cURL extension

##Installation
In order to install AliOSS-storage, just add

    "wantp/ali-oss-storage": "^2.3"

to your composer.json. Then run `composer install` or `composer update`.  
Or you can simply run below command to install:

    "composer require wantp/ali-oss-storage:^2.3"
    
## Configuration
Add the following in app/filesystems.php:
```php
'disks'=>[
    ...
    'oss' => [
            'driver'            => 'oss',
            'access_id'         => '<Your Aliyun OSS AccessKeyId>',
            'access_key'        => '<Your Aliyun OSS AccessKeySecret>',
            'bucket'            => '<OSS bucket name>',
            // OSS 外网节点或自定义外部域名
            'endpoint'          => '<the endpoint of OSS, E.g: oss-cn-hangzhou.aliyuncs.com | custom domain, E.g:img.abc.com>',
            // v2.0.4 新增配置属性，如果为空，则默认使用 endpoint 配置(由于内网上传有点小问题未解决，请大家暂时不要使用内网节点上传，正在与阿里技术沟通中)            
            //'endpoint_internal' => '<internal endpoint [OSS内网节点] 如：oss-cn-shenzhen-internal.aliyuncs.com>',
            // 如果isCName为true, getUrl会判断cdnDomain是否设定来决定返回的url，如果cdnDomain未设置，则使用endpoint来生成url，否则使用cdn
            'cdnDomain'         => '<CDN domain, cdn域名>',
            // true|false true to use 'https://' and false to use 'http://'. default is false,
            'ssl'               => false,
            // true|false 是否使用自定义域名,true: 则Storage.url()会使用自定义的cdn或域名生成文件url， false: 则使用外部节点生成url
            'isCName'           => false,
            // true|false
            'debug'             => false,
            // 是否STS认证
            'isSts'             => false,
            // 角色ARN，isSts为true时必填，在阿里云RAM控制台中的角色详情中查看ARN
            'roleArn'           => '',
            'roleSessionName'   => 'default',
            // 选填项，默认值3600，sts认证的有效时间，单位秒
            'stsDuration'       => 3600,
            // 选填项，默认值1，client连接超时时间，单位秒
            'stsConnectTimeout' => 1,
            // 选填项，默认值3，client请求接口超时时间，单位秒
            'stsRequestTimeout' => 3,
    ],
    ...
]
```


## Usage
See [Larave doc for Storage](https://laravel.com/docs/5.2/filesystem#custom-filesystems)
Or you can learn here:

> First you must use Storage facade

```php
use Illuminate\Support\Facades\Storage;
```    
> Then You can use all APIs of laravel Storage

```php
Storage::disk('oss'); // if default filesystems driver is oss, you can skip this step

//fetch all files of specified bucket(see upond configuration)
Storage::files($directory);
Storage::allFiles($directory);

Storage::put('path/to/file/file.jpg', $contents); //first parameter is the target file path, second paramter is file content
Storage::putFile('path/to/file/file.jpg', 'local/path/to/local_file.jpg'); // upload file from local path

Storage::get('path/to/file/file.jpg'); // get the file object by path
Storage::exists('path/to/file/file.jpg'); // determine if a given file exists on the storage(OSS)
Storage::size('path/to/file/file.jpg'); // get the file size (Byte)
Storage::lastModified('path/to/file/file.jpg'); // get date of last modification

Storage::directories($directory); // Get all of the directories within a given directory
Storage::allDirectories($directory); // Get all (recursive) of the directories within a given directory

Storage::copy('old/file1.jpg', 'new/file1.jpg');
Storage::move('old/file1.jpg', 'new/file1.jpg');
Storage::rename('path/to/file1.jpg', 'path/to/file2.jpg');

Storage::prepend('file.log', 'Prepended Text'); // Prepend to a file.
Storage::append('file.log', 'Appended Text'); // Append to a file.

Storage::delete('file.jpg');
Storage::delete(['file1.jpg', 'file2.jpg']);

Storage::makeDirectory($directory); // Create a directory.
Storage::deleteDirectory($directory); // Recursively delete a directory.It will delete all files within a given directory, SO Use with caution please.

// upgrade logs
// new plugin for v2.0 version
Storage::putRemoteFile('target/path/to/file/jacob.jpg', 'http://example.com/jacob.jpg'); //upload remote file to storage by remote url
// new function for v2.0.1 version
Storage::url('path/to/img.jpg') // get the file url

// get stsAuth
Storage::stsAuth() 

//get DownloadUrl
Storage::downloadUrl('path/to/img.jpg');
```

## Documentation
More development detail see [Aliyun OSS DOC](https://help.aliyun.com/document_detail/32099.html?spm=5176.doc31981.6.335.eqQ9dM)
## License
Source code is release under MIT license. Read LICENSE file for more information.
