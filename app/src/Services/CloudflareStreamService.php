<?php

namespace {

    use GuzzleHttp\Client;
    use SilverStripe\Core\Environment;
    use SilverStripe\Core\Injector\Injectable;

    /**
     * Uploads local video files to Cloudflare Stream.
     *
     * Requires CLOUDFLARE_STREAM_ACCOUNT_ID and CLOUDFLARE_STREAM_API_TOKEN to be
     * set in .env (the API token needs the "Stream: Edit" permission).
     *
     * Uses Cloudflare's single-request upload endpoint, which caps out at 200MB -
     * fine for a short, compressed background video, but not for long-form content.
     */
    class CloudflareStreamService
    {
        use Injectable;

        /**
         * @param resource $stream A readable stream of the file's contents, e.g. from File::getStream() -
         *                         assets aren't necessarily on local disk, so a stream is used rather than a path
         * @return string The uploaded video's Cloudflare Stream UID
         * @throws RuntimeException if credentials are missing or the upload fails
         */
        public function upload($stream, string $fileName): string
        {
            $accountID = Environment::getEnv('CLOUDFLARE_STREAM_ACCOUNT_ID');
            $apiToken = Environment::getEnv('CLOUDFLARE_STREAM_API_TOKEN');

            if (!$accountID || !$apiToken) {
                throw new RuntimeException(
                    'Cloudflare Stream is not configured - set CLOUDFLARE_STREAM_ACCOUNT_ID and '
                    . 'CLOUDFLARE_STREAM_API_TOKEN in .env'
                );
            }

            $client = new Client();

            $response = $client->post(
                "https://api.cloudflare.com/client/v4/accounts/{$accountID}/stream",
                [
                    'headers' => [
                        'Authorization' => "Bearer {$apiToken}",
                    ],
                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => $stream,
                            'filename' => $fileName,
                        ],
                    ],
                ]
            );

            $body = json_decode((string) $response->getBody(), true);

            if (empty($body['success']) || empty($body['result']['uid'])) {
                throw new RuntimeException(
                    'Cloudflare Stream upload failed: ' . json_encode($body['errors'] ?? $body)
                );
            }

            return $body['result']['uid'];
        }
    }
}
