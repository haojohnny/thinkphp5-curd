<h1 align="center"> tp5-curd </h1>

<p align="center"> .</p>


## Installing

```shell
$ composer require haojohnny/tp5-curd -vvv
```

## Usage

在Thinkphp5框架的command.php文件中，加入工具命令
```php
<?php

    return [
        'Haojohnny\Tp5Curd\Command\Curd',
        'Haojohnny\Tp5Curd\Command\Model',
        'Haojohnny\Tp5Curd\Command\Validate',
        'Haojohnny\Tp5Curd\Command\Controller',
    ];
```

在应用根目录下执行
    
    php think

将列出该工具的命令用法。

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/haojohnny/tp5-curd/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/haojohnny/tp5-curd/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT