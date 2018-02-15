@inject('home', 'App\Http\Controllers\HomeController')
@extends('layouts.app')

@section('title')
    MUUSA Scholarship Process
@endsection

@section('heading')
    This page can teach you all you need to know about how to apply for a scholarship to receive financial assistance for MUUSA.
@endsection

@section('content')
    @if($home->year()->is_scholarship_full == '1')
        <div class="alert alert-warning">
            Unfortunately, all {{ $home->year()->year }} scholarship funds have been awarded. Please check back
            in {{ $home->year()->year+1 }}.
        </div>
    @endif
    <div class="container">
        <a href="/MUUSA_Scholarship_Process_2018.pdf" class="p-2 float-right btn btn-primary" data-toggle="tooltip"
           title="Printer Friendly Version"><i class="fa fa-print fa-2x"></i>
        </a>

        <ul class="nav nav-tabs flex-column flex-lg-row" role="tablist">
            <li role="presentation" class="nav-item">
                <a href="#1" aria-controls="1" role="tab" class="nav-link active" data-toggle="tab">
                    Main Information
                </a>
            </li>
            <li role="presentation" class="nav-item">
                <a href="#2" aria-controls="2" role="tab" class="nav-link" data-toggle="tab">
                    Appendix
                </a>
            </li>
            <li role="presentation" class="nav-item">
                <a href="#3" aria-controls="3" role="tab" class="nav-link" data-toggle="tab">
                    Examples
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade active show" aria-expanded="true" id="1">

                <p>Our goal at MUUSA is to make camp affordable for those who wish to attend. We strive to accomplish
                    this goal by providing lower-cost housing options, inviting campers to apply for staff positions
                    that offer a credit toward camp expenses, and partnering with YMCA of the Ozarks (which operates
                    Trout Lodge) to offer scholarship funds.
                </p>

                <p>This document lays out the scholarship application process, details the sources of scholarship funds
                    that are available, and explains the scholarship award process.
                </p>
                <h3>How to Apply For a Scholarship</h3>
                <p>&nbsp;</p>
                <ol>
                    <li><h5>Download an application form, available <a
                                    href="/Trout_Lodge_Financial_Assistance_Form.pdf">here</a>.
                        </h5>
                        <p>The application form is developed by the YMCA of the Ozarks and is the same form that they
                            use to evaluate scholarships for other YMCA programming. You do not have to be a YMCA member
                            to apply for a MUUSA scholarship.</p>
                        <p>Notes about the Trout Lodge Financial Assistance Form:</p>
                        <ul>
                            <li>The MUUSA Scholarship Process will follow the time schedule detailed in this document
                                (see &quot;Timing&quot;), not the one outlined in the scholarship application. All
                                scholarship applicants will be contacted by a member of the MUUSA Scholarship Committee.
                            </li>
                            <li>Please disregard the &quot;method of payment&quot; section.</li>
                            <li>Please write &quot;MUUSA&quot; in the space next to &quot;Member ID&quot;.</li>
                            <li>You do not need to initial the &quot;expectations of eligibility&quot; or the &quot;membership
                                dues to be paid.&quot;
                            </li>
                            <li>Although the Trout Lodge Financial Assistance Form mentions &quot;membership&quot; in
                                several places, rest assured that you are filling out the correct document for a MUUSA
                                scholarship.
                            </li>
                            <li>If you have extenuating circumstances not reflected in your tax documents, we encourage
                                you to attach an additional page explaining said circumstances.
                        </ul>
                    </li>
                    <li><h5>Submit the application by mail or e-mail by April 15 to:</h5>
                        <address> Nicolle Wright<br/> YMCA Trout Lodge<br/> 13528 State Highway AA<br/> Potosi, MO 63664<br/>
                            <a href="mailto:nicolle.wright@gwrymca.org">nicolle.wright@gwrymca.org</a></address>
                    </li>
                    <li><h5>Notify Maya Rao, Scholarship Committee Coordinator, once you have submitted your
                            application.</h5>
                        <p>Send
                            <a href="mailto:maya.m.rao3@gmail.com?subject=MUUSA%20Scholarship%20Application%20Submitted">Maya
                                Rao</a> an email (maya.m.rao3@gmail.com). In the body of the email please list the names
                            and ages (in July 2018) of those in your application.</p></li>
                </ol>
                <p><strong>Scholarships are limited and cannot be guaranteed. Campers should not make any travel or
                        financial plans on the assumption that they will receive a scholarship or any specific
                        scholarship amount until they have received written (via email or letter) confirmation of their
                        scholarship award.</strong></p>
                <h3>Timing</h3>
                <p>&nbsp;</p>
                <p>The Scholarship process will open on February 1. Campers seeking financial assistance must submit
                    scholarship applications no later than April 15. The timeline for the process is as follows:</p>
                <table>
                    <tbody>
                    <tr>
                        <td class="pb-3" width="25%"><strong>February 1</strong></td>
                        <td width="75%">Scholarship process opens; applications can be submitted</td>
                    </tr>
                    <tr>
                        <td class="pb-3"><strong>April 15</strong></td>
                        <td>Applications due, including receipt of all financial information</td>
                    </tr>
                    <tr>
                        <td class="pb-3"><strong>May 15</td>
                        <td>Scholarship determinations made and campers contacted.</td>
                    </tr>
                    <tr>
                        <td class="pb-3"><strong>June 1</strong></td>
                        <td>Deadline for late application submissions (these applications will only be considered if
                            funds remain after scholarships are distributed to those who applied by April 15).
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-3"><strong>June 10</strong></td>
                        <td>Additional determinations made for late submissions, but only if funds remain.</td>
                    </tr>
                    </tbody>
                </table>
                <p>Applicants who submit their applications by the April 15 deadline will be notified of their award by
                    May 15, barring unforeseen delays. Balances of camper invoices on the MUUSA website will be updated
                    as soon as feasible after scholarships are awarded.
                <p>If scholarship funds remain after determinations are made (by May 15), late applications (submitted
                    after April 15) will be considered. These additional determinations will be made by June 10.
                    <strong>No scholarship applications submitted after June 1 will be considered.</strong></p>
                <h3>Details</h3>
                <p>&nbsp;</p>
                <h4>Review and Award of Scholarships</h4>
                <p>&nbsp;</p>
                <p>The scholarship process will be administeredby the MUUSA Scholarship Committee, which includes: Maya
                    Rao, Veronica Colegrove, Sara Teppema, John Sandman, and Bill Pokorny for MUUSA 2018. Maya Rao will
                    serve as the Scholarship Committee Coordinator and the primary contact for the Scholarship
                    Committee.</p>
                <p>As explained in the appendix, scholarship funds come from the MUUSA Scholarship Fund and the YMCA of
                    the Ozarks.</p>
                <p>Trout Lodge staff will review all applications to determine whether they meet the YMCA of the Ozarks
                    eligibility criteria for financial assistance, and whether the YMCA will contribute to a scholarship
                    (and the amount) for the camper after MUUSA satisfies its guarantee (again, see appendix for details
                    on how this works).</p>
                <p>Upon receipt of the YMCA's determinations, the Scholarship Committee will review all applications and
                    independently determine how available scholarship funds will be allocated.</p>
                <p>Scholarships will be awarded based upon the following criteria:</p>
                <ul>
                    <li>YMCA scholarship determinations</li>
                    <li>Other circumstances contributing to financial need that may not be reflected in Trout Lodge's
                        assessment
                    </li>
                    <li>Timeliness of application</li>
                    <li>Welcoming new campers who have not previously had an opportunity to attend MUUSA</li>
                    <li>Availability of funds</li>
                </ul>
                <p>To make the process as fair as possible, members of the Scholarship Committee will recuse themselves
                    from any decision involving a scholarship application by a family member or close personal
                    friend.</p>
                <p>The Scholarship Committee has sole discretion to determine whether to award a scholarship and in what
                    amount. The Committee's decisions are final.</p>

                <h4>Scholarship Amounts</h4>
                <p>&nbsp;</p>
                <p>For 2018, the total scholarship amounts awarded will initially be capped on a per-camper (not
                    per-family) basis. The maximum scholarship awards will be as follows:</p>
                <p>Adults (including YAs): $500 per person<br/> Children and Youth age 6 and up: $300 per person<br/>
                    Children under age 6: $70 per person</p>
                <p>Please note that these are maximum awards. In many cases a lower scholarship amount may be awarded so
                    as to share available funds among a broader group of applicants.</p>
                <p>Additionally, scholarships awarded will not exceed total fees after all additions and reductions
                    (including staff honoraria) less $100 for each adult camper (including YAs) in Trout Lodge, Lakeview
                    or Forest View, and $50 for each adult (including YAs) in Lakewood or tent camping. In other words,
                    all adults receiving MUUSA scholarship funds will pay at least $100 or $50 (depending on housing)
                    for their week at camp, regardless of honoraria.</p>
                <p>Scholarship amounts do not apply toward additional MUUSA workshop or class fees, such as the float
                    trip or supplies for the fabric workshop.</p>
                <p>The Scholarship Committee may adjust the caps and minimum charges listed above for recipients of YMCA
                    scholarships if the Treasurer projects that MUUSA will receive YMCA scholarship credits in excess of
                    the above amounts after exceeding its minimum guarantee to Trout Lodge. Please refer to the appendix
                    for more information on the minimum guarantee, how YMCA scholarship funds are applied, and sample
                    scholarship calculations.</p>

                <h4>Why Would I Take on a Staff Role at MUUSA if I am Applying for a Scholarship?</h4>
                <p>&nbsp;</p>
                <p>Choosing to serve in a MUUSA staff role allows you to give back to the MUUSA community in a way that
                    best reflects your skills and talents. Whether you choose to lead a workshop, assist in the
                    Children's Program, or fill another crucial role, you are providing a valuable contribution to the
                    MUUSA community. Furthermore, funding for staff honoraria is included in the MUUSA budget whereas
                    scholarships (and their amounts) are subject to availability.</p>
                <p><strong>Thank you for your interest in applying for a scholarship for MUUSA 2018. We hope this
                        document has helped clarify the scholarship process. If you have further questions or concerns
                        please contact the Scholarship Committee Coordinator, Maya Rao at
                        maya.m.rao3@gmail.com.</strong></p>
            </div>

            <div role="tabpanel" class="tab-pane fade" aria-expanded="false" id="2"><h3>Appendix</h3>
                <h4>Where Do Scholarship Funds Come From?</h4>
                <p>MUUSA scholarships provide a discount off of the fees that MUUSA would otherwise charge a camper for
                    their stay. Because MUUSA has to cover its financial obligations, the money that we are not
                    collecting from campers who receive scholarships must be made up from some other source. Scholarship
                    funds may come from two sources: YMCA of the Ozarks and MUUSA's own scholarship fund. Understanding
                    how these two sources work together requires some understanding of our (MUUSA's) financial
                    obligations to Trout Lodge.</p>
                <p>Campers pay MUUSA for their week at camp. The revenue we receive from campers covers our fees to
                    Trout Lodge (for food, lodging, Trout Lodge staff, etc.) and MUUSA expenses (for program staff,
                    supplies, insurance, etc.). Our contract with Trout Lodge obligates MUUSA to pay a certain minimum
                    guaranteed amount to Trout Lodge (the &quot;minimum guarantee&quot;), regardless of how many campers
                    register or our actual revenue. Paying the minimum guarantee allows MUUSA to retain exclusive rights
                    to the Trout Lodge property.We have not met the minimum guaranteein some years, or met it by only a
                    very small margin, even though camp has been nearly full. This is because Trout Lodge bases the
                    minimum guarantee on a higher occupancy rate (i.e., more campers per room) than we achieve.</p>
                <p>The YMCA of the Ozarks has funding to provide a limited number of scholarships to MUUSA campers who
                    may not otherwise be able to afford a camp experience. These scholarships do not go directly to the
                    camper or MUUSA. Rather, they operate as a percentage discount off of what Trout Lodge would
                    otherwise charge MUUSA for that camper's stay. However, the YMCA provides these discounts only once
                    MUUSA's minimum guarantee is met. In other words, YMCA scholarships only benefit MUUSA campers to
                    the extent that our enrollment is high enough to exceed our minimum guarantee with Trout Lodge. Even
                    if we exceed the guarantee by more than the value of the scholarships awarded, YMCA scholarships do
                    not cover the other MUUSA expenses paid for by our camp fees.</p>
                <p>MUUSA has its own scholarship fund that we use to provide additional assistance with camp costs not
                    covered by YMCA scholarships. These funds come mainly from voluntary donations from MUUSA campers
                    and through fundraising. MUUSA's main scholarship fundraising sources have historically included
                    donations paid as part of the registration process, a portion of MUUSA bookstore profits (if any),
                    and art show sales.</p>
                <p>Each year, the Treasurer and Registrar will review the balance in the Scholarship Fund as well as
                    MUUSA's projected enrollment and revenue. They will then recommend an amount to be included in the
                    budget for scholarship awards. The amount available for distribution will be included in the budget
                    approved by the Planning Council, and will be finalized before scholarship awards are communicated
                    to campers.</p></div>
            <div role="tabpanel" class="tab-pane fade" aria-expanded="false" id="3">
                <h3>Sample Scholarship Calculations</h3>
                <p>The following are some examples of how this calculation would apply, using 2018 rates. (Examples 1
                    and 2 assume the maximum scholarship has been awarded, which will not always be the case.)</p>

                <h4>Example 1:</h4>
                <p> Family of 4, with 2 adults and 2 kids over the age of 6, staying in a Trout Lodge room, with1 adult
                    working in the Children's Program and 1 adult leading a 3 day workshop.</p>
                <p>Adult fee: $670 x 2 = $1,340</p>
                <p>Child fee: $344 x 2 = $688</p>
                <p>Staff honorarium: $300 (Children's Program worker)+ $150 (3 day workshop leader)=$450</p>
                <p>Total costbefore scholarship: $1,578 ($1,340+$688-$450)</p>
                <p>Scholarship cap: $1,600 ($500 x 2 adults + $300 x 2 children)</p>
                <p>Maximum scholarship: $1,378 ($1,600 or cost before scholarship minus $100 per adult, whichever is
                    less)</p>
                <p>Actual scholarship awarded: $1,378</p>
                <p>Total cost after scholarship &amp; credits (or honoraria): $222</p>

                <h4>Example 2: </h4>
                <p>Single YA(young adult) tent camper, under 21 years old</p>
                <p>YA fee: $350</p>
                <p>Total cost before scholarship: $350</p>
                <p>Scholarship cap: $500</p>
                <p>Maximum scholarship: $300 ($500, or cost before scholarship minus $50 per adult tent camper,
                    whichever is less)</p>
                <p>Actual scholarship awarded: $300</p>
                <p>Total cost after scholarship: $50 ($350-$50)</p>

                <h4>Example 3:</h4>
                <p> 2 adults staying in a Forest View cabin with 1 adult leading a 5 day workshop. The Scholarship
                    Committee determines that the couple will be awarded a $400 scholarship.</p>
                <p>Adult fee: $795x 2 = $1,590</p>
                <p>Staff honorarium: $300 (5 day workshop leader)</p>
                <p>Total cost before scholarship: $1,290 ($1,590-$300)</p>
                <p>Actual scholarship awarded: $400</p>
                <p>Total cost after scholarship: $890 ($1,290-$400)</p></div>
        </div>
    </div>
@endsection