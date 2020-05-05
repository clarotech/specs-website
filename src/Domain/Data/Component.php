<?php

namespace App\Domain\Data;

use App\Configuration;

class Component extends AbstractModel
{
    /** @var string */
    public $id;
    /** @var string */
    public $title;
    /** @var string */
    public $description;
    /** @var string */
    public $keywords;
    /** @var Jira */
    public $jira;
    /** @var Specification[] */
    public $specifications;
    /** @var Expression[] */
    public $expressions;
    /** @var Release[] */
    public $releases;
    /** @var Release */
    public $release;
    /** @var Types[] */
    public $types;
    /** @var Package[] */
    public $packages;

    public function __invoke(array $args = [])
    {
        parent::__invoke($args);
        if (!$this->release) {
            $this->release = new Release($this->settings);
            $this->release->component = $this;
            $this->release->makeLatest();
        }
        return $this;
    }

    public function setId(string $value = null): Component
    {
        $this->id = $value;
        return $this;
    }

    public function setTitle(string $value = null): Component
    {
        $this->title = $value;
        return $this;
    }

    public function setDescription(string $value = null): Component
    {
        $this->description = $value;
        return $this;
    }

    public function setKeywords(string $value = null): Component
    {
        $this->keywords = $value;
        return $this;
    }

    public function setJira(array $value = []): Component
    {
        $jira = new Jira($this->settings);
        $this->jira = $jira($value);
        return $this;
    }

    public function setSpecifications(array $value = []): Component
    {
        foreach ($value as $i => $data) {
            $specification = (new Specification($this->settings))($data);
            $specification->component = $this;
            $this->specifications[$i] = $specification;
        }
        return $this;
    }

    public function getSpecificationById(string $id = ''): Specification
    {
        foreach ($this->specifications as $specification) {
            if ($specification->is($id)) {
                return $specification;
            }
        }
        throw new \DomainException("Invalid specification: $id.");
    }

    public function setExpressions(array $value = []): Component
    {
        foreach ($value as $i => $data) {
            $expression = (new Expression($this->settings))($data);
            $expression->component = $this;
            $this->expressions[$i] = $expression;
        }
        return $this;
    }

    public function getExpressionById(string $id): Expression
    {
        foreach ($this->expressions as $expression) {
            if ($expression->is($id)) {
                return $expression;
            }
        }
        throw new \DomainException("Invalid expression: $id.");
    }

    public function setReleases(array $value = []): Component
    {
        foreach ($value as $i => $data) {
            $release = (new Release($this->settings))($data);
            $release->component = $this;
            $this->releases[$i] = $release;
        }
        return $this;
    }

    public function getReleaseById(string $id): Release
    {
        if ($this->release && $this->release->is($id)) {
            return $this->release;
        }
        foreach ($this->releases as $release) {
            if ($release->is($id)) {
                return $release;
            }
        }
        throw new \DomainException("Invalid release: $id.");
    }

    public function useRelease(?string $releaseId): Component
    {
        $this->release = $this->getReleaseById($releaseId ?: Release::LATEST);
        return $this;
    }

    public function registerPackage(Package $package): Component
    {
        $this->packages[$package->name] = $package;
        return $this;
    }

    public function getPackageByName(string $packageName): Package
    {
        if ($this->packages[$packageName]) {
            return $this->packages[$packageName];
        }
        foreach ($this->packages as $package) {
            if ($package->is($packageName)) {
                return $package;
            }
        }
        throw new \DomainException("Invalid package: $packageName.");
    }

    public function registerType(Type $type): Component
    {
        $this->types[$type->name] = $type;
        try {
            $specification = $this->getSpecificationById($type->specificationId);
            $specification->registerType($type);
            try {
                $package = $this->getPackageByName($type->packageName);
                $package->registerType($type);
            } catch (\Exception $e) {
                $package = (new Package($this->settings))(['name' => $type->packageName]);
                $this->registerPackage($package);
                $package->registerType($type);
            }
            $type->component = $this;
        } catch (\Exception $e) {
            // silently do nothing
        }
        return $this;
    }

    public function setTypes(array $types): Component
    {
        foreach ($types as $data) {
            $type = (new Type($this->settings))($data);
            $this->registerType($type);
        }
        return $this;
    }

    public function getTypeByName(string $typeName): Type
    {
        if ($this->types[$typeName]) {
            return $this->types[$typeName];
        }
        foreach ($this->types as $type) {
            if ($type->is($typeName)) {
                return $type;
            }
        }
        throw new \DomainException("Invalid type: $typeName.");
    }

    public function getLink(): string
    {
        if ($this->id) {
            return "/releases/{$this->id}";
        }
        return '';
    }

    public function getDirectory(): string
    {
        if ($this->id) {
            return "{$this->settings->sites_root}/releases/{$this->id}";
        }
        return '';
    }

    public function getAssetFilename(string $asset = ''): string
    {
        if ($asset && $this->id && $this->release) {
            $asset = preg_replace('/\.{2,}/', '.', $asset);
            $asset = preg_replace('/^docs\//', '', $asset);
            return "{$this->release->getDirectory()}/docs/{$asset}";
        }
        return '';
    }

    public function getUMLFilename(string $asset = ''): string
    {
        if ($asset && $this->id && $this->release) {
            $asset = preg_replace('/\.{2,}/', '.', $asset);
            return "{$this->release->getDirectory()}/computable/UML/{$asset}";
        }
        return '';
    }

}
