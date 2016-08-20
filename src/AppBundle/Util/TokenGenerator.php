<?php

namespace AppBundle\Util;

class TokenGenerator
{
    /**
     * Generate token
     *
     * @return string
     */
    public function generate()
    {
        return md5(uniqid(random_bytes(32), true));
    }
}