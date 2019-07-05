<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2019-07-04 19:12
// | Remark:
// |

namespace Haojohnny\Tp5Curd\Command;

use think\Db;
use Haojohnny\Tp5Curd\Make;
use think\console\Input\Argument;


class Validate extends Make
{
    protected $type = 'validate';

    protected $columnsInfo;

    protected function configure()
    {
        $this->setName('make:curd-validate')
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

        if ($this->input->getArgument('tableName')) {
            $tableName = $this->input->getArgument('tableName');
        } else {
            $tableName = config('database.prefix').strtolower($class);
        }

        $columnsInfo = $this->getColumnsInfo($tableName);

        $search = [
            '{%namespace%}',
            '{%createTime%}',
            '{%className%}',
            '{%rule%}',
            '{%message%}',
            '{%scene%}'
        ];

        $replace = [
            $namespace,
            date('Y-m-d H:i'),
            $class,
            $this->getRule($columnsInfo),
            $this->getMessage($columnsInfo),
            $this->getScene($columnsInfo)
        ];

        return str_replace($search, $replace, $stub);
    }

    /**
     * @param $tableName
     * @return mixed
     */
    public function getColumnsInfo($tableName)
    {
        $sql = "SELECT COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,COLUMN_COMMENT,IS_NULLABLE 
                FROM INFORMATION_SCHEMA.Columns 
                WHERE table_name='{$tableName}'";

        return Db::query($sql);
    }
    
    public function getRule($columnsInfo)
    {
        $rule = '';

        foreach ($columnsInfo as $key => $column) {
            $rules = $this->parseColumnToRule($column);
            $columnRule = implode('|', $rules);

$rule .= <<<EOF
'{$column['COLUMN_NAME']}' => '{$columnRule}',
        
EOF;
        }

        return $rule;
    }

    /**
     * 解析字段验证规则
     * @param $column
     * @return array 规则数组
     */
    public function parseColumnToRule($column)
    {
        $rules = [];
        if ($column['IS_NULLABLE'] == 'NO') {
            $rules[] = 'require';
        }

        switch ($column['DATA_TYPE']) {
            case 'int':
                $rules[] = 'number';
                break;
            case 'char':
                $rules[] = 'length:'.$column['CHARACTER_MAXIMUM_LENGTH'];
                break;
            case 'varchar':
                $rules[] = 'max:'.$column['CHARACTER_MAXIMUM_LENGTH'];
                break;
            case 'datetime':
                $rules[] = 'datetime';
                break;
            // TODO: and more
            default:
        }

        return $rules;
    }

    /**
     * 解析规则为错误信息提示
     * @param $ruleName
     * @return string
     */
    public function parseRoleToMessage($ruleName)
    {
        switch ($ruleName) {
            case 'require':
                $roleMessage = '必须填写';
                break;
            case 'number':
                $roleMessage = '数据格式必须为数字';
                break;
            case 'datetime':
                $roleMessage = '必须为有效的时间格式';
                break;
            default:
                list($ruleName, $num) = explode(':', $ruleName);
                switch ($ruleName) {
                    case 'length':
                        $roleMessage = "长度必须为{$num}个字符";
                        break;
                    case 'max':
                        $roleMessage = "最大长度为{$num}个字符";
                        break;
                    default:
                        $roleMessage = '数据有误';
                }
        }

        return $roleMessage;
    }

    public function getMessage($columnsInfo)
    {
        $message = '';

        foreach ($columnsInfo as $column) {
            $roles = $this->parseColumnToRule($column);
            foreach ($roles as $ruleName) {
                $msg = $this->parseRoleToMessage($ruleName);
$message .= <<<EOF
'{$column['COLUMN_NAME']}.{$ruleName}' => '{$column['COLUMN_COMMENT']}{$msg}',
        
EOF;
            }
        }

        return $message;
    }

    public function getScene($columnsInfo)
    {
        $scene = '';

        // TODO

        return $scene;
    }
}