<?php

declare(strict_types=1);

namespace Siketyan\Loxcan\Scanner\Yarn;

use Siketyan\Loxcan\Model\Dependency;
use Siketyan\Loxcan\Model\DependencyCollection;
use Siketyan\Loxcan\Model\Package;
use Siketyan\Loxcan\Versioning\SemVer\SemVerVersionParser;
use Siketyan\YarnLock\YarnLock;

class YarnLockParser
{
    private YarnPackagePool $packagePool;
    private SemVerVersionParser $versionParser;

    public function __construct(
        YarnPackagePool $packagePool,
        SemVerVersionParser $versionParser
    ) {
        $this->packagePool = $packagePool;
        $this->versionParser = $versionParser;
    }

    public function parse(?string $lock): DependencyCollection
    {
        $packages = YarnLock::parse($lock ?? '');
        $dependencies = [];

        foreach ($packages as $names => $package) {
            foreach (explode(',', $names) as $name) {
                $name = substr($name, 0, strrpos($name, '@', -1));
                $version = $package['version'];
                $package = $this->packagePool->get($name);

                if ($package === null) {
                    $package = new Package($name);
                    $this->packagePool->add($package);
                }

                $dependencies[] = new Dependency(
                    $package,
                    $this->versionParser->parse($version),
                );
            }
        }

        return new DependencyCollection(
            $dependencies,
        );
    }
}