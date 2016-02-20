<?php
/**
 * @author zhukov
 */

namespace Application\ValueObject;


abstract class ValueObjectAbstract
{
    /**
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if (isset($this->$property)) {
            return $this->$property;
        }

        return null;
    }
}
