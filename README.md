
<div align="center">

# DCAT-ADMIN GRID-SORTABLE

</div>

这个插件可以帮助你通过拖动数据列表的行来进行排序，前端基于[SortableJS](https://github.com/SortableJS/Sortable), 后端基于[eloquent-sortable](https://github.com/spatie/eloquent-sortable)。

[Dcat-admin](https://github.com/jqhph/dcat-admin) 官方的插件[DCAT-ADMIN GRID-SORTABLE](https://github.com/dcat-admin/grid-sortable) 只支持 1.* 的版本
，在此基础上制作了这个仅2.* 可用的版本。

添加了不同的拖动方式，可以在设置中选择。

添加了取消的按钮，可以在设置中选择显示与否。

## 安装

```shell
composer require pstldz/dcat-admin-grid-sotrable
```

然后打开`http://yourhost/admin/auth/extensions` ，依次点击 `更新` 和 `启用` 。


## 使用

修改模型

```php
<?php

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MyModel extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];
}
```

在表格中使用对应的排序字段

```php
$grid = new Grid(new MyModel());

$grid->sortable('order_column');
```

## 翻译
对应语言目录下新建`sortable.php` ,或者直接在 `global.php` 添加以下内容
```php
return [
    'save_order' => 'Save order',
    'cancel_save_order' => 'Cancel save order',
    'save_succeeded' => 'Save succeeded !',
    'save_cancel' => 'Save canceled !'
];
```
