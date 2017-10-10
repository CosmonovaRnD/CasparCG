<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

use CosmonovaRnD\CasparCG\Command\BaseBuilderInterface;
use CosmonovaRnD\CasparCG\Command\CommandBuilderInterface;
use CosmonovaRnD\CasparCG\Exception\ParseException;

/**
 * Class AddBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 */
class AddBuilder implements BaseBuilderInterface, CommandBuilderInterface
{
    protected $channel;

    protected $deckLink;
    protected $bluefish;
    protected $screen;
    protected $audio;
    protected $image;
    protected $file;
    protected $stream;

    protected $separateKey;
    protected $streamArgs;

    /**
     * @inheritDoc
     */
    public function channel(int $channel): BaseBuilderInterface
    {
        $this->channel = $channel;

        return $this;
    }

    public function deckLink(int $deckLink): AddBuilder
    {
        $this->deckLink = $deckLink;

        return $this;
    }

    public function bluefish(int $bluefish): AddBuilder
    {
        $this->bluefish = $bluefish;

        return $this;
    }

    public function screen(): AddBuilder
    {
        $this->screen = true;

        return $this;
    }

    public function audio(): AddBuilder
    {
        $this->audio = true;

        return $this;
    }

    public function image(string $filename): AddBuilder
    {
        $this->image = $filename;

        return $this;
    }

    public function file(string $filename, bool $separateKey = null): AddBuilder
    {
        $this->file = $filename;

        if (null !== $separateKey) {
            $this->separateKey = $separateKey;
        }

        return $this;
    }

    public function stream(string $path, string $args = null): AddBuilder
    {
        $this->stream = $path;

        if (null !== $args) {
            $this->streamArgs = $args;
        }

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
            $result = 'FILE ' . $this->file;

            if ($this->separateKey) {
                $result = $result . ' SEPARATE_KEY';
            }

            return $result;
        }

        return '';
    }

    public function buildStream(): string
    {
        if ($this->stream) {
            $result = 'STREAM ' . $this->stream;

            if ($this->streamArgs) {
                $result = $result . ' ' . $this->streamArgs;
            }

            return $result;
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $commandParts[] = 'ADD';
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

            if (strlen($consumer)) {
                $consumerCommandPart = $consumer;
            }
        }

        if (null === $consumerCommandPart) {
            throw new ParseException('At least one consumer must be set');
        }

        $commandParts[] = $consumerCommandPart;

        $commandParts = array_filter($commandParts);
        $command      = join(' ', $commandParts);

        return $command;
    }

    #endregion
}
