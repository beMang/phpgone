<?php
namespace phpGone\Session;

trait FlashTrait
{
    public function flash($message)
    {
        $_SESSION['flash'] = $message;
    }
}
