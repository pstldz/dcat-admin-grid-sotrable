<?php

namespace Pstldz\DcatAdminGridSotrable;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Pstldz\DcatAdminGridSotrable\SortableDisplay;
use Dcat\Admin\Grid;
use Illuminate\Support\Collection;

class DcatAdminGridSotrableServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/sortable.min.js',
    ];

	protected $css = [
	    'css/sortable.css',
    ];

    protected $column = '__sortable__';

	public function init()
	{
		parent::init();
		//

        $sortType=self::setting('sortalbe_type')?self::setting('sortalbe_type'):0;
        $cancelBtn=self::setting('sortalbe_cancel')?self::setting('sortalbe_cancel'):0;
        Admin::requireAssets('@pstldz.dcat-admin-grid-sotrable');
        Grid::macro('sortable', function ($sortName = 'order') use($sortType,$cancelBtn){
            /* @var $this Grid */

            $this->tools(new SaveOrderButton($sortName));

            if($cancelBtn){
                $this->tools(new CancelSaveButton());
            }

            if (!request()->has($this->model()->getSortName())) {
                $this->model()->ordered();
            }
            if($sortType){
                $this->column($sortName)
                    ->displayUsing(SortableDisplay::class, [$sortName]);
            }else{
                $this->rows(function (Collection $rows) use ($sortName){
                    $rows->each(function ($row) use ($sortName){
                        $row->setAttributes(['data-key'=>$row->getKey(),'data-sort'=>$row->{$sortName},'class'=>'grid-sortable-handle']);
                    });
                });
                $id = $this->getTableId();
                $script = <<<JS
new Sortable($("#{$id} tbody")[0], {
    handle: '.grid-sortable-handle', // handle's class
    animation: 150,
    onUpdate: function () {
        var _sorts = [], tb = $('#{$id}');
        tb.find('.grid-sortable-handle').each(function () {
            _sorts.push($(this).data());
        });
        tb.closest('.row').first().find('.grid-save-order-confirm-btn').data('_sort', _sorts);
        tb.closest('.row').first().find('.grid-save-order-btn').show();
    },
});
JS;
                Admin::script($script);
            }
        });
	}


    public function settingForm()
    {
        return new Setting($this);
    }
}
