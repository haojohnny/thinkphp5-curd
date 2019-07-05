<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2019-07-04 19:12
// | Remark:
// |

namespace Haojohnny\Tp5Curd\Command;

use think\console\Input\Argument;
use Haojohnny\Tp5Curd\Make;

class Model extends Make
{
    protected $type = 'model';

    public function configure()
    {
        $this->setName('make:curd-model')
            ->addArgument('name', Argument::REQUIRED, 'Please input your class name')
            ->addArgument('tableName', Argument::OPTIONAL, 'Please input your table name')
            ->setDescription('Creat a new validate class for CURD');
    }

    // 填充模板
    public function buildClass($name)
    {
        $stub = $this->getStub();
        $namespace = trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');

        $class = str_replace($namespace . '\\', '', $name);

        $search = [
            '{%createTime%}',
            '{%className%}',
            '{%namespace%}',
        ];

        $replace = [
            date('Y-m-d H:i'),
            $class,
            $namespace,
        ];

        return str_replace($search, $replace, $stub);
    }
}