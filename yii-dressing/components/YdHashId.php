<?php

/**
 * YdHashId
 */
class YdHashId extends CApplicationComponent
{
    /**
     * @var \Hashids\Hashids
     */
    public $hashids;

    /**
     *
     */
    public function init()
    {
        $alphabet = 'abcdefghjkmnpqrstuvwxyz23456789';
        $this->hashids = new \Hashids\Hashids(YII_DRESSING_HASH, 6, $alphabet);
    }

    /**
     * @param int $id
     * @return string
     */
    public function hash($id)
    {
        return $this->hashids->encrypt($id);
    }

    /**
     * @param string $hash
     * @return int
     */
    public function id($hash)
    {
        return current($this->hashids->decrypt($hash));
    }

}
