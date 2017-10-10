<?php
declare(strict_types=1);

namespace CosmonovaRnD\CasparCG\OSC;

use CosmonovaRnD\CasparCG\Exception\OSCMessageException;

/**
 * Class Parser
 *
 * @author  Aleksandr Besedin <bs@cosmonova.net>
 * @package CosmonovaRnD\CasparCG\OSC
 * Cosmonova | Research & Development
 */
class Parser
{
    /**
     * @param string $bin Binary data
     *
     * @return Bundle|RawMessage
     * @throws OSCMessageException
     */
    public function parse(string $bin)
    {
        if ('#' === $bin[0]) {
            return $this->parseBundle($bin);
        }

        if ('/' === $bin[0]) {
            $len = strlen($bin);

            return $this->parseMessage($len, $bin);
        }

        throw new OSCMessageException('Unknown message type');
    }

    /**
     * Parse bundle message
     *
     * @param string $bin Binary data to parse
     *
     * @return Bundle
     */
    protected function parseBundle(string $bin): Bundle
    {
        // Unpack bundle identifier, time and tail (bundle messages)
        $bundleMsg = unpack('a8bundle/Jtime/a*tail', $bin);

        $msgInfo['tail'] = $bundleMsg['tail'];

        $bundleObj = new Bundle($bundleMsg['time']);

        do {
            // Get length of next bundle message and tail
            $msgInfo = unpack('Nlen/a*tail', $msgInfo['tail']);
            // Parse next bundle message
            $message = $this->parseMessage($msgInfo['len'], $msgInfo['tail']);
            // Append message to bundle message collection
            $bundleObj->addMessage($message);
            // Exclude parsed message from tail
            $msgInfo['tail'] = substr($msgInfo['tail'], $msgInfo['len']);

            // Check if message tail is not ended
        } while (isset($msgInfo['tail'][0]));

        return $bundleObj;
    }

    /**
     * Parse message
     *
     * @param int    $len Length of message to parse
     * @param string $bin Binary data to parse
     *
     * @return RawMessage
     * @throws OSCMessageException
     */
    protected function parseMessage(int $len, string $bin): RawMessage
    {
        // unpack message of pointed length
        $format = "a{$len}msg";
        $msg    = unpack($format, $bin);

        // match address and type tags by pattern
        preg_match_all(
            '#(/(channel|diag)/\d+(/[\w_-]+)*\x00*),([ifsbhtdcTFNI]*)#',
            $msg['msg'],
            $matches
        );

        if (!isset($matches[0][0])) {
            throw new OSCMessageException('Unknown CasparCG address');
        }

        // get total address length (with type tags)
        $addressLen = $this->strLen($matches[0][0]);
        // Type tags
        $typeTags    = $matches[4][0];
        $typeTagsLen = strlen($typeTags);

        // Hold already read bytes offset
        $readBytes = $addressLen;

        $msgObj = new RawMessage($matches[1][0], []);

        // Read data per each type tag
        for ($i = 0; $i < $typeTagsLen; $i++) {
            // get bytes count for specific data type
            $typeBytes = Converter::getTypeBytes($typeTags[$i]);
            // get next binary data for converting
            $data = is_null($typeBytes)
                ? substr($msg['msg'], $addressLen)
                : substr($msg['msg'], $readBytes, $typeBytes);
            // convert binary data to specified type
            $msgObj->addArgument(Converter::convert($data, $typeTags[$i]));
            // New binary data offset
            $readBytes += $typeBytes;
        }

        return $msgObj;
    }

    /**
     * Get length of string and append null bytes if multiply is not 4
     *
     * @param string $str string
     *
     * @return int length
     */
    public function strLen(string $str): int
    {
        $len     = strlen($str);
        $remains = $len % 4;

        if ($remains !== 0) {
            return $len + 4 - $remains;
        }

        return $len;
    }
}
