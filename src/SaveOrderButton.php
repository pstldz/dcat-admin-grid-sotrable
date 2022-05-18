<?php

namespace Pstldz\DcatAdminGridSotrable;

use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Illuminate\Http\Request;

class SaveOrderButton extends AbstractTool
{
    protected $sortColumn;

    protected $style = 'btn btn-primary btn-custom grid-save-order-btn grid-save-order-confirm-btn';

    public function __construct($column=null,Request $request=null)
    {
        if($column){
            $this->sortColumn=$column;
        }else{
            $this->sortColumn=$request->post('_column');
        }
    }

    public function title()
    {
        return admin_trans('sortable.save_order');
    }

    public function handle(Request $request)
    {
        $status = true;
        $column = $request->post('_column');
        $message = admin_trans('sortable.save_succeeded');
        $repository = $request->post('_model');

        $sorts = $request->post('_sort');
        $sorts = collect($sorts)
            ->pluck('key')
            ->combine(
                collect($sorts)->pluck('sort')->sort()
            );
        try {
            $sorts->each(function ($v, $k) use ($repository, $column) {
                $form = new Form(new $repository);
                $form->text($column);

                $form->update($k, [$column => $v]);
            });

        } catch (\Exception $exception) {
            $status  = false;
            $message = $exception->getMessage();
        }
        if($status){
            return $this->response()->success($message)->refresh();
        }else{
            return $this->response()->error($message);
        }

    }


    public function html()
    {
        $this->appendHtmlAttribute('class', $this->style);

        return <<<HTML
<button {$this->formatHtmlAttributes()}><i class="fa fa-save"></i><span class="hidden-xs">&nbsp;&nbsp;{$this->title()}</span></button>
HTML;
    }

    public function parameters()
    {
        $repository = $this->parent->model()->repository();
        if (method_exists($repository, 'getOriginalClassName')) {
            $class = $repository->getOriginalClassName();
        } else {
            $class = get_class($repository);
        }
        return [
            '_column'=>$this->sortColumn,
            '_model'=>$class
        ];
    }

}
