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
         * Where enquiry emails are sent - override in app/_config/app.yml, e.g:
         *
         * ContactPageController:
         *   recipient_email: 'enquiries@example.com'
         */
        private static $recipient_email = 'info@tairawhitiinvestments.nz';

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
                    ->addExtraClass('form-control-wrapper')
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
            $recipient = $this->config()->get('recipient_email');

            $body = sprintf(
                "New enquiry from %s %s\nEmail: %s\nType: %s\n\n%s",
                $data['FirstName'],
                $data['LastName'],
                $data['Email'],
                $data['EnquiryType'],
                $data['Message']
            );

            Email::create()
                ->setFrom($recipient)
                ->setTo($recipient)
                ->setReplyTo($data['Email'])
                ->setSubject(sprintf('New enquiry from %s %s', $data['FirstName'], $data['LastName']))
                ->setBody(nl2br(htmlspecialchars($body)))
                ->send();

            $form->sessionMessage('Thanks for getting in touch - we\'ll be in contact soon.', 'good');

            return $this->redirectBack();
        }
    }
}
