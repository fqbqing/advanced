

<link rel="stylesheet" href="/static/css/order/pay_120414e.css">

<input type="hidden" value="<?= $isInWeixin ?>" id="isInWeixin">
<div class="container bg-white pay-container">
    <h2>微信支付</h2>
    <div class="pay-wrap">
        <div class="padding-big line">
            <?php if($isInWeixin): ?>
                <div class="suc-wrap none">
                    <div class="xb6 xm6 xs6 xl12 pay-detail">
                        <div class="text-center text-black">
                            <span class="text-big">应付金额（元）</span>
                            <p class="margin-top"><strong class="icon-rmb text-dot text-large"><em class="deposit"></em></strong></p>
                            <img src="" alt="" class="wechat-qrcode">
                        </div>
                    </div>
                    <div class="xb6 xm6 xs6 xl12 wechat-hint">
                        <img src="/static/images/wechat-hint_8eaaae7.png" class="img-responsive">
                    </div>
                </div>
                <div class="fail-wrap none">
                    <p class="text-big errmsg">抱歉，系统繁忙，请重试</p>
                </div>

            <?php else: ?>
                <div class="fail-wrap">
                    <p class="text-big errmsg"></p>
                </div>
            <?php endif ?>


        </div>
    </div>
</div>

