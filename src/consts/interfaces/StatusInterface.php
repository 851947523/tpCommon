<?php

namespace Gz\TpCommon\consts\interfaces;
/**
 * @method emptyModel()   模型不能为空
 * @method timeTypeError()  时间格式错误
 * @method noKey()  数组不存在键值
 */
interface  StatusInterface
{

    /**
     * 参数错误
     * @return mixed
     */
    static function argumentsErr();

    /**
     * 表存在
     * @return mixed
     */
    static function tableExist();

    /**
     * 规则错误
     * @return mixed
     */
    static function ruleError();

    /**
     * 修改成功
     * @return mixed
     */
    static function editSuc();

    /**
     * 修改失败
     * @return mixed
     */
    static function editErr();

    /**
     * 新增成功
     * @return mixed
     */
    static function insertSuc();

    /**
     * 新增失败
     * @return mixed
     */
    static function insertErr();

    /**
     * 删除成功
     * @return mixed
     */
    static function delSuc();

    /**
     * 删除失败
     * @return mixed
     */
    static function delErr();

    /**
     * 密码错误
     * @return mixed
     */
    static function passwordErr();

    /**
     * 旧密码错误
     * @return mixed
     */
    static function oldPasswordErr();

    /**
     * 数据为空
     * @return mixed
     */
    static function dataEmpty();


}