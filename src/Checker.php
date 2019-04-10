<?php
namespace SykesCottages\LicenceCheck;

use InvalidArgumentException;

abstract class Checker
{
    protected $ignoredPackages = [];
    protected $validLicences = [];

    abstract public function validate($licences);
    abstract public function getDefaultOutput();

    public function addValidLicence($licenceName)
    {
        $this->validLicences[] = $licenceName;
    }

    public function addValidFile($filePath)
    {
        $this->callFunctionPerLine($filePath, [$this, 'addValidLicence']);
    }

    public function ignorePackage($packageName)
    {
        $this->ignoredPackages[]= $packageName;
    }

    public function ignorePackageFile($filePath)
    {
        $this->callFunctionPerLine($filePath, [$this, 'ignorePackage']);
    }

    protected function callFunctionPerLine($filePath, $callback)
    {
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new InvalidArgumentException("Cant open file");
        }
        while(($license = fgets($handle)) !== false) {
            $callback(trim($license));
        }
    }

    public function getValidLicences()
    {
        return $this->validLicenses;
    }

    protected function checkLicences($licences)
    {
        foreach ($licences as $name => $licence) {
            if (in_array($name, $this->ignoredPackages)) {
                continue;
            }

            if (array_uintersect(
                $licence,
                $this->validLicences,
                'strcasecmp')
            ) {
                continue;
            }
            $message = sprintf(
                "Package %s licence (%s) is not on the approved list",
                $name,
                implode(', ', $licence)
            );

            throw new InvalidLicence($message);
        }
    }
}
