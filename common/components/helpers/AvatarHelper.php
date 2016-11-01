<?php

namespace common\components\helpers;

class AvatarHelper
{
    public $mobile;
    public $size;

    public function __construct($mobile, $size = 50)
    {
        $this->mobile = $mobile;
        $this->size = $size;
    }

    public function getAvater()
    {

        // TODO 保存头像图片 加缓存
        $identicon = new \Identicon\Identicon();
        return $identicon->getImageDataUri($this->mobile, $this->size);
    }

    /**
     * 根据 手机号 获取 gravatar 头像的地址
     * @return string
     */
    private function getGravatar()
    {
        $hash = md5(strtolower(trim($this->mobile)));
        return sprintf('http://gravatar.com/avatar/%s?s=%d&d=%s', $hash, $this->size, 'identicon');
    }

    /**
     * 验证mobile是否有对应的 Gravatar 头像（
     * @return bool
     */
    private function validateGravatar()
    {
        $hash = md5(strtolower(trim($this->mobile)));
        $uri = 'http://gravatar.com/avatar/' . $hash . '?d=404';
        $headers = @get_headers($uri);
        if (!preg_match("|200|", $headers[0])) {
            return false;
        } else {
            return true;
        }
    }
}