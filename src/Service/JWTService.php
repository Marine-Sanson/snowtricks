<?php

/**
 * MediaMapper File Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Service;

use DateTimeImmutable;

/**
 * JWTService Class Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class JWTService
{


    /**
     * Summary of generate
     *
     * @param array  $header   header
     * @param array  $payload  payload
     * @param string $secret   secret
     * @param int    $validity validity
     *
     * @return string
     */
    public function generate(array $header, array $payload, string $secret, int $validity=10800): string
    {

        if ($validity > 0) {
            $now = new DateTimeImmutable();
            $exp = ($now->getTimestamp() + $validity);

            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $exp;
        }

        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        $secret = base64_encode($secret);

        $signature = hash_hmac('sha256', $base64Header.'.'.$base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);

        $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        $jwt = $base64Header.'.'.$base64Payload.'.'.$base64Signature;

        return $jwt;

    }


    /**
     * Summary of isValid
     *
     * @param string $token token
     *
     * @return bool
     */
    public function isValid(string $token): bool
    {

        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;

    }


    /**
     * Summary of getPayload
     *
     * @param string $token token
     *
     * @return array
     */
    public function getPayload(string $token): array
    {

        $array = explode('.', $token);

        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;

    }


    /**
     * Summary of getHeader
     *
     * @param string $token token
     *
     * @return array
     */
    public function getHeader(string $token): array
    {

        $array = explode('.', $token);

        $header = json_decode(base64_decode($array[0]), true);

        return $header;

    }


    /**
     * Summary of isExpired
     *
     * @param string $token token
     *
     * @return bool
     */
    public function isExpired(string $token): bool
    {

        $payload = $this->getPayload($token);

        $now = new DateTimeImmutable();

        return $payload['exp'] < $now->getTimestamp();

    }


    /**
     * Summary of check
     *
     * @param string $token  token
     * @param string $secret secret
     *
     * @return bool
     */
    public function check(string $token, string $secret): bool
    {

        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        $verifToken = $this->generate($header, $payload, $secret, 0);

        return $token === $verifToken;

    }


}
