<?php

namespace Pstldz\DcatAdminGridSotrable;

use Dcat\Admin\Extend\Setting as Form;
use Dcat\Admin\OperationLog\Models\OperationLog;
use Dcat\Admin\Support\Helper;


class Setting extends Form
{
    // 返回表单弹窗标题
    public function title()
    {
        return $this->trans('setting.title');
    }


    public function form()
    {
        // 定义表单字段
        $this->radio('sortalbe_type',$this->trans('setting.sortalbe_type'))->options([0=>$this->trans('setting.row_style'),1=>$this->trans('setting.row_button_style')])->default(0);
        $this->radio('sortalbe_cancel',$this->trans('setting.sortalbe_cancel'))->options([0=>$this->trans('setting.do_not_show'),1=>$this->trans('setting.show')])->default(0);
    }
}
