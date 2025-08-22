<?php

namespace App\Entity;

use App\Repository\InitialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InitialRepository::class)]
#[ORM\Table(name: 'defaults')]
class Initial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $sslMode = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $domainSuffix = null;

    #[ORM\Column(length: 255)]
    private ?string $logDirFormat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sslCertificate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sslCertificateKey = null;

    #[ORM\Column(length: 255)]
    private ?string $wellKnownDir = '/var/www/_letsencrypt/.well-known';

    #[ORM\Column(length: 10)]
    private ?string $clientMaxBodySize = '512M';

    #[ORM\Column(length: 10)]
    private ?string $clientBodyTimeout = '300s';

    #[ORM\Column(length: 20)]
    private ?string $fastcgiBuffers = '64 4K';

    #[ORM\Column]
    private ?int $httpPort = 80;

    #[ORM\Column]
    private ?int $httpsPort = 443;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSslMode(): ?string
    {
        return $this->sslMode;
    }

    public function setSslMode(string $sslMode): static
    {
        $this->sslMode = $sslMode;

        return $this;
    }

    public function getDomainSuffix(): ?string
    {
        return $this->domainSuffix;
    }

    public function setDomainSuffix(?string $domainSuffix): static
    {
        $this->domainSuffix = $domainSuffix;

        return $this;
    }

    public function getLogDirFormat(): ?string
    {
        return $this->logDirFormat;
    }

    public function setLogDirFormat(string $logDirFormat): static
    {
        $this->logDirFormat = $logDirFormat;

        return $this;
    }

    public function getSslCertificate(): ?string
    {
        return $this->sslCertificate;
    }

    public function setSslCertificate(?string $sslCertificate): static
    {
        $this->sslCertificate = $sslCertificate;

        return $this;
    }

    public function getSslCertificateKey(): ?string
    {
        return $this->sslCertificateKey;
    }

    public function setSslCertificateKey(?string $sslCertificateKey): static
    {
        $this->sslCertificateKey = $sslCertificateKey;

        return $this;
    }

    public function getWellKnownDir(): ?string
    {
        return $this->wellKnownDir;
    }

    public function setWellKnownDir(string $wellKnownDir): static
    {
        $this->wellKnownDir = $wellKnownDir;

        return $this;
    }

    public function getClientMaxBodySize(): ?string
    {
        return $this->clientMaxBodySize;
    }

    public function setClientMaxBodySize(string $clientMaxBodySize): static
    {
        $this->clientMaxBodySize = $clientMaxBodySize;

        return $this;
    }

    public function getClientBodyTimeout(): ?string
    {
        return $this->clientBodyTimeout;
    }

    public function setClientBodyTimeout(string $clientBodyTimeout): static
    {
        $this->clientBodyTimeout = $clientBodyTimeout;

        return $this;
    }

    public function getFastcgiBuffers(): ?string
    {
        return $this->fastcgiBuffers;
    }

    public function setFastcgiBuffers(string $fastcgiBuffers): static
    {
        $this->fastcgiBuffers = $fastcgiBuffers;

        return $this;
    }

    public function getHttpPort(): ?int
    {
        return $this->httpPort;
    }

    public function setHttpPort(int $httpPort): static
    {
        $this->httpPort = $httpPort;

        return $this;
    }

    public function getHttpsPort(): ?int
    {
        return $this->httpsPort;
    }

    public function setHttpsPort(int $httpsPort): static
    {
        $this->httpsPort = $httpsPort;

        return $this;
    }
}
