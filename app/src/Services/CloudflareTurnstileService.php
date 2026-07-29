<?php

namespace {

    use GuzzleHttp\Client;
    use Psr\Log\LoggerInterface;
    use SilverStripe\Core\Environment;
    use SilverStripe\Core\Injector\Injectable;
    use SilverStripe\Core\Injector\Injector;

    /**
     * Verifies Cloudflare Turnstile challenge tokens server-side.
     *
     * Requires CLOUDFLARE_TURNSTILE_SITE_KEY (public, used by TurnstileField's
     * widget) and CLOUDFLARE_TURNSTILE_SECRET_KEY (private, used here) to be
     * set in .env - get both from the Cloudflare dashboard under Turnstile.
     */
    class CloudflareTurnstileService
    {
        use Injectable;

        /**
         * @param string $token The 'cf-turnstile-response' value submitted by the widget
         * @param string|null $remoteIP The submitting visitor's IP address - optional, per
         *                     Cloudflare's siteverify API (HTTPRequest::getIP() can return null,
         *                     e.g. behind a misconfigured proxy)
         * @return bool True if the challenge was passed
         */
        public function verify(string $token, ?string $remoteIP = null): bool
        {
            $secretKey = Environment::getEnv('CLOUDFLARE_TURNSTILE_SECRET_KEY');

            if (!$secretKey || !$token) {
                return false;
            }

            $formParams = [
                'secret' => $secretKey,
                'response' => $token,
            ];

            if ($remoteIP) {
                $formParams['remoteip'] = $remoteIP;
            }

            try {
                $client = new Client();

                $response = $client->post(
                    'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                    [
                        'form_params' => $formParams,
                    ]
                );

                $body = json_decode((string) $response->getBody(), true);

                return !empty($body['success']);
            } catch (\Throwable $e) {
                Injector::inst()->get(LoggerInterface::class)->error(
                    'Cloudflare Turnstile verification failed: ' . $e->getMessage()
                );

                return false;
            }
        }
    }
}
