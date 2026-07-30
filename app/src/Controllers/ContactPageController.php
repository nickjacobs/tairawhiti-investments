<?php

namespace {

    use SilverStripe\Control\Email\Email;
    use SilverStripe\Control\Middleware\HTTPCacheControlMiddleware;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\EmailField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\Form;
    use SilverStripe\Forms\FormAction;
    use SilverStripe\Forms\Validation\RequiredFieldsValidator;
    use SilverStripe\Forms\TextareaField;
    use SilverStripe\Forms\TextField;

    /**
     * @template T of ContactPage
     * @extends PageController<T>
     */
    class ContactPageController extends PageController
    {
        private static $allowed_actions = [
            'ContactForm',
        ];

        protected function init()
        {
            parent::init();

            // ContactForm's CSRF token is tied to the visitor's session -
            // publicly caching this page would serve one visitor's token to
            // everyone else, breaking their form submission.
            HTTPCacheControlMiddleware::singleton()->disableCache(true);
        }

        /**
         * Where enquiry emails are sent, the display name they're sent from,
         * and an optional extra address to BCC - set in app/_config/app.yml:
         *
         * ContactPageController:
         *   recipient_email: 'enquiries@example.com'
         *   sender_name: 'Example Trust'
         *   bcc_email: 'archive@example.com'
         */
        private static $recipient_email;

        private static $sender_name;

        private static $bcc_email;

        private static $enquiry_types = [
            'General enquiry' => 'General enquiry',
            'Media enquiry' => 'Media enquiry',
            'Other' => 'Other',
        ];

        public function ContactForm()
        {
            $fields = FieldList::create(
                TextField::create('FirstName', 'First name')
                    ->addExtraClass('form-control-wrapper'),
                TextField::create('LastName', 'Last name')
                    ->addExtraClass('form-control-wrapper'),
                EmailField::create('Email', 'Email address')
                    ->addExtraClass('form-control-wrapper'),
                DropdownField::create('EnquiryType', 'What\'s your enquiry about?', $this->config()->get('enquiry_types'))
                    ->setValue(array_key_first($this->config()->get('enquiry_types')))
                    ->addExtraClass('form-select-wrapper'),
                TextareaField::create('Message', 'Your enquiry')
                    ->setRows(3)
                    ->addExtraClass('form-control-wrapper'),
                TurnstileField::create('Turnstile', '')
            );

            $validator = RequiredFieldsValidator::create([
                'FirstName',
                'LastName',
                'Email',
                'EnquiryType',
                'Message',
            ]);

            $actions = FieldList::create(
                FormAction::create('doSubmitContactForm', 'Send message')
                    ->addExtraClass('pill-link')
            );

            return Form::create($this, 'ContactForm', $fields, $actions, $validator);
        }

        public function doSubmitContactForm(array $data, Form $form)
        {
            $from_email = $this->config()->get('from_email');
            $from_name = $this->config()->get('from_name');
            $recipient = $this->config()->get('recipient_email');
            $bcc = $this->config()->get('bcc_email');

            $email = Email::create()
                ->setFrom($from_email, $from_name)
                ->setTo($recipient)
                ->setReplyTo($data['Email'], sprintf('%s %s', $data['FirstName'], $data['LastName']))
                ->setSubject(sprintf('New enquiry from %s %s', $data['FirstName'], $data['LastName']))
                ->setHTMLTemplate('Email/ContactEnquiry')
                ->setData([
                    'FirstName' => $data['FirstName'],
                    'LastName' => $data['LastName'],
                    'Email' => $data['Email'],
                    'EnquiryType' => $data['EnquiryType'],
                    // Pre-escaped/formatted here and output with $Message.RAW
                    // in the template, rather than relying on template-level
                    // casting of a plain array value.
                    'Message' => nl2br(htmlspecialchars($data['Message'])),
                ]);

            if ($bcc) {
                $email->setBCC($bcc);
            }

            $email->send();

            $form->sessionMessage('Thanks for getting in touch - we\'ll be in contact soon.', 'good');

            return $this->redirectBack();
        }
    }
}
