<?php

namespace App\Domain\Data;

class Expression extends AbstractModel implements \JsonSerializable
{
    /** @var string */
    public $id;
    /** @var string */
    public $title;
    /** @var string */
    public $type;
    /** @var string */
    public $description;
    /** @var string */
    public $link;
    /** @var array */
    public $dependency;
    
    /** @var Component */
    public $component;

    public function setId(string $value = null): Expression
    {
        $this->id = $value;
        return $this;
    }

    public function setTitle(string $value = null): Expression
    {
        $this->title = $value;
        return $this;
    }

    public function setType(string $value = null): Expression
    {
        $this->type = $value;
        return $this;
    }

    public function setDescription(string $value = null): Expression
    {
        $this->description = $value;
        return $this;
    }

    public function setLink(string $value = null): Expression
    {
        $this->link = $value;
        return $this;
    }

    public function setDependency(array $value = []): Expression
    {
        $this->dependency = $value;
        //todo
        return $this;
    }

    public function isOwned(): bool
    {
        return empty($this->dependency);
    }

    public function getLink(): string
    {
        if ($this->link) {
            return $this->link;
        } elseif ($this->id && $this->component && $this->component->release) {
            return "{$this->component->release->getLink()}/UML/{$this->id}";
        }
        return '';
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'description' => $this->description,
            'dependency' => $this->dependency,
            '_component' => $this->component->id,
            '_getLink()' => $this->getLink(),
        ];
    }
}
