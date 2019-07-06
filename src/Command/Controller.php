<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2019-07-04 19:12
// | Remark:
// |

namespace Haojohnny\Tp5Curd\Command;

use Haojohnny\Tp5Curd\Make;
use think\console\Input\Argument;

class Controller extends Make
{
    protected $type = 'controller';

    protected function configure()
    {
        $this->setName('make:curd-controller')
            ->addArgument('name', Argument::REQUIRED, 'Please input your class name')
            ->addArgument('tableName', Argument::OPTIONAL, 'Please input your table name')
            ->setDescription('Creat a new controller class for CURD');
    }

    // 填充模板
    public function buildClass($name)
    {
        $stub = $this->getStub();
        $namespace = trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');

        $class = str_replace($namespace . '\\', '', $name);

        $namespaceDirName = substr($namespace, 0, strrpos($namespace, '\\'));
        
        $search = [
            '{%createTime%}',
            '{%modelNameSpace%}',
            '{%validateNameSpace%}',
            '{%className%}',
            '{%lowerClassName%}',
            '{%namespace%}',
            '{%actionSuffix%}',
        ];

        $replace = [
            date('Y-m-d H:i'),
            $namespaceDirName.'\model',
            $namespaceDirName.'\validate',
            $class,
            lcfirst($class),
            $namespace,
            config('action_suffix')
        ];

        return str_replace($search, $replace, $stub);
    }
}