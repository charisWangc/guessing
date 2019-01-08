<?php

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\facade\Log;

class NewTerm extends Command
{
    protected function configure()
    {
        $this->setName('new_term')->setDescription('整点和半点在award_info新建一条term');
    }

    protected function execute(Input $input, Output $output)
    {

        $output->writeln('new term start.');
        $nowTime = date('H:i',time());
        if($nowTime >= '22:00'){
            return false;
        }
        if($nowTime == '10:00' || $nowTime == '10:01'){
            $data = [
                'term_num' => date('ymd').'-024',
                'created_date' => time()
            ];
        }else{
            $termInfo = Db::name('award_info')
                ->order('id desc')
                ->field('term_num')
                ->find();

            $termInfo['term_num']++;
            $term_num = $termInfo['term_num'];
            $data = [
                'term_num' => $term_num,
                'created_date' => time()
            ];
        }

        $status = false;
        while (!$status){
            $status = $this->insertDB($data);
        }

        $output->writeln('new term end.');
        return true;
    }

    protected function insertDB($data)
    {
        Db::startTrans();
        $res = false;
        try {
            $res = Db::name('award_info')->insert($data);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
        return $res;
    }
}