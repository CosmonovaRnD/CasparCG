<?php

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

use CosmonovaRnD\CasparCG\Exception\ParamException;
use CosmonovaRnD\CasparCG\Exception\ParseException;

/**
 * Class SetBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#SET
 */
class SetBuilder implements BaseBuilderInterface
{
    #region properties

    /** @var int */
    protected $channel;

    /** @var  string */
    protected $mode;

    #endregion

    #region setters

    /**
     * @inheritDoc
     */
    public function channel(int $channel): BaseBuilderInterface
    {
        if ($channel < 0) {
            throw new ParamException('Channel must be unsigned integer value');
        }

        $this->channel = $channel;

        return $this;
    }

    /**
     * Set video format mode
     *
     * @param string $videoFormat
     *
     * @return SetBuilder
     * @throws ParamException
     */
    public function mode(string $videoFormat): SetBuilder
    {
        if (!in_array($videoFormat, self::videoFormats())) {
            $message = sprintf('Video format must be one of the following values: ', join(',', self::videoFormats()));
            throw new ParamException($message);
        }

        $this->mode = $videoFormat;

        return $this;
    }

    #endregion

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

    /**
     * @return string
     * @throws ParseException
     */
    protected function buildMode(): string
    {
        if (null === $this->mode) {
            throw new ParseException('Mode is required');
        }

        return $this->mode;
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        $commandParts[] = 'SET';
        $commandParts[] = $this->buildChannel();
        $commandParts[] = $this->buildMode();

        $commandParts = array_filter($commandParts);
        $command      = join(' ', $commandParts);

        return $command;
    }

    #endregion

    #region service

    /**
     * Supported video formats
     *
     * @return array
     */
    protected static function videoFormats(): array
    {
        return [
            'PAL',
            'NTSC',
            '576p2500',
            '720p2398',
            '720p2400',
            '720p2500',
            '720p2997',
            '720p3000',
            '720p5000',
            '720p5994',
            '720p6000',
            '1080p2398',
            '1080p2400',
            '1080p2500',
            '1080p2997',
            '1080p3000',
            '1080p5000',
            '1080i5000',
            '1080p5994',
            '1080i5994',
            '1080p6000',
            '1080i6000',
            '2160p2398',
            '2160p2400',
            '2160p2500',
            '2160p2997',
            '2160p3000',
        ];
    }

    #endregion
}
