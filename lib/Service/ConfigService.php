<?php

declare(strict_types=1);

namespace OCA\Paperless\Service;

use OCA\Paperless\AppInfo\Application;
use OCA\Paperless\Model\Config;
use OCP\Config\IUserConfig;
use OCP\PreConditionNotMetException;

class ConfigService {
	/** @psalm-suppress PossiblyUnusedMethod */
	public function __construct(
		private IUserConfig $userConfig,
		private string $userId,
	) {
	}

	/**
	 * @throws PreConditionNotMetException
	 */
	public function setConfig(Config $config): void {
		$serialized = $config->jsonSerialize();
		foreach ($serialized as $key => $value) {
			$this->userConfig->setValueString($this->userId, Application::APP_ID, $key, $value);
		}
	}

	public function getConfig(): Config {
		return new Config(
			$this->getConfigValue('url'),
			$this->getConfigValue('token'),
		);
	}

	private function getConfigValue(string $key): string {
		return $this->userConfig->getValueString($this->userId, Application::APP_ID, $key);
	}
}
