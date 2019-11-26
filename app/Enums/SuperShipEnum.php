<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SuperShipEnum extends Enum
{
//    public $status_pending=array(0,1,2,);
//    public $status_picked_up=array(3,6,7,8,9);
//    public $status_pickup_failed=array(4,5);
//    public $status_delivering=array(10);
//    public $status_delivered=array(11,14);
//    public $status_deliver_failed=array(12,13);
    const CHO_DUYET = 0;
    const CHO_LAY_HANG = 1;
    const DANG_LAY_HANG = 2;
    const DA_LAY_HANG = 3;
    const HOAN_LAY_HANG = 4;
    const KHONG_LAY_DUOC = 5;
    const DANG_NHAP_KHO = 6;
    const DA_NHAP_KHO = 7;
    const DANG_CHUYEN_KHO_GIAO = 8;
    const DA_CHUYEN_KHO_GIAO = 9;
    const DANG_GIAO_HANG =10;
    const DA_GIAO_HANG_TOAN_BO = 11;
    const DA_GIAO_HANG_MOT_PHAN = 12;
    const HOAN_GIAO_HANG = 13;
    const KHONG_GIAO_DUOC = 14;
    const DA_DOI_SOAT_GIAO = 15 ;
    const DA_DOI_SOAT_TRA_HANG = 16;
    const DANG_CHUYEN_KHO_TRA =17;
    const DA_CHUYEN_KHO_TRA = 18;
    const DANG_TRA_HANG = 19;
    const DA_TRA_HANG = 20;
    const HOAN_TRA_HANG = 21;
    const HUY = 22;
    const DANG_VAN_CHUYEN = 23;
    const XAC_NHAN_HOAN = 24;
}
