<?php

declare(strict_types=1);

namespace SoftWax\CorrelationIds\Generator;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(IdGeneratorInterface::class)]
final class SnowflakeIdGenerator implements IdGeneratorInterface
{
    private const string SYMBOLS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';

    private string $hostBin = '';

    public function __construct()
    {
        if (!\extension_loaded('gmp')) {
            throw new \LogicException('ext-gmp must be enabled to use ' . self::class);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generate(): string
    {
        if ($this->hostBin === '') {
            $this->hostBin = \str_pad(
                \mb_substr(\base_convert(\mb_substr(\sha1((string)\gethostname()), 0, 4), 16, 2), 0, 16),
                16,
                '0',
                \STR_PAD_LEFT,
            );
        }

        [$msec, $sec] = \explode(' ', \microtime());
        $time = $sec . ((float)$msec * 1000000);

        $num = \gmp_init('0b' . $this->hostBin . \base_convert($time, 10, 2));

        $encoded = '';
        while (\gmp_intval($num) > 0) {
            $divmod = \gmp_div_qr($num, 64);
            $num = $divmod[0];
            $encoded = \mb_substr(self::SYMBOLS, \gmp_intval($divmod[1]), 1) . $encoded;
        }

        if ($encoded === '') {
            throw new \RuntimeException('Unable to generate snowflake id.');
        }

        return $encoded;
    }
}
