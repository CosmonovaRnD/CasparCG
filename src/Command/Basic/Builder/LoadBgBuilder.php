<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

use CosmonovaRnD\CasparCG\Command\Tween;
use CosmonovaRnD\CasparCG\Exception\ParamException;
use CosmonovaRnD\CasparCG\Exception\ParseException;

/**
 * Class LoadBgBuilder
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 *
 * @see     http://casparcg.com/wiki/CasparCG_2.0_AMCP_Protocol#LOADBG
 */
class LoadBgBuilder extends BaseBuilder implements ExtendBuilderInterface
{
    #region constants

    const TRANSITION_CUT   = 'CUT';
    const TRANSITION_MIX   = 'MIX';
    const TRANSITION_PUSH  = 'PUSH';
    const TRANSITION_WIPE  = 'WIPE';
    const TRANSITION_SLIDE = 'SLIDE';

    const DIRECTION_LEFT  = 'LEFT';
    const DIRECTION_RIGHT = 'RIGHT';

    #endregion

    #region properties

    /** @var bool */
    protected $useHtmlProducer;
    /** @var  string */
    protected $clip;
    /** @var  bool */
    protected $loop;
    /** @var  string */
    protected $transition;
    /** @var  int */
    protected $duration;
    /** @var  string */
    protected $tween;
    /** @var  string */
    protected $direction;
    /** @var  integer */
    protected $seek;
    /** @var  integer */
    protected $length;
    /** @var  string */
    protected $filter;
    /** @var  bool */
    protected $auto;

    #endregion

    #region setters

    /**
     * Use HTML producer
     *
     * @return $this
     */
    public function useHtmlProducer()
    {
        $this->useHtmlProducer = true;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function clip(string $clip, bool $htmlProducer = false): ExtendBuilderInterface
    {
        if ($htmlProducer) {
            $this->useHtmlProducer();
        } else {
            $clipParts = explode('.', $clip);

            if (count($clipParts) > 1) {
                array_pop($clipParts);
                $clip = implode('.', $clipParts);
            }
        }

        $this->clip = $clip;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function loop($loop = true): ExtendBuilderInterface
    {
        $this->loop = $loop;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function transition(string $transition): ExtendBuilderInterface
    {
        if (!in_array(strtoupper($transition), static::transitionTypes())) {
            $message = 'Transition must be one of the following values: ' . implode(',', static::transitionTypes());
            throw new ParamException($message);
        }

        $this->transition = $transition;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function duration(int $duration): ExtendBuilderInterface
    {
        if ($duration < 0) {
            throw new ParamException('Duration value must be unsigned integer');
        }

        $this->duration = $duration;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function tween(string $tween): ExtendBuilderInterface
    {
        if (!in_array($tween, Tween::animationTypes())) {
            $message = 'Tween param must be one of the following values: ' . implode(',', Tween::animationTypes());
            throw new ParamException($message);
        }

        $this->tween = $tween;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function direction(string $direction): ExtendBuilderInterface
    {
        $directions = [self::DIRECTION_LEFT, self::DIRECTION_RIGHT];

        if (!in_array(strtoupper($direction), $directions)) {
            $message = 'Direction must be one of the following values: ' . implode(',', $directions);
            throw new ParamException($message);
        }

        $this->direction = $direction;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function seek(int $frame): ExtendBuilderInterface
    {
        if ($frame < 0) {
            throw new ParamException('Frame value must be unsigned integer');
        }

        $this->seek = $frame;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function length(int $frames): ExtendBuilderInterface
    {
        if ($frames < 0) {
            throw new ParamException('Frames value must be unsigned integer');
        }

        $this->length = $frames;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function filter(string $filter): ExtendBuilderInterface
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function auto($auto = true): ExtendBuilderInterface
    {
        $this->auto = $auto;

        return $this;
    }

    #endregion

    #region builders

    /**
     * @return string
     */
    public function buildUseHtmlProducer(): string
    {
        return true === $this->useHtmlProducer
            ? '[html]'
            : '';
    }

    /**
     * @return string
     * @throws ParseException
     */
    protected function buildClip(): string
    {
        if (null === $this->clip) {
            throw new ParseException('Clip is required');
        }

        return sprintf('"%s"', addslashes($this->clip));
    }

    /**
     * @return string
     */
    protected function buildLoop(): string
    {
        return true === $this->loop
            ? 'LOOP'
            : '';
    }

    /**
     * @return string
     */
    protected function buildTransitionGroup(): string
    {
        if (isset($this->transition) || isset($this->duration)) {
            $transitionParts[] = $this->buildTransition();
            $transitionParts[] = $this->buildDuration();
            $transitionParts[] = $this->tween;
            $transitionParts[] = $this->direction;

            $transitionParts = array_filter($transitionParts);

            return implode(' ', $transitionParts);
        }

        return '';
    }

    /**
     * @return string
     * @throws ParseException
     */
    protected function buildTransition(): string
    {
        if (null === $this->transition) {
            throw new ParseException('Transition is required');
        }

        return $this->transition;
    }

    /**
     * @return string
     * @throws ParseException
     */
    protected function buildDuration(): string
    {
        if (null === $this->duration) {
            throw new ParseException('Duration is required');
        }

        return (string)$this->duration;
    }

    /**
     * @return string
     */
    protected function buildSeek(): string
    {
        return null !== $this->seek
            ? sprintf('SEEK %d', $this->seek)
            : '';
    }

    /**
     * @return string
     */
    protected function buildLength(): string
    {
        return null !== $this->length
            ? sprintf('LENGTH %d', $this->length)
            : '';
    }

    /**
     * @return string
     */
    protected function buildFilter(): string
    {
        return null !== $this->filter
            ? sprintf('FILTER %s', $this->filter)
            : '';
    }

    /**
     * @return string
     */
    protected function buildAuto(): string
    {
        return true === $this->auto
            ? 'AUTO'
            : '';
    }

    /**
     * @inheritDoc
     */
    public function build(bool $legacy = false): string
    {
        $commandParts[] = 'LOADBG';
        $commandParts[] = $this->buildChannel();
        $commandParts[] = $this->buildUseHtmlProducer();
        $commandParts[] = $this->buildClip();
        $commandParts[] = $this->buildLoop();
        $commandParts[] = $this->buildTransitionGroup();
        $commandParts[] = $this->buildSeek();
        $commandParts[] = $this->buildLength();
        $commandParts[] = $this->buildFilter();
        $commandParts[] = $this->buildAuto();


        $commandParts = array_filter($commandParts);

        return implode(' ', $commandParts);
    }

    #endregion

    #region service

    /**
     * Supported transition types
     *
     * @return array
     */
    private static function transitionTypes(): array
    {
        return [
            self::TRANSITION_CUT,
            self::TRANSITION_MIX,
            self::TRANSITION_PUSH,
            self::TRANSITION_SLIDE,
            self::TRANSITION_WIPE
        ];
    }

    #endregion
}
