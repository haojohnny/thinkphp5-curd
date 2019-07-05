<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2019-07-04 19:35
// | Remark:
// |

namespace Haojohnny\Tp5Curd\Command;

use think\console\Command\Make;
use think\console\Input;
use think\console\Output;
use think\console\Input\Argument;

class Curd extends Make
{
    protected function getStub()
    {
    }

    protected function configure()
    {
        $this->setName('make:curd')
            ->addArgument('className', Argument::REQUIRED, 'Please input your class name')
            ->addArgument('tableName', Argument::OPTIONAL, 'Please input your table name')
            ->setDescription('Creat model,validate,controller class for CURD');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln("Created successful");
    }
}