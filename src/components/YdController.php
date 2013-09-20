<?php
/**
 * All controller classes for this application should extend from this base class.
 */
class YdController extends CController
{
    /**
     * @var
     */
    protected $loadModel;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

}
