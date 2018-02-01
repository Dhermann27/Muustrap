@include('snippet.formgroup', ['type' => 'info', 'label' => 'Your Name', 'attribs' => ['name' => 'yourname'],
    'default' => $camper->firstname . ' ' . $camper->lastname])

@include('snippet.formgroup', ['type' => 'info', 'label' => 'Email Address', 'attribs' => ['name' => 'email'],
    'default' => $camper->email])

@include('snippet.formgroup', ['type' => 'info', 'label' => 'Address Line #1', 'attribs' => ['name' => 'address1'],
    'default' => $camper->family->address1])

@if($camper->family->address2 != '')
    @include('snippet.formgroup', ['type' => 'info', 'label' => 'Address Line #2', 'attribs' => ['name' => 'address2'],
        'default' => $camper->family->address2])
@endif

@include('snippet.formgroup', ['type' => 'info', 'label' => 'City', 'attribs' => ['name' => 'city'],
    'default' => $camper->family->city])

@include('snippet.formgroup', ['type' => 'info', 'label' => 'State', 'attribs' => ['name' => 'state'],
    'default' => $camper->family->state_code])

@include('snippet.formgroup', ['type' => 'info', 'label' => 'Zip Code', 'attribs' => ['name' => 'zip'],
    'default' => $camper->family->zipcd])

@if($camper->phonenbr != '')
    @include('snippet.formgroup', ['type' => 'info', 'label' => 'Phone Number', 'attribs' => ['name' => 'phonenbr'],
        'default' => $camper->formatted_phone])
@endif