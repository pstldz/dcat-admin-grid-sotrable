<?php

namespace Pstldz\DcatAdminGridSotrable;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Pstldz\DcatAdminGridSotrable\SortableDisplay;
use Dcat\Admin\Grid;

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
        Admin::requireAssets('@pstldz.dcat-admin-grid-sotrable');
        $column = $this->column;
        Grid::macro('sortable', function ($sortName = 'order') use ($column) {
            /* @var $this Grid */

            $this->tools(new SaveOrderButton($sortName));

            $this->tools(new CancelSaveButton());

            if (!request()->has($this->model()->getSortName())) {
                $this->model()->ordered();
            }

            $this->column($column, admin_trans_field($sortName))
                ->displayUsing(SortableDisplay::class, [$sortName]);
        });

	}
}
