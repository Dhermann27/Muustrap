@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('title')
    Scholarship Information
@endsection

@section('heading')
    This page can teach you all you need to know about the scholarship process to receive financial assistance for MUUSA.
@endsection

@section('content')
    @if($home->year()->is_scholarship_full == '1')
        <div class="alert alert-warning">
            Unfortunately, all {{ $home->year()->year }} scholarship funds have been awarded. Please check back
            in {{ $home->year()->year+1 }}.
        </div>
    @endif
    <div class="container">
        @if(false)
            <p>In order to help with camp costs, Scholarships are awarded on a need basis. Applicants fill out YMCA
                provided forms and the YMCA reviews your application to confirm your financial needs. Based on this
                assessment the YMCA and MUUSA together provide the grant. Both MUUSA and the YMCA are committed to
                making the camp available to all and to provide need-based help. There are a limited number of
                need-based scholarships available on a first‐come basis, eligible for up to 100% of the cost of
                attending camp.</p>
            <h6>Review Process</h6>
            <ol>
                <li>Complete the MUUSA registration (either on‐line or by mail). If you cannot pay the deposit,
                    contact the MUUSA registrar using Contact Us form above.
                </li>
                <li>Complete and return the <a href="/Financial_Assistance_Member_Packet.pdf">YMCA Aid
                        Application</a>. You will need to provide personal financial information, including proof of
                    income. This information is only seen by the YMCA scholarship coordinator and not by MUUSA PC or
                    Scholarship Coordinator.<br/>

                    Mail or fax form to:<br/>
                    US Mail: YMCA Trout Lodge, 13528 State Highway AA, Potosi, MO 63664, attn: Nicolle Wright<br/>
                    Fax: 573-438-5752 attn: Nicolle Wright<br/>
                    Email: <a href="mailto:nwright@ymcastlouis.org">Nicolle Wright</a><br/>
                </li>
                <li>Contact the Scholarship Coordinator, Bill Pokorny, to say you have completed and submitted both
                    the MUUSA registration and the YMCA Aid Application. To qualify for a scholarship, you must
                    follow all these steps. Again, all information is confidential and no personal financial
                    information that you provide the YMCA is shared with MUUSA.
                </li>
                <li>Upon review, the YMCA will communicate the award percentage to the registrar and the scholarship
                    coordinator. You will be informed of the amount when decision is made.
                </li>
            </ol>
        @endif
        <p>The Planning Council is currently reviewing and updating the MUUSA Scholarship application process.
            Information on the new process will be posted by late January, and applications will be accepted from
            February 1 through April 15. Please check back for more information.</p>

        <p>Please contact the Scholarship Coordinator using the Contact Us form above if you have questions.</p>
    </div>
@endsection