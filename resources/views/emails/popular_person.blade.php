@component('mail::message')
# 🔥 Popular Person Alert

Hello Admin,

The following person is very popular:

@component('mail::panel')
**Person ID:** {{ $personId }}  
**Name:** {{ $personName }}  
**Likes:** {{ $likes }}
@endcomponent

@component('mail::button', ['url' => url('/api/people/'.$personId)])
View Profile
@endcomponent

Thanks,<br>
**{{ config('app.name') }}**
@endcomponent
