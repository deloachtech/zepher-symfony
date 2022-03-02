<?php


namespace DeLoachTech\ZepherBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AccessControlVoter extends Voter
{

    private $accessControl;

    public function __construct(AccessControl $accessControl)
    {
        $this->accessControl = $accessControl;
    }


    protected function supports(string $attribute, $subject): bool
    {
        $key = $this->accessControl->getConfig()['feature_id_prefix'];

        if (substr($attribute, 0, strlen($key)) != $key) {
            return false;
        }
        return true;
    }


    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if (!$user = $token->getUser()) {
            return false;
        }


        return $this->accessControl->userCanAccess($attribute, $subject);
    }
}