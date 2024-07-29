<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Model\Resolver;

/**
 * Class From
 * @package Magexperts\Smtp\Model\Resolver
 */
class From
{
    /**
     * @var null
     */
    protected $from = null;

    /**
     * @return null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->from = null;

        return $this;
    }
}
