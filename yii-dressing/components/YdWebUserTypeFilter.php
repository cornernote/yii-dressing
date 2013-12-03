<?php

/**
 * YdWebUserFilter will ensure the user logged in through the correct UserIdentity method
 */
class YdWebUserTypeFilter extends CFilter
{

    /**
     * @var string The method in UserIdentity that the user logged in with.
     */
    public $requiredUserIdentityMethod = 'authenticate';

    /**
     * Ensure the user logged in through the correct UserIdentity method.
     *
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @return boolean whether the filtering process should continue and the action
     * should be executed.
     */
    protected function preFilter($filterChain)
    {
        $app = Yii::app();
        $user = $app->getUser();
        $request = $app->getRequest();

        if (!$user->getIsGuest() && $user->getState('UserIdentity_method') != $this->requiredUserIdentityMethod) {
            if ($app->createUrl($user->loginUrl[0], array_splice($user->loginUrl, 1)) != $request->getRequestUri()) {
                $user->loginRequired();
                return false;
            }
        }

        return true;
    }

}