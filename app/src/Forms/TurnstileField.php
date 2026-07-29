<?php

namespace {

    use SilverStripe\Core\Environment;
    use SilverStripe\Core\Validation\ValidationResult;
    use SilverStripe\Forms\FormField;
    use SilverStripe\View\Requirements;

    /**
     * Renders a Cloudflare Turnstile challenge widget and verifies it
     * server-side on submission (see CloudflareTurnstileService). If
     * CLOUDFLARE_TURNSTILE_SITE_KEY/CLOUDFLARE_TURNSTILE_SECRET_KEY aren't set
     * in .env, the field quietly does nothing - renders no widget and skips
     * verification - so forms keep working in local dev without real keys.
     */
    class TurnstileField extends FormField
    {
        public function Field($properties = [])
        {
            $siteKey = Environment::getEnv('CLOUDFLARE_TURNSTILE_SITE_KEY');

            if (!$siteKey) {
                return '';
            }

            Requirements::javascript('https://challenges.cloudflare.com/turnstile/v0/api.js', [
                'async' => true,
                'defer' => true,
            ]);

            return $this->customise([
                'SiteKey' => $siteKey,
            ])->renderWith('Includes/TurnstileField');
        }

        public function validate(): ValidationResult
        {
            $result = ValidationResult::create();
            $siteKey = Environment::getEnv('CLOUDFLARE_TURNSTILE_SITE_KEY');
            $secretKey = Environment::getEnv('CLOUDFLARE_TURNSTILE_SECRET_KEY');

            if (!$siteKey || !$secretKey) {
                return $result;
            }

            $request = $this->getForm()->getController()->getRequest();
            $token = $request->postVar('cf-turnstile-response');

            if (!$token) {
                $result->addFieldError($this->getName(), 'Please complete the verification challenge.');
                return $result;
            }

            if (!CloudflareTurnstileService::create()->verify($token, $request->getIP())) {
                $result->addFieldError($this->getName(), 'Verification failed - please try again.');
            }

            return $result;
        }
    }
}
