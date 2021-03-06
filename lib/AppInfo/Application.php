<?php
namespace OCA\Metadata\AppInfo;

use OCP\AppFramework\App;
use OCA\Metadata;
use OCA\Metadata\Services;

class Application extends App {

	const APP_NAME = 'metadata';

	public function __construct(array $params = array()) {
		parent::__construct(self::APP_NAME, $params);

		$container = $this->getContainer();

		$container->registerService('MetadataService', function(IAppContainer $c) {
			return new Services\MetadataService($c->getAppName());
		});
		\OC::$server->getEventDispatcher()->addListener('OCA\Files::loadAdditionalScripts', function(){
			\OCP\Util::addStyle('metadata', 'tabview' );
			\OCP\Util::addScript('metadata', 'tabview' );
			\OCP\Util::addScript('metadata', 'plugin' );

			$policy = new \OCP\AppFramework\Http\EmptyContentSecurityPolicy();
			$policy->addAllowedConnectDomain('https://nominatim.openstreetmap.org/');
			$policy->addAllowedFrameDomain('https://www.openstreetmap.org/');
			\OC::$server->getContentSecurityPolicyManager()->addDefaultPolicy($policy);
		});
	}
}
