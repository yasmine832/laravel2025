<x-mail::message>
# New Contact Form Submission

**From:** {{ $message->name }} ({{ $message->email }})
**Subject:** {{ $message->subject }}

**Message:**
{{ $message->message }}

<x-mail::button :url="route('contact.show')">
View All Messages
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>