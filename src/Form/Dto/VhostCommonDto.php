<?php
// src/Form/Dto/VhostCommonDto.php
namespace App\Form\Dto;

use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

class VhostCommonDto implements JsonSerializable
{
    private ?string $documentRoot = null;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    private ?string $serverName = "";
    private ?string $domainSuffix = "";

    private bool $useHttp = true;
    private bool $useHttps = false;
    private bool $useHttpRedirect = false;

    #[Assert\PositiveOrZero]
    private ?int $httpPort = null;

    #[Assert\PositiveOrZero]
    private ?int $httpsPort = null;

    private ?string $sslMode = null;
    private ?string $sslCertificate = '';

    private ?string $sslCertificateKey = '';
    private ?string $logDirFormat = '';

    private ?string $wellKnownDir = '';

    private ?string $clientMaxBodySize = null;

    private ?string $clientBodyTimeout = null;
    private ?string $fastcgiBuffers = null;


    private ?string $sslClientCertificate = null;
    private string $sslVerifyClient = "off";
    private bool $sslClientFastcgi = false;

    private ?string $extraBlock = null;
    private bool $useStaticFiles = true;

    public function __construct(array $data = [])
    {
        $this->load($data);
    }
    public function loadDefaults(mixed $data = []): void
    {
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


    public function load(array $data = []): void
    {
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $getter = 'get' . ucfirst($key);
            if (!method_exists($this, $getter)) {
                $getter = 'is' . ucfirst($key);
            }
            if (method_exists($this, $setter)) {
                $this->$setter($value);
                //dump("Cargando $setter=$value;".$this->$getter());
            } else {
                dump("No existe $setter");
            }
        }
    }

    public function getDocumentRoot(): ?string
    {
        if (!$this->documentRoot) {
            $this->documentRoot = '/var/www/vhosts/' . $this->serverName;
        }

        return $this->documentRoot;
    }

    public function setDocumentRoot(?string $documentRoot): self
    {
        $this->documentRoot = $documentRoot;
        return $this;
    }

    public function getServerName(): ?string
    {
        return $this->serverName;
    }

    public function setServerName(?string $serverName): self
    {
        $this->serverName = $serverName;
        return $this;
    }

    public function isUseHttp(): bool
    {
        return $this->useHttp;
    }

    public function setUseHttp(bool $useHttp): self
    {
        $this->useHttp = $useHttp;
        return $this;
    }

    public function isUseHttps(): bool
    {
        return $this->useHttps;
    }

    public function setUseHttps(bool $useHttps): self
    {
        $this->useHttps = $useHttps;
        return $this;
    }

    public function isUseHttpRedirect(): bool
    {
        return $this->useHttpRedirect;
    }

    public function setUseHttpRedirect(bool $useHttpRedirect): self
    {
        $this->useHttpRedirect = $useHttpRedirect;
        return $this;
    }

    public function getHttpPort(): ?int
    {
        return $this->httpPort;
    }

    public function setHttpPort(?int $httpPort): self
    {
        $this->httpPort = $httpPort;
        return $this;
    }

    public function getHttpsPort(): ?int
    {
        return $this->httpsPort;
    }

    public function setHttpsPort(?int $httpsPort): self
    {
        $this->httpsPort = $httpsPort;
        return $this;
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

    public function getSslClientCertificate(): ?string
    {
        return $this->sslClientCertificate;
    }

    public function setSslClientCertificate(?string $sslClientCertificate): self
    {
        $this->sslClientCertificate = $sslClientCertificate;
        return $this;
    }

    public function getSslVerifyClient(): ?string
    {
        return $this->sslVerifyClient;
    }

    public function setSslVerifyClient(?string $sslVerifyClient): self
    {
        $this->sslVerifyClient = $sslVerifyClient;
        return $this;
    }

    public function getSslClientFastcgi(): ?bool
    {
        return $this->sslClientFastcgi;
    }

    public function setSslClientFastcgi(?string $sslClientFastcgi): self
    {
        $this->sslClientFastcgi = $sslClientFastcgi;
        return $this;
    }

    public function getExtraBlock(): ?string
    {
        return $this->extraBlock;
    }

    public function setExtraBlock(?string $extraBlock): self
    {
        $this->extraBlock = $extraBlock;
        return $this;
    }

    public function getUseStaticFiles(): bool
    {
        return $this->useStaticFiles;
    }

    public function setUseStaticFiles(bool $useStaticFiles): self
    {
        $this->useStaticFiles = $useStaticFiles;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'documentRoot' => $this->getDocumentRoot(),
            'serverName' => $this->serverName,
            'domainSuffix' => $this->domainSuffix,
            'logDirFormat' => $this->logDirFormat,
            'useHttp' => $this->useHttp,
            'useHttps' => $this->useHttps,
            'useHttpRedirect' => $this->useHttpRedirect,
            'httpPort' => $this->httpPort,
            'httpsPort' => $this->httpsPort,
            'sslCertificate' => $this->sslCertificate,
            'sslCertificateKey' => $this->sslCertificateKey,
            'sslClientCertificate' => $this->sslClientCertificate,
            'sslVerifyClient' => $this->sslVerifyClient,
            'sslClientFastcgi' => $this->sslClientFastcgi,
            'extraBlock' => $this->extraBlock,
            'useStaticFiles' => $this->useStaticFiles,
            'sslMode' => $this->sslMode,
            'wellKnownDir' => $this->wellKnownDir,
            'clientMaxBodySize' => $this->clientMaxBodySize,
            'clientBodyTimeout' => $this->clientBodyTimeout,
            'fastcgiBuffers' => $this->fastcgiBuffers,
        ];
    }
}
