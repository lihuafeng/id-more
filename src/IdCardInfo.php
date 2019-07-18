<?php


namespace IdMoreInfo;


class IdCardInfo
{
    private $id_type;

    private $id_num;

    private $info;
    /**
     * @var array
     * 中华人民共和国省级行政区划代码(不含港澳台地区)
     */
    protected $aProvinces = array(
        '11' => '北京',
        '12' => '天津',
        '13' => '河北',
        '14' => '山西',
        '15' => '内蒙古',
        '21' => '辽宁',
        '22' => '吉林',
        '23' => '黑龙江',
        '31' => '上海',
        '32' => '江苏',
        '33' => '浙江',
        '34' => '安徽',
        '35' => '福建',
        '36' => '江西',
        '37' => '山东',
        '41' => '河南',
        '42' => '湖北',
        '43' => '湖南',
        '44' => '广东',
        '45' => '广西',
        '46' => '海南',
        '50' => '重庆',
        '51' => '四川',
        '52' => '贵州',
        '53' => '云南',
        '54' => '西藏',
        '61' => '陕西',
        '62' => '甘肃',
        '63' => '青海',
        '64' => '宁夏',
        '65' => '新疆',
    );

    public function __construct()
    {
    }
    protected function check($idNum){
        return IdCardCheck::validation_filter_id_card($idNum);
    }

    /**
     * @param $idNum
     * @return bool|string
     * 返回 1男 2女
     */
    protected function getGender($idNum)
    {
        if ($this->check($idNum)) {
            $gender = substr($idNum, 16, 1);  //倒数第2位
            return ($gender % 2 == 0) ? '2' : '1';
        } else {
            return false;
        }
    }
    /**
     * @param $birthday
     * @param null $date
     * @return bool
     * 根据出生日期获取年龄
     */
    protected function getAgeByBirthday($birthday, $date = null)
    {
        if (!$date) {
            $date = strtotime('now');
        }
        $birthdayTm = strtotime($birthday);
        if ($birthdayTm === false) {
            return false;
        }
        list($y1, $m1, $d1) = explode('-', date('Y-m-d', $birthdayTm));
        list($y2, $m2, $d2) = explode('-', date('Y-m-d', $date));
        $age = $y2 - $y1;
        if ((int) ($m2.$d2) < (int) ($m1.$d1)) {
            --$age;
        }

        return $age;
    }

    /**
     * @param $IDCard
     * @param int $format
     * @return bool|string
     * 根据身份证获取生日
     */
    protected function getBirthByIdCard($IDCard, $format = 1)
    {
        if (!preg_match("/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/", $IDCard)) {
            return false;
        } else {
            if (strlen($IDCard) == 18) {
                $tyear = intval(substr($IDCard, 6, 4));
                $tmonth = intval(substr($IDCard, 10, 2));
                $tday = intval(substr($IDCard, 12, 2));
            } elseif (strlen($IDCard) == 15) {
                $tyear = intval('19'.substr($IDCard, 6, 2));
                $tmonth = intval(substr($IDCard, 8, 2));
                $tday = intval(substr($IDCard, 10, 2));
            }

            if ($tyear > date('Y') || $tyear < (date('Y') - 100)) {
                return false;
            } elseif ($tmonth < 0 || $tmonth > 12) {
                return false;
            } elseif ($tday < 0 || $tday > 31) {
                return false;
            }

            if ($format) {
                $tdate = $tyear.'-'.$tmonth.'-'.$tday;
            } else {
                $tdate = $tmonth.'-'.$tday;
            }
        }

        return $tdate;
    }
}