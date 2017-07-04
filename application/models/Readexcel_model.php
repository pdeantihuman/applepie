<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Readexcel_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Excel');
        $this->load->database();

    }


    /**
     * @param $file
     * @return mixed
     * 通过读取excel文件，将数据转换成数组的形式返回
     */
    public function getReadexcel ($file){
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
            if ($row == 1) {
                $header[$row][$column] = $data_value;
            } else {
                $arr_data[$row][$column] = $data_value;
            }
        }
        $data_key=[
            'A'=>'V_name',
            'B'=>'V_number',
            'C'=>'V_card',
            'D'=>'V_profession',
            'E'=>'V_class',
            ];
        for($i=0;$i<count($arr_data);$i++){
            if($data[$i]= array_combine($data_key,$arr_data[$i+2])){
            }else{
                return false;
            }
        }
        return $data;
    }





}















?>