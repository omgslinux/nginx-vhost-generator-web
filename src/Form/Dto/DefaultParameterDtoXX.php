<?php

namespace App\Form\Dto;

use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

class DefaultParameterDto implements JsonSerializable
{
    private const FILE_PATH = __DIR__ . '/../../../config/vhost_defaults.json';

    #[Assert\Choice(choices: ['letsencrypt', 'custom'])]
    private ?string $sslMode = 'custom';

    private ?string $domainSuffix = '';

    private ?string $logDirFormat = '/var/log/nginx/{{ SERVER }}';

    private ?string $sslCertificate = '';

    private ?string $sslCertificateKey = '';

    private ?string $wellKnownDir = '/var/www/_letsencrypt/.well-known';

    private ?string $clientMaxBodySize = '512M';

    private ?string $clientBodyTimeout = '300s';

    private ?string $fastcgiBuffers = '64 4K';

    private int $httpPort = 80;
    private int $httpsPort = 443;

    public function __construct(array $data = [])
    {
        $this->load($data);
    }

    public function load(mixed $data = []): void
    {
        if (is_array($data)) {
            $fileData = [];
            if (file_exists(self::FILE_PATH)) {
                $fileContent = file_get_contents(self::FILE_PATH);
                if ($fileContent !== false) {
                    $fileData = json_decode($fileContent, true) ?? [];
                }
            }

            $mergedData = array_merge($fileData, $data);

            foreach ($mergedData as $key => $value) {
                $setter = 'set' . ucfirst($key);
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        } else {
            $this
            ->setSslMode($data->getSslMode())
            ->setDomainSuffix($data->getDomainSuffix())
            ->setLogDirFormat($data->getLogDirFormat())
            ->setSslCertificate($data->getSslCertificate())
            ->setSslCertificateKey($data->getSslCertificateKey())
            ->setWellKnownDir($data->getWellKnownDir())
            ->setClientMaxBodySize($data->getClientMaxBodySize())
            ->setClientBodyTimeout($data->getClientBodyTimeout())
            ->setFastcgiBuffers($data->getFastcgiBuffers())
            ->setHttpPort($data->getHttpPort())
            ->setHttpsPort($data->getHttpsPort())
            ;
        }
    }

    public function save(): void
    {
        $json = json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($json !== false) {
            file_put_contents(self::FILE_PATH, $json);
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'sslMode' => $this->sslMode,
            'domainSuffix' => $this->domainSuffix,
            'logDirFormat' => $this->logDirFormat,
            'sslCertificate' => $this->sslCertificate,
            'sslCertificateKey' => $this->sslCertificateKey,
            'wellKnownDir' => $this->wellKnownDir,
            'clientMaxBodySize' => $this->clientMaxBodySize,
            'clientBodyTimeout' => $this->clientBodyTimeout,
            'fastcgiBuffers' => $this->fastcgiBuffers,
            'httpPort' => $this->httpPort,
            'httpsPort' => $this->httpsPort,
        ];
    }

    public function getSslMode(): ?string
    {
        return $this->sslMode;
    }

    public function setSslMode(?string $sslMode): self
    {
        $this->sslMode = $sslMode;
        return $this;
    }

    public function getDomainSuffix(): ?string
    {
        return $this->domainSuffix;
    }

    public function setDomainSuffix(?string $domainSuffix): self
    {
        $this->domainSuffix = $domainSuffix;
        return $this;
    }

    public function getLogDirFormat(): ?string
    {
        return $this->logDirFormat;
    }

    public function setLogDirFormat(?string $logDirFormat): self
    {
        $this->logDirFormat = $logDirFormat;
        return $this;
    }

    public function getSslCertificate(): ?string
    {
        return $this->sslCertificate;
    }

    public function setSslCertificate(?string $sslCertificate): self
    {
        $this->sslCertificate = $sslCertificate;
        return $this;
    }

    public function getSslCertificateKey(): ?string
    {
        return $this->sslCertificateKey;
    }

    public function setSslCertificateKey(?string $sslCertificateKey): self
    {
        $this->sslCertificateKey = $sslCertificateKey;
        return $this;
    }

    public function getWellKnownDir(): ?string
    {
        return $this->wellKnownDir;
    }

    public function setWellKnownDir(?string $wellKnownDir): self
    {
        $this->wellKnownDir = $wellKnownDir;
        return $this;
    }

    public function getClientMaxBodySize(): ?string
    {
        return $this->clientMaxBodySize;
    }

    public function setClientMaxBodySize(?string $clientMaxBodySize): self
    {
        $this->clientMaxBodySize = $clientMaxBodySize;
        return $this;
    }

    public function getClientBodyTimeout(): ?string
    {
        return $this->clientBodyTimeout;
    }

    public function setClientBodyTimeout(?string $clientBodyTimeout): self
    {
        $this->clientBodyTimeout = $clientBodyTimeout;
        return $this;
    }

    public function getFastcgiBuffers(): ?string
    {
        return $this->fastcgiBuffers;
    }

    public function setFastcgiBuffers(?string $fastcgiBuffers): self
    {
        $this->fastcgiBuffers = $fastcgiBuffers;
        return $this;
    }

    public function getHttpPort(): int
    {
        return $this->httpPort;
    }

    public function setHttpPort(int $httpPort): self
    {
        $this->httpPort = $httpPort;
        return $this;
    }

    public function getHttpsPort(): int
    {
        return $this->httpsPort;
    }

    public function setHttpsPort(int $httpsPort): self
    {
        $this->httpsPort = $httpsPort;
        return $this;
    }
}
