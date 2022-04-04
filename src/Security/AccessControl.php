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

use DeLoachTech\ZepherBundle\Repository\AccessRepository;
use DeLoachTech\Zepher\Zepher;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AccessControl extends Zepher
{

    private $accessConfig;

    public function __construct(
        AccessRepository $accessRepository,
        SessionInterface $session,
        array            $accessConfig
    )
    {
        $this->accessConfig = $accessConfig;

        $domainId = null;

        $accountId = $session->get($this->accessConfig['session_keys']['account_id']);
        $userRoles = $session->get($this->accessConfig['session_keys']['user_roles']) ?? [];

        $dev = [];

        if ($_ENV['APP_ENV'] == 'dev') {

            $info = pathinfo($this->accessConfig['object_file']);
            $dir = ($info['dirname'] ? $info['dirname'] . DIRECTORY_SEPARATOR : '');
            $devFile = $dir . $info['filename'] . '_dev.json';

            if (file_exists($devFile)) {
                $dev = json_decode(file_get_contents($devFile), true);
            }
        }

        $domainId = $dev['simulate']['domain'] ?? $domainId;
//        $accountId = $dev['simulate']['account'] ?? $accountId;
        $userRoles = isset($dev['simulate']['role']) ? (array)$dev['simulate']['role'] : $userRoles;


        if ($accountId) {
            if ($accessRepository->isEmpty()) {
                $domainId =  $this->accessConfig['app_domain_id'];
//            } else {
//                $vo = new AccessValueObject($accountId);
//                $accessRepository->->getCurrentAccessRecord($vo);
//                $domainId = $vo->getDomainId();
            }
        }



        parent::__construct(
            $domainId,
            $accountId,
            $userRoles,
            $accessRepository,
            $this->accessConfig['object_file']
        );
    }

    public function getAccessConfig(): array
    {
        return $this->accessConfig;
    }

}