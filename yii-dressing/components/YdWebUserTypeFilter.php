<?php

/**
 * Class YdWebUserFilter
 */
class YdWebUserTypeFilter extends CFilter
{

    /**
     * @var string
     */
    public $type = 'web';

    /**
     * Performs the pre-action filtering.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @return boolean whether the filtering process should continue and the action
     * should be executed.
     */
    protected function preFilter($filterChain)
    {
        $app = Yii::app();
        $user = $app->getUser();
        $request = $app->getRequest();
        $session = $app->getSession();

        // ensure the user is the right type of login
        if (!$user->getIsGuest() && !$session->get('UserIdentity.' . $this->type)) {
            if ($app->createUrl($user->loginUrl[0], array_splice($user->loginUrl, 1)) != $request->getRequestUri()) {
                $user->loginRequired();
                return false;
            }
        }

        return true;
    }

}