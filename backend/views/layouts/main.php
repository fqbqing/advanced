<?php

use yii\helpers\Html;
use backend\assets\TemplateAsset;
use common\components\MenuHelper;
use yii\web\HttpException;
TemplateAsset::register($this);

//获取角色
//$roles = Yii::$app->authManager->getAssignments(Yii::$app->user->id);
//$roleName='';
//if($roles) $roleName = array_keys($roles)[0];
$context = $this->context;
$route = $context->action->getUniqueId()?:$context->getUniqueId().'/'.$context->defaultAction;
/*$roleName = yii::$app->view->params['roleName'];
$roleNames = yii::$app->view->params['roleNames'];
if(!in_array($roleName,$roleNames)) throw new HttpException(404, '对不起，角色名没找到！');*/
$assignedMenu = MenuHelper::getAssignedMenu('主办方');
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
    <html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php $this->head() ?>
    </head>

    <body class="fixed-left">
    <?php $this->beginBody() ?>

     <!-- Begin page -->
		<div id="wrapper">
		    <!-- Top Bar Start -->
		    <div class="topbar">
		        <!-- LOGO -->
		        <div class="topbar-left">
		            <div class="text-center">
		                <a class="logo"><img src="/frontend/template/upbond/images/logo.jpg" alt="logo"></a>
		                <a class="logo-sm"><img src="/frontend/template/upbond/images/logo_sm.png" height="30" alt="logo"></a>
		            </div>
		        </div>
		        <!-- Button mobile view to collapse sidebar menu -->
		        <div class="navbar navbar-default" role="navigation">
		            <div class="container">
		                <div class="">
		                    <div class="pull-left">
		                        <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
		                            <i class="iconfont">&#xe6c4;</i>
		                        </button>
		                        <span class="clearfix"></span>
		                    </div>
		                    <div class="pull-left">
		                    	<a href="" title="" class="navbarLink waves-effect waves-button">展曲官网 <i class="iconfont">&#xe6b8;</i></a>
		                    </div>
		                    <div class="pull-left">
		                    	<select class="form-control navbarSelect">
                                    <option>2016年第九届华中国际车展</option>
                                    <option value="">2016年第九届华中国际车展</option>
                                    <option value="">2016年第九届华中国际车展</option>
                                    <option value="">2016年第九届华中国际车展</option>
                                    <option value="">2016年第九届华中国际车展</option>
                                </select>
		                    </div>
		                    <ul class="nav navbar-nav navbar-right pull-right">
		                        <li>
		                        	你好，张默默
		                        </li>
		                        <li>
									<a href="" class="operation-btn"><img src="/frontend/template/upbond/images/operation-btn.png" alt="" width="92"></a>
		                        </li>
		                        <li>
									<a href="" >账户设置 <i class="iconfont">&#xe6b7;</i></a> |
									<a href="" >消息通知 <i class="iconfont">&#xe6c2;</i></a>
		                        </li>
		                        <li style="margin-left: 20px">
									<a href="">退出 <i class="iconfont">&#xe6c5;</i></a>
		                        </li>
		                    </ul>
		                </div>
		                <!--/.nav-collapse -->
		            </div>
		        </div>
		    </div>
		    <!-- Top Bar End -->
		    <!-- ========== Left Sidebar Start ========== -->
			<?php echo $this->render('@app/views/layouts/common/menu.php', ['allMenu'=>$assignedMenu,'route'=>$route]); ?>
		    <!-- Left Sidebar End -->
		    <!-- Start right Content here -->
		    <div class="content-page">
		        <!-- Start content -->
		        <div class="content">
		        	<div class="page-content-wrapper ">
		        		<div class="container">
		        			<?= $content ?>
		        		</div>
		        	</div>
		        	
		        </div>
		        <!-- container -->
		    </div>
		    <!-- Page content Wrapper -->
		</div>
		<!-- content -->
		<footer class="footer">
		    © 2017 Upbond - By Themesdesign.
		</footer>
		</div>
		<!-- End Right content here -->
		</div>
		<!-- END wrapper -->

	

    <?php $this->endBody() ?>

    </body>
    </html>
<?php $this->endPage() ?>