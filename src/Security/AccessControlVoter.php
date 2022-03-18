<?php
/**
 * This file is part of the deloachtech/zepher-symfony package.
 *
 * (c) DeLoach Tech, LLC
 * https://deloachtech.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


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
        $key = $this->accessControl->getAccessConfig()['feature_id_prefix'];

        if (substr($attribute, 0, strlen($key)) != $key) {
            return false;
        }
        return true;
    }


    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        return $this->accessControl->userCanAccess($attribute, $subject);
    }
}