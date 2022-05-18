<?php


namespace Pstldz\DcatAdminGridSotrable;

use Dcat\Admin\Grid\Tools\AbstractTool;
use Illuminate\Http\Request;

class CancelSaveButton extends AbstractTool
{
    protected $style = 'btn btn-danger btn-custom grid-save-order-btn';

    public function title()
    {
        return admin_trans('sortable.cancel_save_order');
    }

    public function html()
    {
        $this->appendHtmlAttribute('class', $this->style);

        return <<<HTML
<button {$this->formatHtmlAttributes()}><i class="fa fa-close"></i><span class="hidden-xs">&nbsp;&nbsp;{$this->title()}</span></button>
HTML;
    }

    public function handle(Request $request)
    {
        $message = admin_trans('sortable.save_cancel');
        return $this->response()->success($message)->refresh();
    }
}
