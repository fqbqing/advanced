<?php
use common\services\UrlService;

?>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="index.html" class="waves-effect"><i class="iconfont">&#xe6c6;</i><span> 首页 </span></a>
                </li>
                <?php foreach ($allMenu as $menu):?>
                    <?php if(isset($menu['_child'])):?>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="iconfont"><?= $menu['icon'] ?></i>
                                <span> <?= $menu['name'] ?> </span>
                                <span class="pull-right">
                            <i class="iconfont arrows">&#xe601;</i>
                        </span>
                            </a>
                            <ul class="list-unstyled">
                                <?php foreach($menu['_child'] as $v): ?>
                                    <li><a href="<?= UrlService::buildUrl($v['route']) ?>"><?= $v['name'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?= UrlService::buildUrl($menu['route']) ?>" class="waves-effect"><i class="iconfont"><?= $menu['icon'] ?></i><span> <?= $menu['name'] ?> </span></a>
                        </li>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- end sidebarinner -->
</div>