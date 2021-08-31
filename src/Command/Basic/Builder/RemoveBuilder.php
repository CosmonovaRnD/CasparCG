<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

use CosmonovaRnD\CasparCG\Command\BaseBuilderInterface;
use CosmonovaRnD\CasparCG\Command\CommandBuilderInterface;
use CosmonovaRnD\CasparCG\Exception\ParseException;

/**
 * Class RemoveBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 */
class RemoveBuilder implements CommandBuilderInterface, BaseBuilderInterface
{
    protected $channel;

    protected $deckLink;
    protected $bluefish;
    protected $screen;
    protected $audio;
    protected $image;
    protected $file;
    protected $stream;

    /**
     * @inheritDoc
     */
    public function channel(int $channel): BaseBuilderInterface
    {
        $this->channel = $channel;

        return $this;
    }

    public function deckLink(int $deckLink): RemoveBuilder
    {
        $this->deckLink = $deckLink;

        return $this;
    }

    public function bluefish(int $bluefish): RemoveBuilder
    {
        $this->bluefish = $bluefish;

        return $this;
    }

    public function screen(): RemoveBuilder
    {
        $this->screen = true;

        return $this;
    }

    public function audio(): RemoveBuilder
    {
        $this->audio = true;

        return $this;
    }

    public function image(string $filename): RemoveBuilder
    {
        $this->image = $filename;

        return $this;
    }

    public function file(string $filename): RemoveBuilder
    {
        $this->file = $filename;

        return $this;
    }

    public function stream(string $path): RemoveBuilder
    {
        $this->stream = $path;

        return $this;
    }

    #region builders

    /**
     * @return string
     * @throws ParseException
     */
    protected function buildChannel(): string
    {
        if (null === $this->channel) {
            throw new ParseException('Channel is required');
        }

        return (string)$this->channel;
    }

    protected function buildDeckLink(): string
    {
        if ($this->deckLink) {
            return 'DECKLINK ' . $this->deckLink;
        }

        return '';
    }

    protected function buildBluefish(): string
    {
        if ($this->bluefish) {
            return 'BLUEFISH ' . $this->bluefish;
        }

        return '';
    }

    protected function buildScreen(): string
    {
        if ($this->screen) {
            return 'SCREEN';
        }

        return '';
    }

    public function buildAudio(): string
    {
        if ($this->audio) {
            return 'AUDIO';
        }

        return '';
    }

    public function buildImage()
    {
        if ($this->image) {
            return 'IMAGE ' . $this->image;
        }

        return '';
    }

    public function buildFile(): string
    {
        if ($this->file) {
            return 'FILE ' . $this->file;
        }

        return '';
    }

    public function buildStream(): string
    {
        if ($this->stream) {
            return 'STREAM ' . $this->stream;
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    public function build(bool $legacy = false): string
    {
        $commandParts[] = 'REMOVE';
        $commandParts[] = $this->buildChannel();


        $consumerBuilders = [
            $this->buildDeckLink(),
            $this->buildBluefish(),
            $this->buildScreen(),
            $this->buildAudio(),
            $this->buildImage(),
            $this->buildFile(),
            $this->buildStream()
        ];

        $consumerCommandPart = null;

        foreach ($consumerBuilders as $consumerBuilder) {
            $consumer = $consumerBuilder;

            if ('' !== $consumer) {
                $consumerCommandPart = $consumer;
            }
        }

        if (null === $consumerCommandPart) {
            throw new ParseException('At least one consumer must be set');
        }

        $commandParts[] = $consumerCommandPart;

        $commandParts = array_filter($commandParts);

        return implode(' ', $commandParts);
    }

    #endregion

}
