<!-- resources/views/emails/concern-submitted.blade.php -->

@component('mail::message')
# New Concern Submitted

A new concern has been submitted from the Contact Us on the homepage:

- **Name:** {{ $name }}
- **Email:** {{ $email }}
- **Phone:** {{ $phone }}
- **Subject:** {{ $subject }}
- **Message:** {{ $message }}

@endcomponent
