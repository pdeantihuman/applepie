<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/9
 * Time: 15:48
 * 自己的工具类
 */
class Tools
{


    /**
     * @param null $keworld
     * @param int $displaypg
     * @return bool
     * 查询学校图书馆数据数据返回数组
     */
    public function book($keworld = null){
        if($keworld==null){
            return null;
        }else{
        $displaypg = 100;
        ini_set('default_charset','utf-8');
        $ch = curl_init();
        $sch_url="http://61.181.145.1:82/opac/";
        curl_setopt($ch, CURLOPT_URL, $sch_url."openlink.php?strSearchType=title&match_flag=forward&historyCount=1&strText=".$keworld."&doctype=ALL&displaypg=".$displaypg."&showmode=list&sort=CATA_DATE&orderby=desc&location=ALL");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL,1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS,2000);//设置超时时间
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        curl_close($ch);
        if($curl_errno >0){
            echo '<script>alert("图书馆系统无响应");</script>';
            exit;
        }else{
            $pattern = '/span><a href=.*?>\b[1-9]\d{0,1}\b.(.+?)<\/a>/';
            preg_match_all($pattern, $output, $match);
            $name = $match[1];
            $preg= '/span><a .*?href="(.*?)".*?>/';
            preg_match_all($preg, $output, $data);
            $pattern1 = '/<\/span.*?>(.+?)<br.*?>/';
            preg_match_all($pattern1, $output, $actor);
            $url = $data[1];
            $actor =$actor[1];

            $j=count($name);

            for($i=0;$i<$j;$i++){
                $bookinfo[$i]=array(
                    'title' => $name[$i],
                    'actor' => $actor[$i],
                    'url'   => $url[$i]
                );
            }
            if(empty($bookinfo)){
                return null;
            }else{
                return $bookinfo;
            }

        }

        }
    }


    /**
     * @return bool
     * 获取图书馆最新图书
     */
    public function newbook(){

            ini_set('default_charset','utf-8');
            $ch = curl_init();
            $sch_url="http://61.181.145.1:82/newbook/";
            $page=1;
            curl_setopt($ch, CURLOPT_URL, $sch_url."newbook_cls_book.php?back_days=15&loca_code=ALL&cls=ALL&s_doctype=ALL&clsname=PHP&page=".$page."");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOSIGNAL,1);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS,2000);//设置超时时间
            $output = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            curl_close($ch);
            if($curl_errno >0){
            echo '<script>alert("图书馆系统无响应");</script>';
            exit;
            }else{
                $pattern = '/title=".*?">(.+?)<\/a><\/strong>/';//name is ok
                preg_match_all($pattern, $output, $match);
                $name = $match[1];
                $preg= '/<a .*?href="..\/opac\/(.*?)".*?>/';//url is ok
                preg_match_all($preg, $output, $data);
                $pattern1 = '/<\/strong>(.+?)<\/h3>/';
                preg_match_all($pattern1, $output, $actor);
                $url = $data[1];
                $actor =$actor[1];
                $j=count($name);

                for($i=0;$i<$j;$i++){
                    $bookinfo[$i]=array(
                        'title' => $name[$i],
                        'actor' => $actor[$i],
                        'url'   => $url[$i]
                    );
                }
                if(empty($bookinfo)){
                    return false;
                }else{
                    return $bookinfo;
                }
        }



        }


    /**
     * @param null $keworld
     * @param $page
     * @return null
     * 图书查询翻页功能
     */
    public function booknextpage($keworld = null, $page=1 ){
        if($keworld==null){
            return false;
        }else{
            $displaypg = 100;
            ini_set('default_charset','utf-8');
            $ch = curl_init();
            $sch_url="http://61.181.145.1:82/opac/";
            curl_setopt($ch, CURLOPT_URL, $sch_url."openlink.php?dept=ALL&title=".$keworld."&doctype=ALL&lang_code=ALL&match_flag=forward&displaypg=".$displaypg."&showmode=list&orderby=DESC&sort=CATA_DATE&onlylendable=no&count=&with_ebook=on&page=".$page."");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOSIGNAL,1);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS,2000);//设置超时时间
            $output = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            curl_close($ch);
            if($curl_errno >0){
                echo '<script>alert("图书馆系统无响应");</script>';
                exit;
            }else{
                $pattern = '/span><a href=.*?>\b[1-9]\d{0,1}\b.(.+?)<\/a>/';
                preg_match_all($pattern, $output, $match);
                $name = $match[1];
                $preg= '/span><a .*?href="(.*?)".*?>/';
                preg_match_all($preg, $output, $data);
                $pattern1 = '/<\/span.*?>(.+?)<br.*?>/';
                preg_match_all($pattern1, $output, $actor);
                $url = $data[1];
                $actor =$actor[1];

                $j=count($name);

                for($i=0;$i<$j;$i++){
                    $bookinfo[$i]=array(
                        'title' => $name[$i],
                        'actor' => $actor[$i],
                        'url'   => $url[$i]
                    );
                }
                if(empty($bookinfo)){
                    return false;
                }else{
                    return $bookinfo;
                }

            }

        }
    }

}