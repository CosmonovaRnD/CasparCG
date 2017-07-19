<?php

namespace CosmonovaRnD\CasparCG\Command\Basic\Builder;

/**
 * Interface ExtendBuilderInterface
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\Command\Basic\Builder
 * Cosmonova | Research & Development
 */
interface ExtendBuilderInterface
{
    /**
     * Set clip string
     *
     * @param string $clip
     *
     * @return ExtendBuilderInterface
     */
    public function clip(string $clip): ExtendBuilderInterface;

    /**
     * Set LOOP definition
     *
     * @param bool $loop
     *
     * @return ExtendBuilderInterface
     */
    public function loop($loop = true): ExtendBuilderInterface;

    /**
     * Set transition type
     *
     * @param string $transition
     *
     * @return ExtendBuilderInterface
     */
    public function transition(string $transition): ExtendBuilderInterface;

    /**
     * Set transition duration
     *
     * @param int $duration
     *
     * @return ExtendBuilderInterface
     */
    public function duration(int $duration): ExtendBuilderInterface;

    /**
     * Set transition tween type
     *
     * @param string $tween
     *
     * @return ExtendBuilderInterface
     */
    public function tween(string $tween): ExtendBuilderInterface;

    /**
     * Set transition direction. `RIGHT` is default value
     *
     * @param string $direction
     *
     * @return ExtendBuilderInterface
     */
    public function direction(string $direction): ExtendBuilderInterface;

    /**
     * Set seek frame number
     *
     * @param int $frame
     *
     * @return ExtendBuilderInterface
     */
    public function seek(int $frame): ExtendBuilderInterface;

    /**
     * Set length of frames
     *
     * @param int $frames
     *
     * @return ExtendBuilderInterface
     */
    public function length(int $frames): ExtendBuilderInterface;

    /**
     * Set filter
     *
     * @param string $filter
     *
     * @return ExtendBuilderInterface
     */
    public function filter(string $filter): ExtendBuilderInterface;

    /**
     * Set AUTO
     *
     * @param bool $auto
     *
     * @return ExtendBuilderInterface
     */
    public function auto($auto = true): ExtendBuilderInterface;
}
