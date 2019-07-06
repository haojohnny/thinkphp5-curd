<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2019-07-04 19:35
// | Remark:
// |

namespace Haojohnny\Tp5Curd\Command;

use Haojohnny\Tp5Curd\Make;
use think\console\Input;
use think\console\Output;
use think\console\Input\Argument;

class Curd extends Make
{
    protected function configure()
    {
        $this->setName('make:curd')
            ->addArgument('name', Argument::REQUIRED, 'Please input your class name')
            ->addArgument('tableName', Argument::OPTIONAL, 'Please input your table name')
            ->setDescription('Creat model,validate,controller class for CURD');
    }

    public function execute(Input $input, Output $output)
    {
        (new Model())->executeBuild($input, $output);
        (new Validate())->executeBuild($input, $output);
        (new Controller())->executeBuild($input, $output);
    }
}