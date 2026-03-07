<x-mail::message>
# Welcome to A.R.T.S.P!

Hello,

Your professional automotive vendor account has been successfully provisioned. We've verified your credentials and you're now part of the **Automotive Resource & Technical Service Platform**.

To get started and access your dashboard, please use the secure credentials provided below:

<x-mail::panel>
**Default Password:** {{ $password }}
</x-mail::panel>

<x-mail::button :url="$activationUrl">
Activate Account & Continue
</x-mail::button>

### Important Security Notice

For your safety, we recommend updating this temporary password immediately after your first login through your profile settings.

If you did not expect this invitation, please ignore this email or contact our support team.

Best Regards,<br>
**The A.R.T.S.P Team**
</x-mail::message>